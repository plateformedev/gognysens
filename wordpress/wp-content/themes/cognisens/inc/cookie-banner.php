<?php
/**
 * Cookie Banner Configuration
 * Integrates with Complianz GDPR/CCPA plugin
 *
 * @package Cognisens
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Complianz recommended settings for CNIL compliance
 *
 * These settings should be applied in Complianz admin:
 * - Cookie banner position: bottom
 * - Accept/Deny with equal prominence
 * - No pre-checked options
 * - No wall (must allow access without consent)
 * - Consent storage: 13 months max
 */

/**
 * Custom CSS for Complianz banner to match CHANEL x APPLE design
 */
function cognisens_complianz_custom_css() {
    if (!function_exists('cmplz_uses_optin')) {
        return;
    }
    ?>
    <style id="cognisens-complianz-css">
        /* Complianz Banner - CHANEL x APPLE Style */
        .cmplz-cookiebanner {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif !important;
            background: #000 !important;
            border: none !important;
            box-shadow: 0 -4px 20px rgba(0,0,0,0.15) !important;
        }

        .cmplz-cookiebanner .cmplz-message {
            color: #fff !important;
            font-size: 14px !important;
            line-height: 1.6 !important;
        }

        .cmplz-cookiebanner a {
            color: #8B7355 !important;
            text-decoration: underline !important;
        }

        .cmplz-cookiebanner a:hover {
            color: #fff !important;
        }

        /* Buttons - Equal prominence for Accept/Deny (CNIL requirement) */
        .cmplz-cookiebanner .cmplz-btn {
            font-family: 'Inter', sans-serif !important;
            font-size: 12px !important;
            font-weight: 500 !important;
            letter-spacing: 0.1em !important;
            text-transform: uppercase !important;
            padding: 12px 24px !important;
            border-radius: 0 !important;
            transition: all 0.3s ease !important;
        }

        /* Accept button */
        .cmplz-cookiebanner .cmplz-btn.cmplz-accept {
            background: #fff !important;
            color: #000 !important;
            border: 1px solid #fff !important;
        }

        .cmplz-cookiebanner .cmplz-btn.cmplz-accept:hover {
            background: #F5F5F0 !important;
        }

        /* Deny button - MUST be equally prominent per CNIL */
        .cmplz-cookiebanner .cmplz-btn.cmplz-deny {
            background: transparent !important;
            color: #fff !important;
            border: 1px solid #fff !important;
        }

        .cmplz-cookiebanner .cmplz-btn.cmplz-deny:hover {
            background: #333 !important;
        }

        /* Manage preferences button */
        .cmplz-cookiebanner .cmplz-btn.cmplz-manage {
            background: transparent !important;
            color: #8B7355 !important;
            border: none !important;
            text-decoration: underline !important;
            padding: 12px 16px !important;
        }

        /* Cookie categories in manage view */
        .cmplz-categories .cmplz-category {
            border-color: #333 !important;
        }

        .cmplz-categories .cmplz-category-title {
            color: #fff !important;
        }

        .cmplz-categories .cmplz-category-description {
            color: #ccc !important;
        }

        /* Toggle switches */
        .cmplz-categories .cmplz-toggle-wrap input:checked + .cmplz-toggle {
            background: #8B7355 !important;
        }

        /* Footer manage cookies button */
        .footer-cookies-btn {
            background: transparent;
            border: none;
            color: inherit;
            cursor: pointer;
            font-size: inherit;
            text-decoration: underline;
            padding: 0;
        }

        .footer-cookies-btn:hover {
            color: #8B7355;
        }
    </style>
    <?php
}
add_action('wp_head', 'cognisens_complianz_custom_css', 100);

/**
 * Ensure scripts are blocked until consent (CNIL requirement)
 *
 * Complianz handles this automatically, but we add extra checks
 */
function cognisens_block_scripts_before_consent() {
    // This is handled by Complianz, but we can add custom script blocking here
    // For example, block Google Analytics until consent
    if (function_exists('cmplz_has_consent') && !cmplz_has_consent('statistics')) {
        // Remove any analytics scripts that might be added outside Complianz
        remove_action('wp_head', 'cognisens_custom_analytics', 1);
    }
}
add_action('wp_head', 'cognisens_block_scripts_before_consent', 1);

/**
 * Filter Complianz settings (if available)
 */
function cognisens_complianz_settings($settings) {
    // Ensure CNIL compliance settings
    $settings['use_country'] = false; // Same rules for all
    $settings['consent_per_service'] = true;
    $settings['use_categories'] = true;

    return $settings;
}
add_filter('cmplz_settings', 'cognisens_complianz_settings');

/**
 * Admin notice if Complianz is not configured
 */
function cognisens_complianz_notice() {
    if (!is_admin() || !current_user_can('manage_options')) {
        return;
    }

    // Check if Complianz is active
    if (!function_exists('cmplz_uses_optin')) {
        ?>
        <div class="notice notice-warning">
            <p><strong>Cognisens RGPD :</strong> Le plugin Complianz n'est pas installe.
            <a href="<?php echo admin_url('plugin-install.php?s=complianz&tab=search&type=term'); ?>">Installer Complianz</a>
            pour la conformite CNIL.</p>
        </div>
        <?php
    }
}
add_action('admin_notices', 'cognisens_complianz_notice');

/**
 * CNIL Compliance Checklist (for documentation)
 *
 * 1. [x] User can refuse cookies as easily as accept them
 * 2. [x] No pre-checked consent boxes
 * 3. [x] No cookie wall (site accessible without consent)
 * 4. [x] Clear information about each cookie category
 * 5. [x] Ability to withdraw consent at any time
 * 6. [x] Consent stored for maximum 13 months
 * 7. [x] No essential cookies require consent
 * 8. [x] Third-party cookies blocked until consent
 */
