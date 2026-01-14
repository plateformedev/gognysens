<?php
/**
 * Custom Blocks Registration
 *
 * @package Cognysens
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register custom block patterns
 */
function cognysens_register_patterns() {
    // Hero Pattern
    register_block_pattern(
        'cognysens/hero',
        array(
            'title'       => __('Hero Cognysens', 'cognysens'),
            'description' => __('Section hero avec titre et CTA', 'cognysens'),
            'categories'  => array('cognysens'),
            'content'     => '<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|section","bottom":"var:preset|spacing|section"}}},"backgroundColor":"stone","layout":{"type":"constrained"}} -->
<div class="wp-block-group has-stone-background-color has-background" style="padding-top:var(--wp--preset--spacing--section);padding-bottom:var(--wp--preset--spacing--section)">
<!-- wp:heading {"textAlign":"center","level":1} -->
<h1 class="wp-block-heading has-text-align-center">Expertise et AMO<br>Bati Ancien & Patrimonial</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","style":{"spacing":{"margin":{"top":"var:preset|spacing|30"}}}} -->
<p class="has-text-align-center" style="margin-top:var(--wp--preset--spacing--30)">Cabinet independant d\'expertise technique et d\'assistance a maitrise d\'ouvrage specialise dans le bati ancien et patrimonial en Ile-de-France.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"},"style":{"spacing":{"margin":{"top":"var:preset|spacing|40"}}}} -->
<div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--40)">
<!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="/prendre-rendez-vous/">Prendre rendez-vous</a></div>
<!-- /wp:button -->
<!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="/honoraires-tarifs-expertise-amo/">Voir les tarifs</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->',
        )
    );

    // Services Grid Pattern
    register_block_pattern(
        'cognysens/services-grid',
        array(
            'title'       => __('Grille Services', 'cognysens'),
            'description' => __('Grille de cartes services', 'cognysens'),
            'categories'  => array('cognysens'),
            'content'     => '<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|section","bottom":"var:preset|spacing|section"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--section);padding-bottom:var(--wp--preset--spacing--section)">
<!-- wp:heading {"textAlign":"center"} -->
<h2 class="wp-block-heading has-text-align-center">Nos expertises</h2>
<!-- /wp:heading -->

<!-- wp:columns {"style":{"spacing":{"margin":{"top":"var:preset|spacing|50"}}}} -->
<div class="wp-block-columns" style="margin-top:var(--wp--preset--spacing--50)">
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"style":{"border":{"width":"1px"},"spacing":{"padding":{"top":"var:preset|spacing|40","right":"var:preset|spacing|30","bottom":"var:preset|spacing|40","left":"var:preset|spacing|30"}}},"borderColor":"gray-light"} -->
<div class="wp-block-group has-border-color has-gray-light-border-color" style="border-width:1px;padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--30)">
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Expertise Amiable</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Diagnostic technique independant pour identifier les desordres et leurs causes.</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph -->
<p><a href="/expertise-amiable-bati-ancien/">En savoir plus</a></p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"style":{"border":{"width":"1px"},"spacing":{"padding":{"top":"var:preset|spacing|40","right":"var:preset|spacing|30","bottom":"var:preset|spacing|40","left":"var:preset|spacing|30"}}},"borderColor":"gray-light"} -->
<div class="wp-block-group has-border-color has-gray-light-border-color" style="border-width:1px;padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--30)">
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">AMO Copropriete</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Accompagnement technique pour eviter de surpayer vos travaux de renovation.</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph -->
<p><a href="/amo-copropriete-eviter-surpayer-travaux/">En savoir plus</a></p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"style":{"border":{"width":"1px"},"spacing":{"padding":{"top":"var:preset|spacing|40","right":"var:preset|spacing|30","bottom":"var:preset|spacing|40","left":"var:preset|spacing|30"}}},"borderColor":"gray-light"} -->
<div class="wp-block-group has-border-color has-gray-light-border-color" style="border-width:1px;padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--30)">
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">DTG Bati Ancien</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Diagnostic Technique Global adapte aux specificites du bati ancien.</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph -->
<p><a href="/dtg-bati-ancien-copropriete/">En savoir plus</a></p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
</div>
<!-- /wp:group -->',
        )
    );

    // FAQ Pattern
    register_block_pattern(
        'cognysens/faq',
        array(
            'title'       => __('FAQ Cognysens', 'cognysens'),
            'description' => __('Section FAQ avec accordeon', 'cognysens'),
            'categories'  => array('cognysens'),
            'content'     => '<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|section","bottom":"var:preset|spacing|section"}}},"backgroundColor":"stone","layout":{"type":"constrained"}} -->
<div class="wp-block-group has-stone-background-color has-background" style="padding-top:var(--wp--preset--spacing--section);padding-bottom:var(--wp--preset--spacing--section)">
<!-- wp:heading {"textAlign":"center"} -->
<h2 class="wp-block-heading has-text-align-center">Questions frequentes</h2>
<!-- /wp:heading -->

<!-- wp:group {"style":{"spacing":{"margin":{"top":"var:preset|spacing|50"}}}} -->
<div class="wp-block-group" style="margin-top:var(--wp--preset--spacing--50)">
<!-- wp:details -->
<details class="wp-block-details"><summary>Quelle est la difference entre expertise et maitrise d\'oeuvre ?</summary><!-- wp:paragraph -->
<p>L\'expert analyse et diagnostique. Il ne concoit pas et ne realise pas de travaux. La maitrise d\'oeuvre concoit et suit l\'execution des travaux. Cognysens est expert et AMO, pas maitre d\'oeuvre.</p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->
<!-- wp:details -->
<details class="wp-block-details"><summary>Pourquoi faire appel a un expert independant ?</summary><!-- wp:paragraph -->
<p>Un expert independant n\'a aucun lien avec les entreprises de travaux. Son avis est objectif et vous protege contre les diagnostics biaises ou les devis gonfles.</p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->
<!-- wp:details -->
<details class="wp-block-details"><summary>Intervenez-vous en dehors de l\'Ile-de-France ?</summary><!-- wp:paragraph -->
<p>Notre zone d\'intervention principale couvre Paris, les Hauts-de-Seine (92), le Val-de-Marne (94) et les Yvelines (78). Pour d\'autres departements, contactez-nous pour etudier votre demande.</p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->',
        )
    );

    // Pricing Table Pattern
    register_block_pattern(
        'cognysens/pricing',
        array(
            'title'       => __('Tableau Tarifs', 'cognysens'),
            'description' => __('Affichage des tarifs', 'cognysens'),
            'categories'  => array('cognysens'),
            'content'     => '<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|section","bottom":"var:preset|spacing|section"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--section);padding-bottom:var(--wp--preset--spacing--section)">
<!-- wp:heading {"textAlign":"center"} -->
<h2 class="wp-block-heading has-text-align-center">Nos honoraires</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">Tarifs indicatifs HT. Devis personnalise sur demande.</p>
<!-- /wp:paragraph -->

<!-- wp:table {"className":"is-style-stripes"} -->
<figure class="wp-block-table is-style-stripes"><table><thead><tr><th>Prestation</th><th>Tarif indicatif</th></tr></thead><tbody><tr><td>Expertise amiable - Appartement</td><td>A partir de 800 EUR HT</td></tr><tr><td>Expertise amiable - Immeuble</td><td>A partir de 1 500 EUR HT</td></tr><tr><td>DTG Bati Ancien</td><td>Sur devis</td></tr><tr><td>AMO Copropriete</td><td>% du montant travaux</td></tr></tbody></table></figure>
<!-- /wp:table -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"},"style":{"spacing":{"margin":{"top":"var:preset|spacing|40"}}}} -->
<div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--40)">
<!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="/honoraires-tarifs-expertise-amo/">Tous nos tarifs</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->',
        )
    );

    // CTA Section Pattern
    register_block_pattern(
        'cognysens/cta-section',
        array(
            'title'       => __('Section CTA', 'cognysens'),
            'description' => __('Appel a l\'action', 'cognysens'),
            'categories'  => array('cognysens'),
            'content'     => '<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"}}},"backgroundColor":"black","textColor":"white","layout":{"type":"constrained"}} -->
<div class="wp-block-group has-white-color has-black-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50)">
<!-- wp:heading {"textAlign":"center","textColor":"white"} -->
<h2 class="wp-block-heading has-text-align-center has-white-color has-text-color">Besoin d\'un avis d\'expert ?</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">Prenez rendez-vous pour un premier echange gratuit de 15 minutes.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"},"style":{"spacing":{"margin":{"top":"var:preset|spacing|30"}}}} -->
<div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--30)">
<!-- wp:button {"backgroundColor":"white","textColor":"black"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-black-color has-white-background-color has-text-color has-background wp-element-button" href="/prendre-rendez-vous/">Prendre rendez-vous</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->',
        )
    );
}
add_action('init', 'cognysens_register_patterns');

/**
 * Register ACF blocks (if ACF Pro installed)
 */
function cognysens_register_acf_blocks() {
    if (!function_exists('acf_register_block_type')) {
        return;
    }

    // FAQ Block
    acf_register_block_type(array(
        'name'              => 'cognysens-faq',
        'title'             => __('FAQ Cognysens', 'cognysens'),
        'description'       => __('Bloc FAQ avec Schema.org', 'cognysens'),
        'render_template'   => 'blocks/faq/faq.php',
        'category'          => 'cognysens',
        'icon'              => 'editor-help',
        'keywords'          => array('faq', 'questions'),
        'supports'          => array(
            'align' => false,
        ),
    ));

    // Tarif Block
    acf_register_block_type(array(
        'name'              => 'cognysens-tarif',
        'title'             => __('Carte Tarif', 'cognysens'),
        'description'       => __('Affichage d\'un tarif', 'cognysens'),
        'render_template'   => 'blocks/tarif/tarif.php',
        'category'          => 'cognysens',
        'icon'              => 'money-alt',
        'keywords'          => array('tarif', 'prix', 'honoraires'),
    ));

    // Livrables Block
    acf_register_block_type(array(
        'name'              => 'cognysens-livrables',
        'title'             => __('Livrables Cognysens', 'cognysens'),
        'description'       => __('Liste des livrables d\'une prestation', 'cognysens'),
        'render_template'   => 'blocks/livrables/livrables.php',
        'category'          => 'cognysens',
        'icon'              => 'clipboard',
        'keywords'          => array('livrables', 'deliverables', 'rapport'),
        'supports'          => array(
            'align' => false,
            'anchor' => true,
        ),
    ));

    // Quand Nous Solliciter Block
    acf_register_block_type(array(
        'name'              => 'cognysens-quand-solliciter',
        'title'             => __('Quand Nous Solliciter', 'cognysens'),
        'description'       => __('Section listant les situations ou faire appel a Cognysens', 'cognysens'),
        'render_template'   => 'blocks/quand-solliciter/quand-solliciter.php',
        'category'          => 'cognysens',
        'icon'              => 'clock',
        'keywords'          => array('quand', 'solliciter', 'situations', 'cas'),
        'supports'          => array(
            'align' => false,
            'anchor' => true,
        ),
    ));

    // Tableau Comparatif Block
    acf_register_block_type(array(
        'name'              => 'cognysens-table-comparatif',
        'title'             => __('Tableau Comparatif', 'cognysens'),
        'description'       => __('Tableau de comparaison entre prestations ou formules', 'cognysens'),
        'render_template'   => 'blocks/table-comparatif/table-comparatif.php',
        'category'          => 'cognysens',
        'icon'              => 'editor-table',
        'keywords'          => array('tableau', 'comparatif', 'comparison', 'table'),
        'supports'          => array(
            'align' => array('wide', 'full'),
            'anchor' => true,
        ),
    ));
}
add_action('acf/init', 'cognysens_register_acf_blocks');
