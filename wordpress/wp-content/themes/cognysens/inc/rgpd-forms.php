<?php
/**
 * RGPD Form Helpers
 * Adds RGPD compliance to all forms
 *
 * @package Cognysens
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * RGPD Checkbox HTML for forms
 *
 * @param array $args Options
 * @return string HTML checkbox
 */
function cognysens_rgpd_checkbox($args = array()) {
    $defaults = array(
        'name'     => 'rgpd_consent',
        'id'       => 'rgpd-consent',
        'required' => true,
        'class'    => 'cognysens-rgpd-checkbox',
    );

    $args = wp_parse_args($args, $defaults);

    $required = $args['required'] ? 'required' : '';
    $required_mark = $args['required'] ? '<span class="required">*</span>' : '';

    ob_start();
    ?>
    <div class="<?php echo esc_attr($args['class']); ?>">
        <label class="rgpd-label">
            <input type="checkbox"
                   name="<?php echo esc_attr($args['name']); ?>"
                   id="<?php echo esc_attr($args['id']); ?>"
                   value="1"
                   <?php echo $required; ?>>
            <span class="rgpd-text">
                J'accepte que mes donnees soient traitees conformement a la
                <a href="<?php echo esc_url(home_url('/politique-de-confidentialite/')); ?>" target="_blank">politique de confidentialite</a>
                de Cognysens. <?php echo $required_mark; ?>
            </span>
        </label>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * RGPD + AI Checkbox HTML for forms using AI
 *
 * @param array $args Options
 * @return string HTML checkbox
 */
function cognysens_rgpd_ai_checkbox($args = array()) {
    $defaults = array(
        'name'     => 'rgpd_ai_consent',
        'id'       => 'rgpd-ai-consent',
        'required' => true,
        'class'    => 'cognysens-rgpd-checkbox cognysens-rgpd-ai',
    );

    $args = wp_parse_args($args, $defaults);

    $required = $args['required'] ? 'required' : '';
    $required_mark = $args['required'] ? '<span class="required">*</span>' : '';

    ob_start();
    ?>
    <div class="<?php echo esc_attr($args['class']); ?>">
        <label class="rgpd-label">
            <input type="checkbox"
                   name="<?php echo esc_attr($args['name']); ?>"
                   id="<?php echo esc_attr($args['id']); ?>"
                   value="1"
                   <?php echo $required; ?>>
            <span class="rgpd-text">
                J'accepte que mes donnees soient traitees par des outils d'intelligence artificielle
                pour qualifier ma demande. Plus d'informations sur la page
                <a href="<?php echo esc_url(home_url('/donnees-personnelles-et-ia/')); ?>" target="_blank">Donnees & IA</a>. <?php echo $required_mark; ?>
            </span>
        </label>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * Shortcode for RGPD checkbox
 */
function cognysens_rgpd_checkbox_shortcode($atts) {
    $atts = shortcode_atts(array(
        'name'     => 'rgpd_consent',
        'id'       => 'rgpd-consent',
        'required' => 'true',
    ), $atts);

    $atts['required'] = $atts['required'] === 'true';

    return cognysens_rgpd_checkbox($atts);
}
add_shortcode('cognysens_rgpd', 'cognysens_rgpd_checkbox_shortcode');

/**
 * Shortcode for RGPD + AI checkbox
 */
function cognysens_rgpd_ai_shortcode($atts) {
    $atts = shortcode_atts(array(
        'name'     => 'rgpd_ai_consent',
        'id'       => 'rgpd-ai-consent',
        'required' => 'true',
    ), $atts);

    $atts['required'] = $atts['required'] === 'true';

    return cognysens_rgpd_ai_checkbox($atts);
}
add_shortcode('cognysens_rgpd_ai', 'cognysens_rgpd_ai_shortcode');

/**
 * Gravity Forms RGPD field filter
 */
function cognysens_gf_rgpd_field($field_content, $field, $value, $lead_id, $form_id) {
    if ($field->cssClass && strpos($field->cssClass, 'cognysens-rgpd') !== false) {
        // Add link to privacy policy
        $field_content = str_replace(
            'politique de confidentialite',
            '<a href="' . esc_url(home_url('/politique-de-confidentialite/')) . '" target="_blank">politique de confidentialite</a>',
            $field_content
        );
    }
    return $field_content;
}
add_filter('gform_field_content', 'cognysens_gf_rgpd_field', 10, 5);

/**
 * Validate RGPD consent on form submission
 */
function cognysens_validate_rgpd_consent() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Check if this is a form submission that needs RGPD validation
        if (isset($_POST['cognysens_form']) && !isset($_POST['rgpd_consent'])) {
            wp_die(
                __('Vous devez accepter la politique de confidentialite pour soumettre ce formulaire.', 'cognysens'),
                __('Consentement requis', 'cognysens'),
                array('back_link' => true)
            );
        }
    }
}
add_action('init', 'cognysens_validate_rgpd_consent');

/**
 * Log RGPD consent for compliance
 */
function cognysens_log_rgpd_consent($form_data) {
    if (!isset($form_data['rgpd_consent']) || $form_data['rgpd_consent'] !== '1') {
        return;
    }

    $consent_log = array(
        'timestamp'  => current_time('mysql'),
        'ip_address' => cognysens_get_client_ip(),
        'user_agent' => isset($_SERVER['HTTP_USER_AGENT']) ? sanitize_text_field($_SERVER['HTTP_USER_AGENT']) : '',
        'form_id'    => isset($form_data['form_id']) ? sanitize_text_field($form_data['form_id']) : 'unknown',
        'consent_type' => 'privacy_policy',
    );

    // Store in option or custom table
    $consents = get_option('cognysens_rgpd_consents', array());
    $consents[] = $consent_log;

    // Keep only last 1000 consents
    if (count($consents) > 1000) {
        $consents = array_slice($consents, -1000);
    }

    update_option('cognysens_rgpd_consents', $consents);
}

/**
 * Get client IP for consent logging
 */
function cognysens_get_client_ip() {
    $ip = '';

    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = sanitize_text_field($_SERVER['HTTP_CLIENT_IP']);
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = sanitize_text_field($_SERVER['HTTP_X_FORWARDED_FOR']);
    } elseif (!empty($_SERVER['REMOTE_ADDR'])) {
        $ip = sanitize_text_field($_SERVER['REMOTE_ADDR']);
    }

    // Anonymize IP for RGPD compliance (remove last octet)
    $ip_parts = explode('.', $ip);
    if (count($ip_parts) === 4) {
        $ip_parts[3] = '0';
        $ip = implode('.', $ip_parts);
    }

    return $ip;
}
