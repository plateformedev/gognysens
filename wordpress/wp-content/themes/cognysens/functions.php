<?php
/**
 * Cognysens Theme Functions
 *
 * @package Cognysens
 * @version 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

define('COGNYSENS_VERSION', '1.0.0');
define('COGNYSENS_DIR', get_template_directory());
define('COGNYSENS_URI', get_template_directory_uri());

/**
 * Theme Setup
 */
function cognysens_setup() {
    // Text domain for translations
    load_theme_textdomain('cognysens', COGNYSENS_DIR . '/languages');

    // Support for various WordPress features
    add_theme_support('automatic-feed-links');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('responsive-embeds');
    add_theme_support('wp-block-styles');
    add_theme_support('align-wide');
    add_theme_support('editor-styles');

    // Custom logo
    add_theme_support('custom-logo', array(
        'height'      => 60,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ));

    // Register navigation menus
    register_nav_menus(array(
        'primary'   => __('Menu Principal', 'cognysens'),
        'footer'    => __('Menu Footer', 'cognysens'),
        'legal'     => __('Liens Legaux', 'cognysens'),
    ));

    // Image sizes
    add_image_size('cognysens-hero', 1920, 800, true);
    add_image_size('cognysens-card', 600, 400, true);
    add_image_size('cognysens-thumbnail', 300, 200, true);
}
add_action('after_setup_theme', 'cognysens_setup');

/**
 * Enqueue Scripts and Styles
 */
function cognysens_scripts() {
    // Main stylesheet
    wp_enqueue_style(
        'cognysens-style',
        COGNYSENS_URI . '/assets/css/main.css',
        array(),
        COGNYSENS_VERSION
    );

    // Google Fonts - Cormorant Garamond + Inter
    wp_enqueue_style(
        'cognysens-fonts',
        'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap',
        array(),
        null
    );

    // Main JavaScript
    wp_enqueue_script(
        'cognysens-main',
        COGNYSENS_URI . '/assets/js/main.js',
        array(),
        COGNYSENS_VERSION,
        true
    );

    // Localize script for AJAX
    wp_localize_script('cognysens-main', 'cognysensAjax', array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('cognysens_nonce'),
    ));
}
add_action('wp_enqueue_scripts', 'cognysens_scripts');

/**
 * Editor Styles
 */
function cognysens_editor_styles() {
    add_editor_style(array(
        'assets/css/gutenberg.css',
        'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap',
    ));
}
add_action('after_setup_theme', 'cognysens_editor_styles');

/**
 * Register Block Patterns Category
 */
function cognysens_register_pattern_category() {
    register_block_pattern_category('cognysens', array(
        'label' => __('Cognysens', 'cognysens'),
    ));
}
add_action('init', 'cognysens_register_pattern_category');

/**
 * Custom Body Classes
 */
function cognysens_body_classes($classes) {
    // Add page-specific classes
    if (is_front_page()) {
        $classes[] = 'page-home';
    }
    if (is_page_template('templates/page-tarifs.php')) {
        $classes[] = 'page-tarifs';
    }
    if (is_page_template('templates/page-contact.php')) {
        $classes[] = 'page-contact';
    }
    return $classes;
}
add_filter('body_class', 'cognysens_body_classes');

/**
 * Disable WordPress Emoji
 */
function cognysens_disable_emojis() {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
}
add_action('init', 'cognysens_disable_emojis');

/**
 * Remove unnecessary WordPress features for performance
 */
function cognysens_cleanup_head() {
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'wp_shortlink_wp_head');
    remove_action('wp_head', 'rest_output_link_wp_head');
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
}
add_action('init', 'cognysens_cleanup_head');

/**
 * Add Schema.org structured data
 */
function cognysens_schema_organization() {
    if (is_front_page()) {
        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => 'Cognysens',
            'description' => 'Cabinet independant d\'expertise et d\'assistance a maitrise d\'ouvrage (AMO) specialise dans le bati ancien et patrimonial',
            'url' => home_url('/'),
            'address' => array(
                '@type' => 'PostalAddress',
                'streetAddress' => '109 chemin de Ronde',
                'addressLocality' => 'Croissy-sur-Seine',
                'postalCode' => '78290',
                'addressCountry' => 'FR',
            ),
            'areaServed' => array(
                array('@type' => 'City', 'name' => 'Paris'),
                array('@type' => 'AdministrativeArea', 'name' => 'Hauts-de-Seine'),
                array('@type' => 'AdministrativeArea', 'name' => 'Val-de-Marne'),
                array('@type' => 'AdministrativeArea', 'name' => 'Yvelines'),
            ),
            'serviceType' => array(
                'Expertise bati ancien',
                'Assistance maitrise d\'ouvrage',
                'Diagnostic technique global',
                'Expertise pathologies batiment',
            ),
        );
        echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>';
    }
}
add_action('wp_head', 'cognysens_schema_organization');

/**
 * Custom excerpt length
 */
function cognysens_excerpt_length($length) {
    return 30;
}
add_filter('excerpt_length', 'cognysens_excerpt_length');

/**
 * Custom excerpt more
 */
function cognysens_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'cognysens_excerpt_more');

/**
 * Security: Hide WordPress version
 */
function cognysens_remove_version() {
    return '';
}
add_filter('the_generator', 'cognysens_remove_version');

/**
 * Include template functions
 */
require_once COGNYSENS_DIR . '/inc/template-functions.php';

/**
 * Include custom blocks
 */
require_once COGNYSENS_DIR . '/inc/blocks.php';

/**
 * Include SEO functions
 */
require_once COGNYSENS_DIR . '/inc/seo.php';

/**
 * Include ACF fields for custom blocks
 */
require_once COGNYSENS_DIR . '/inc/acf-fields.php';

/**
 * Enqueue blocks CSS
 */
function cognysens_enqueue_blocks_css() {
    wp_enqueue_style(
        'cognysens-blocks',
        COGNYSENS_URI . '/assets/css/blocks.css',
        array('cognysens-style'),
        COGNYSENS_VERSION
    );
}
add_action('wp_enqueue_scripts', 'cognysens_enqueue_blocks_css');

/**
 * Include development mode settings (noindex)
 */
require_once COGNYSENS_DIR . '/inc/dev-mode.php';

/**
 * Include recommended plugins configuration
 */
require_once COGNYSENS_DIR . '/inc/recommended-plugins.php';

/**
 * Include RGPD form helpers
 */
require_once COGNYSENS_DIR . '/inc/rgpd-forms.php';

/**
 * Include cookie banner configuration
 */
require_once COGNYSENS_DIR . '/inc/cookie-banner.php';

/**
 * Include sitemap configuration
 */
require_once COGNYSENS_DIR . '/inc/sitemap-config.php';
