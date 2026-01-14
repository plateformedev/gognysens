<?php
/**
 * Booking Integration
 * Integrates with Amelia, Simply Schedule Appointments, or custom booking
 *
 * @package Cognysens
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Check which booking plugin is active
 */
function cognysens_get_booking_system() {
    if (class_exists('AmeliaBooking\Infrastructure\Services\Plugin\PluginService')) {
        return 'amelia';
    }

    if (function_exists('ssa_get_appointments')) {
        return 'ssa';
    }

    if (function_exists('booked_get_appointments')) {
        return 'booked';
    }

    return 'custom'; // Our fallback form
}

/**
 * Display booking widget
 */
function cognysens_booking_widget($args = array()) {
    $defaults = array(
        'service' => '',
        'category' => '',
        'employee' => '',
    );
    $args = wp_parse_args($args, $defaults);
    $booking_system = cognysens_get_booking_system();

    switch ($booking_system) {
        case 'amelia':
            echo cognysens_amelia_shortcode($args);
            break;

        case 'ssa':
            echo cognysens_ssa_shortcode($args);
            break;

        default:
            // Our custom qualification form
            get_template_part('template-parts/booking', 'form', $args);
            break;
    }
}

/**
 * Amelia booking shortcode
 */
function cognysens_amelia_shortcode($args = array()) {
    $shortcode = '[ameliabooking';

    if (!empty($args['service'])) {
        $shortcode .= ' service="' . esc_attr($args['service']) . '"';
    }
    if (!empty($args['category'])) {
        $shortcode .= ' category="' . esc_attr($args['category']) . '"';
    }
    if (!empty($args['employee'])) {
        $shortcode .= ' employee="' . esc_attr($args['employee']) . '"';
    }

    $shortcode .= ']';

    return do_shortcode($shortcode);
}

/**
 * Simply Schedule Appointments shortcode
 */
function cognysens_ssa_shortcode($args = array()) {
    $shortcode = '[ssa_booking';

    if (!empty($args['service'])) {
        $shortcode .= ' type="' . esc_attr($args['service']) . '"';
    }

    $shortcode .= ']';

    return do_shortcode($shortcode);
}

/**
 * Register webhook endpoint for booking notifications
 */
function cognysens_register_booking_endpoints() {
    register_rest_route('cognysens/v1', '/booking/webhook', array(
        'methods' => 'POST',
        'callback' => 'cognysens_handle_booking_webhook',
        'permission_callback' => 'cognysens_verify_booking_webhook',
    ));

    register_rest_route('cognysens/v1', '/booking/availability', array(
        'methods' => 'GET',
        'callback' => 'cognysens_get_availability',
        'permission_callback' => '__return_true',
    ));
}
add_action('rest_api_init', 'cognysens_register_booking_endpoints');

/**
 * Verify booking webhook (basic token verification)
 */
function cognysens_verify_booking_webhook($request) {
    $token = $request->get_header('X-Webhook-Token');
    $expected = get_option('cognysens_webhook_token');

    if (empty($expected)) {
        // Generate token if not exists
        $expected = wp_generate_password(32, false);
        update_option('cognysens_webhook_token', $expected);
    }

    return $token === $expected;
}

/**
 * Handle booking webhook (from external calendar or n8n/Make)
 */
function cognysens_handle_booking_webhook($request) {
    $data = $request->get_json_params();

    if (empty($data)) {
        return new WP_Error('no_data', 'No data received', array('status' => 400));
    }

    $action = isset($data['action']) ? sanitize_text_field($data['action']) : '';

    switch ($action) {
        case 'appointment_created':
            return cognysens_process_new_appointment($data);

        case 'appointment_cancelled':
            return cognysens_process_cancelled_appointment($data);

        case 'appointment_rescheduled':
            return cognysens_process_rescheduled_appointment($data);

        default:
            return new WP_Error('unknown_action', 'Unknown action', array('status' => 400));
    }
}

/**
 * Process new appointment from webhook
 */
function cognysens_process_new_appointment($data) {
    // Log the appointment
    $appointments = get_option('cognysens_appointments', array());

    $appointment = array(
        'id' => isset($data['appointment_id']) ? sanitize_text_field($data['appointment_id']) : uniqid('appt_'),
        'client_name' => isset($data['client_name']) ? sanitize_text_field($data['client_name']) : '',
        'client_email' => isset($data['client_email']) ? sanitize_email($data['client_email']) : '',
        'client_phone' => isset($data['client_phone']) ? sanitize_text_field($data['client_phone']) : '',
        'service' => isset($data['service']) ? sanitize_text_field($data['service']) : '',
        'datetime' => isset($data['datetime']) ? sanitize_text_field($data['datetime']) : '',
        'notes' => isset($data['notes']) ? sanitize_textarea_field($data['notes']) : '',
        'ai_summary' => isset($data['ai_summary']) ? sanitize_textarea_field($data['ai_summary']) : '',
        'status' => 'confirmed',
        'created_at' => current_time('mysql'),
    );

    array_unshift($appointments, $appointment);

    // Keep last 200 appointments
    if (count($appointments) > 200) {
        $appointments = array_slice($appointments, 0, 200);
    }

    update_option('cognysens_appointments', $appointments);

    // Send confirmation email
    cognysens_send_appointment_confirmation($appointment);

    return array(
        'success' => true,
        'message' => 'Appointment processed',
        'appointment_id' => $appointment['id'],
    );
}

/**
 * Process cancelled appointment
 */
function cognysens_process_cancelled_appointment($data) {
    $appointment_id = isset($data['appointment_id']) ? sanitize_text_field($data['appointment_id']) : '';

    if (empty($appointment_id)) {
        return new WP_Error('missing_id', 'Appointment ID required', array('status' => 400));
    }

    $appointments = get_option('cognysens_appointments', array());

    foreach ($appointments as &$appointment) {
        if ($appointment['id'] === $appointment_id) {
            $appointment['status'] = 'cancelled';
            $appointment['cancelled_at'] = current_time('mysql');
            break;
        }
    }

    update_option('cognysens_appointments', $appointments);

    return array(
        'success' => true,
        'message' => 'Appointment cancelled',
    );
}

/**
 * Process rescheduled appointment
 */
function cognysens_process_rescheduled_appointment($data) {
    $appointment_id = isset($data['appointment_id']) ? sanitize_text_field($data['appointment_id']) : '';
    $new_datetime = isset($data['new_datetime']) ? sanitize_text_field($data['new_datetime']) : '';

    if (empty($appointment_id) || empty($new_datetime)) {
        return new WP_Error('missing_data', 'Appointment ID and new datetime required', array('status' => 400));
    }

    $appointments = get_option('cognysens_appointments', array());

    foreach ($appointments as &$appointment) {
        if ($appointment['id'] === $appointment_id) {
            $appointment['previous_datetime'] = $appointment['datetime'];
            $appointment['datetime'] = $new_datetime;
            $appointment['rescheduled_at'] = current_time('mysql');
            break;
        }
    }

    update_option('cognysens_appointments', $appointments);

    return array(
        'success' => true,
        'message' => 'Appointment rescheduled',
    );
}

/**
 * Get availability (placeholder for future calendar integration)
 */
function cognysens_get_availability($request) {
    $start_date = $request->get_param('start_date') ?: date('Y-m-d');
    $end_date = $request->get_param('end_date') ?: date('Y-m-d', strtotime('+30 days'));

    // Placeholder: Return mock available slots
    // In production, this would query Google Calendar or the booking plugin
    $slots = array();
    $current = strtotime($start_date);
    $end = strtotime($end_date);

    while ($current <= $end) {
        $day = date('N', $current);

        // Skip weekends
        if ($day < 6) {
            $date = date('Y-m-d', $current);
            $slots[$date] = array(
                '09:00', '10:00', '11:00',
                '14:00', '15:00', '16:00', '17:00'
            );
        }

        $current = strtotime('+1 day', $current);
    }

    return array(
        'success' => true,
        'slots' => $slots,
    );
}

/**
 * Send appointment confirmation email
 */
function cognysens_send_appointment_confirmation($appointment) {
    if (empty($appointment['client_email'])) {
        return false;
    }

    $subject = 'Confirmation de rendez-vous - COGNYSENS';

    $datetime = !empty($appointment['datetime'])
        ? date('d/m/Y a H:i', strtotime($appointment['datetime']))
        : 'a confirmer';

    $body = "Bonjour {$appointment['client_name']},\n\n";
    $body .= "Votre rendez-vous avec COGNYSENS est confirme.\n\n";
    $body .= "Details:\n";
    $body .= "- Date et heure: {$datetime}\n";
    $body .= "- Service: {$appointment['service']}\n\n";
    $body .= "En cas d'empechement, merci de nous prevenir au moins 24h a l'avance.\n\n";
    $body .= "A bientot,\n";
    $body .= "L'equipe COGNYSENS\n\n";
    $body .= "---\n";
    $body .= "COGNYSENS - Expertise & AMO Bati Ancien\n";
    $body .= home_url() . "\n";

    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: COGNYSENS <noreply@' . parse_url(home_url(), PHP_URL_HOST) . '>',
    );

    return wp_mail($appointment['client_email'], $subject, $body, $headers);
}

/**
 * Admin page for viewing appointments (basic)
 */
function cognysens_add_appointments_menu() {
    add_submenu_page(
        'cognysens-settings',
        'Rendez-vous',
        'Rendez-vous',
        'manage_options',
        'cognysens-appointments',
        'cognysens_appointments_page'
    );
}
add_action('admin_menu', 'cognysens_add_appointments_menu');

/**
 * Appointments admin page
 */
function cognysens_appointments_page() {
    $appointments = get_option('cognysens_appointments', array());
    ?>
    <div class="wrap">
        <h1>Rendez-vous COGNYSENS</h1>

        <div class="cognysens-webhook-info" style="background:#fff; padding:15px; margin:15px 0; border-left:4px solid #2271b1;">
            <h3 style="margin-top:0;">Configuration Webhook</h3>
            <p>URL du webhook: <code><?php echo esc_url(rest_url('cognysens/v1/booking/webhook')); ?></code></p>
            <p>Token: <code><?php echo esc_html(get_option('cognysens_webhook_token', 'Non genere')); ?></code></p>
        </div>

        <?php if (empty($appointments)) : ?>
            <p>Aucun rendez-vous enregistre.</p>
        <?php else : ?>
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Client</th>
                        <th>Service</th>
                        <th>Statut</th>
                        <th>Resume IA</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($appointments as $appt) : ?>
                        <tr>
                            <td>
                                <?php
                                if (!empty($appt['datetime'])) {
                                    echo esc_html(date('d/m/Y H:i', strtotime($appt['datetime'])));
                                } else {
                                    echo '-';
                                }
                                ?>
                            </td>
                            <td>
                                <strong><?php echo esc_html($appt['client_name']); ?></strong><br>
                                <small><?php echo esc_html($appt['client_email']); ?></small><br>
                                <small><?php echo esc_html($appt['client_phone']); ?></small>
                            </td>
                            <td><?php echo esc_html($appt['service']); ?></td>
                            <td>
                                <span class="status-<?php echo esc_attr($appt['status']); ?>">
                                    <?php echo esc_html(ucfirst($appt['status'])); ?>
                                </span>
                            </td>
                            <td>
                                <?php echo !empty($appt['ai_summary']) ? esc_html($appt['ai_summary']) : '-'; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
    <style>
        .status-confirmed { color: #00a32a; font-weight: 500; }
        .status-cancelled { color: #d63638; font-weight: 500; }
        .status-pending { color: #dba617; font-weight: 500; }
    </style>
    <?php
}

/**
 * Shortcode for booking
 */
function cognysens_booking_shortcode($atts) {
    $atts = shortcode_atts(array(
        'service' => '',
        'type' => '',
    ), $atts);

    ob_start();
    cognysens_booking_widget($atts);
    return ob_get_clean();
}
add_shortcode('cognysens_booking', 'cognysens_booking_shortcode');
