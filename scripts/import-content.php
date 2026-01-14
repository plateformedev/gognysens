<?php
/**
 * COGNYSENS - Content Import Script
 *
 * Run this script from WP-CLI or directly in WordPress
 * Usage: wp eval-file scripts/import-content.php
 *
 * @package Cognysens
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    // Try to load WordPress
    $wp_load_paths = array(
        __DIR__ . '/../wordpress/wp-load.php',
        __DIR__ . '/../../wp-load.php',
        __DIR__ . '/../../../wp-load.php',
    );

    foreach ($wp_load_paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            break;
        }
    }

    if (!defined('ABSPATH')) {
        die('WordPress not found. Run this script via WP-CLI: wp eval-file scripts/import-content.php');
    }
}

/**
 * Import pages from JSON file
 */
function cognysens_import_pages() {
    $json_file = __DIR__ . '/seed-pages.json';

    if (!file_exists($json_file)) {
        WP_CLI::error('seed-pages.json not found');
        return false;
    }

    $data = json_decode(file_get_contents($json_file), true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        WP_CLI::error('Invalid JSON file: ' . json_last_error_msg());
        return false;
    }

    $pages = $data['pages'] ?? array();
    $created = 0;
    $updated = 0;
    $skipped = 0;
    $parent_map = array();

    // First pass: create all pages without parent relationships
    foreach ($pages as $page_data) {
        $existing = get_page_by_path($page_data['slug']);

        if ($existing) {
            $parent_map[$page_data['slug']] = $existing->ID;
            $skipped++;
            if (defined('WP_CLI')) {
                WP_CLI::log("Skipped (exists): {$page_data['title']}");
            }
            continue;
        }

        $post_data = array(
            'post_title'   => $page_data['title'],
            'post_name'    => $page_data['slug'],
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'post_content' => '',
            'menu_order'   => $page_data['menu_order'] ?? 0,
        );

        // Set template if specified
        if (!empty($page_data['template'])) {
            $post_data['page_template'] = $page_data['template'];
        }

        $post_id = wp_insert_post($post_data);

        if (is_wp_error($post_id)) {
            if (defined('WP_CLI')) {
                WP_CLI::warning("Failed to create: {$page_data['title']} - " . $post_id->get_error_message());
            }
            continue;
        }

        $parent_map[$page_data['slug']] = $post_id;

        // Set SEO meta if RankMath is active
        if (!empty($page_data['seo'])) {
            if (class_exists('RankMath')) {
                update_post_meta($post_id, 'rank_math_title', $page_data['seo']['title']);
                update_post_meta($post_id, 'rank_math_description', $page_data['seo']['description']);
            }
            // Fallback: store as custom meta
            update_post_meta($post_id, '_cognysens_seo_title', $page_data['seo']['title']);
            update_post_meta($post_id, '_cognysens_seo_description', $page_data['seo']['description']);
        }

        $created++;
        if (defined('WP_CLI')) {
            WP_CLI::log("Created: {$page_data['title']} (ID: {$post_id})");
        }
    }

    // Second pass: set parent relationships
    foreach ($pages as $page_data) {
        if (empty($page_data['parent'])) {
            continue;
        }

        $page_id = $parent_map[$page_data['slug']] ?? null;
        $parent_id = $parent_map[$page_data['parent']] ?? null;

        if ($page_id && $parent_id) {
            wp_update_post(array(
                'ID'          => $page_id,
                'post_parent' => $parent_id,
            ));
            $updated++;
        }
    }

    // Create menus
    if (!empty($data['menus'])) {
        cognysens_create_menus($data['menus'], $parent_map);
    }

    if (defined('WP_CLI')) {
        WP_CLI::success("Import complete: {$created} created, {$updated} parent relationships set, {$skipped} skipped");
    }

    return array(
        'created' => $created,
        'updated' => $updated,
        'skipped' => $skipped,
    );
}

/**
 * Create navigation menus
 */
function cognysens_create_menus($menus, $parent_map) {
    foreach ($menus as $location => $items) {
        $menu_name = 'Menu ' . ucfirst($location);
        $menu_id = wp_create_nav_menu($menu_name);

        if (is_wp_error($menu_id)) {
            // Menu might already exist
            $menu_obj = wp_get_nav_menu_object($menu_name);
            if ($menu_obj) {
                $menu_id = $menu_obj->term_id;
            } else {
                continue;
            }
        }

        $position = 0;
        foreach ($items as $item) {
            $page = get_page_by_path(trim($item['url'], '/'));

            $menu_item_data = array(
                'menu-item-title'     => $item['title'],
                'menu-item-url'       => home_url($item['url']),
                'menu-item-status'    => 'publish',
                'menu-item-position'  => $position++,
            );

            if ($page) {
                $menu_item_data['menu-item-type'] = 'post_type';
                $menu_item_data['menu-item-object'] = 'page';
                $menu_item_data['menu-item-object-id'] = $page->ID;
            } else {
                $menu_item_data['menu-item-type'] = 'custom';
            }

            wp_update_nav_menu_item($menu_id, 0, $menu_item_data);
        }

        // Assign menu to location
        $locations = get_theme_mod('nav_menu_locations');
        $locations[$location] = $menu_id;
        set_theme_mod('nav_menu_locations', $locations);

        if (defined('WP_CLI')) {
            WP_CLI::log("Created menu: {$menu_name}");
        }
    }
}

/**
 * Set up homepage
 */
function cognysens_setup_homepage() {
    $front_page = get_page_by_path('home');

    if (!$front_page) {
        // Create a home page if it doesn't exist
        $front_page_id = wp_insert_post(array(
            'post_title'   => 'Accueil',
            'post_name'    => 'accueil',
            'post_status'  => 'publish',
            'post_type'    => 'page',
        ));
    } else {
        $front_page_id = $front_page->ID;
    }

    // Set as static front page
    update_option('show_on_front', 'page');
    update_option('page_on_front', $front_page_id);

    if (defined('WP_CLI')) {
        WP_CLI::log("Homepage configured");
    }
}

// Run import
if (defined('WP_CLI') && WP_CLI) {
    cognysens_import_pages();
    cognysens_setup_homepage();
} elseif (current_user_can('manage_options')) {
    // Allow running from admin if logged in
    add_action('admin_init', function() {
        if (isset($_GET['cognysens_import']) && wp_verify_nonce($_GET['_wpnonce'], 'cognysens_import')) {
            $result = cognysens_import_pages();
            cognysens_setup_homepage();
            wp_die('Import complete: ' . print_r($result, true));
        }
    });
}
