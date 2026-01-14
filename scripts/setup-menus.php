<?php
/**
 * Setup WordPress Menus
 *
 * Run via WP-CLI: wp eval-file scripts/setup-menus.php
 * Or include in import-content.php
 *
 * @package Cognysens
 */

if (!defined('ABSPATH')) {
    // If running directly, load WordPress
    $wp_load = dirname(__FILE__) . '/../wordpress/wp-load.php';
    if (file_exists($wp_load)) {
        require_once $wp_load;
    } else {
        die('WordPress not found. Run this script from WordPress context.');
    }
}

/**
 * Create Primary Menu with 7 entries max
 * Structure: Cabinet | Expertise | AMO | Pathologies | Tarifs | Contact
 * (Rendez-vous is already a CTA button in header)
 */
function cognysens_setup_primary_menu() {
    // Delete existing menu if exists
    $menu_name = 'Menu Principal';
    $menu_exists = wp_get_nav_menu_object($menu_name);

    if ($menu_exists) {
        wp_delete_nav_menu($menu_exists->term_id);
    }

    // Create new menu
    $menu_id = wp_create_nav_menu($menu_name);

    if (is_wp_error($menu_id)) {
        echo "Error creating menu: " . $menu_id->get_error_message() . "\n";
        return false;
    }

    // Menu structure (7 items max, with dropdowns)
    $menu_items = array(
        // 1. Cabinet
        array(
            'title' => 'Cabinet',
            'url' => home_url('/le-cabinet/'),
            'parent' => 0,
            'order' => 1,
            'children' => array(
                array('title' => 'Equipe', 'url' => home_url('/equipe/')),
                array('title' => 'Methodologie', 'url' => home_url('/methodologie/')),
                array('title' => 'Independance', 'url' => home_url('/independance-deontologie/')),
                array('title' => 'Zone d\'intervention', 'url' => home_url('/zone-intervention/')),
            ),
        ),
        // 2. Expertise
        array(
            'title' => 'Expertise',
            'url' => home_url('/expertise-amiable-bati-ancien/'),
            'parent' => 0,
            'order' => 2,
            'children' => array(
                array('title' => 'Expertise Amiable', 'url' => home_url('/expertise-amiable-bati-ancien/')),
                array('title' => 'Expertise Judiciaire', 'url' => home_url('/assistance-expertise-judiciaire-bati-patrimonial/')),
                array('title' => 'DTG Bati Ancien', 'url' => home_url('/dtg-bati-ancien-copropriete/')),
            ),
        ),
        // 3. AMO
        array(
            'title' => 'AMO',
            'url' => home_url('/amo-bati-ancien-patrimonial/'),
            'parent' => 0,
            'order' => 3,
            'children' => array(
                array('title' => 'AMO Bati Ancien', 'url' => home_url('/amo-bati-ancien-patrimonial/')),
                array('title' => 'AMO Copropriete', 'url' => home_url('/amo-copropriete-eviter-surpayer-travaux/')),
                array('title' => 'AMO Fonciere', 'url' => home_url('/amo-fonciere-patrimoniale/')),
            ),
        ),
        // 4. Pathologies
        array(
            'title' => 'Pathologies',
            'url' => home_url('/fissures-facade-immeuble-ancien/'),
            'parent' => 0,
            'order' => 4,
            'children' => array(
                array('title' => 'Fissures facade', 'url' => home_url('/fissures-facade-immeuble-ancien/')),
                array('title' => 'Infiltrations toiture', 'url' => home_url('/infiltrations-toiture-zinc-ardoise/')),
                array('title' => 'Pathologies bois', 'url' => home_url('/bois-champignons-insectes-humidite/')),
                array('title' => 'Degradation pierre', 'url' => home_url('/pierre-qui-se-delite/')),
            ),
        ),
        // 5. Tarifs
        array(
            'title' => 'Tarifs',
            'url' => home_url('/honoraires-tarifs-expertise-amo/'),
            'parent' => 0,
            'order' => 5,
            'children' => array(),
        ),
        // 6. Contact
        array(
            'title' => 'Contact',
            'url' => home_url('/contact/'),
            'parent' => 0,
            'order' => 6,
            'children' => array(),
        ),
    );

    // Add menu items
    foreach ($menu_items as $item) {
        $parent_id = wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title'   => $item['title'],
            'menu-item-url'     => $item['url'],
            'menu-item-status'  => 'publish',
            'menu-item-position' => $item['order'],
        ));

        if (is_wp_error($parent_id)) {
            echo "Error adding menu item {$item['title']}: " . $parent_id->get_error_message() . "\n";
            continue;
        }

        // Add children
        if (!empty($item['children'])) {
            $child_order = 1;
            foreach ($item['children'] as $child) {
                wp_update_nav_menu_item($menu_id, 0, array(
                    'menu-item-title'     => $child['title'],
                    'menu-item-url'       => $child['url'],
                    'menu-item-status'    => 'publish',
                    'menu-item-parent-id' => $parent_id,
                    'menu-item-position'  => $child_order++,
                ));
            }
        }
    }

    // Assign menu to location
    $locations = get_theme_mod('nav_menu_locations');
    $locations['primary'] = $menu_id;
    set_theme_mod('nav_menu_locations', $locations);

    echo "Primary menu created successfully with " . count($menu_items) . " items.\n";
    return true;
}

/**
 * Create Footer Menu
 */
function cognysens_setup_footer_menu() {
    $menu_name = 'Menu Footer';
    $menu_exists = wp_get_nav_menu_object($menu_name);

    if ($menu_exists) {
        wp_delete_nav_menu($menu_exists->term_id);
    }

    $menu_id = wp_create_nav_menu($menu_name);

    if (is_wp_error($menu_id)) {
        return false;
    }

    $footer_items = array(
        array('title' => 'Cabinet', 'url' => home_url('/le-cabinet/')),
        array('title' => 'Expertise', 'url' => home_url('/expertise-amiable-bati-ancien/')),
        array('title' => 'AMO', 'url' => home_url('/amo-bati-ancien-patrimonial/')),
        array('title' => 'Tarifs', 'url' => home_url('/honoraires-tarifs-expertise-amo/')),
        array('title' => 'Contact', 'url' => home_url('/contact/')),
    );

    $order = 1;
    foreach ($footer_items as $item) {
        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title'   => $item['title'],
            'menu-item-url'     => $item['url'],
            'menu-item-status'  => 'publish',
            'menu-item-position' => $order++,
        ));
    }

    // Assign to footer location
    $locations = get_theme_mod('nav_menu_locations');
    $locations['footer'] = $menu_id;
    set_theme_mod('nav_menu_locations', $locations);

    echo "Footer menu created successfully.\n";
    return true;
}

/**
 * Create Legal Menu
 */
function cognysens_setup_legal_menu() {
    $menu_name = 'Liens Legaux';
    $menu_exists = wp_get_nav_menu_object($menu_name);

    if ($menu_exists) {
        wp_delete_nav_menu($menu_exists->term_id);
    }

    $menu_id = wp_create_nav_menu($menu_name);

    if (is_wp_error($menu_id)) {
        return false;
    }

    $legal_items = array(
        array('title' => 'Mentions legales', 'url' => home_url('/mentions-legales/')),
        array('title' => 'Confidentialite', 'url' => home_url('/politique-de-confidentialite/')),
        array('title' => 'Cookies', 'url' => home_url('/politique-cookies/')),
        array('title' => 'CGU', 'url' => home_url('/conditions-generales-utilisation/')),
        array('title' => 'CGP', 'url' => home_url('/conditions-generales-prestations/')),
        array('title' => 'IA & Donnees', 'url' => home_url('/donnees-personnelles-et-ia/')),
    );

    $order = 1;
    foreach ($legal_items as $item) {
        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title'   => $item['title'],
            'menu-item-url'     => $item['url'],
            'menu-item-status'  => 'publish',
            'menu-item-position' => $order++,
        ));
    }

    // Assign to legal location
    $locations = get_theme_mod('nav_menu_locations');
    $locations['legal'] = $menu_id;
    set_theme_mod('nav_menu_locations', $locations);

    echo "Legal menu created successfully.\n";
    return true;
}

// Run setup
echo "=== Setting up COGNYSENS Menus ===\n\n";

cognysens_setup_primary_menu();
cognysens_setup_footer_menu();
cognysens_setup_legal_menu();

echo "\n=== Menu setup complete ===\n";
