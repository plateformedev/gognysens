<?php
/**
 * Recommended Plugins Configuration
 * Uses TGM Plugin Activation library pattern
 *
 * @package Cognysens
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Define required/recommended plugins
 */
function cognysens_get_recommended_plugins() {
    return array(
        // SEO
        array(
            'name'        => 'Rank Math SEO',
            'slug'        => 'seo-by-rank-math',
            'required'    => true,
            'description' => 'SEO technique complet',
        ),
        // Cache & Performance
        array(
            'name'        => 'LiteSpeed Cache',
            'slug'        => 'litespeed-cache',
            'required'    => false,
            'description' => 'Cache et optimisation performance',
        ),
        // Security
        array(
            'name'        => 'Wordfence Security',
            'slug'        => 'wordfence',
            'required'    => false,
            'description' => 'Securite et firewall',
        ),
        // Redirections
        array(
            'name'        => 'Redirection',
            'slug'        => 'redirection',
            'required'    => false,
            'description' => 'Gestion des redirections 301',
        ),
        // RGPD Cookies
        array(
            'name'        => 'Complianz GDPR/CCPA',
            'slug'        => 'complianz-gdpr',
            'required'    => true,
            'description' => 'Bandeau cookies RGPD conforme CNIL',
        ),
        // Advanced Custom Fields
        array(
            'name'        => 'Advanced Custom Fields',
            'slug'        => 'advanced-custom-fields',
            'required'    => true,
            'description' => 'Blocs personnalises',
        ),
        // Image Optimization
        array(
            'name'        => 'Imagify',
            'slug'        => 'imagify',
            'required'    => false,
            'description' => 'Optimisation des images',
        ),
    );
}

/**
 * Admin notice for missing plugins
 */
function cognysens_missing_plugins_notice() {
    if (!current_user_can('install_plugins')) {
        return;
    }

    $plugins = cognysens_get_recommended_plugins();
    $missing_required = array();

    foreach ($plugins as $plugin) {
        if ($plugin['required'] && !is_plugin_active($plugin['slug'] . '/' . $plugin['slug'] . '.php')) {
            // Check alternative paths
            $active = false;
            $all_plugins = get_plugins();
            foreach ($all_plugins as $path => $info) {
                if (strpos($path, $plugin['slug']) === 0 && is_plugin_active($path)) {
                    $active = true;
                    break;
                }
            }
            if (!$active) {
                $missing_required[] = $plugin['name'];
            }
        }
    }

    if (!empty($missing_required)) {
        ?>
        <div class="notice notice-warning is-dismissible">
            <p><strong>Cognysens :</strong> Les plugins suivants sont requis pour le bon fonctionnement du theme :</p>
            <ul style="list-style: disc; padding-left: 20px;">
                <?php foreach ($missing_required as $plugin_name) : ?>
                    <li><?php echo esc_html($plugin_name); ?></li>
                <?php endforeach; ?>
            </ul>
            <p><a href="<?php echo admin_url('plugins.php'); ?>">Gerer les plugins</a></p>
        </div>
        <?php
    }
}
add_action('admin_notices', 'cognysens_missing_plugins_notice');

/**
 * RankMath SEO Configuration recommendations
 */
function cognysens_rankmath_defaults() {
    // These would be applied via import/export in RankMath
    return array(
        'titles' => array(
            'homepage_title'       => 'Cognysens - Expertise Bati Ancien & AMO Paris',
            'homepage_description' => 'Cabinet independant d\'expertise technique et d\'assistance a maitrise d\'ouvrage (AMO) specialise dans le bati ancien et patrimonial en Ile-de-France.',
            'separator'            => '-',
        ),
        'sitemap' => array(
            'items_per_page' => 200,
            'include_images' => true,
        ),
        'general' => array(
            'breadcrumbs'      => true,
            'rich_snippet'     => true,
            'schema_type'      => 'Organization',
            'local_seo'        => true,
        ),
    );
}

/**
 * Complianz GDPR Cookie Banner defaults
 */
function cognysens_complianz_defaults() {
    return array(
        'cookie_banner' => array(
            'position'         => 'bottom',
            'theme'            => 'minimal',
            'accept_text'      => 'Accepter',
            'deny_text'        => 'Refuser',
            'manage_text'      => 'Personnaliser',
            'privacy_link'     => '/politique-de-confidentialite/',
            'cookie_link'      => '/politique-cookies/',
        ),
    );
}
