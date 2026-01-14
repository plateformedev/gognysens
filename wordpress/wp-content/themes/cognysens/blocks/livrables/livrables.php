<?php
/**
 * Livrables Block Template
 *
 * @package Cognysens
 */

// Get fields
$title = get_field('titre') ?: 'Ce que vous recevez';
$intro = get_field('introduction');
$livrables = get_field('livrables'); // Repeater field

// Block attributes
$block_id = 'livrables-' . $block['id'];
$class_name = 'block-livrables';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}
?>

<div id="<?php echo esc_attr($block_id); ?>" class="<?php echo esc_attr($class_name); ?>">
    <h2 class="livrables-title"><?php echo esc_html($title); ?></h2>

    <?php if ($intro) : ?>
        <p class="livrables-intro"><?php echo esc_html($intro); ?></p>
    <?php endif; ?>

    <?php if ($livrables) : ?>
        <ul class="livrables-list">
            <?php foreach ($livrables as $item) : ?>
                <li class="livrable-item">
                    <div class="livrable-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                            <line x1="16" y1="13" x2="8" y2="13"/>
                            <line x1="16" y1="17" x2="8" y2="17"/>
                        </svg>
                    </div>
                    <div class="livrable-content">
                        <h3 class="livrable-name"><?php echo esc_html($item['titre']); ?></h3>
                        <?php if (!empty($item['description'])) : ?>
                            <p class="livrable-desc"><?php echo esc_html($item['description']); ?></p>
                        <?php endif; ?>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else : ?>
        <!-- Default livrables for preview -->
        <ul class="livrables-list">
            <li class="livrable-item">
                <div class="livrable-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                    </svg>
                </div>
                <div class="livrable-content">
                    <h3 class="livrable-name">Rapport d'expertise detaille</h3>
                    <p class="livrable-desc">Document technique complet avec analyses et preconisations</p>
                </div>
            </li>
            <li class="livrable-item">
                <div class="livrable-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="18" height="18" rx="2"/>
                        <circle cx="8.5" cy="8.5" r="1.5"/>
                        <polyline points="21 15 16 10 5 21"/>
                    </svg>
                </div>
                <div class="livrable-content">
                    <h3 class="livrable-name">Reportage photographique</h3>
                    <p class="livrable-desc">Photos annotees des desordres constates</p>
                </div>
            </li>
            <li class="livrable-item">
                <div class="livrable-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/>
                        <line x1="12" y1="17" x2="12.01" y2="17"/>
                    </svg>
                </div>
                <div class="livrable-content">
                    <h3 class="livrable-name">Echange post-rapport</h3>
                    <p class="livrable-desc">30 minutes de reponses a vos questions</p>
                </div>
            </li>
        </ul>
    <?php endif; ?>
</div>
