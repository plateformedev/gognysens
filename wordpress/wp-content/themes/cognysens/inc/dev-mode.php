<?php
/**
 * Development Mode Settings
 * Includes noindex for development environment
 *
 * @package Cognysens
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Check if site is in development mode
 */
function cognysens_is_dev_mode() {
    // Check for DEV_MODE constant
    if (defined('COGNYSENS_DEV_MODE') && COGNYSENS_DEV_MODE === true) {
        return true;
    }

    // Check for localhost or staging domains
    $dev_domains = array(
        'localhost',
        '127.0.0.1',
        '.local',
        '.test',
        'staging.',
        'dev.',
    );

    $current_host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';

    foreach ($dev_domains as $domain) {
        if (strpos($current_host, $domain) !== false) {
            return true;
        }
    }

    return false;
}

/**
 * Add noindex meta tag in development mode
 */
function cognysens_dev_noindex() {
    if (cognysens_is_dev_mode()) {
        echo '<meta name="robots" content="noindex, nofollow" />' . "\n";
    }
}
add_action('wp_head', 'cognysens_dev_noindex', 1);

/**
 * Add admin bar notice for dev mode
 */
function cognysens_dev_admin_notice() {
    if (cognysens_is_dev_mode() && is_admin_bar_showing()) {
        ?>
        <style>
            #wpadminbar {
                background: linear-gradient(90deg, #333 0%, #8B7355 100%) !important;
            }
            #wpadminbar::after {
                content: 'MODE DEV - NOINDEX';
                position: absolute;
                right: 200px;
                top: 0;
                padding: 0 10px;
                background: #ff6b6b;
                color: white;
                font-size: 11px;
                font-weight: bold;
                line-height: 32px;
            }
        </style>
        <?php
    }
}
add_action('wp_head', 'cognysens_dev_admin_notice');
add_action('admin_head', 'cognysens_dev_admin_notice');

/**
 * Prevent search engines via robots.txt in dev mode
 */
function cognysens_dev_robots_txt($output, $public) {
    if (cognysens_is_dev_mode()) {
        $output = "User-agent: *\n";
        $output .= "Disallow: /\n";
    }
    return $output;
}
add_filter('robots_txt', 'cognysens_dev_robots_txt', 10, 2);

/**
 * Log development mode status
 */
function cognysens_dev_mode_init() {
    if (cognysens_is_dev_mode() && WP_DEBUG) {
        error_log('Cognysens: Site running in DEVELOPMENT mode - noindex active');
    }
}
add_action('init', 'cognysens_dev_mode_init');
