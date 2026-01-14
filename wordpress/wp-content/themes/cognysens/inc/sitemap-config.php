<?php
/**
 * Sitemap Configuration
 * Configuration for XML sitemap (works with RankMath, Yoast, or custom)
 *
 * @package Cognysens
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Priority pages for sitemap
 * These pages should have higher priority in search engines
 */
function cognysens_get_priority_pages() {
    return array(
        // Homepage
        '/' => array(
            'priority' => 1.0,
            'changefreq' => 'weekly',
        ),
        // Main service pages
        '/expertise-amiable-bati-ancien/' => array(
            'priority' => 0.9,
            'changefreq' => 'monthly',
        ),
        '/amo-copropriete-eviter-surpayer-travaux/' => array(
            'priority' => 0.9,
            'changefreq' => 'monthly',
        ),
        '/dtg-bati-ancien-copropriete/' => array(
            'priority' => 0.9,
            'changefreq' => 'monthly',
        ),
        // GEO SEO pages
        '/expert-bati-ancien-paris/' => array(
            'priority' => 0.9,
            'changefreq' => 'monthly',
        ),
        '/expert-bati-ancien-hauts-de-seine/' => array(
            'priority' => 0.8,
            'changefreq' => 'monthly',
        ),
        '/expert-bati-ancien-val-de-marne/' => array(
            'priority' => 0.8,
            'changefreq' => 'monthly',
        ),
        '/expert-bati-ancien-yvelines/' => array(
            'priority' => 0.8,
            'changefreq' => 'monthly',
        ),
        // Tarifs
        '/honoraires-tarifs-expertise-amo/' => array(
            'priority' => 0.8,
            'changefreq' => 'monthly',
        ),
        // Contact/RDV
        '/prendre-rendez-vous/' => array(
            'priority' => 0.8,
            'changefreq' => 'monthly',
        ),
        '/contact/' => array(
            'priority' => 0.7,
            'changefreq' => 'monthly',
        ),
        // Cabinet
        '/le-cabinet/' => array(
            'priority' => 0.7,
            'changefreq' => 'monthly',
        ),
    );
}

/**
 * Pages to exclude from sitemap
 */
function cognysens_get_excluded_pages() {
    return array(
        'mentions-legales',
        'politique-de-confidentialite',
        'politique-cookies',
        'conditions-generales-utilisation',
        'conditions-generales-prestations',
        'donnees-personnelles-et-ia',
    );
}

/**
 * RankMath: Modify sitemap priority
 */
function cognysens_rankmath_sitemap_priority($priority, $type, $object) {
    if ($type !== 'post' || !is_a($object, 'WP_Post')) {
        return $priority;
    }

    $priority_pages = cognysens_get_priority_pages();
    $slug = '/' . $object->post_name . '/';

    if (isset($priority_pages[$slug])) {
        return $priority_pages[$slug]['priority'];
    }

    // Default priorities by template
    $template = get_page_template_slug($object->ID);
    switch ($template) {
        case 'templates/page-expertise.php':
        case 'templates/page-amo.php':
            return 0.8;
        case 'templates/page-geo.php':
            return 0.8;
        case 'templates/page-pathologie.php':
        case 'templates/page-domaine.php':
            return 0.7;
        case 'templates/page-tarifs.php':
            return 0.8;
        case 'templates/page-legal.php':
            return 0.3;
        default:
            return 0.6;
    }
}
add_filter('rank_math/sitemap/entry', function($url, $type, $object) {
    if ($type === 'post' && is_a($object, 'WP_Post')) {
        $url['priority'] = cognysens_rankmath_sitemap_priority($url['priority'] ?? 0.6, $type, $object);
    }
    return $url;
}, 10, 3);

/**
 * RankMath: Exclude legal pages from sitemap (optional)
 */
function cognysens_rankmath_exclude_from_sitemap($exclude, $type, $object) {
    if ($type !== 'post' || !is_a($object, 'WP_Post')) {
        return $exclude;
    }

    // Don't exclude legal pages by default - they should be indexed
    // Uncomment below to exclude them
    // $excluded_pages = cognysens_get_excluded_pages();
    // if (in_array($object->post_name, $excluded_pages)) {
    //     return true;
    // }

    return $exclude;
}
// add_filter('rank_math/sitemap/exclude_post', 'cognysens_rankmath_exclude_from_sitemap', 10, 3);

/**
 * Generate basic sitemap XML (fallback if no SEO plugin)
 */
function cognysens_generate_basic_sitemap() {
    $pages = get_pages(array(
        'post_status' => 'publish',
        'sort_column' => 'menu_order',
    ));

    $priority_pages = cognysens_get_priority_pages();

    $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

    // Homepage
    $xml .= '  <url>' . "\n";
    $xml .= '    <loc>' . home_url('/') . '</loc>' . "\n";
    $xml .= '    <lastmod>' . date('Y-m-d') . '</lastmod>' . "\n";
    $xml .= '    <changefreq>weekly</changefreq>' . "\n";
    $xml .= '    <priority>1.0</priority>' . "\n";
    $xml .= '  </url>' . "\n";

    // Pages
    foreach ($pages as $page) {
        $slug = '/' . $page->post_name . '/';
        $priority = isset($priority_pages[$slug]) ? $priority_pages[$slug]['priority'] : 0.6;
        $changefreq = isset($priority_pages[$slug]) ? $priority_pages[$slug]['changefreq'] : 'monthly';

        $xml .= '  <url>' . "\n";
        $xml .= '    <loc>' . get_permalink($page->ID) . '</loc>' . "\n";
        $xml .= '    <lastmod>' . get_the_modified_date('Y-m-d', $page->ID) . '</lastmod>' . "\n";
        $xml .= '    <changefreq>' . $changefreq . '</changefreq>' . "\n";
        $xml .= '    <priority>' . $priority . '</priority>' . "\n";
        $xml .= '  </url>' . "\n";
    }

    $xml .= '</urlset>';

    return $xml;
}

/**
 * Add last modified header for better caching
 */
function cognysens_last_modified_header() {
    if (is_singular() && !is_admin()) {
        $post_id = get_the_ID();
        $modified = get_the_modified_time('U', $post_id);

        if ($modified) {
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $modified) . ' GMT');
        }
    }
}
add_action('template_redirect', 'cognysens_last_modified_header');

/**
 * Ping search engines when content is updated
 * (Only if no SEO plugin is handling this)
 */
function cognysens_ping_search_engines($post_id) {
    // Skip if SEO plugin is active
    if (function_exists('rank_math') || class_exists('WPSEO_Options')) {
        return;
    }

    // Only for published pages
    if (get_post_status($post_id) !== 'publish' || get_post_type($post_id) !== 'page') {
        return;
    }

    // Ping Google
    $sitemap_url = home_url('/sitemap.xml');
    wp_remote_get('https://www.google.com/ping?sitemap=' . urlencode($sitemap_url), array(
        'blocking' => false,
        'timeout' => 5,
    ));
}
add_action('save_post', 'cognysens_ping_search_engines');
