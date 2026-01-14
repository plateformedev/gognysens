<?php
/**
 * Debug and Logging Functions
 * Development helpers and error logging
 *
 * @package Cognysens
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Log messages to debug.log when WP_DEBUG_LOG is enabled
 *
 * @param mixed  $message Message to log
 * @param string $level   Log level (info, warning, error)
 */
function cognysens_log($message, $level = 'info') {
    if (!defined('WP_DEBUG_LOG') || !WP_DEBUG_LOG) {
        return;
    }

    $prefix = strtoupper($level);
    $timestamp = current_time('Y-m-d H:i:s');

    if (is_array($message) || is_object($message)) {
        $message = print_r($message, true);
    }

    error_log("[{$timestamp}] [COGNYSENS] [{$prefix}] {$message}");
}

/**
 * Log form submissions for debugging
 *
 * @param array  $data      Form data (sanitized)
 * @param string $form_type Form type identifier
 */
function cognysens_log_form_submission($data, $form_type = 'contact') {
    if (!WP_DEBUG) {
        return;
    }

    // Remove sensitive data before logging
    $safe_data = $data;
    unset($safe_data['email']);
    unset($safe_data['telephone']);
    unset($safe_data['phone']);

    cognysens_log("Form submission [{$form_type}]: " . wp_json_encode($safe_data), 'info');
}

/**
 * Display debug info in footer (development only)
 */
function cognysens_debug_footer() {
    if (!WP_DEBUG || !current_user_can('manage_options')) {
        return;
    }

    global $wpdb;

    $queries = get_num_queries();
    $time = timer_stop(0);
    $memory = size_format(memory_get_peak_usage());

    echo "\n<!-- COGNYSENS Debug Info -->\n";
    echo "<!-- Queries: {$queries} | Time: {$time}s | Memory: {$memory} -->\n";
}
add_action('wp_footer', 'cognysens_debug_footer', 9999);

/**
 * Add debug bar data for Query Monitor plugin
 */
function cognysens_query_monitor_data($data) {
    if (!class_exists('QM_Output')) {
        return $data;
    }

    $data['cognysens'] = array(
        'theme_version' => COGNYSENS_VERSION,
        'dev_mode' => get_option('cognysens_dev_mode', false),
        'seo_plugin' => cognysens_has_seo_plugin(),
    );

    return $data;
}

/**
 * Log slow queries (over 0.5s)
 */
function cognysens_log_slow_queries() {
    if (!WP_DEBUG || !defined('SAVEQUERIES') || !SAVEQUERIES) {
        return;
    }

    global $wpdb;

    foreach ($wpdb->queries as $query) {
        if ($query[1] > 0.5) {
            cognysens_log("Slow query ({$query[1]}s): " . substr($query[0], 0, 200), 'warning');
        }
    }
}
add_action('shutdown', 'cognysens_log_slow_queries');

/**
 * Log 404 errors for monitoring broken links
 */
function cognysens_log_404() {
    if (!is_404()) {
        return;
    }

    $url = esc_url($_SERVER['REQUEST_URI'] ?? '');
    $referer = esc_url($_SERVER['HTTP_REFERER'] ?? 'direct');
    $user_agent = sanitize_text_field($_SERVER['HTTP_USER_AGENT'] ?? 'unknown');

    // Skip common bot/scanner requests
    $skip_patterns = array('/wp-login', '/xmlrpc', '/.env', '/wp-config', '/admin', '/.git');
    foreach ($skip_patterns as $pattern) {
        if (strpos($url, $pattern) !== false) {
            return;
        }
    }

    cognysens_log("404 Error: {$url} | Referer: {$referer}", 'warning');
}
add_action('template_redirect', 'cognysens_log_404');

/**
 * Log theme activation/deactivation
 */
function cognysens_log_theme_switch($new_name, $new_theme, $old_theme) {
    cognysens_log("Theme switched from '{$old_theme->get('Name')}' to '{$new_name}'", 'info');
}
add_action('switch_theme', 'cognysens_log_theme_switch', 10, 3);

/**
 * Development notice in admin bar
 */
function cognysens_admin_bar_dev_notice($wp_admin_bar) {
    if (!current_user_can('manage_options')) {
        return;
    }

    $dev_mode = get_option('cognysens_dev_mode', false);

    if ($dev_mode) {
        $wp_admin_bar->add_node(array(
            'id'    => 'cognysens-dev-mode',
            'title' => '<span style="color: #ff6b6b;">DEV MODE</span>',
            'href'  => admin_url('themes.php?page=cognysens-health-check'),
            'meta'  => array('title' => 'Site en mode developpement - noindex actif'),
        ));
    }

    if (WP_DEBUG) {
        $wp_admin_bar->add_node(array(
            'id'    => 'cognysens-debug',
            'title' => '<span style="color: #ffd93d;">DEBUG</span>',
            'href'  => '#',
            'meta'  => array('title' => 'WP_DEBUG est active'),
        ));
    }
}
add_action('admin_bar_menu', 'cognysens_admin_bar_dev_notice', 999);

/**
 * Quick debug dump function (development only)
 *
 * @param mixed $var Variable to dump
 * @param bool  $die Whether to die after dump
 */
function cognysens_dump($var, $die = false) {
    if (!WP_DEBUG || !current_user_can('manage_options')) {
        return;
    }

    echo '<pre style="background: #1e1e1e; color: #d4d4d4; padding: 15px; margin: 10px; font-size: 12px; overflow: auto; max-height: 500px;">';
    var_dump($var);
    echo '</pre>';

    if ($die) {
        die();
    }
}

/**
 * Check for common configuration issues
 */
function cognysens_check_config_issues() {
    if (!is_admin() || !current_user_can('manage_options')) {
        return;
    }

    $issues = array();

    // Check memory limit
    $memory_limit = wp_convert_hr_to_bytes(WP_MEMORY_LIMIT);
    if ($memory_limit < 67108864) { // 64MB
        $issues[] = 'Memory limit is below 64MB';
    }

    // Check max execution time
    $max_execution = ini_get('max_execution_time');
    if ($max_execution > 0 && $max_execution < 30) {
        $issues[] = 'Max execution time is below 30 seconds';
    }

    // Check upload size
    $upload_max = wp_max_upload_size();
    if ($upload_max < 2097152) { // 2MB
        $issues[] = 'Max upload size is below 2MB';
    }

    // Log issues if any
    if (!empty($issues)) {
        cognysens_log('Configuration issues detected: ' . implode(', ', $issues), 'warning');
    }
}
add_action('admin_init', 'cognysens_check_config_issues');
