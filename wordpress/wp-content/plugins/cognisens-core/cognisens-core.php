<?php
/**
 * Plugin Name: Cognisens Core
 * Plugin URI: https://cognisens.fr
 * Description: Plugin principal pour le site Cognisens - SEO Schema, RGPD, Leads Management
 * Version: 1.0.0
 * Author: Cognisens
 * Author URI: https://cognisens.fr
 * License: MIT
 * Text Domain: cognisens-core
 *
 * @package Cognisens_Core
 */

if (!defined('ABSPATH')) {
    exit;
}

define('COGNISENS_CORE_VERSION', '1.0.0');
define('COGNISENS_CORE_PATH', plugin_dir_path(__FILE__));
define('COGNISENS_CORE_URL', plugin_dir_url(__FILE__));

/**
 * Main plugin class
 */
class Cognisens_Core {

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
        require_once COGNISENS_CORE_PATH . 'includes/class-seo-schema.php';
        require_once COGNISENS_CORE_PATH . 'includes/class-rgpd.php';
        require_once COGNISENS_CORE_PATH . 'includes/class-lead-manager.php';
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
        Cognisens_SEO_Schema::get_instance();
        Cognisens_RGPD::get_instance();
        Cognisens_Lead_Manager::get_instance();

        // Load text domain
        load_plugin_textdomain('cognisens-core', false, dirname(plugin_basename(__FILE__)) . '/languages');
    }

    /**
     * Admin menu
     */
    public function admin_menu() {
        add_menu_page(
            __('Cognisens', 'cognisens-core'),
            __('Cognisens', 'cognisens-core'),
            'manage_options',
            'cognisens',
            array($this, 'admin_page'),
            'dashicons-building',
            30
        );

        add_submenu_page(
            'cognisens',
            __('Leads', 'cognisens-core'),
            __('Leads', 'cognisens-core'),
            'manage_options',
            'cognisens-leads',
            array($this, 'leads_page')
        );
    }

    /**
     * Admin page
     */
    public function admin_page() {
        ?>
        <div class="wrap">
            <h1><?php esc_html_e('Cognisens - Tableau de bord', 'cognisens-core'); ?></h1>

            <div class="cognisens-dashboard">
                <div class="card">
                    <h2><?php esc_html_e('Statistiques', 'cognisens-core'); ?></h2>
                    <?php
                    $leads_count = wp_count_posts('cognisens_lead');
                    $pages_count = wp_count_posts('page');
                    ?>
                    <ul>
                        <li><strong><?php esc_html_e('Leads:', 'cognisens-core'); ?></strong> <?php echo esc_html($leads_count->publish ?? 0); ?></li>
                        <li><strong><?php esc_html_e('Pages:', 'cognisens-core'); ?></strong> <?php echo esc_html($pages_count->publish); ?></li>
                    </ul>
                </div>

                <div class="card">
                    <h2><?php esc_html_e('Actions rapides', 'cognisens-core'); ?></h2>
                    <p>
                        <a href="<?php echo esc_url(admin_url('admin.php?page=cognisens-leads')); ?>" class="button button-primary">
                            <?php esc_html_e('Voir les leads', 'cognisens-core'); ?>
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
        $lead_manager = Cognisens_Lead_Manager::get_instance();
        $lead_manager->render_admin_page();
    }

    /**
     * Activation
     */
    public function activate() {
        // Create custom tables if needed
        Cognisens_Lead_Manager::get_instance()->create_tables();

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
function cognisens_core() {
    return Cognisens_Core::get_instance();
}

add_action('plugins_loaded', 'cognisens_core');
