<?php
/**
 * CTA Block Template
 * Subtle, elegant call to action
 *
 * @package Cognysens
 */

if (!defined('ABSPATH')) {
    exit;
}

// Get block values
$title = get_field('cta_title') ?: 'Besoin d\'un avis d\'expert ?';
$subtitle = get_field('cta_subtitle') ?: '';
$button_text = get_field('cta_button_text') ?: 'Solliciter une analyse';
$button_link = get_field('cta_button_link') ?: '/prendre-rendez-vous/';
$style = get_field('cta_style') ?: 'dark'; // dark, light, subtle

$block_classes = 'cognysens-cta cognysens-cta--' . esc_attr($style);

// Get block alignment
if (!empty($block['align'])) {
    $block_classes .= ' align' . $block['align'];
}
?>

<section class="<?php echo esc_attr($block_classes); ?>">
    <div class="cognysens-cta__content">
        <?php if ($title): ?>
            <h2 class="cognysens-cta__title"><?php echo esc_html($title); ?></h2>
        <?php endif; ?>

        <?php if ($subtitle): ?>
            <p class="cognysens-cta__subtitle"><?php echo esc_html($subtitle); ?></p>
        <?php endif; ?>

        <?php if ($button_text): ?>
            <a href="<?php echo esc_url($button_link); ?>" class="cognysens-cta__button">
                <?php echo esc_html($button_text); ?>
            </a>
        <?php endif; ?>
    </div>
</section>
