<?php
/**
 * Tableau Comparatif Block Template
 *
 * @package Cognysens
 */

// Get fields
$title = get_field('titre') ?: 'Comparez nos prestations';
$columns = get_field('colonnes'); // Repeater field for comparison columns

// Block attributes
$block_id = 'table-comparatif-' . $block['id'];
$class_name = 'block-table-comparatif';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $class_name .= ' align' . $block['align'];
}
?>

<div id="<?php echo esc_attr($block_id); ?>" class="<?php echo esc_attr($class_name); ?>">
    <h2 class="comparatif-title"><?php echo esc_html($title); ?></h2>

    <?php if ($columns && count($columns) > 0) : ?>
        <div class="comparatif-wrapper">
            <table class="comparatif-table">
                <thead>
                    <tr>
                        <th class="feature-header">Caracteristiques</th>
                        <?php foreach ($columns as $col) : ?>
                            <th class="plan-header <?php echo !empty($col['mise_en_avant']) ? 'highlighted' : ''; ?>">
                                <?php if (!empty($col['mise_en_avant'])) : ?>
                                    <span class="badge-popular">Recommande</span>
                                <?php endif; ?>
                                <span class="plan-name"><?php echo esc_html($col['nom']); ?></span>
                                <?php if (!empty($col['prix'])) : ?>
                                    <span class="plan-price"><?php echo esc_html($col['prix']); ?></span>
                                <?php endif; ?>
                            </th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Get features from first column as reference
                    $features = get_field('caracteristiques'); // Repeater for features
                    if ($features) :
                        foreach ($features as $index => $feature) : ?>
                            <tr>
                                <td class="feature-name"><?php echo esc_html($feature['nom']); ?></td>
                                <?php foreach ($columns as $col) :
                                    $value = isset($col['valeurs'][$index]) ? $col['valeurs'][$index] : '';
                                    ?>
                                    <td class="feature-value <?php echo !empty($col['mise_en_avant']) ? 'highlighted' : ''; ?>">
                                        <?php if ($value === 'oui' || $value === true) : ?>
                                            <svg class="icon-check" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <polyline points="20 6 9 17 4 12"/>
                                            </svg>
                                        <?php elseif ($value === 'non' || $value === false) : ?>
                                            <svg class="icon-cross" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <line x1="18" y1="6" x2="6" y2="18"/>
                                                <line x1="6" y1="6" x2="18" y2="18"/>
                                            </svg>
                                        <?php else : ?>
                                            <?php echo esc_html($value); ?>
                                        <?php endif; ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach;
                    endif; ?>
                </tbody>
            </table>
        </div>
    <?php else : ?>
        <!-- Default comparison table for preview -->
        <div class="comparatif-wrapper">
            <table class="comparatif-table">
                <thead>
                    <tr>
                        <th class="feature-header">Caracteristiques</th>
                        <th class="plan-header">Expertise Simple</th>
                        <th class="plan-header highlighted">
                            <span class="badge-popular">Recommande</span>
                            <span class="plan-name">Expertise Complete</span>
                            <span class="plan-price">A partir de 1200EUR</span>
                        </th>
                        <th class="plan-header">Expertise + AMO</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="feature-name">Visite sur site</td>
                        <td class="feature-value">
                            <svg class="icon-check" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                        </td>
                        <td class="feature-value highlighted">
                            <svg class="icon-check" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                        </td>
                        <td class="feature-value">
                            <svg class="icon-check" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                        </td>
                    </tr>
                    <tr>
                        <td class="feature-name">Rapport detaille</td>
                        <td class="feature-value">Simplifie</td>
                        <td class="feature-value highlighted">Complet</td>
                        <td class="feature-value">Complet</td>
                    </tr>
                    <tr>
                        <td class="feature-name">Reportage photo</td>
                        <td class="feature-value">
                            <svg class="icon-check" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                        </td>
                        <td class="feature-value highlighted">
                            <svg class="icon-check" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                        </td>
                        <td class="feature-value">
                            <svg class="icon-check" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                        </td>
                    </tr>
                    <tr>
                        <td class="feature-name">Preconisations travaux</td>
                        <td class="feature-value">
                            <svg class="icon-cross" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="18" y1="6" x2="6" y2="18"/>
                                <line x1="6" y1="6" x2="18" y2="18"/>
                            </svg>
                        </td>
                        <td class="feature-value highlighted">
                            <svg class="icon-check" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                        </td>
                        <td class="feature-value">
                            <svg class="icon-check" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                        </td>
                    </tr>
                    <tr>
                        <td class="feature-name">Suivi de chantier</td>
                        <td class="feature-value">
                            <svg class="icon-cross" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="18" y1="6" x2="6" y2="18"/>
                                <line x1="6" y1="6" x2="18" y2="18"/>
                            </svg>
                        </td>
                        <td class="feature-value highlighted">
                            <svg class="icon-cross" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="18" y1="6" x2="6" y2="18"/>
                                <line x1="6" y1="6" x2="18" y2="18"/>
                            </svg>
                        </td>
                        <td class="feature-value">
                            <svg class="icon-check" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                        </td>
                    </tr>
                    <tr>
                        <td class="feature-name">Echange post-rapport</td>
                        <td class="feature-value">15 min</td>
                        <td class="feature-value highlighted">30 min</td>
                        <td class="feature-value">Illimite</td>
                    </tr>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
