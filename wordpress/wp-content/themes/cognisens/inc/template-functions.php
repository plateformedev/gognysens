<?php
/**
 * Template Functions
 *
 * @package Cognisens
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get page breadcrumb
 */
function cognisens_breadcrumb() {
    if (is_front_page()) {
        return;
    }

    $separator = '<span class="breadcrumb-separator">/</span>';
    $output = '<nav class="breadcrumb" aria-label="Fil d\'Ariane">';
    $output .= '<a href="' . esc_url(home_url('/')) . '">' . esc_html__('Accueil', 'cognisens') . '</a>';

    if (is_page()) {
        $ancestors = get_post_ancestors(get_the_ID());
        if ($ancestors) {
            $ancestors = array_reverse($ancestors);
            foreach ($ancestors as $ancestor) {
                $output .= $separator . '<a href="' . esc_url(get_permalink($ancestor)) . '">' . esc_html(get_the_title($ancestor)) . '</a>';
            }
        }
        $output .= $separator . '<span class="current">' . esc_html(get_the_title()) . '</span>';
    }

    $output .= '</nav>';
    echo $output;
}

/**
 * Get section title with optional subtitle
 */
function cognisens_section_title($title, $subtitle = '', $tag = 'h2') {
    $output = '<div class="section-header">';
    $output .= '<' . esc_attr($tag) . ' class="section-title">' . esc_html($title) . '</' . esc_attr($tag) . '>';
    if ($subtitle) {
        $output .= '<p class="section-subtitle">' . esc_html($subtitle) . '</p>';
    }
    $output .= '</div>';
    echo $output;
}

/**
 * CTA Button
 */
function cognisens_cta_button($text, $url, $style = 'primary') {
    $class = 'btn btn-' . esc_attr($style);
    return '<a href="' . esc_url($url) . '" class="' . $class . '">' . esc_html($text) . '</a>';
}

/**
 * Get zone intervention areas
 */
function cognisens_get_zones() {
    return array(
        'paris' => array(
            'name' => 'Paris',
            'slug' => 'expert-bati-ancien-paris',
            'department' => '75',
        ),
        'hauts-de-seine' => array(
            'name' => 'Hauts-de-Seine',
            'slug' => 'expert-bati-ancien-hauts-de-seine',
            'department' => '92',
        ),
        'val-de-marne' => array(
            'name' => 'Val-de-Marne',
            'slug' => 'expert-bati-ancien-val-de-marne',
            'department' => '94',
        ),
        'yvelines' => array(
            'name' => 'Yvelines',
            'slug' => 'expert-bati-ancien-yvelines',
            'department' => '78',
        ),
    );
}

/**
 * Format price display
 */
function cognisens_format_price($price, $suffix = ' HT') {
    return number_format($price, 0, ',', ' ') . ' &euro;' . $suffix;
}

/**
 * Get contact info
 */
function cognisens_get_contact() {
    return array(
        'address' => '109 chemin de Ronde',
        'city' => 'Croissy-sur-Seine',
        'postal' => '78290',
        'country' => 'France',
        'full_address' => '109 chemin de Ronde, 78290 Croissy-sur-Seine',
    );
}

/**
 * Phone link formatter
 */
function cognisens_phone_link($phone) {
    $clean = preg_replace('/[^0-9+]/', '', $phone);
    return 'tel:' . $clean;
}

/**
 * Check if page is in a section
 */
function cognisens_is_section($section) {
    if (!is_page()) {
        return false;
    }

    $current_slug = get_post_field('post_name', get_the_ID());
    $parent_slug = '';

    if ($parent_id = wp_get_post_parent_id(get_the_ID())) {
        $parent_slug = get_post_field('post_name', $parent_id);
    }

    $sections = array(
        'cabinet' => array('le-cabinet', 'equipe', 'methodologie', 'independance-deontologie', 'cadre-juridique', 'zone-intervention'),
        'expertise' => array('expertise-amiable-bati-ancien', 'assistance-expertise-judiciaire-bati-patrimonial', 'dtg-bati-ancien-copropriete'),
        'amo' => array('amo-bati-ancien-patrimonial', 'amo-copropriete-eviter-surpayer-travaux', 'amo-fonciere-patrimoniale'),
        'tarifs' => array('honoraires-tarifs-expertise-amo', 'combien-coute-expertise-fissure-facade'),
    );

    if (isset($sections[$section])) {
        return in_array($current_slug, $sections[$section]) || in_array($parent_slug, $sections[$section]);
    }

    return false;
}
