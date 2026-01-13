<?php
/**
 * SEO Functions
 *
 * @package Cognisens
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add Schema.org LocalBusiness for geo pages
 */
function cognisens_schema_local_business() {
    if (!is_page()) {
        return;
    }

    $slug = get_post_field('post_name', get_the_ID());
    $geo_pages = array(
        'expert-bati-ancien-paris' => array(
            'name' => 'Cognisens Paris',
            'area' => 'Paris',
        ),
        'expert-bati-ancien-hauts-de-seine' => array(
            'name' => 'Cognisens Hauts-de-Seine',
            'area' => 'Hauts-de-Seine',
        ),
        'expert-bati-ancien-val-de-marne' => array(
            'name' => 'Cognisens Val-de-Marne',
            'area' => 'Val-de-Marne',
        ),
        'expert-bati-ancien-yvelines' => array(
            'name' => 'Cognisens Yvelines',
            'area' => 'Yvelines',
        ),
    );

    if (!isset($geo_pages[$slug])) {
        return;
    }

    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'LocalBusiness',
        'name' => $geo_pages[$slug]['name'],
        'description' => 'Expert bati ancien et AMO en ' . $geo_pages[$slug]['area'],
        'url' => get_permalink(),
        'address' => array(
            '@type' => 'PostalAddress',
            'streetAddress' => '109 chemin de Ronde',
            'addressLocality' => 'Croissy-sur-Seine',
            'postalCode' => '78290',
            'addressCountry' => 'FR',
        ),
        'areaServed' => array(
            '@type' => 'AdministrativeArea',
            'name' => $geo_pages[$slug]['area'],
        ),
        'priceRange' => '$$',
    );

    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>';
}
add_action('wp_head', 'cognisens_schema_local_business');

/**
 * Add Schema.org Service for expertise pages
 */
function cognisens_schema_service() {
    if (!is_page()) {
        return;
    }

    $slug = get_post_field('post_name', get_the_ID());
    $service_pages = array(
        'expertise-amiable-bati-ancien' => array(
            'name' => 'Expertise Amiable Bati Ancien',
            'description' => 'Diagnostic technique independant pour identifier les desordres et pathologies du bati ancien',
        ),
        'assistance-expertise-judiciaire-bati-patrimonial' => array(
            'name' => 'Assistance Expertise Judiciaire',
            'description' => 'Accompagnement technique lors d\'expertises judiciaires sur bati patrimonial',
        ),
        'dtg-bati-ancien-copropriete' => array(
            'name' => 'DTG Bati Ancien',
            'description' => 'Diagnostic Technique Global adapte aux coproprietes en bati ancien',
        ),
        'amo-bati-ancien-patrimonial' => array(
            'name' => 'AMO Bati Ancien',
            'description' => 'Assistance a Maitrise d\'Ouvrage specialisee bati ancien et patrimonial',
        ),
        'amo-copropriete-eviter-surpayer-travaux' => array(
            'name' => 'AMO Copropriete',
            'description' => 'Accompagnement des coproprietes pour eviter de surpayer leurs travaux',
        ),
    );

    if (!isset($service_pages[$slug])) {
        return;
    }

    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'Service',
        'name' => $service_pages[$slug]['name'],
        'description' => $service_pages[$slug]['description'],
        'url' => get_permalink(),
        'provider' => array(
            '@type' => 'Organization',
            'name' => 'Cognisens',
            'url' => home_url('/'),
        ),
        'areaServed' => array(
            array('@type' => 'City', 'name' => 'Paris'),
            array('@type' => 'AdministrativeArea', 'name' => 'Hauts-de-Seine'),
            array('@type' => 'AdministrativeArea', 'name' => 'Val-de-Marne'),
            array('@type' => 'AdministrativeArea', 'name' => 'Yvelines'),
        ),
    );

    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>';
}
add_action('wp_head', 'cognisens_schema_service');

/**
 * Add Schema.org FAQPage for FAQ content
 */
function cognisens_schema_faq($faqs) {
    if (empty($faqs)) {
        return '';
    }

    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => array(),
    );

    foreach ($faqs as $faq) {
        $schema['mainEntity'][] = array(
            '@type' => 'Question',
            'name' => $faq['question'],
            'acceptedAnswer' => array(
                '@type' => 'Answer',
                'text' => $faq['answer'],
            ),
        );
    }

    return '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>';
}

/**
 * Add canonical URL
 */
function cognisens_canonical_url() {
    if (function_exists('rank_math') || class_exists('WPSEO_Options')) {
        return; // Let RankMath or Yoast handle it
    }

    if (is_singular()) {
        echo '<link rel="canonical" href="' . esc_url(get_permalink()) . '" />' . "\n";
    } elseif (is_front_page()) {
        echo '<link rel="canonical" href="' . esc_url(home_url('/')) . '" />' . "\n";
    }
}
add_action('wp_head', 'cognisens_canonical_url', 1);

/**
 * Add Open Graph meta tags
 */
function cognisens_open_graph() {
    if (function_exists('rank_math') || class_exists('WPSEO_Options')) {
        return; // Let SEO plugins handle it
    }

    if (is_singular()) {
        $title = get_the_title();
        $description = has_excerpt() ? get_the_excerpt() : wp_trim_words(get_the_content(), 30);
        $url = get_permalink();
        $image = get_the_post_thumbnail_url(get_the_ID(), 'large');
        ?>
        <meta property="og:type" content="website" />
        <meta property="og:title" content="<?php echo esc_attr($title); ?>" />
        <meta property="og:description" content="<?php echo esc_attr($description); ?>" />
        <meta property="og:url" content="<?php echo esc_url($url); ?>" />
        <?php if ($image) : ?>
        <meta property="og:image" content="<?php echo esc_url($image); ?>" />
        <?php endif; ?>
        <meta property="og:site_name" content="Cognisens" />
        <meta property="og:locale" content="fr_FR" />
        <?php
    }
}
add_action('wp_head', 'cognisens_open_graph');

/**
 * Optimize title tag
 */
function cognisens_document_title_parts($title) {
    // Add location for geo pages
    $slug = get_post_field('post_name', get_the_ID());
    $geo_suffixes = array(
        'expert-bati-ancien-paris' => ' | Paris 75',
        'expert-bati-ancien-hauts-de-seine' => ' | Hauts-de-Seine 92',
        'expert-bati-ancien-val-de-marne' => ' | Val-de-Marne 94',
        'expert-bati-ancien-yvelines' => ' | Yvelines 78',
    );

    if (isset($geo_suffixes[$slug]) && isset($title['title'])) {
        $title['title'] .= $geo_suffixes[$slug];
    }

    return $title;
}
add_filter('document_title_parts', 'cognisens_document_title_parts');
