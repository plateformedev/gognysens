<?php
/**
 * Tarif Card Block Template
 *
 * @package Cognysens
 */

if (!defined('ABSPATH')) {
    exit;
}

// Get block values
$title = get_field('tarif_title') ?: '';
$price = get_field('tarif_price') ?: '';
$price_suffix = get_field('tarif_price_suffix') ?: 'HT';
$description = get_field('tarif_description') ?: '';
$features = get_field('tarif_features');
$cta_text = get_field('tarif_cta_text') ?: 'Demander un devis';
$cta_link = get_field('tarif_cta_link') ?: '/prendre-rendez-vous/';
$highlighted = get_field('tarif_highlighted') ?: false;

$block_classes = 'cognysens-tarif';
if ($highlighted) {
    $block_classes .= ' cognysens-tarif--highlighted';
}
?>

<div class="<?php echo esc_attr($block_classes); ?>">
    <?php if ($title): ?>
        <h3 class="cognysens-tarif__title"><?php echo esc_html($title); ?></h3>
    <?php endif; ?>

    <?php if ($price): ?>
        <div class="cognysens-tarif__price">
            <span class="cognysens-tarif__amount"><?php echo esc_html($price); ?></span>
            <?php if ($price_suffix): ?>
                <span class="cognysens-tarif__suffix"><?php echo esc_html($price_suffix); ?></span>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php if ($description): ?>
        <p class="cognysens-tarif__description"><?php echo esc_html($description); ?></p>
    <?php endif; ?>

    <?php if ($features): ?>
        <ul class="cognysens-tarif__features">
            <?php foreach ($features as $feature): ?>
                <li><?php echo esc_html($feature['feature']); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <?php if ($cta_text): ?>
        <a href="<?php echo esc_url($cta_link); ?>" class="cognysens-tarif__cta">
            <?php echo esc_html($cta_text); ?>
        </a>
    <?php endif; ?>
</div>
