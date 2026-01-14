<?php
/**
 * Form Handler
 * Processes contact and RDV forms via AJAX
 *
 * @package Cognysens
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register AJAX handlers
 */
add_action('wp_ajax_cognysens_contact', 'cognysens_handle_contact_form');
add_action('wp_ajax_nopriv_cognysens_contact', 'cognysens_handle_contact_form');

add_action('wp_ajax_cognysens_rdv', 'cognysens_handle_rdv_form');
add_action('wp_ajax_nopriv_cognysens_rdv', 'cognysens_handle_rdv_form');

/**
 * Handle Contact Form Submission
 */
function cognysens_handle_contact_form() {
    // Verify nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'cognysens_forms')) {
        wp_send_json_error(array(
            'message' => __('Erreur de securite. Veuillez rafraichir la page.', 'cognysens')
        ));
    }

    // Sanitize fields
    $name = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
    $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
    $phone = isset($_POST['phone']) ? sanitize_text_field($_POST['phone']) : '';
    $subject = isset($_POST['subject']) ? sanitize_text_field($_POST['subject']) : '';
    $message = isset($_POST['message']) ? sanitize_textarea_field($_POST['message']) : '';
    $code_postal = isset($_POST['code_postal']) ? sanitize_text_field($_POST['code_postal']) : '';
    $type_bien = isset($_POST['type_bien']) ? sanitize_text_field($_POST['type_bien']) : '';

    // Validate required fields
    $errors = array();
    if (empty($name)) $errors[] = 'Nom requis';
    if (empty($email) || !is_email($email)) $errors[] = 'Email valide requis';
    if (empty($subject)) $errors[] = 'Sujet requis';
    if (empty($message)) $errors[] = 'Message requis';

    if (!empty($errors)) {
        wp_send_json_error(array(
            'message' => implode(', ', $errors)
        ));
    }

    // Prepare email
    $to = get_option('admin_email');
    $email_subject = '[COGNYSENS Contact] ' . cognysens_get_subject_label($subject);

    $body = "Nouveau message de contact COGNYSENS\n";
    $body .= "=====================================\n\n";
    $body .= "Nom: {$name}\n";
    $body .= "Email: {$email}\n";
    $body .= "Telephone: {$phone}\n";
    $body .= "Sujet: " . cognysens_get_subject_label($subject) . "\n";

    if (!empty($type_bien)) {
        $body .= "Type de bien: {$type_bien}\n";
    }
    if (!empty($code_postal)) {
        $body .= "Code postal: {$code_postal}\n";
    }

    $body .= "\nMessage:\n{$message}\n";
    $body .= "\n=====================================\n";
    $body .= "Envoye depuis: " . home_url() . "\n";
    $body .= "Date: " . current_time('d/m/Y H:i') . "\n";

    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'Reply-To: ' . $name . ' <' . $email . '>',
    );

    // Send email
    $sent = wp_mail($to, $email_subject, $body, $headers);

    if ($sent) {
        // Log RGPD consent
        cognysens_log_form_submission('contact', array(
            'name'       => $name,
            'email'      => $email,
            'subject'    => $subject,
            'code_postal'=> $code_postal,
        ));

        // Send confirmation email to user
        cognysens_send_confirmation_email($email, $name, 'contact');

        wp_send_json_success(array(
            'message' => __('Merci ! Votre message a bien ete envoye. Nous vous repondrons sous 48h.', 'cognysens')
        ));
    } else {
        wp_send_json_error(array(
            'message' => __('Erreur lors de l\'envoi. Veuillez reessayer ou nous contacter par telephone.', 'cognysens')
        ));
    }
}

/**
 * Handle RDV Form Submission
 */
function cognysens_handle_rdv_form() {
    // Verify nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'cognysens_forms')) {
        wp_send_json_error(array(
            'message' => __('Erreur de securite. Veuillez rafraichir la page.', 'cognysens')
        ));
    }

    // Sanitize fields
    $data = array(
        'nom'              => isset($_POST['nom']) ? sanitize_text_field($_POST['nom']) : '',
        'prenom'           => isset($_POST['prenom']) ? sanitize_text_field($_POST['prenom']) : '',
        'email'            => isset($_POST['email']) ? sanitize_email($_POST['email']) : '',
        'telephone'        => isset($_POST['telephone']) ? sanitize_text_field($_POST['telephone']) : '',
        'type_bien'        => isset($_POST['type_bien']) ? sanitize_text_field($_POST['type_bien']) : '',
        'code_postal'      => isset($_POST['code_postal']) ? sanitize_text_field($_POST['code_postal']) : '',
        'annee_construction'=> isset($_POST['annee_construction']) ? sanitize_text_field($_POST['annee_construction']) : '',
        'qualite'          => isset($_POST['qualite']) ? sanitize_text_field($_POST['qualite']) : '',
        'prestation'       => isset($_POST['prestation']) ? sanitize_text_field($_POST['prestation']) : '',
        'description'      => isset($_POST['description']) ? sanitize_textarea_field($_POST['description']) : '',
        'urgence'          => isset($_POST['urgence']) ? sanitize_text_field($_POST['urgence']) : 'normal',
        'date_preferee'    => isset($_POST['date_preferee']) ? sanitize_text_field($_POST['date_preferee']) : '',
        'creneau'          => isset($_POST['creneau']) ? sanitize_text_field($_POST['creneau']) : '',
    );

    // Validate required fields
    $errors = array();
    if (empty($data['nom'])) $errors[] = 'Nom requis';
    if (empty($data['prenom'])) $errors[] = 'Prenom requis';
    if (empty($data['email']) || !is_email($data['email'])) $errors[] = 'Email valide requis';
    if (empty($data['telephone'])) $errors[] = 'Telephone requis';
    if (empty($data['type_bien'])) $errors[] = 'Type de bien requis';
    if (empty($data['code_postal'])) $errors[] = 'Code postal requis';
    if (empty($data['qualite'])) $errors[] = 'Qualite requise';
    if (empty($data['prestation'])) $errors[] = 'Type de prestation requis';
    if (empty($data['description'])) $errors[] = 'Description requise';

    if (!empty($errors)) {
        wp_send_json_error(array(
            'message' => implode(', ', $errors)
        ));
    }

    // Validate zone d'intervention
    $zone_ok = cognysens_check_zone($data['code_postal']);

    // Prepare email
    $to = get_option('admin_email');
    $urgence_label = cognysens_get_urgence_label($data['urgence']);
    $email_subject = "[COGNYSENS RDV] {$urgence_label} - " . cognysens_get_prestation_label($data['prestation']);

    $body = "NOUVELLE DEMANDE DE RENDEZ-VOUS\n";
    $body .= "=====================================\n\n";

    if (!$zone_ok) {
        $body .= "*** ATTENTION: HORS ZONE D'INTERVENTION ***\n\n";
    }

    if ($data['urgence'] === 'urgent') {
        $body .= "*** DEMANDE URGENTE ***\n\n";
    }

    $body .= "COORDONNEES\n";
    $body .= "-----------\n";
    $body .= "Nom: {$data['prenom']} {$data['nom']}\n";
    $body .= "Email: {$data['email']}\n";
    $body .= "Telephone: {$data['telephone']}\n\n";

    $body .= "LE BIEN\n";
    $body .= "-------\n";
    $body .= "Type: " . cognysens_get_type_bien_label($data['type_bien']) . "\n";
    $body .= "Code postal: {$data['code_postal']}" . ($zone_ok ? '' : ' (HORS ZONE)') . "\n";
    if (!empty($data['annee_construction'])) {
        $body .= "Construction: " . cognysens_get_annee_label($data['annee_construction']) . "\n";
    }
    $body .= "Profil: " . cognysens_get_qualite_label($data['qualite']) . "\n\n";

    $body .= "LA DEMANDE\n";
    $body .= "----------\n";
    $body .= "Prestation: " . cognysens_get_prestation_label($data['prestation']) . "\n";
    $body .= "Urgence: {$urgence_label}\n";
    if (!empty($data['date_preferee'])) {
        $body .= "Date souhaitee: " . date('d/m/Y', strtotime($data['date_preferee']));
        if (!empty($data['creneau'])) {
            $body .= " ({$data['creneau']})";
        }
        $body .= "\n";
    }
    $body .= "\nDescription:\n{$data['description']}\n";

    $body .= "\n=====================================\n";
    $body .= "Date de la demande: " . current_time('d/m/Y H:i') . "\n";

    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'Reply-To: ' . $data['prenom'] . ' ' . $data['nom'] . ' <' . $data['email'] . '>',
    );

    // Send email
    $sent = wp_mail($to, $email_subject, $body, $headers);

    if ($sent) {
        // Log the lead
        cognysens_log_form_submission('rdv', $data);

        // Send confirmation email to user
        cognysens_send_confirmation_email($data['email'], $data['prenom'], 'rdv', $data);

        wp_send_json_success(array(
            'message' => __('Merci ! Votre demande de rendez-vous a ete envoyee. Nous vous recontacterons sous 48h ouvrees.', 'cognysens')
        ));
    } else {
        wp_send_json_error(array(
            'message' => __('Erreur lors de l\'envoi. Veuillez reessayer ou nous contacter par telephone.', 'cognysens')
        ));
    }
}

/**
 * Check if postal code is in zone
 */
function cognysens_check_zone($code_postal) {
    $zones = array('75', '92', '94', '78');
    $dept = substr($code_postal, 0, 2);
    return in_array($dept, $zones);
}

/**
 * Log form submission
 */
function cognysens_log_form_submission($form_type, $data) {
    $leads = get_option('cognysens_leads', array());

    $lead = array(
        'id'         => uniqid('lead_'),
        'type'       => $form_type,
        'data'       => $data,
        'timestamp'  => current_time('mysql'),
        'ip'         => cognysens_get_client_ip(),
    );

    array_unshift($leads, $lead);

    // Keep last 500 leads
    if (count($leads) > 500) {
        $leads = array_slice($leads, 0, 500);
    }

    update_option('cognysens_leads', $leads);
}

/**
 * Send confirmation email to user
 */
function cognysens_send_confirmation_email($email, $name, $type, $data = array()) {
    $subject = ($type === 'rdv')
        ? 'Confirmation de votre demande de rendez-vous - COGNYSENS'
        : 'Confirmation de votre message - COGNYSENS';

    $body = "Bonjour {$name},\n\n";

    if ($type === 'rdv') {
        $body .= "Nous avons bien recu votre demande de rendez-vous.\n\n";
        $body .= "Recapitulatif:\n";
        $body .= "- Prestation: " . cognysens_get_prestation_label($data['prestation'] ?? '') . "\n";
        $body .= "- Type de bien: " . cognysens_get_type_bien_label($data['type_bien'] ?? '') . "\n";
        $body .= "- Localisation: " . ($data['code_postal'] ?? '') . "\n\n";
        $body .= "Nous vous recontacterons sous 48h ouvrees pour planifier votre premier echange telephonique gratuit de 15 minutes.\n\n";
    } else {
        $body .= "Nous avons bien recu votre message et nous vous repondrons sous 48h ouvrees.\n\n";
    }

    $body .= "A tres bientot,\n";
    $body .= "L'equipe COGNYSENS\n\n";
    $body .= "---\n";
    $body .= "COGNYSENS - Expertise & AMO Bati Ancien\n";
    $body .= home_url() . "\n";

    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: COGNYSENS <noreply@' . parse_url(home_url(), PHP_URL_HOST) . '>',
    );

    wp_mail($email, $subject, $body, $headers);
}

/**
 * Label helpers
 */
function cognysens_get_subject_label($value) {
    $labels = array(
        'expertise' => 'Demande d\'expertise',
        'amo'       => 'Demande d\'AMO',
        'devis'     => 'Demande de devis',
        'autre'     => 'Autre demande',
    );
    return $labels[$value] ?? $value;
}

function cognysens_get_prestation_label($value) {
    $labels = array(
        'expertise' => 'Expertise technique',
        'amo'       => 'AMO (Accompagnement travaux)',
        'dtg'       => 'DTG (Diagnostic Technique Global)',
        'conseil'   => 'Conseil / Orientation',
    );
    return $labels[$value] ?? $value;
}

function cognysens_get_type_bien_label($value) {
    $labels = array(
        'appartement'     => 'Appartement',
        'immeuble'        => 'Immeuble entier',
        'maison'          => 'Maison ancienne',
        'hotel-particulier'=> 'Hotel particulier',
        'batiment-public' => 'Batiment public/Monument',
        'autre'           => 'Autre',
    );
    return $labels[$value] ?? $value;
}

function cognysens_get_qualite_label($value) {
    $labels = array(
        'proprietaire'    => 'Proprietaire occupant',
        'bailleur'        => 'Proprietaire bailleur',
        'syndic'          => 'Syndic de copropriete',
        'conseil-syndical'=> 'Conseil syndical',
        'acquereur'       => 'Acquereur potentiel',
        'professionnel'   => 'Professionnel',
        'autre'           => 'Autre',
    );
    return $labels[$value] ?? $value;
}

function cognysens_get_annee_label($value) {
    $labels = array(
        'avant-1850' => 'Avant 1850',
        '1850-1900'  => '1850-1900',
        '1900-1945'  => '1900-1945',
        '1945-1970'  => '1945-1970',
        'apres-1970' => 'Apres 1970',
    );
    return $labels[$value] ?? 'Non precisee';
}

function cognysens_get_urgence_label($value) {
    $labels = array(
        'normal'  => 'Normal',
        'rapide'  => 'Rapide',
        'urgent'  => 'URGENT',
    );
    return $labels[$value] ?? 'Normal';
}

/**
 * Localize script data
 */
function cognysens_form_scripts() {
    wp_localize_script('cognysens-main', 'cognysensAjax', array(
        'url'   => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('cognysens_forms'),
    ));
}
add_action('wp_enqueue_scripts', 'cognysens_form_scripts', 20);
