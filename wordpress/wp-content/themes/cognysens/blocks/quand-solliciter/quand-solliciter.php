<?php
/**
 * Quand Nous Solliciter Block Template
 *
 * @package Cognysens
 */

// Get fields
$title = get_field('titre') ?: 'Quand nous solliciter ?';
$intro = get_field('introduction');
$situations = get_field('situations'); // Repeater field
$cta_text = get_field('cta_texte') ?: 'Prendre rendez-vous';
$cta_url = get_field('cta_url') ?: home_url('/prendre-rendez-vous/');

// Block attributes
$block_id = 'quand-solliciter-' . $block['id'];
$class_name = 'block-quand-solliciter';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}
?>

<div id="<?php echo esc_attr($block_id); ?>" class="<?php echo esc_attr($class_name); ?>">
    <h2 class="quand-title"><?php echo esc_html($title); ?></h2>

    <?php if ($intro) : ?>
        <p class="quand-intro"><?php echo esc_html($intro); ?></p>
    <?php endif; ?>

    <?php if ($situations) : ?>
        <div class="situations-grid">
            <?php foreach ($situations as $index => $item) : ?>
                <div class="situation-card">
                    <span class="situation-number"><?php echo str_pad($index + 1, 2, '0', STR_PAD_LEFT); ?></span>
                    <h3 class="situation-title"><?php echo esc_html($item['titre']); ?></h3>
                    <?php if (!empty($item['description'])) : ?>
                        <p class="situation-desc"><?php echo esc_html($item['description']); ?></p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else : ?>
        <!-- Default situations for preview -->
        <div class="situations-grid">
            <div class="situation-card">
                <span class="situation-number">01</span>
                <h3 class="situation-title">Fissures sur votre facade</h3>
                <p class="situation-desc">Vous constatez des fissures et souhaitez comprendre leur origine et gravite.</p>
            </div>
            <div class="situation-card">
                <span class="situation-number">02</span>
                <h3 class="situation-title">Avant des travaux importants</h3>
                <p class="situation-desc">Vous envisagez une renovation et voulez eviter les mauvaises surprises.</p>
            </div>
            <div class="situation-card">
                <span class="situation-number">03</span>
                <h3 class="situation-title">Litige avec une entreprise</h3>
                <p class="situation-desc">Des travaux mal realises necessitent une expertise independante.</p>
            </div>
            <div class="situation-card">
                <span class="situation-number">04</span>
                <h3 class="situation-title">Achat d'un bien ancien</h3>
                <p class="situation-desc">Vous souhaitez connaitre l'etat reel du batiment avant d'acheter.</p>
            </div>
        </div>
    <?php endif; ?>

    <div class="quand-cta">
        <a href="<?php echo esc_url($cta_url); ?>" class="btn btn-primary">
            <?php echo esc_html($cta_text); ?>
        </a>
    </div>
</div>
