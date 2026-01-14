<?php
/**
 * SEO Functions
 * Advanced SEO features for Cognysens theme
 *
 * @package Cognysens
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Check if an SEO plugin is active
 */
function cognysens_has_seo_plugin() {
    return function_exists('rank_math') || class_exists('WPSEO_Options') || defined('AIOSEO_VERSION');
}

/**
 * Add meta description
 */
function cognysens_meta_description() {
    if (cognysens_has_seo_plugin()) {
        return;
    }

    $description = '';

    if (is_front_page()) {
        $description = 'Cognysens - Cabinet independant d\'expertise et d\'AMO specialise dans le bati ancien et patrimonial en Ile-de-France. Paris, 92, 94, 78.';
    } elseif (is_singular()) {
        if (has_excerpt()) {
            $description = get_the_excerpt();
        } else {
            $description = wp_trim_words(wp_strip_all_tags(get_the_content()), 25, '...');
        }
    }

    if ($description) {
        echo '<meta name="description" content="' . esc_attr($description) . '" />' . "\n";
    }
}
add_action('wp_head', 'cognysens_meta_description', 1);

/**
 * Add canonical URL
 */
function cognysens_canonical_url() {
    if (cognysens_has_seo_plugin()) {
        return;
    }

    if (is_singular()) {
        echo '<link rel="canonical" href="' . esc_url(get_permalink()) . '" />' . "\n";
    } elseif (is_front_page()) {
        echo '<link rel="canonical" href="' . esc_url(home_url('/')) . '" />' . "\n";
    }
}
add_action('wp_head', 'cognysens_canonical_url', 1);

/**
 * Add Open Graph meta tags
 */
function cognysens_open_graph() {
    if (cognysens_has_seo_plugin()) {
        return;
    }

    $og_type = 'website';
    $og_title = get_bloginfo('name');
    $og_description = get_bloginfo('description');
    $og_url = home_url('/');
    $og_image = '';

    if (is_singular()) {
        $og_title = get_the_title();
        $og_description = has_excerpt() ? get_the_excerpt() : wp_trim_words(wp_strip_all_tags(get_the_content()), 30);
        $og_url = get_permalink();
        $og_image = get_the_post_thumbnail_url(get_the_ID(), 'large');
    } elseif (is_front_page()) {
        $og_description = 'Cabinet independant d\'expertise et d\'AMO specialise dans le bati ancien et patrimonial en Ile-de-France.';
    }
    ?>
    <meta property="og:type" content="<?php echo esc_attr($og_type); ?>" />
    <meta property="og:title" content="<?php echo esc_attr($og_title); ?>" />
    <meta property="og:description" content="<?php echo esc_attr($og_description); ?>" />
    <meta property="og:url" content="<?php echo esc_url($og_url); ?>" />
    <?php if ($og_image) : ?>
    <meta property="og:image" content="<?php echo esc_url($og_image); ?>" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />
    <?php endif; ?>
    <meta property="og:site_name" content="Cognysens" />
    <meta property="og:locale" content="fr_FR" />
    <?php
}
add_action('wp_head', 'cognysens_open_graph', 5);

/**
 * Add Twitter Card meta tags
 */
function cognysens_twitter_cards() {
    if (cognysens_has_seo_plugin()) {
        return;
    }

    $twitter_title = get_bloginfo('name');
    $twitter_description = get_bloginfo('description');
    $twitter_image = '';

    if (is_singular()) {
        $twitter_title = get_the_title();
        $twitter_description = has_excerpt() ? get_the_excerpt() : wp_trim_words(wp_strip_all_tags(get_the_content()), 30);
        $twitter_image = get_the_post_thumbnail_url(get_the_ID(), 'large');
    } elseif (is_front_page()) {
        $twitter_description = 'Cabinet independant d\'expertise et d\'AMO specialise dans le bati ancien et patrimonial en Ile-de-France.';
    }
    ?>
    <meta name="twitter:card" content="<?php echo $twitter_image ? 'summary_large_image' : 'summary'; ?>" />
    <meta name="twitter:title" content="<?php echo esc_attr($twitter_title); ?>" />
    <meta name="twitter:description" content="<?php echo esc_attr($twitter_description); ?>" />
    <?php if ($twitter_image) : ?>
    <meta name="twitter:image" content="<?php echo esc_url($twitter_image); ?>" />
    <?php endif; ?>
    <?php
}
add_action('wp_head', 'cognysens_twitter_cards', 5);

/**
 * Add WebSite Schema with SearchAction
 */
function cognysens_schema_website() {
    if (!is_front_page()) {
        return;
    }

    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'WebSite',
        'name' => 'Cognysens',
        'description' => 'Cabinet independant d\'expertise et d\'AMO specialise dans le bati ancien et patrimonial',
        'url' => home_url('/'),
        'publisher' => array(
            '@type' => 'Organization',
            'name' => 'Cognysens',
            'url' => home_url('/'),
        ),
        'inLanguage' => 'fr-FR',
    );

    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
}
add_action('wp_head', 'cognysens_schema_website', 10);

/**
 * Add BreadcrumbList Schema
 */
function cognysens_schema_breadcrumb() {
    if (is_front_page() || cognysens_has_seo_plugin()) {
        return;
    }

    $breadcrumbs = array();
    $position = 1;

    // Home
    $breadcrumbs[] = array(
        '@type' => 'ListItem',
        'position' => $position++,
        'name' => 'Accueil',
        'item' => home_url('/'),
    );

    if (is_page()) {
        // Get ancestors
        $ancestors = get_post_ancestors(get_the_ID());
        if ($ancestors) {
            $ancestors = array_reverse($ancestors);
            foreach ($ancestors as $ancestor) {
                $breadcrumbs[] = array(
                    '@type' => 'ListItem',
                    'position' => $position++,
                    'name' => get_the_title($ancestor),
                    'item' => get_permalink($ancestor),
                );
            }
        }

        // Current page
        $breadcrumbs[] = array(
            '@type' => 'ListItem',
            'position' => $position,
            'name' => get_the_title(),
            'item' => get_permalink(),
        );
    }

    if (count($breadcrumbs) > 1) {
        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $breadcrumbs,
        );

        echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
    }
}
add_action('wp_head', 'cognysens_schema_breadcrumb', 10);

/**
 * Add Schema.org Organization (global)
 */
function cognysens_schema_organization_global() {
    if (!is_front_page()) {
        return;
    }

    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        '@id' => home_url('/#organization'),
        'name' => 'Cognysens',
        'url' => home_url('/'),
        'description' => 'Cabinet independant d\'expertise et d\'assistance a maitrise d\'ouvrage (AMO) specialise dans le bati ancien et patrimonial en Ile-de-France',
        'address' => array(
            '@type' => 'PostalAddress',
            'streetAddress' => '109 chemin de Ronde',
            'addressLocality' => 'Croissy-sur-Seine',
            'postalCode' => '78290',
            'addressRegion' => 'Ile-de-France',
            'addressCountry' => 'FR',
        ),
        'areaServed' => array(
            array('@type' => 'City', 'name' => 'Paris'),
            array('@type' => 'AdministrativeArea', 'name' => 'Hauts-de-Seine (92)'),
            array('@type' => 'AdministrativeArea', 'name' => 'Val-de-Marne (94)'),
            array('@type' => 'AdministrativeArea', 'name' => 'Yvelines (78)'),
        ),
        'knowsAbout' => array(
            'Expertise bati ancien',
            'Assistance maitrise d\'ouvrage',
            'Diagnostic technique global',
            'Pathologies du batiment',
            'Bati patrimonial',
        ),
        'slogan' => 'Expert independant en bati ancien et patrimonial',
        'foundingLocation' => array(
            '@type' => 'Place',
            'name' => 'Croissy-sur-Seine, France',
        ),
        'priceRange' => '€€',
    );

    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
}
add_action('wp_head', 'cognysens_schema_organization_global', 10);

/**
 * Add Schema.org LocalBusiness for geo pages
 */
function cognysens_schema_local_business() {
    if (!is_page()) {
        return;
    }

    $slug = get_post_field('post_name', get_the_ID());
    $geo_pages = array(
        'expert-bati-ancien-paris' => array(
            'name' => 'Cognysens - Expert Bati Ancien Paris',
            'area' => 'Paris',
            'department' => '75',
            'lat' => '48.8566',
            'lng' => '2.3522',
        ),
        'expert-bati-ancien-hauts-de-seine' => array(
            'name' => 'Cognysens - Expert Bati Ancien Hauts-de-Seine',
            'area' => 'Hauts-de-Seine',
            'department' => '92',
            'lat' => '48.8407',
            'lng' => '2.2173',
        ),
        'expert-bati-ancien-val-de-marne' => array(
            'name' => 'Cognysens - Expert Bati Ancien Val-de-Marne',
            'area' => 'Val-de-Marne',
            'department' => '94',
            'lat' => '48.7904',
            'lng' => '2.4555',
        ),
        'expert-bati-ancien-yvelines' => array(
            'name' => 'Cognysens - Expert Bati Ancien Yvelines',
            'area' => 'Yvelines',
            'department' => '78',
            'lat' => '48.8820',
            'lng' => '2.1292',
        ),
    );

    if (!isset($geo_pages[$slug])) {
        return;
    }

    $page = $geo_pages[$slug];

    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'LocalBusiness',
        '@id' => get_permalink() . '#localbusiness',
        'name' => $page['name'],
        'description' => 'Expert bati ancien et AMO intervenant en ' . $page['area'] . ' (' . $page['department'] . ')',
        'url' => get_permalink(),
        'address' => array(
            '@type' => 'PostalAddress',
            'streetAddress' => '109 chemin de Ronde',
            'addressLocality' => 'Croissy-sur-Seine',
            'postalCode' => '78290',
            'addressCountry' => 'FR',
        ),
        'geo' => array(
            '@type' => 'GeoCoordinates',
            'latitude' => $page['lat'],
            'longitude' => $page['lng'],
        ),
        'areaServed' => array(
            '@type' => 'AdministrativeArea',
            'name' => $page['area'] . ' (' . $page['department'] . ')',
        ),
        'priceRange' => '€€',
        'serviceType' => array(
            'Expertise bati ancien',
            'Assistance maitrise d\'ouvrage',
            'Diagnostic technique global',
        ),
    );

    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
}
add_action('wp_head', 'cognysens_schema_local_business', 10);

/**
 * Add Schema.org Service for expertise pages
 */
function cognysens_schema_service() {
    if (!is_page()) {
        return;
    }

    $slug = get_post_field('post_name', get_the_ID());
    $service_pages = array(
        'expertise-amiable-bati-ancien' => array(
            'name' => 'Expertise Amiable Bati Ancien',
            'description' => 'Diagnostic technique independant pour identifier les desordres et pathologies du bati ancien. Rapport d\'expertise detaille avec preconisations.',
            'category' => 'Expertise',
        ),
        'assistance-expertise-judiciaire-bati-patrimonial' => array(
            'name' => 'Assistance Expertise Judiciaire',
            'description' => 'Accompagnement technique lors d\'expertises judiciaires sur bati patrimonial. Defense de vos interets avec arguments techniques.',
            'category' => 'Expertise',
        ),
        'dtg-bati-ancien-copropriete' => array(
            'name' => 'DTG Bati Ancien Copropriete',
            'description' => 'Diagnostic Technique Global adapte aux coproprietes en bati ancien. Plan pluriannuel de travaux et estimations budgetaires.',
            'category' => 'Diagnostic',
        ),
        'amo-bati-ancien-patrimonial' => array(
            'name' => 'AMO Bati Ancien et Patrimonial',
            'description' => 'Assistance a Maitrise d\'Ouvrage specialisee bati ancien et patrimonial. Accompagnement technique de vos projets de renovation.',
            'category' => 'AMO',
        ),
        'amo-copropriete-eviter-surpayer-travaux' => array(
            'name' => 'AMO Copropriete',
            'description' => 'Accompagnement des coproprietes pour eviter de surpayer leurs travaux. Analyse des devis, negociation, suivi de chantier.',
            'category' => 'AMO',
        ),
        'amo-fonciere-patrimoniale' => array(
            'name' => 'AMO Fonciere Patrimoniale',
            'description' => 'Accompagnement des foncieres et investisseurs patrimoniaux dans leurs projets de renovation de bati ancien.',
            'category' => 'AMO',
        ),
    );

    if (!isset($service_pages[$slug])) {
        return;
    }

    $service = $service_pages[$slug];

    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'Service',
        '@id' => get_permalink() . '#service',
        'name' => $service['name'],
        'description' => $service['description'],
        'url' => get_permalink(),
        'category' => $service['category'],
        'provider' => array(
            '@type' => 'Organization',
            '@id' => home_url('/#organization'),
            'name' => 'Cognysens',
            'url' => home_url('/'),
        ),
        'areaServed' => array(
            array('@type' => 'City', 'name' => 'Paris'),
            array('@type' => 'AdministrativeArea', 'name' => 'Hauts-de-Seine'),
            array('@type' => 'AdministrativeArea', 'name' => 'Val-de-Marne'),
            array('@type' => 'AdministrativeArea', 'name' => 'Yvelines'),
        ),
        'serviceType' => $service['category'],
    );

    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
}
add_action('wp_head', 'cognysens_schema_service', 10);

/**
 * Add Schema.org FAQPage helper function
 */
function cognysens_schema_faq($faqs) {
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
 * Optimize document title
 */
function cognysens_document_title_parts($title) {
    $slug = get_post_field('post_name', get_the_ID());

    // Add location suffix for geo pages
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
add_filter('document_title_parts', 'cognysens_document_title_parts');

/**
 * Add preconnect for external resources
 */
function cognysens_resource_hints($urls, $relation_type) {
    if ('preconnect' === $relation_type) {
        $urls[] = array(
            'href' => 'https://fonts.googleapis.com',
            'crossorigin' => true,
        );
        $urls[] = array(
            'href' => 'https://fonts.gstatic.com',
            'crossorigin' => true,
        );
    }
    return $urls;
}
add_filter('wp_resource_hints', 'cognysens_resource_hints', 10, 2);

/**
 * Add DNS prefetch
 */
function cognysens_dns_prefetch() {
    echo '<link rel="dns-prefetch" href="//fonts.googleapis.com" />' . "\n";
    echo '<link rel="dns-prefetch" href="//fonts.gstatic.com" />' . "\n";
}
add_action('wp_head', 'cognysens_dns_prefetch', 0);
