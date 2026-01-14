<?php
/**
 * Setup all navigation menus for Cognysens
 */

// Load WordPress
$wp_load_paths = array(
    __DIR__ . '/../../wp-load.php',
    __DIR__ . '/../../../wp-load.php',
    '/var/www/html/wp-load.php',
);

foreach ($wp_load_paths as $path) {
    if (file_exists($path)) {
        require_once $path;
        break;
    }
}

if (!defined('ABSPATH')) {
    die('WordPress not found');
}

echo "=== Setting up Cognysens menus ===\n\n";

// Helper function to create menu
function create_menu($menu_name, $items, $location) {
    $menu_id = wp_create_nav_menu($menu_name);

    if (is_wp_error($menu_id)) {
        $menu_obj = wp_get_nav_menu_object($menu_name);
        if ($menu_obj) {
            $menu_id = $menu_obj->term_id;
            // Clear existing items
            $existing = wp_get_nav_menu_items($menu_id);
            if ($existing) {
                foreach ($existing as $item) {
                    wp_delete_post($item->ID, true);
                }
            }
        } else {
            echo "Error creating menu: $menu_name\n";
            return false;
        }
    }

    echo "Menu: $menu_name (ID: $menu_id)\n";

    $position = 0;
    foreach ($items as $item) {
        $page = get_page_by_path($item['slug']);

        $menu_item_data = array(
            'menu-item-title' => $item['title'],
            'menu-item-status' => 'publish',
            'menu-item-position' => $position++,
        );

        if ($page) {
            $menu_item_data['menu-item-object'] = 'page';
            $menu_item_data['menu-item-object-id'] = $page->ID;
            $menu_item_data['menu-item-type'] = 'post_type';
        } else {
            $menu_item_data['menu-item-url'] = home_url('/' . $item['slug'] . '/');
            $menu_item_data['menu-item-type'] = 'custom';
        }

        $result = wp_update_nav_menu_item($menu_id, 0, $menu_item_data);

        if (is_wp_error($result)) {
            echo "  - Error: " . $item['title'] . "\n";
        } else {
            echo "  + " . $item['title'] . ($page ? '' : ' (custom)') . "\n";
        }
    }

    // Assign to location
    $locations = get_theme_mod('nav_menu_locations');
    if (!is_array($locations)) {
        $locations = array();
    }
    $locations[$location] = $menu_id;
    set_theme_mod('nav_menu_locations', $locations);

    echo "  => Assigned to: $location\n\n";

    return $menu_id;
}

// Menu Principal
$primary_items = array(
    array('title' => 'Accueil', 'slug' => 'accueil'),
    array('title' => 'Le Cabinet', 'slug' => 'le-cabinet'),
    array('title' => 'Expertise', 'slug' => 'expertise-amiable-bati-ancien'),
    array('title' => 'AMO', 'slug' => 'amo-bati-ancien-patrimonial'),
    array('title' => 'Tarifs', 'slug' => 'tarifs'),
    array('title' => 'Contact', 'slug' => 'contact'),
);

create_menu('Menu Principal', $primary_items, 'primary');

// Menu Footer
$footer_items = array(
    array('title' => 'Le Cabinet', 'slug' => 'le-cabinet'),
    array('title' => 'Nos Expertises', 'slug' => 'expertise-amiable-bati-ancien'),
    array('title' => 'AMO', 'slug' => 'amo-bati-ancien-patrimonial'),
    array('title' => 'Tarifs', 'slug' => 'tarifs'),
    array('title' => 'Contact', 'slug' => 'contact'),
    array('title' => 'Prendre RDV', 'slug' => 'prendre-rendez-vous'),
);

create_menu('Menu Footer', $footer_items, 'footer');

// Menu Legal
$legal_items = array(
    array('title' => 'Mentions Legales', 'slug' => 'mentions-legales'),
    array('title' => 'Politique de Confidentialite', 'slug' => 'politique-de-confidentialite'),
    array('title' => 'Politique Cookies', 'slug' => 'politique-cookies'),
    array('title' => 'CGU', 'slug' => 'conditions-generales-utilisation'),
    array('title' => 'CGP', 'slug' => 'conditions-generales-prestation'),
);

create_menu('Menu Legal', $legal_items, 'legal');

echo "=== Menu setup complete ===\n";

// Verify assignments
$locations = get_theme_mod('nav_menu_locations');
echo "\nMenu locations:\n";
foreach ($locations as $loc => $id) {
    $menu = wp_get_nav_menu_object($id);
    echo "  $loc => " . ($menu ? $menu->name : 'not set') . "\n";
}
