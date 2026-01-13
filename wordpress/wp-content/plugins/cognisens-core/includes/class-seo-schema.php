<?php
/**
 * SEO Schema Class
 *
 * Handles Schema.org structured data
 *
 * @package Cognisens_Core
 */

if (!defined('ABSPATH')) {
    exit;
}

class Cognisens_SEO_Schema {

    private static $instance = null;

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action('wp_head', array($this, 'output_schema'), 5);
    }

    /**
     * Output schema markup
     */
    public function output_schema() {
        if (is_admin()) {
            return;
        }

        $schemas = array();

        // Organization schema on all pages
        $schemas[] = $this->get_organization_schema();

        // Page-specific schemas
        if (is_singular('page')) {
            $page_schema = $this->get_page_schema();
            if ($page_schema) {
                $schemas[] = $page_schema;
            }
        }

        // Output all schemas
        foreach ($schemas as $schema) {
            if (!empty($schema)) {
                echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
            }
        }
    }

    /**
     * Get Organization schema
     */
    private function get_organization_schema() {
        return array(
            '@context' => 'https://schema.org',
            '@type' => 'ProfessionalService',
            '@id' => home_url('/#organization'),
            'name' => 'Cognisens',
            'alternateName' => 'Cognisens Expert Bati Ancien',
            'description' => 'Cabinet independant d\'expertise et d\'assistance a maitrise d\'ouvrage (AMO) specialise dans le bati ancien et patrimonial',
            'url' => home_url('/'),
            'logo' => array(
                '@type' => 'ImageObject',
                'url' => get_template_directory_uri() . '/assets/images/logo.png',
            ),
            'address' => array(
                '@type' => 'PostalAddress',
                'streetAddress' => '109 chemin de Ronde',
                'addressLocality' => 'Croissy-sur-Seine',
                'postalCode' => '78290',
                'addressRegion' => 'Ile-de-France',
                'addressCountry' => 'FR',
            ),
            'areaServed' => array(
                array(
                    '@type' => 'City',
                    'name' => 'Paris',
                ),
                array(
                    '@type' => 'AdministrativeArea',
                    'name' => 'Hauts-de-Seine',
                ),
                array(
                    '@type' => 'AdministrativeArea',
                    'name' => 'Val-de-Marne',
                ),
                array(
                    '@type' => 'AdministrativeArea',
                    'name' => 'Yvelines',
                ),
            ),
            'priceRange' => '$$',
            'knowsAbout' => array(
                'Expertise batiment',
                'Bati ancien',
                'Patrimoine immobilier',
                'AMO',
                'Diagnostic technique',
            ),
        );
    }

    /**
     * Get page-specific schema
     */
    private function get_page_schema() {
        $post_id = get_the_ID();
        $slug = get_post_field('post_name', $post_id);

        // Service pages
        $service_schemas = $this->get_service_pages();
        if (isset($service_schemas[$slug])) {
            return $this->build_service_schema($service_schemas[$slug]);
        }

        // FAQ pages - check if page has FAQ content
        if (has_block('core/details')) {
            return $this->build_faq_schema($post_id);
        }

        return null;
    }

    /**
     * Get service pages configuration
     */
    private function get_service_pages() {
        return array(
            'expertise-amiable-bati-ancien' => array(
                'name' => 'Expertise Amiable Bati Ancien',
                'description' => 'Diagnostic technique independant pour identifier les desordres et pathologies du bati ancien',
                'serviceType' => 'Expertise Batiment',
            ),
            'assistance-expertise-judiciaire-bati-patrimonial' => array(
                'name' => 'Assistance Expertise Judiciaire',
                'description' => 'Accompagnement technique lors d\'expertises judiciaires sur bati patrimonial',
                'serviceType' => 'Assistance Juridique Technique',
            ),
            'dtg-bati-ancien-copropriete' => array(
                'name' => 'DTG Bati Ancien',
                'description' => 'Diagnostic Technique Global adapte aux coproprietes en bati ancien',
                'serviceType' => 'Diagnostic Technique Global',
            ),
            'amo-bati-ancien-patrimonial' => array(
                'name' => 'AMO Bati Ancien',
                'description' => 'Assistance a Maitrise d\'Ouvrage specialisee bati ancien et patrimonial',
                'serviceType' => 'Assistance Maitrise Ouvrage',
            ),
            'amo-copropriete-eviter-surpayer-travaux' => array(
                'name' => 'AMO Copropriete',
                'description' => 'Accompagnement des coproprietes pour eviter de surpayer leurs travaux',
                'serviceType' => 'Assistance Maitrise Ouvrage',
            ),
        );
    }

    /**
     * Build Service schema
     */
    private function build_service_schema($config) {
        return array(
            '@context' => 'https://schema.org',
            '@type' => 'Service',
            'name' => $config['name'],
            'description' => $config['description'],
            'serviceType' => $config['serviceType'],
            'url' => get_permalink(),
            'provider' => array(
                '@type' => 'ProfessionalService',
                '@id' => home_url('/#organization'),
                'name' => 'Cognisens',
            ),
            'areaServed' => array(
                array('@type' => 'City', 'name' => 'Paris'),
                array('@type' => 'AdministrativeArea', 'name' => 'Hauts-de-Seine'),
                array('@type' => 'AdministrativeArea', 'name' => 'Val-de-Marne'),
                array('@type' => 'AdministrativeArea', 'name' => 'Yvelines'),
            ),
        );
    }

    /**
     * Build FAQ schema from page content
     */
    private function build_faq_schema($post_id) {
        $content = get_post_field('post_content', $post_id);
        $blocks = parse_blocks($content);

        $faq_items = array();

        foreach ($blocks as $block) {
            if ($block['blockName'] === 'core/details') {
                $inner_html = $block['innerHTML'];

                // Extract question from summary
                if (preg_match('/<summary[^>]*>(.*?)<\/summary>/s', $inner_html, $matches)) {
                    $question = strip_tags($matches[1]);

                    // Extract answer
                    $answer = strip_tags(preg_replace('/<summary[^>]*>.*?<\/summary>/s', '', $inner_html));
                    $answer = trim($answer);

                    if ($question && $answer) {
                        $faq_items[] = array(
                            '@type' => 'Question',
                            'name' => $question,
                            'acceptedAnswer' => array(
                                '@type' => 'Answer',
                                'text' => $answer,
                            ),
                        );
                    }
                }
            }
        }

        if (empty($faq_items)) {
            return null;
        }

        return array(
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => $faq_items,
        );
    }
}
