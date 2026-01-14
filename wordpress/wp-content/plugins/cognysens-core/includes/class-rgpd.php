<?php
/**
 * RGPD Compliance Class
 *
 * Handles GDPR/RGPD compliance features
 *
 * @package Cognysens_Core
 */

if (!defined('ABSPATH')) {
    exit;
}

class Cognysens_RGPD {

    private static $instance = null;

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        // Form enhancements
        add_filter('gform_field_content', array($this, 'add_rgpd_notice'), 10, 5);

        // Data export
        add_filter('wp_privacy_personal_data_exporters', array($this, 'register_exporter'));
        add_filter('wp_privacy_personal_data_erasers', array($this, 'register_eraser'));

        // Cookie consent shortcode
        add_shortcode('cognysens_cookie_settings', array($this, 'cookie_settings_shortcode'));

        // Add AI disclosure to booking forms
        add_action('wp_footer', array($this, 'ai_disclosure_notice'));
    }

    /**
     * Add RGPD notice to Gravity Forms
     */
    public function add_rgpd_notice($content, $field, $value, $entry_id, $form_id) {
        // Only add to consent/checkbox fields
        if ($field->type !== 'consent' && $field->type !== 'checkbox') {
            return $content;
        }

        // Check if this is a RGPD field
        if (strpos($field->label, 'RGPD') !== false || strpos($field->label, 'confidentialite') !== false) {
            $privacy_url = home_url('/politique-de-confidentialite/');
            $ai_url = home_url('/donnees-personnelles-et-ia/');

            $notice = sprintf(
                '<p class="rgpd-notice">%s <a href="%s" target="_blank">%s</a> %s <a href="%s" target="_blank">%s</a>.</p>',
                __('Consultez notre', 'cognysens-core'),
                esc_url($privacy_url),
                __('politique de confidentialite', 'cognysens-core'),
                __('et notre page', 'cognysens-core'),
                esc_url($ai_url),
                __('Donnees et IA', 'cognysens-core')
            );

            $content .= $notice;
        }

        return $content;
    }

    /**
     * Register data exporter
     */
    public function register_exporter($exporters) {
        $exporters['cognysens-leads'] = array(
            'exporter_friendly_name' => __('Cognysens Leads', 'cognysens-core'),
            'callback' => array($this, 'export_lead_data'),
        );
        return $exporters;
    }

    /**
     * Export lead data
     */
    public function export_lead_data($email_address, $page = 1) {
        $data_to_export = array();

        $leads = get_posts(array(
            'post_type' => 'cognysens_lead',
            'meta_query' => array(
                array(
                    'key' => '_lead_email',
                    'value' => $email_address,
                ),
            ),
            'posts_per_page' => -1,
        ));

        foreach ($leads as $lead) {
            $data_to_export[] = array(
                'group_id' => 'cognysens-leads',
                'group_label' => __('Demandes Cognysens', 'cognysens-core'),
                'item_id' => 'lead-' . $lead->ID,
                'data' => array(
                    array(
                        'name' => __('Date', 'cognysens-core'),
                        'value' => $lead->post_date,
                    ),
                    array(
                        'name' => __('Type', 'cognysens-core'),
                        'value' => get_post_meta($lead->ID, '_lead_type', true),
                    ),
                    array(
                        'name' => __('Message', 'cognysens-core'),
                        'value' => $lead->post_content,
                    ),
                ),
            );
        }

        return array(
            'data' => $data_to_export,
            'done' => true,
        );
    }

    /**
     * Register data eraser
     */
    public function register_eraser($erasers) {
        $erasers['cognysens-leads'] = array(
            'eraser_friendly_name' => __('Cognysens Leads', 'cognysens-core'),
            'callback' => array($this, 'erase_lead_data'),
        );
        return $erasers;
    }

    /**
     * Erase lead data
     */
    public function erase_lead_data($email_address, $page = 1) {
        $leads = get_posts(array(
            'post_type' => 'cognysens_lead',
            'meta_query' => array(
                array(
                    'key' => '_lead_email',
                    'value' => $email_address,
                ),
            ),
            'posts_per_page' => -1,
        ));

        $items_removed = 0;

        foreach ($leads as $lead) {
            wp_delete_post($lead->ID, true);
            $items_removed++;
        }

        return array(
            'items_removed' => $items_removed,
            'items_retained' => 0,
            'messages' => array(),
            'done' => true,
        );
    }

    /**
     * Cookie settings shortcode
     */
    public function cookie_settings_shortcode() {
        ob_start();
        ?>
        <div class="cookie-settings-wrapper">
            <p><?php esc_html_e('Gerez vos preferences de cookies ci-dessous :', 'cognysens-core'); ?></p>

            <div class="cookie-category">
                <h4><?php esc_html_e('Cookies essentiels', 'cognysens-core'); ?></h4>
                <p><?php esc_html_e('Necessaires au fonctionnement du site. Toujours actifs.', 'cognysens-core'); ?></p>
            </div>

            <div class="cookie-category">
                <h4><?php esc_html_e('Cookies analytiques', 'cognysens-core'); ?></h4>
                <p><?php esc_html_e('Nous aident a comprendre comment vous utilisez le site.', 'cognysens-core'); ?></p>
                <label>
                    <input type="checkbox" name="analytics_cookies" id="analytics_cookies">
                    <?php esc_html_e('Accepter les cookies analytiques', 'cognysens-core'); ?>
                </label>
            </div>

            <button type="button" class="btn btn-primary" id="save-cookie-preferences">
                <?php esc_html_e('Enregistrer mes preferences', 'cognysens-core'); ?>
            </button>
        </div>

        <script>
        document.getElementById('save-cookie-preferences').addEventListener('click', function() {
            var analytics = document.getElementById('analytics_cookies').checked;
            document.cookie = 'cognysens_analytics=' + (analytics ? '1' : '0') + ';path=/;max-age=' + (60*60*24*365);
            alert('<?php echo esc_js(__('Preferences enregistrees', 'cognysens-core')); ?>');
        });
        </script>
        <?php
        return ob_get_clean();
    }

    /**
     * AI disclosure notice for booking pages
     */
    public function ai_disclosure_notice() {
        if (!is_page('prendre-rendez-vous')) {
            return;
        }
        ?>
        <div id="ai-disclosure-modal" style="display:none;">
            <div class="ai-disclosure-content">
                <h3><?php esc_html_e('Information sur l\'utilisation de l\'IA', 'cognysens-core'); ?></h3>
                <p>
                    <?php esc_html_e('Lors de votre prise de rendez-vous, vos reponses peuvent etre traitees par un systeme d\'intelligence artificielle pour :', 'cognysens-core'); ?>
                </p>
                <ul>
                    <li><?php esc_html_e('Resumer votre demande', 'cognysens-core'); ?></li>
                    <li><?php esc_html_e('Orienter vers le bon type d\'expertise', 'cognysens-core'); ?></li>
                    <li><?php esc_html_e('Proposer des creneaux adaptes', 'cognysens-core'); ?></li>
                </ul>
                <p>
                    <strong><?php esc_html_e('L\'IA n\'effectue aucune analyse technique de votre situation et ne prend aucune decision engageante.', 'cognysens-core'); ?></strong>
                </p>
                <p>
                    <a href="<?php echo esc_url(home_url('/donnees-personnelles-et-ia/')); ?>">
                        <?php esc_html_e('En savoir plus', 'cognysens-core'); ?>
                    </a>
                </p>
            </div>
        </div>
        <?php
    }
}
