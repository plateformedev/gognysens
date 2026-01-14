<?php
/**
 * Health Check Functions
 * Validates theme installation and configuration
 *
 * @package Cognysens
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Run all health checks
 */
function cognysens_run_health_checks() {
    $checks = array();

    // PHP Version
    $checks['php_version'] = array(
        'name' => 'PHP Version',
        'status' => version_compare(PHP_VERSION, '8.0', '>=') ? 'pass' : 'fail',
        'message' => 'PHP ' . PHP_VERSION . (version_compare(PHP_VERSION, '8.0', '>=') ? ' (OK)' : ' (Requires 8.0+)'),
    );

    // WordPress Version
    global $wp_version;
    $checks['wp_version'] = array(
        'name' => 'WordPress Version',
        'status' => version_compare($wp_version, '6.0', '>=') ? 'pass' : 'fail',
        'message' => 'WordPress ' . $wp_version . (version_compare($wp_version, '6.0', '>=') ? ' (OK)' : ' (Requires 6.0+)'),
    );

    // Theme Directory Writable
    $checks['theme_writable'] = array(
        'name' => 'Theme Directory',
        'status' => is_writable(get_template_directory()) ? 'pass' : 'warning',
        'message' => is_writable(get_template_directory()) ? 'Writable' : 'Not writable (may affect some features)',
    );

    // Required Files
    $required_files = array(
        'functions.php',
        'style.css',
        'header.php',
        'footer.php',
        'front-page.php',
        'inc/seo.php',
        'inc/performance.php',
        'assets/css/main.css',
        'assets/css/critical.css',
    );

    $missing_files = array();
    foreach ($required_files as $file) {
        if (!file_exists(get_template_directory() . '/' . $file)) {
            $missing_files[] = $file;
        }
    }

    $checks['required_files'] = array(
        'name' => 'Required Files',
        'status' => empty($missing_files) ? 'pass' : 'fail',
        'message' => empty($missing_files) ? 'All files present' : 'Missing: ' . implode(', ', $missing_files),
    );

    // Menus Registered
    $menus = get_nav_menu_locations();
    $checks['menus'] = array(
        'name' => 'Navigation Menus',
        'status' => !empty($menus['primary']) ? 'pass' : 'warning',
        'message' => !empty($menus['primary']) ? 'Primary menu assigned' : 'Primary menu not assigned',
    );

    // SSL/HTTPS
    $checks['ssl'] = array(
        'name' => 'SSL/HTTPS',
        'status' => is_ssl() ? 'pass' : 'warning',
        'message' => is_ssl() ? 'HTTPS active' : 'Not using HTTPS',
    );

    // Permalinks
    $permalink_structure = get_option('permalink_structure');
    $checks['permalinks'] = array(
        'name' => 'Permalinks',
        'status' => !empty($permalink_structure) ? 'pass' : 'fail',
        'message' => !empty($permalink_structure) ? 'Custom structure: ' . $permalink_structure : 'Using default (not SEO friendly)',
    );

    // Debug Mode
    $checks['debug'] = array(
        'name' => 'Debug Mode',
        'status' => !WP_DEBUG ? 'pass' : 'warning',
        'message' => !WP_DEBUG ? 'Disabled (production ready)' : 'Enabled (disable for production)',
    );

    // Memory Limit
    $memory_limit = wp_convert_hr_to_bytes(WP_MEMORY_LIMIT);
    $checks['memory'] = array(
        'name' => 'Memory Limit',
        'status' => $memory_limit >= 268435456 ? 'pass' : 'warning', // 256MB
        'message' => WP_MEMORY_LIMIT . ($memory_limit >= 268435456 ? ' (OK)' : ' (Recommend 256M+)'),
    );

    // Max Upload Size
    $max_upload = wp_max_upload_size();
    $checks['upload'] = array(
        'name' => 'Max Upload Size',
        'status' => $max_upload >= 10485760 ? 'pass' : 'warning', // 10MB
        'message' => size_format($max_upload) . ($max_upload >= 10485760 ? ' (OK)' : ' (Recommend 10MB+)'),
    );

    // SEO Plugin
    $has_seo_plugin = function_exists('rank_math') || class_exists('WPSEO_Options') || defined('AIOSEO_VERSION');
    $checks['seo_plugin'] = array(
        'name' => 'SEO Plugin',
        'status' => $has_seo_plugin ? 'pass' : 'warning',
        'message' => $has_seo_plugin ? 'Active' : 'Not detected (theme fallback active)',
    );

    // Cache Plugin
    $has_cache = defined('WP_ROCKET_VERSION') || class_exists('LiteSpeed_Cache') || defined('W3TC');
    $checks['cache_plugin'] = array(
        'name' => 'Cache Plugin',
        'status' => $has_cache ? 'pass' : 'warning',
        'message' => $has_cache ? 'Active' : 'Not detected (recommended for performance)',
    );

    // RGPD Plugin
    $has_rgpd = defined('COMPLIANZ_VERSION') || class_exists('Cookie_Notice');
    $checks['rgpd_plugin'] = array(
        'name' => 'RGPD/Cookie Plugin',
        'status' => $has_rgpd ? 'pass' : 'warning',
        'message' => $has_rgpd ? 'Active' : 'Not detected (required for RGPD compliance)',
    );

    // Homepage Set
    $show_on_front = get_option('show_on_front');
    $checks['homepage'] = array(
        'name' => 'Homepage Setting',
        'status' => $show_on_front === 'page' ? 'pass' : 'warning',
        'message' => $show_on_front === 'page' ? 'Static page set' : 'Using blog posts (set a static homepage)',
    );

    // GD Library (for images)
    $checks['gd'] = array(
        'name' => 'GD Library',
        'status' => extension_loaded('gd') ? 'pass' : 'warning',
        'message' => extension_loaded('gd') ? 'Available' : 'Not available (image processing limited)',
    );

    // cURL
    $checks['curl'] = array(
        'name' => 'cURL Extension',
        'status' => function_exists('curl_version') ? 'pass' : 'fail',
        'message' => function_exists('curl_version') ? 'Available' : 'Not available (required for API calls)',
    );

    return $checks;
}

/**
 * Display health check results in admin
 */
function cognysens_health_check_page() {
    if (!current_user_can('manage_options')) {
        return;
    }

    $checks = cognysens_run_health_checks();
    $pass_count = count(array_filter($checks, function($c) { return $c['status'] === 'pass'; }));
    $total_count = count($checks);

    ?>
    <div class="wrap">
        <h1>Cognysens - Health Check</h1>
        <p>Score: <strong><?php echo $pass_count; ?>/<?php echo $total_count; ?></strong> checks passed</p>

        <table class="widefat striped">
            <thead>
                <tr>
                    <th>Check</th>
                    <th>Status</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($checks as $key => $check) : ?>
                <tr>
                    <td><strong><?php echo esc_html($check['name']); ?></strong></td>
                    <td>
                        <?php
                        $status_colors = array(
                            'pass' => '#46b450',
                            'warning' => '#ffb900',
                            'fail' => '#dc3232',
                        );
                        $status_labels = array(
                            'pass' => '✓ Pass',
                            'warning' => '⚠ Warning',
                            'fail' => '✗ Fail',
                        );
                        ?>
                        <span style="color: <?php echo $status_colors[$check['status']]; ?>; font-weight: bold;">
                            <?php echo $status_labels[$check['status']]; ?>
                        </span>
                    </td>
                    <td><?php echo esc_html($check['message']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2 style="margin-top: 2rem;">Quick Actions</h2>
        <p>
            <a href="<?php echo admin_url('options-permalink.php'); ?>" class="button">Permalinks Settings</a>
            <a href="<?php echo admin_url('nav-menus.php'); ?>" class="button">Menu Settings</a>
            <a href="<?php echo admin_url('options-reading.php'); ?>" class="button">Homepage Settings</a>
            <a href="<?php echo admin_url('plugins.php'); ?>" class="button">Plugins</a>
        </p>
    </div>
    <?php
}

/**
 * Add health check menu item
 */
function cognysens_add_health_check_menu() {
    add_theme_page(
        'Health Check',
        'Health Check',
        'manage_options',
        'cognysens-health-check',
        'cognysens_health_check_page'
    );
}
add_action('admin_menu', 'cognysens_add_health_check_menu');

/**
 * Show admin notice if critical checks fail
 */
function cognysens_health_check_notice() {
    if (!current_user_can('manage_options')) {
        return;
    }

    // Only show on theme pages
    $screen = get_current_screen();
    if (!$screen || strpos($screen->id, 'theme') === false) {
        return;
    }

    $checks = cognysens_run_health_checks();
    $failures = array_filter($checks, function($c) { return $c['status'] === 'fail'; });

    if (!empty($failures)) {
        echo '<div class="notice notice-error">';
        echo '<p><strong>Cognysens:</strong> ' . count($failures) . ' critical issue(s) detected. ';
        echo '<a href="' . admin_url('themes.php?page=cognysens-health-check') . '">View Health Check</a></p>';
        echo '</div>';
    }
}
add_action('admin_notices', 'cognysens_health_check_notice');

/**
 * REST API endpoint for health check (for monitoring)
 */
function cognysens_health_check_rest() {
    register_rest_route('cognysens/v1', '/health', array(
        'methods' => 'GET',
        'callback' => function() {
            $checks = cognysens_run_health_checks();
            $failures = array_filter($checks, function($c) { return $c['status'] === 'fail'; });

            return array(
                'status' => empty($failures) ? 'healthy' : 'unhealthy',
                'checks' => $checks,
                'timestamp' => current_time('c'),
            );
        },
        'permission_callback' => function() {
            return current_user_can('manage_options');
        },
    ));
}
add_action('rest_api_init', 'cognysens_health_check_rest');
