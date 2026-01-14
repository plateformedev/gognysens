<?php
/**
 * Lead Manager Class
 *
 * Handles lead capture and management
 *
 * @package Cognysens_Core
 */

if (!defined('ABSPATH')) {
    exit;
}

class Cognysens_Lead_Manager {

    private static $instance = null;

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action('init', array($this, 'register_post_type'));
        add_action('gform_after_submission', array($this, 'capture_gravity_form_lead'), 10, 2);
        add_action('wp_ajax_cognysens_create_lead', array($this, 'ajax_create_lead'));
        add_action('wp_ajax_nopriv_cognysens_create_lead', array($this, 'ajax_create_lead'));
    }

    /**
     * Register Lead CPT
     */
    public function register_post_type() {
        register_post_type('cognysens_lead', array(
            'labels' => array(
                'name' => __('Leads', 'cognysens-core'),
                'singular_name' => __('Lead', 'cognysens-core'),
                'add_new' => __('Ajouter', 'cognysens-core'),
                'add_new_item' => __('Ajouter un lead', 'cognysens-core'),
                'edit_item' => __('Modifier le lead', 'cognysens-core'),
                'view_item' => __('Voir le lead', 'cognysens-core'),
                'search_items' => __('Rechercher', 'cognysens-core'),
                'not_found' => __('Aucun lead trouve', 'cognysens-core'),
            ),
            'public' => false,
            'show_ui' => true,
            'show_in_menu' => false,
            'supports' => array('title', 'editor', 'custom-fields'),
            'capability_type' => 'post',
            'capabilities' => array(
                'create_posts' => 'manage_options',
            ),
            'map_meta_cap' => true,
        ));

        // Register lead statuses
        register_post_status('lead_new', array(
            'label' => __('Nouveau', 'cognysens-core'),
            'public' => true,
            'show_in_admin_all_list' => true,
            'show_in_admin_status_list' => true,
            'label_count' => _n_noop('Nouveau <span class="count">(%s)</span>', 'Nouveaux <span class="count">(%s)</span>', 'cognysens-core'),
        ));

        register_post_status('lead_contacted', array(
            'label' => __('Contacte', 'cognysens-core'),
            'public' => true,
            'show_in_admin_all_list' => true,
            'show_in_admin_status_list' => true,
            'label_count' => _n_noop('Contacte <span class="count">(%s)</span>', 'Contactes <span class="count">(%s)</span>', 'cognysens-core'),
        ));

        register_post_status('lead_converted', array(
            'label' => __('Converti', 'cognysens-core'),
            'public' => true,
            'show_in_admin_all_list' => true,
            'show_in_admin_status_list' => true,
            'label_count' => _n_noop('Converti <span class="count">(%s)</span>', 'Convertis <span class="count">(%s)</span>', 'cognysens-core'),
        ));
    }

    /**
     * Create tables on activation
     */
    public function create_tables() {
        // Using CPT, no custom tables needed
        flush_rewrite_rules();
    }

    /**
     * Capture lead from Gravity Forms
     */
    public function capture_gravity_form_lead($entry, $form) {
        // Map form fields to lead data
        $lead_data = array(
            'name' => '',
            'email' => '',
            'phone' => '',
            'type' => 'contact',
            'message' => '',
            'source' => 'gravity_form_' . $form['id'],
        );

        foreach ($form['fields'] as $field) {
            $value = rgar($entry, $field->id);

            switch (strtolower($field->label)) {
                case 'nom':
                case 'name':
                    $lead_data['name'] = $value;
                    break;
                case 'email':
                case 'e-mail':
                    $lead_data['email'] = $value;
                    break;
                case 'telephone':
                case 'phone':
                case 'tel':
                    $lead_data['phone'] = $value;
                    break;
                case 'sujet':
                case 'subject':
                    $lead_data['type'] = $this->map_subject_to_type($value);
                    break;
                case 'message':
                    $lead_data['message'] = $value;
                    break;
            }
        }

        $this->create_lead($lead_data);
    }

    /**
     * Map form subject to lead type
     */
    private function map_subject_to_type($subject) {
        $subject = strtolower($subject);

        if (strpos($subject, 'expertise') !== false) {
            return 'expertise';
        } elseif (strpos($subject, 'amo') !== false) {
            return 'amo';
        } elseif (strpos($subject, 'devis') !== false) {
            return 'devis';
        }

        return 'contact';
    }

    /**
     * Create a new lead
     */
    public function create_lead($data) {
        $post_data = array(
            'post_type' => 'cognysens_lead',
            'post_title' => sanitize_text_field($data['name']) . ' - ' . date('d/m/Y H:i'),
            'post_content' => sanitize_textarea_field($data['message']),
            'post_status' => 'lead_new',
        );

        $lead_id = wp_insert_post($post_data);

        if (is_wp_error($lead_id)) {
            return false;
        }

        // Save meta
        update_post_meta($lead_id, '_lead_name', sanitize_text_field($data['name']));
        update_post_meta($lead_id, '_lead_email', sanitize_email($data['email']));
        update_post_meta($lead_id, '_lead_phone', sanitize_text_field($data['phone']));
        update_post_meta($lead_id, '_lead_type', sanitize_text_field($data['type']));
        update_post_meta($lead_id, '_lead_source', sanitize_text_field($data['source'] ?? 'website'));

        // AI summary placeholder
        if (!empty($data['ai_summary'])) {
            update_post_meta($lead_id, '_lead_ai_summary', sanitize_textarea_field($data['ai_summary']));
        }

        // Trigger notification
        do_action('cognysens_new_lead', $lead_id, $data);

        return $lead_id;
    }

    /**
     * AJAX handler for creating leads
     */
    public function ajax_create_lead() {
        check_ajax_referer('cognysens_nonce', 'nonce');

        $data = array(
            'name' => sanitize_text_field($_POST['name'] ?? ''),
            'email' => sanitize_email($_POST['email'] ?? ''),
            'phone' => sanitize_text_field($_POST['phone'] ?? ''),
            'type' => sanitize_text_field($_POST['type'] ?? 'contact'),
            'message' => sanitize_textarea_field($_POST['message'] ?? ''),
            'source' => 'ajax_form',
        );

        if (empty($data['name']) || empty($data['email'])) {
            wp_send_json_error(array('message' => __('Nom et email requis', 'cognysens-core')));
        }

        $lead_id = $this->create_lead($data);

        if ($lead_id) {
            wp_send_json_success(array(
                'message' => __('Demande enregistree', 'cognysens-core'),
                'lead_id' => $lead_id,
            ));
        } else {
            wp_send_json_error(array('message' => __('Erreur lors de l\'enregistrement', 'cognysens-core')));
        }
    }

    /**
     * Render admin page
     */
    public function render_admin_page() {
        $leads = get_posts(array(
            'post_type' => 'cognysens_lead',
            'posts_per_page' => 50,
            'orderby' => 'date',
            'order' => 'DESC',
        ));
        ?>
        <div class="wrap">
            <h1><?php esc_html_e('Leads Cognysens', 'cognysens-core'); ?></h1>

            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th><?php esc_html_e('Date', 'cognysens-core'); ?></th>
                        <th><?php esc_html_e('Nom', 'cognysens-core'); ?></th>
                        <th><?php esc_html_e('Email', 'cognysens-core'); ?></th>
                        <th><?php esc_html_e('Type', 'cognysens-core'); ?></th>
                        <th><?php esc_html_e('Statut', 'cognysens-core'); ?></th>
                        <th><?php esc_html_e('Actions', 'cognysens-core'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($leads)) : ?>
                        <tr>
                            <td colspan="6"><?php esc_html_e('Aucun lead pour le moment.', 'cognysens-core'); ?></td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($leads as $lead) : ?>
                            <tr>
                                <td><?php echo esc_html(get_the_date('d/m/Y H:i', $lead)); ?></td>
                                <td><?php echo esc_html(get_post_meta($lead->ID, '_lead_name', true)); ?></td>
                                <td><?php echo esc_html(get_post_meta($lead->ID, '_lead_email', true)); ?></td>
                                <td><?php echo esc_html(ucfirst(get_post_meta($lead->ID, '_lead_type', true))); ?></td>
                                <td><?php echo esc_html($lead->post_status); ?></td>
                                <td>
                                    <a href="<?php echo esc_url(get_edit_post_link($lead->ID)); ?>" class="button button-small">
                                        <?php esc_html_e('Voir', 'cognysens-core'); ?>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php
    }
}
