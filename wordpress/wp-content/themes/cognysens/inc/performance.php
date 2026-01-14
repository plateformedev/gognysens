<?php
/**
 * Performance Optimizations
 * Speed and Core Web Vitals improvements
 *
 * @package Cognysens
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add native lazy loading to images
 */
function cognysens_lazy_load_images($content) {
    if (is_admin() || is_feed()) {
        return $content;
    }

    // Add loading="lazy" to images without it
    $content = preg_replace(
        '/<img(?![^>]*loading=)([^>]*)>/i',
        '<img loading="lazy"$1>',
        $content
    );

    // Add decoding="async" for better performance
    $content = preg_replace(
        '/<img(?![^>]*decoding=)([^>]*)>/i',
        '<img decoding="async"$1>',
        $content
    );

    return $content;
}
add_filter('the_content', 'cognysens_lazy_load_images', 99);
add_filter('post_thumbnail_html', 'cognysens_lazy_load_images', 99);
add_filter('widget_text', 'cognysens_lazy_load_images', 99);

/**
 * Add fetchpriority="high" to hero images (LCP optimization)
 */
function cognysens_hero_image_priority($html, $post_id, $post_thumbnail_id, $size, $attr) {
    // Only on front page or single pages for hero images
    if (is_front_page() || is_singular()) {
        // Remove lazy loading from hero images
        $html = str_replace('loading="lazy"', 'loading="eager"', $html);
        // Add fetchpriority
        if (strpos($html, 'fetchpriority') === false) {
            $html = str_replace('<img', '<img fetchpriority="high"', $html);
        }
    }
    return $html;
}
add_filter('post_thumbnail_html', 'cognysens_hero_image_priority', 100, 5);

/**
 * Preload critical resources
 */
function cognysens_preload_resources() {
    // Preload main CSS
    echo '<link rel="preload" href="' . esc_url(COGNYSENS_URI . '/assets/css/main.css') . '" as="style">' . "\n";

    // Preload fonts (critical for LCP)
    echo '<link rel="preload" href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" as="style" onload="this.onload=null;this.rel=\'stylesheet\'">' . "\n";
    echo '<noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap"></noscript>' . "\n";
}
add_action('wp_head', 'cognysens_preload_resources', 1);

/**
 * Defer non-critical JavaScript
 */
function cognysens_defer_scripts($tag, $handle, $src) {
    // Scripts to defer
    $defer_scripts = array(
        'cognysens-main',
        'comment-reply',
    );

    // Scripts to load async
    $async_scripts = array();

    if (in_array($handle, $defer_scripts)) {
        return str_replace(' src', ' defer src', $tag);
    }

    if (in_array($handle, $async_scripts)) {
        return str_replace(' src', ' async src', $tag);
    }

    return $tag;
}
add_filter('script_loader_tag', 'cognysens_defer_scripts', 10, 3);

/**
 * Add resource hints for third-party domains
 */
function cognysens_add_resource_hints() {
    // Preconnect to critical third-party origins
    $preconnect = array(
        'https://fonts.googleapis.com',
        'https://fonts.gstatic.com',
    );

    foreach ($preconnect as $url) {
        echo '<link rel="preconnect" href="' . esc_url($url) . '" crossorigin>' . "\n";
    }
}
add_action('wp_head', 'cognysens_add_resource_hints', 0);

/**
 * Remove query strings from static resources (better caching)
 */
function cognysens_remove_query_strings($src) {
    if (strpos($src, '?ver=') !== false) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}
// Uncomment if not using versioning for cache busting
// add_filter('style_loader_src', 'cognysens_remove_query_strings', 10);
// add_filter('script_loader_src', 'cognysens_remove_query_strings', 10);

/**
 * Add Cache-Control headers for static assets
 */
function cognysens_cache_headers() {
    if (is_admin()) {
        return;
    }

    // Don't cache if user is logged in
    if (is_user_logged_in()) {
        return;
    }

    // Cache static pages for 1 hour
    if (!is_singular() || is_front_page()) {
        header('Cache-Control: public, max-age=3600, s-maxage=86400');
    } else {
        // Cache single pages for 30 minutes
        header('Cache-Control: public, max-age=1800, s-maxage=43200');
    }

    // Add Vary header for proper caching
    header('Vary: Accept-Encoding, Cookie');
}
add_action('send_headers', 'cognysens_cache_headers');

/**
 * Optimize WordPress heartbeat
 */
function cognysens_heartbeat_settings($settings) {
    // Slow down heartbeat to every 60 seconds
    $settings['interval'] = 60;
    return $settings;
}
add_filter('heartbeat_settings', 'cognysens_heartbeat_settings');

/**
 * Disable heartbeat on front-end (not needed)
 */
function cognysens_disable_frontend_heartbeat() {
    if (!is_admin()) {
        wp_deregister_script('heartbeat');
    }
}
add_action('init', 'cognysens_disable_frontend_heartbeat', 1);

/**
 * Remove jQuery migrate (not needed for modern code)
 */
function cognysens_remove_jquery_migrate($scripts) {
    if (!is_admin() && isset($scripts->registered['jquery'])) {
        $script = $scripts->registered['jquery'];
        if ($script->deps) {
            $script->deps = array_diff($script->deps, array('jquery-migrate'));
        }
    }
}
add_action('wp_default_scripts', 'cognysens_remove_jquery_migrate');

/**
 * Disable self-pingbacks
 */
function cognysens_disable_self_pingbacks(&$links) {
    $home = get_option('home');
    foreach ($links as $l => $link) {
        if (strpos($link, $home) === 0) {
            unset($links[$l]);
        }
    }
}
add_action('pre_ping', 'cognysens_disable_self_pingbacks');

/**
 * Limit post revisions
 */
if (!defined('WP_POST_REVISIONS')) {
    define('WP_POST_REVISIONS', 5);
}

/**
 * Add width and height to images (CLS optimization)
 */
function cognysens_add_image_dimensions($content) {
    if (is_admin() || is_feed()) {
        return $content;
    }

    // Match images without width/height
    preg_match_all('/<img[^>]+>/i', $content, $images);

    foreach ($images[0] as $image) {
        // Skip if already has width and height
        if (preg_match('/width=/i', $image) && preg_match('/height=/i', $image)) {
            continue;
        }

        // Try to get image URL
        preg_match('/src=["\']([^"\']+)["\']/i', $image, $src);
        if (empty($src[1])) {
            continue;
        }

        // Get image dimensions
        $image_url = $src[1];
        $attachment_id = attachment_url_to_postid($image_url);

        if ($attachment_id) {
            $image_data = wp_get_attachment_image_src($attachment_id, 'full');
            if ($image_data) {
                $new_image = str_replace('<img', '<img width="' . $image_data[1] . '" height="' . $image_data[2] . '"', $image);
                $content = str_replace($image, $new_image, $content);
            }
        }
    }

    return $content;
}
add_filter('the_content', 'cognysens_add_image_dimensions', 98);

/**
 * Optimize WooCommerce (if installed)
 */
function cognysens_optimize_woocommerce() {
    if (!class_exists('WooCommerce')) {
        return;
    }

    // Disable WooCommerce styles and scripts on non-WC pages
    if (!is_woocommerce() && !is_cart() && !is_checkout()) {
        wp_dequeue_style('woocommerce-general');
        wp_dequeue_style('woocommerce-layout');
        wp_dequeue_style('woocommerce-smallscreen');
        wp_dequeue_script('wc-add-to-cart');
        wp_dequeue_script('wc-cart-fragments');
    }
}
add_action('wp_enqueue_scripts', 'cognysens_optimize_woocommerce', 99);

/**
 * Add loading="lazy" to iframes
 */
function cognysens_lazy_load_iframes($content) {
    if (is_admin() || is_feed()) {
        return $content;
    }

    $content = preg_replace(
        '/<iframe(?![^>]*loading=)([^>]*)>/i',
        '<iframe loading="lazy"$1>',
        $content
    );

    return $content;
}
add_filter('the_content', 'cognysens_lazy_load_iframes', 99);
add_filter('embed_oembed_html', 'cognysens_lazy_load_iframes', 99);

/**
 * Preload LCP image on front page
 */
function cognysens_preload_lcp_image() {
    if (!is_front_page()) {
        return;
    }

    // If there's a hero image, preload it
    $hero_image = get_theme_mod('cognysens_hero_image');
    if ($hero_image) {
        echo '<link rel="preload" as="image" href="' . esc_url($hero_image) . '">' . "\n";
    }
}
add_action('wp_head', 'cognysens_preload_lcp_image', 2);

/**
 * Add font-display: swap to Google Fonts
 * (Already included in the Google Fonts URL, but this ensures it)
 */
function cognysens_font_display_swap($html, $handle, $href, $media) {
    if (strpos($href, 'fonts.googleapis.com') !== false) {
        if (strpos($href, 'display=swap') === false) {
            $href = add_query_arg('display', 'swap', $href);
            $html = sprintf(
                '<link rel="stylesheet" id="%s-css" href="%s" media="%s" />',
                esc_attr($handle),
                esc_url($href),
                esc_attr($media)
            );
        }
    }
    return $html;
}
add_filter('style_loader_tag', 'cognysens_font_display_swap', 10, 4);
