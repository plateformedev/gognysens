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

/**
 * Get related pages by section type
 */
function cognisens_get_related_pages($section, $limit = 3) {
    $current_id = get_the_ID();

    $section_slugs = array(
        'expertise' => array(
            'expertise-amiable-bati-ancien',
            'assistance-expertise-judiciaire-bati-patrimonial',
            'dtg-bati-ancien-copropriete',
            'expertise-avant-achat-immeuble-ancien',
            'expertise-reception-travaux-bati-ancien',
            'expertise-desordres-apres-travaux',
        ),
        'amo' => array(
            'amo-bati-ancien-patrimonial',
            'amo-copropriete-eviter-surpayer-travaux',
            'amo-fonciere-patrimoniale',
            'amo-particulier-bati-ancien',
            'amo-indivision-sci-bati-ancien',
            'amo-apres-expertise',
        ),
        'pathologie' => array(
            'fissures-facade-immeuble-ancien',
            'infiltrations-toiture-zinc-ardoise',
            'bois-champignons-insectes-humidite',
            'pierre-qui-se-delite',
            'decollement-enduit-facade',
            'desordres-apres-ravalement',
            'deformations-structurelles-bati-ancien',
        ),
        'domaine' => array(
            'expertise-pierre-pierre-de-taille',
            'expertise-sculpture-pierre',
            'expertise-pan-de-bois-colombage',
            'expertise-charpente-traditionnelle',
            'expertise-couverture-zinc-ardoise',
            'expertise-zinguerie-patrimoniale',
            'expertise-stucs-parisiens',
            'expertise-modenatures',
        ),
    );

    if (!isset($section_slugs[$section])) {
        return new WP_Query(array('post__in' => array(0)));
    }

    $slugs = $section_slugs[$section];
    $current_slug = get_post_field('post_name', $current_id);

    // Remove current page from related
    $slugs = array_diff($slugs, array($current_slug));

    // Randomize and limit
    shuffle($slugs);
    $slugs = array_slice($slugs, 0, $limit);

    return new WP_Query(array(
        'post_type' => 'page',
        'post_name__in' => $slugs,
        'posts_per_page' => $limit,
        'orderby' => 'post__in',
    ));
}

/**
 * Get location data from slug
 */
function cognisens_get_location_data($slug) {
    $locations = array(
        'expert-bati-ancien-paris' => array(
            'name' => 'Paris',
            'department' => '75',
            'preposition' => 'a',
            'tagline' => 'Expert en bati ancien et patrimonial intervenant sur Paris intra-muros.',
            'lat' => '48.8566',
            'lng' => '2.3522',
        ),
        'expert-bati-ancien-hauts-de-seine' => array(
            'name' => 'Hauts-de-Seine',
            'department' => '92',
            'preposition' => 'dans les',
            'tagline' => 'Expert en bati ancien intervenant dans les Hauts-de-Seine (92).',
            'lat' => '48.8407',
            'lng' => '2.2173',
        ),
        'expert-bati-ancien-val-de-marne' => array(
            'name' => 'Val-de-Marne',
            'department' => '94',
            'preposition' => 'dans le',
            'tagline' => 'Expert en bati ancien intervenant dans le Val-de-Marne (94).',
            'lat' => '48.7904',
            'lng' => '2.4555',
        ),
        'expert-bati-ancien-yvelines' => array(
            'name' => 'Yvelines',
            'department' => '78',
            'preposition' => 'dans les',
            'tagline' => 'Expert en bati ancien intervenant dans les Yvelines (78). Cabinet base a Croissy-sur-Seine.',
            'lat' => '48.8820',
            'lng' => '2.1292',
        ),
    );

    return $locations[$slug] ?? array(
        'name' => '',
        'department' => '',
        'preposition' => '',
        'tagline' => '',
        'lat' => '',
        'lng' => '',
    );
}

/**
 * Output LocalBusiness Schema for GEO pages
 */
function cognisens_local_business_schema($location_data) {
    if (empty($location_data['name'])) {
        return;
    }

    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'LocalBusiness',
        'name' => 'Cognisens - Expert Bati Ancien ' . $location_data['name'],
        'description' => 'Cabinet independant d\'expertise en bati ancien et assistance a maitrise d\'ouvrage ' . $location_data['preposition'] . ' ' . $location_data['name'],
        'address' => array(
            '@type' => 'PostalAddress',
            'streetAddress' => '109 chemin de Ronde',
            'addressLocality' => 'Croissy-sur-Seine',
            'postalCode' => '78290',
            'addressCountry' => 'FR',
        ),
        'areaServed' => array(
            '@type' => 'AdministrativeArea',
            'name' => $location_data['name'] . ' (' . $location_data['department'] . ')',
        ),
        'priceRange' => '€€',
        'serviceType' => array(
            'Expertise bati ancien',
            'Assistance maitrise d\'ouvrage',
            'Diagnostic technique global',
        ),
    );

    if (!empty($location_data['lat']) && !empty($location_data['lng'])) {
        $schema['geo'] = array(
            '@type' => 'GeoCoordinates',
            'latitude' => $location_data['lat'],
            'longitude' => $location_data['lng'],
        );
    }

    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>';
}
