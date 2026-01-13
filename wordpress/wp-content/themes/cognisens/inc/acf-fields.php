<?php
/**
 * ACF Fields Registration for Custom Blocks
 *
 * @package Cognisens
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register ACF fields for blocks
 */
function cognisens_register_acf_fields() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    // FAQ Block Fields
    acf_add_local_field_group(array(
        'key' => 'group_cognisens_faq',
        'title' => 'FAQ Block',
        'fields' => array(
            array(
                'key' => 'field_faq_title',
                'label' => 'Titre',
                'name' => 'faq_title',
                'type' => 'text',
                'default_value' => 'Questions frequentes',
            ),
            array(
                'key' => 'field_faq_questions',
                'label' => 'Questions',
                'name' => 'faq_questions',
                'type' => 'repeater',
                'layout' => 'block',
                'sub_fields' => array(
                    array(
                        'key' => 'field_faq_question',
                        'label' => 'Question',
                        'name' => 'question',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_faq_answer',
                        'label' => 'Reponse',
                        'name' => 'answer',
                        'type' => 'wysiwyg',
                        'toolbar' => 'basic',
                        'media_upload' => 0,
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'block',
                    'operator' => '==',
                    'value' => 'acf/cognisens-faq',
                ),
            ),
        ),
    ));

    // Tarif Block Fields
    acf_add_local_field_group(array(
        'key' => 'group_cognisens_tarif',
        'title' => 'Tarif Block',
        'fields' => array(
            array(
                'key' => 'field_tarif_title',
                'label' => 'Titre',
                'name' => 'tarif_title',
                'type' => 'text',
            ),
            array(
                'key' => 'field_tarif_price',
                'label' => 'Prix',
                'name' => 'tarif_price',
                'type' => 'text',
                'placeholder' => 'A partir de 800 EUR',
            ),
            array(
                'key' => 'field_tarif_price_suffix',
                'label' => 'Suffixe prix',
                'name' => 'tarif_price_suffix',
                'type' => 'text',
                'default_value' => 'HT',
            ),
            array(
                'key' => 'field_tarif_description',
                'label' => 'Description',
                'name' => 'tarif_description',
                'type' => 'textarea',
                'rows' => 2,
            ),
            array(
                'key' => 'field_tarif_features',
                'label' => 'Caracteristiques',
                'name' => 'tarif_features',
                'type' => 'repeater',
                'layout' => 'table',
                'sub_fields' => array(
                    array(
                        'key' => 'field_tarif_feature',
                        'label' => 'Element',
                        'name' => 'feature',
                        'type' => 'text',
                    ),
                ),
            ),
            array(
                'key' => 'field_tarif_cta_text',
                'label' => 'Texte bouton',
                'name' => 'tarif_cta_text',
                'type' => 'text',
                'default_value' => 'Demander un devis',
            ),
            array(
                'key' => 'field_tarif_cta_link',
                'label' => 'Lien bouton',
                'name' => 'tarif_cta_link',
                'type' => 'url',
                'default_value' => '/prendre-rendez-vous/',
            ),
            array(
                'key' => 'field_tarif_highlighted',
                'label' => 'Mise en avant',
                'name' => 'tarif_highlighted',
                'type' => 'true_false',
                'ui' => 1,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'block',
                    'operator' => '==',
                    'value' => 'acf/cognisens-tarif',
                ),
            ),
        ),
    ));

    // CTA Block Fields
    acf_add_local_field_group(array(
        'key' => 'group_cognisens_cta',
        'title' => 'CTA Block',
        'fields' => array(
            array(
                'key' => 'field_cta_title',
                'label' => 'Titre',
                'name' => 'cta_title',
                'type' => 'text',
                'default_value' => 'Besoin d\'un avis d\'expert ?',
            ),
            array(
                'key' => 'field_cta_subtitle',
                'label' => 'Sous-titre',
                'name' => 'cta_subtitle',
                'type' => 'text',
            ),
            array(
                'key' => 'field_cta_button_text',
                'label' => 'Texte bouton',
                'name' => 'cta_button_text',
                'type' => 'text',
                'default_value' => 'Solliciter une analyse',
            ),
            array(
                'key' => 'field_cta_button_link',
                'label' => 'Lien bouton',
                'name' => 'cta_button_link',
                'type' => 'url',
                'default_value' => '/prendre-rendez-vous/',
            ),
            array(
                'key' => 'field_cta_style',
                'label' => 'Style',
                'name' => 'cta_style',
                'type' => 'select',
                'choices' => array(
                    'dark' => 'Sombre (fond noir)',
                    'light' => 'Clair (fond pierre)',
                    'subtle' => 'Discret (bordures)',
                ),
                'default_value' => 'dark',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'block',
                    'operator' => '==',
                    'value' => 'acf/cognisens-cta',
                ),
            ),
        ),
    ));
}
add_action('acf/init', 'cognisens_register_acf_fields');

/**
 * Register ACF blocks from block.json
 */
function cognisens_register_acf_block_types() {
    if (!function_exists('acf_register_block_type')) {
        return;
    }

    $blocks = array('faq', 'tarif', 'cta');

    foreach ($blocks as $block) {
        $block_path = get_template_directory() . '/blocks/' . $block;
        if (file_exists($block_path . '/block.json')) {
            register_block_type($block_path);
        }
    }
}
add_action('init', 'cognisens_register_acf_block_types');
