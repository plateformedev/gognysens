<?php
/**
 * COGNISENS - Page Content Import Script
 *
 * Imports content from content/*.json files to existing pages
 * Run via WP-CLI: wp eval-file scripts/import-page-content.php
 *
 * @package Cognisens
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
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
        die('WordPress not found. Run this script via WP-CLI: wp eval-file scripts/import-page-content.php');
    }
}

/**
 * Import page content from JSON files
 */
function cognisens_import_page_content() {
    $content_dir = __DIR__ . '/../content/';
    $content_files = glob($content_dir . 'pages-*.json');

    if (empty($content_files)) {
        if (defined('WP_CLI')) {
            WP_CLI::error('No content files found in content/ directory');
        }
        return false;
    }

    $updated = 0;
    $not_found = 0;
    $errors = 0;

    foreach ($content_files as $file) {
        $file_name = basename($file);
        if (defined('WP_CLI')) {
            WP_CLI::log("Processing: {$file_name}");
        }

        $data = json_decode(file_get_contents($file), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            if (defined('WP_CLI')) {
                WP_CLI::warning("Invalid JSON in {$file_name}: " . json_last_error_msg());
            }
            $errors++;
            continue;
        }

        $pages = $data['pages'] ?? array();

        foreach ($pages as $page_data) {
            $slug = $page_data['slug'] ?? '';
            $content = $page_data['content'] ?? '';

            if (empty($slug)) {
                continue;
            }

            $page = get_page_by_path($slug);

            if (!$page) {
                // Try to create the page
                $result = cognisens_create_page_with_content($page_data);
                if ($result) {
                    $updated++;
                    if (defined('WP_CLI')) {
                        WP_CLI::log("  Created: {$slug}");
                    }
                } else {
                    $not_found++;
                    if (defined('WP_CLI')) {
                        WP_CLI::warning("  Page not found and couldn't create: {$slug}");
                    }
                }
                continue;
            }

            // Update existing page content
            $update_result = wp_update_post(array(
                'ID'           => $page->ID,
                'post_content' => $content,
            ));

            if (is_wp_error($update_result)) {
                $errors++;
                if (defined('WP_CLI')) {
                    WP_CLI::warning("  Failed to update: {$slug}");
                }
            } else {
                $updated++;
                if (defined('WP_CLI')) {
                    WP_CLI::log("  Updated: {$slug}");
                }
            }
        }
    }

    if (defined('WP_CLI')) {
        WP_CLI::success("Content import complete: {$updated} updated, {$not_found} not found, {$errors} errors");
    }

    return array(
        'updated'   => $updated,
        'not_found' => $not_found,
        'errors'    => $errors,
    );
}

/**
 * Create a page with content
 */
function cognisens_create_page_with_content($page_data) {
    $slug = $page_data['slug'];
    $content = $page_data['content'] ?? '';

    // Determine title from slug
    $title = str_replace('-', ' ', $slug);
    $title = ucwords($title);

    // Determine template based on slug
    $template = '';
    if (strpos($slug, 'mentions-legales') !== false ||
        strpos($slug, 'politique') !== false ||
        strpos($slug, 'conditions-generales') !== false ||
        strpos($slug, 'donnees-personnelles') !== false) {
        $template = 'templates/page-legal.php';
    }

    $post_data = array(
        'post_title'   => $title,
        'post_name'    => $slug,
        'post_content' => $content,
        'post_status'  => 'publish',
        'post_type'    => 'page',
    );

    if ($template) {
        $post_data['page_template'] = $template;
    }

    $post_id = wp_insert_post($post_data);

    return !is_wp_error($post_id) ? $post_id : false;
}

/**
 * Import only legal pages
 */
function cognisens_import_legal_pages() {
    $file = __DIR__ . '/../content/pages-legales.json';

    if (!file_exists($file)) {
        if (defined('WP_CLI')) {
            WP_CLI::error('pages-legales.json not found');
        }
        return false;
    }

    $data = json_decode(file_get_contents($file), true);
    $pages = $data['pages'] ?? array();
    $updated = 0;

    foreach ($pages as $page_data) {
        $slug = $page_data['slug'];
        $content = $page_data['content'];

        $page = get_page_by_path($slug);

        if (!$page) {
            // Create the page
            $title = str_replace('-', ' ', $slug);
            $title = ucwords($title);

            $post_id = wp_insert_post(array(
                'post_title'    => $title,
                'post_name'     => $slug,
                'post_content'  => $content,
                'post_status'   => 'publish',
                'post_type'     => 'page',
                'page_template' => 'templates/page-legal.php',
            ));

            if (!is_wp_error($post_id)) {
                $updated++;
                if (defined('WP_CLI')) {
                    WP_CLI::log("Created legal page: {$slug}");
                }
            }
        } else {
            // Update existing
            wp_update_post(array(
                'ID'            => $page->ID,
                'post_content'  => $content,
                'page_template' => 'templates/page-legal.php',
            ));
            $updated++;
            if (defined('WP_CLI')) {
                WP_CLI::log("Updated legal page: {$slug}");
            }
        }
    }

    if (defined('WP_CLI')) {
        WP_CLI::success("Legal pages import complete: {$updated} pages processed");
    }

    return $updated;
}

// Run import
if (defined('WP_CLI') && WP_CLI) {
    // Check for --legal-only flag
    if (in_array('--legal-only', $GLOBALS['argv'] ?? array())) {
        cognisens_import_legal_pages();
    } else {
        cognisens_import_page_content();
    }
}
