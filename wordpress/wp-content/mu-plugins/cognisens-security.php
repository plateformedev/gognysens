<?php
/**
 * Plugin Name: Cognisens Security
 * Description: Must-use security plugin for Cognisens
 * Version: 1.0.0
 *
 * @package Cognisens
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Disable XML-RPC
 */
add_filter('xmlrpc_enabled', '__return_false');

/**
 * Remove WordPress version from head
 */
remove_action('wp_head', 'wp_generator');

/**
 * Disable file editing in admin
 */
if (!defined('DISALLOW_FILE_EDIT')) {
    define('DISALLOW_FILE_EDIT', true);
}

/**
 * Limit login attempts
 */
class Cognisens_Login_Security {

    private static $instance = null;
    private $max_attempts = 5;
    private $lockout_time = 900; // 15 minutes

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_filter('authenticate', array($this, 'check_attempts'), 30, 3);
        add_action('wp_login_failed', array($this, 'log_failed_attempt'));
        add_action('wp_login', array($this, 'clear_attempts'), 10, 2);
    }

    public function check_attempts($user, $username, $password) {
        if (empty($username)) {
            return $user;
        }

        $ip = $this->get_client_ip();
        $attempts = get_transient('login_attempts_' . md5($ip));

        if ($attempts >= $this->max_attempts) {
            return new WP_Error(
                'too_many_attempts',
                sprintf(
                    __('Trop de tentatives de connexion. Reessayez dans %d minutes.', 'cognisens'),
                    ceil($this->lockout_time / 60)
                )
            );
        }

        return $user;
    }

    public function log_failed_attempt($username) {
        $ip = $this->get_client_ip();
        $key = 'login_attempts_' . md5($ip);
        $attempts = get_transient($key);

        if ($attempts === false) {
            $attempts = 0;
        }

        set_transient($key, $attempts + 1, $this->lockout_time);
    }

    public function clear_attempts($username, $user) {
        $ip = $this->get_client_ip();
        delete_transient('login_attempts_' . md5($ip));
    }

    private function get_client_ip() {
        $ip = '';

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = sanitize_text_field($_SERVER['HTTP_CLIENT_IP']);
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = sanitize_text_field($_SERVER['HTTP_X_FORWARDED_FOR']);
        } elseif (!empty($_SERVER['REMOTE_ADDR'])) {
            $ip = sanitize_text_field($_SERVER['REMOTE_ADDR']);
        }

        return $ip;
    }
}
Cognisens_Login_Security::get_instance();

/**
 * Add security headers
 */
add_action('send_headers', function() {
    if (!is_admin()) {
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: SAMEORIGIN');
        header('X-XSS-Protection: 1; mode=block');
        header('Referrer-Policy: strict-origin-when-cross-origin');
    }
});

/**
 * Disable author archives (prevent user enumeration)
 */
add_action('template_redirect', function() {
    if (is_author()) {
        wp_redirect(home_url(), 301);
        exit;
    }
});

/**
 * Hide login errors
 */
add_filter('login_errors', function($error) {
    return __('Identifiants incorrects.', 'cognisens');
});

/**
 * Remove REST API user endpoints for non-authenticated users
 */
add_filter('rest_endpoints', function($endpoints) {
    if (!is_user_logged_in()) {
        if (isset($endpoints['/wp/v2/users'])) {
            unset($endpoints['/wp/v2/users']);
        }
        if (isset($endpoints['/wp/v2/users/(?P<id>[\d]+)'])) {
            unset($endpoints['/wp/v2/users/(?P<id>[\d]+)']);
        }
    }
    return $endpoints;
});
