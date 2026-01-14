<?php
/**
 * Plugin Name: Cognysens Core
 * Plugin URI: https://cognysens.fr
 * Description: Plugin principal pour le site Cognysens - SEO Schema, RGPD, Leads Management
 * Version: 1.0.0
 * Author: Cognysens
 * Author URI: https://cognysens.fr
 * License: MIT
 * Text Domain: cognysens-core
 *
 * @package Cognysens_Core
 */

if (!defined('ABSPATH')) {
    exit;
}

define('COGNYSENS_CORE_VERSION', '1.0.0');
define('COGNYSENS_CORE_PATH', plugin_dir_path(__FILE__));
define('COGNYSENS_CORE_URL', plugin_dir_url(__FILE__));

/**
 * Main plugin class
 */
class Cognysens_Core {

    /**
     * Instance
     */
    private static $instance = null;

    /**
     * Get instance
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructor
     */
    private function __construct() {
        $this->load_dependencies();
        $this->init_hooks();
    }

    /**
     * Load dependencies
     */
    private function load_dependencies() {
        require_once COGNYSENS_CORE_PATH . 'includes/class-seo-schema.php';
        require_once COGNYSENS_CORE_PATH . 'includes/class-rgpd.php';
        require_once COGNYSENS_CORE_PATH . 'includes/class-lead-manager.php';
    }

    /**
     * Initialize hooks
     */
    private function init_hooks() {
        add_action('init', array($this, 'init'));
        add_action('admin_menu', array($this, 'admin_menu'));
        register_activation_hook(__FILE__, array($this, 'activate'));
        register_deactivation_hook(__FILE__, array($this, 'deactivate'));
    }

    /**
     * Initialize
     */
    public function init() {
        // Initialize components
        Cognysens_SEO_Schema::get_instance();
        Cognysens_RGPD::get_instance();
        Cognysens_Lead_Manager::get_instance();

        // Load text domain
        load_plugin_textdomain('cognysens-core', false, dirname(plugin_basename(__FILE__)) . '/languages');
    }

    /**
     * Admin menu
     */
    public function admin_menu() {
        add_menu_page(
            __('Cognysens', 'cognysens-core'),
            __('Cognysens', 'cognysens-core'),
            'manage_options',
            'cognysens',
            array($this, 'admin_page'),
            'dashicons-building',
            30
        );

        add_submenu_page(
            'cognysens',
            __('Leads', 'cognysens-core'),
            __('Leads', 'cognysens-core'),
            'manage_options',
            'cognysens-leads',
            array($this, 'leads_page')
        );
    }

    /**
     * Admin page
     */
    public function admin_page() {
        ?>
        <div class="wrap">
            <h1><?php esc_html_e('Cognysens - Tableau de bord', 'cognysens-core'); ?></h1>

            <div class="cognysens-dashboard">
                <div class="card">
                    <h2><?php esc_html_e('Statistiques', 'cognysens-core'); ?></h2>
                    <?php
                    $leads_count = wp_count_posts('cognysens_lead');
                    $pages_count = wp_count_posts('page');
                    ?>
                    <ul>
                        <li><strong><?php esc_html_e('Leads:', 'cognysens-core'); ?></strong> <?php echo esc_html($leads_count->publish ?? 0); ?></li>
                        <li><strong><?php esc_html_e('Pages:', 'cognysens-core'); ?></strong> <?php echo esc_html($pages_count->publish); ?></li>
                    </ul>
                </div>

                <div class="card">
                    <h2><?php esc_html_e('Actions rapides', 'cognysens-core'); ?></h2>
                    <p>
                        <a href="<?php echo esc_url(admin_url('admin.php?page=cognysens-leads')); ?>" class="button button-primary">
                            <?php esc_html_e('Voir les leads', 'cognysens-core'); ?>
                        </a>
                    </p>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * Leads page
     */
    public function leads_page() {
        $lead_manager = Cognysens_Lead_Manager::get_instance();
        $lead_manager->render_admin_page();
    }

    /**
     * Activation
     */
    public function activate() {
        // Create custom tables if needed
        Cognysens_Lead_Manager::get_instance()->create_tables();

        // Flush rewrite rules
        flush_rewrite_rules();
    }

    /**
     * Deactivation
     */
    public function deactivate() {
        flush_rewrite_rules();
    }
}

// Initialize plugin
function cognysens_core() {
    return Cognysens_Core::get_instance();
}

add_action('plugins_loaded', 'cognysens_core');
