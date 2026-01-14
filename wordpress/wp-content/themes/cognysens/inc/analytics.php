<?php
/**
 * Google Analytics 4 Integration
 * GDPR-compliant analytics tracking
 *
 * @package Cognysens
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add analytics settings to customizer
 */
function cognysens_analytics_customizer($wp_customize) {
    // Add Analytics section
    $wp_customize->add_section('cognysens_analytics', array(
        'title'    => __('Analytics & Tracking', 'cognysens'),
        'priority' => 160,
    ));

    // GA4 Measurement ID
    $wp_customize->add_setting('cognysens_ga4_id', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('cognysens_ga4_id', array(
        'label'       => __('Google Analytics 4 Measurement ID', 'cognysens'),
        'description' => __('Entrez votre ID de mesure GA4 (ex: G-XXXXXXXXXX)', 'cognysens'),
        'section'     => 'cognysens_analytics',
        'type'        => 'text',
    ));

    // Google Tag Manager ID
    $wp_customize->add_setting('cognysens_gtm_id', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('cognysens_gtm_id', array(
        'label'       => __('Google Tag Manager ID', 'cognysens'),
        'description' => __('Entrez votre ID GTM (ex: GTM-XXXXXXX)', 'cognysens'),
        'section'     => 'cognysens_analytics',
        'type'        => 'text',
    ));

    // Consent mode
    $wp_customize->add_setting('cognysens_analytics_consent', array(
        'default'           => 'wait_for_consent',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('cognysens_analytics_consent', array(
        'label'   => __('Mode de consentement', 'cognysens'),
        'section' => 'cognysens_analytics',
        'type'    => 'select',
        'choices' => array(
            'wait_for_consent' => __('Attendre le consentement (RGPD)', 'cognysens'),
            'load_always'      => __('Charger toujours (non recommande)', 'cognysens'),
        ),
    ));

    // Track form submissions
    $wp_customize->add_setting('cognysens_track_forms', array(
        'default'           => true,
        'sanitize_callback' => 'cognysens_sanitize_checkbox',
    ));

    $wp_customize->add_control('cognysens_track_forms', array(
        'label'   => __('Suivre les soumissions de formulaire', 'cognysens'),
        'section' => 'cognysens_analytics',
        'type'    => 'checkbox',
    ));

    // Track CTA clicks
    $wp_customize->add_setting('cognysens_track_cta', array(
        'default'           => true,
        'sanitize_callback' => 'cognysens_sanitize_checkbox',
    ));

    $wp_customize->add_control('cognysens_track_cta', array(
        'label'   => __('Suivre les clics sur les CTA', 'cognysens'),
        'section' => 'cognysens_analytics',
        'type'    => 'checkbox',
    ));
}
add_action('customize_register', 'cognysens_analytics_customizer');

/**
 * Sanitize checkbox
 */
function cognysens_sanitize_checkbox($checked) {
    return ((isset($checked) && true == $checked) ? true : false);
}

/**
 * Output GA4 tracking code
 */
function cognysens_ga4_head() {
    $ga4_id = get_theme_mod('cognysens_ga4_id', '');
    $consent_mode = get_theme_mod('cognysens_analytics_consent', 'wait_for_consent');

    if (empty($ga4_id)) {
        return;
    }

    // Don't track admin users
    if (current_user_can('manage_options')) {
        return;
    }
    ?>
    <!-- Google Analytics 4 - COGNYSENS -->
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}

        <?php if ($consent_mode === 'wait_for_consent') : ?>
        // Consent Mode v2 - Default denied
        gtag('consent', 'default', {
            'analytics_storage': 'denied',
            'ad_storage': 'denied',
            'ad_user_data': 'denied',
            'ad_personalization': 'denied',
            'wait_for_update': 500
        });
        <?php endif; ?>

        gtag('js', new Date());
        gtag('config', '<?php echo esc_js($ga4_id); ?>', {
            'anonymize_ip': true,
            'send_page_view': <?php echo $consent_mode === 'wait_for_consent' ? 'false' : 'true'; ?>
        });

        <?php if ($consent_mode === 'wait_for_consent') : ?>
        // Listen for consent update (from Complianz or cookie banner)
        window.addEventListener('cmplz_consent_status', function(e) {
            if (e.detail && e.detail.statistics === 'allow') {
                gtag('consent', 'update', {
                    'analytics_storage': 'granted'
                });
                gtag('event', 'page_view');
            }
        });

        // Fallback: Check Complianz consent
        if (typeof cmplz_has_consent === 'function' && cmplz_has_consent('statistics')) {
            gtag('consent', 'update', {
                'analytics_storage': 'granted'
            });
            gtag('event', 'page_view');
        }
        <?php endif; ?>
    </script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_attr($ga4_id); ?>"></script>
    <?php
}
add_action('wp_head', 'cognysens_ga4_head', 1);

/**
 * Output GTM code (head)
 */
function cognysens_gtm_head() {
    $gtm_id = get_theme_mod('cognysens_gtm_id', '');
    $consent_mode = get_theme_mod('cognysens_analytics_consent', 'wait_for_consent');

    if (empty($gtm_id)) {
        return;
    }

    // Don't track admin users
    if (current_user_can('manage_options')) {
        return;
    }

    // If waiting for consent, only load after consent given
    if ($consent_mode === 'wait_for_consent') {
        ?>
        <!-- Google Tag Manager - Consent Mode -->
        <script>
            window.addEventListener('cmplz_consent_status', function(e) {
                if (e.detail && e.detail.statistics === 'allow' && !window.gtmLoaded) {
                    window.gtmLoaded = true;
                    (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
                    })(window,document,'script','dataLayer','<?php echo esc_js($gtm_id); ?>');
                }
            });
        </script>
        <?php
    } else {
        ?>
        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','<?php echo esc_js($gtm_id); ?>');</script>
        <!-- End Google Tag Manager -->
        <?php
    }
}
add_action('wp_head', 'cognysens_gtm_head', 2);

/**
 * Output GTM noscript (body)
 */
function cognysens_gtm_body() {
    $gtm_id = get_theme_mod('cognysens_gtm_id', '');
    $consent_mode = get_theme_mod('cognysens_analytics_consent', 'wait_for_consent');

    if (empty($gtm_id) || $consent_mode === 'wait_for_consent') {
        return;
    }

    if (current_user_can('manage_options')) {
        return;
    }
    ?>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo esc_attr($gtm_id); ?>"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <?php
}
add_action('wp_body_open', 'cognysens_gtm_body', 1);

/**
 * Event tracking JavaScript
 */
function cognysens_analytics_tracking_js() {
    $ga4_id = get_theme_mod('cognysens_ga4_id', '');
    $track_forms = get_theme_mod('cognysens_track_forms', true);
    $track_cta = get_theme_mod('cognysens_track_cta', true);

    if (empty($ga4_id) || (!$track_forms && !$track_cta)) {
        return;
    }

    if (current_user_can('manage_options')) {
        return;
    }
    ?>
    <script>
    (function() {
        'use strict';

        // Wait for gtag to be available
        function trackEvent(eventName, params) {
            if (typeof gtag === 'function') {
                gtag('event', eventName, params);
            }
        }

        <?php if ($track_forms) : ?>
        // Track form submissions
        document.addEventListener('submit', function(e) {
            var form = e.target;

            if (form.classList.contains('cognysens-contact-form')) {
                trackEvent('form_submit', {
                    'event_category': 'Contact',
                    'event_label': 'Formulaire de contact'
                });
            }

            if (form.classList.contains('cognysens-rdv-form')) {
                var prestation = form.querySelector('input[name="prestation"]:checked');
                trackEvent('generate_lead', {
                    'event_category': 'RDV',
                    'event_label': prestation ? prestation.value : 'inconnu',
                    'currency': 'EUR',
                    'value': 100
                });
            }
        });
        <?php endif; ?>

        <?php if ($track_cta) : ?>
        // Track CTA clicks
        document.addEventListener('click', function(e) {
            var target = e.target.closest('a');
            if (!target) return;

            var href = target.getAttribute('href') || '';
            var text = target.textContent.trim();

            // Phone clicks
            if (href.startsWith('tel:')) {
                trackEvent('click', {
                    'event_category': 'CTA',
                    'event_label': 'Telephone'
                });
            }

            // RDV page link
            if (href.includes('prendre-rendez-vous') || href.includes('rdv')) {
                trackEvent('click', {
                    'event_category': 'CTA',
                    'event_label': 'Prendre RDV'
                });
            }

            // Tarifs link
            if (href.includes('tarif') || href.includes('honoraires')) {
                trackEvent('click', {
                    'event_category': 'Navigation',
                    'event_label': 'Voir tarifs'
                });
            }

            // Primary button clicks
            if (target.classList.contains('btn-primary')) {
                trackEvent('click', {
                    'event_category': 'CTA',
                    'event_label': text.substring(0, 50)
                });
            }
        });

        // Track scroll depth
        var scrollTracked = {};
        window.addEventListener('scroll', function() {
            var scrollPercent = Math.round((window.scrollY / (document.body.scrollHeight - window.innerHeight)) * 100);

            [25, 50, 75, 90].forEach(function(threshold) {
                if (scrollPercent >= threshold && !scrollTracked[threshold]) {
                    scrollTracked[threshold] = true;
                    trackEvent('scroll', {
                        'event_category': 'Engagement',
                        'event_label': threshold + '%'
                    });
                }
            });
        }, { passive: true });
        <?php endif; ?>

    })();
    </script>
    <?php
}
add_action('wp_footer', 'cognysens_analytics_tracking_js', 100);

/**
 * Admin notice if no analytics configured
 */
function cognysens_analytics_admin_notice() {
    if (!current_user_can('manage_options')) {
        return;
    }

    $ga4_id = get_theme_mod('cognysens_ga4_id', '');
    $dismissed = get_user_meta(get_current_user_id(), 'cognysens_analytics_notice_dismissed', true);

    if (empty($ga4_id) && !$dismissed && get_current_screen()->id !== 'customize') {
        ?>
        <div class="notice notice-info is-dismissible" id="cognysens-analytics-notice">
            <p>
                <strong>COGNYSENS:</strong>
                <?php _e('Configurez Google Analytics 4 pour suivre les performances de votre site.', 'cognysens'); ?>
                <a href="<?php echo esc_url(admin_url('customize.php?autofocus[section]=cognysens_analytics')); ?>">
                    <?php _e('Configurer maintenant', 'cognysens'); ?>
                </a>
            </p>
        </div>
        <script>
            jQuery(function($) {
                $(document).on('click', '#cognysens-analytics-notice .notice-dismiss', function() {
                    $.post(ajaxurl, {
                        action: 'cognysens_dismiss_analytics_notice',
                        nonce: '<?php echo wp_create_nonce('cognysens_analytics_notice'); ?>'
                    });
                });
            });
        </script>
        <?php
    }
}
add_action('admin_notices', 'cognysens_analytics_admin_notice');

/**
 * Dismiss analytics notice
 */
function cognysens_dismiss_analytics_notice() {
    if (!wp_verify_nonce($_POST['nonce'], 'cognysens_analytics_notice')) {
        wp_die();
    }

    update_user_meta(get_current_user_id(), 'cognysens_analytics_notice_dismissed', true);
    wp_die();
}
add_action('wp_ajax_cognysens_dismiss_analytics_notice', 'cognysens_dismiss_analytics_notice');
