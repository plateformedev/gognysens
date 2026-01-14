<?php
/**
 * Template Name: Page Tarifs
 * Template Post Type: page
 *
 * @package Cognysens
 */

get_header();

// Prepare Schema.org Service data
$services_schema = array(
    array(
        'name' => 'Expertise Appartement',
        'description' => 'Expertise technique independante pour appartement en bati ancien',
        'price' => '800',
        'priceCurrency' => 'EUR',
    ),
    array(
        'name' => 'Expertise Immeuble',
        'description' => 'Expertise technique complete pour immeuble ancien',
        'price' => '1500',
        'priceCurrency' => 'EUR',
    ),
    array(
        'name' => 'DTG Bati Ancien',
        'description' => 'Diagnostic Technique Global adapte au bati ancien',
        'price' => null,
        'priceCurrency' => 'EUR',
    ),
    array(
        'name' => 'AMO Copropriete',
        'description' => 'Assistance a Maitrise d\'Ouvrage pour coproprietes',
        'price' => null,
        'priceCurrency' => 'EUR',
    ),
);

// FAQ data for Schema.org
$faq_items = array(
    array(
        'question' => 'Le premier echange est-il payant ?',
        'answer' => 'Non, le premier echange telephonique de 15 minutes est gratuit et sans engagement. Il nous permet d\'evaluer votre situation et de vous orienter vers la prestation adaptee.',
    ),
    array(
        'question' => 'Les deplacements sont-ils inclus ?',
        'answer' => 'Oui, les deplacements sont inclus dans nos tarifs pour les interventions a Paris (75), Hauts-de-Seine (92), Val-de-Marne (94) et Yvelines (78). Au-dela, un supplement peut s\'appliquer.',
    ),
    array(
        'question' => 'Comment se calcule le tarif AMO ?',
        'answer' => 'Le tarif AMO est generalement calcule en pourcentage du montant des travaux HT (entre 3% et 5% selon la complexite). Un forfait peut etre propose pour les petits chantiers.',
    ),
    array(
        'question' => 'Quand dois-je payer ?',
        'answer' => 'Un acompte de 30% est demande a la commande. Le solde est regle a la remise du rapport d\'expertise ou a la fin de la mission AMO. Paiement par virement ou cheque.',
    ),
    array(
        'question' => 'Puis-je avoir un devis avant de m\'engager ?',
        'answer' => 'Absolument. Apres notre premier echange, nous vous envoyons un devis detaille et personnalise. Vous etes libre d\'accepter ou non, sans aucune obligation.',
    ),
);
?>

<main id="main" class="site-main page-tarifs">
    <?php while (have_posts()) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            <header class="page-hero">
                <div class="container">
                    <?php cognysens_breadcrumb(); ?>
                    <?php the_title('<h1 class="page-title">', '</h1>'); ?>
                    <p class="page-lead">
                        Tarifs transparents et honoraires clairs. Devis personnalise sur demande.
                    </p>
                </div>
            </header>

            <section class="section">
                <div class="container">
                    <div class="tarifs-intro">
                        <p>
                            Nos honoraires sont calcules en fonction de la complexite de la mission,
                            de la surface concernee et de la nature des desordres a analyser.
                            Les tarifs ci-dessous sont indicatifs et exprimes HT.
                        </p>
                    </div>
                </div>
            </section>

            <!-- Expertises -->
            <section class="section section--stone">
                <div class="container">
                    <h2 class="section-title text-center">Expertises</h2>

                    <div class="tarif-grid">
                        <div class="tarif-card">
                            <h3 class="tarif-card-title">Expertise Appartement</h3>
                            <div class="tarif-card-price">800 &euro;</div>
                            <div class="tarif-card-suffix">HT - A partir de</div>
                            <ul class="tarif-card-features">
                                <li>Visite sur site (2-3h)</li>
                                <li>Analyse des desordres</li>
                                <li>Rapport d'expertise PDF</li>
                                <li>Preconisations techniques</li>
                                <li>Echanges telephoniques</li>
                            </ul>
                            <a href="<?php echo esc_url(home_url('/prendre-rendez-vous/')); ?>" class="btn btn-outline">
                                Demander un devis
                            </a>
                        </div>

                        <div class="tarif-card tarif-card--featured">
                            <h3 class="tarif-card-title">Expertise Immeuble</h3>
                            <div class="tarif-card-price">1 500 &euro;</div>
                            <div class="tarif-card-suffix">HT - A partir de</div>
                            <ul class="tarif-card-features">
                                <li>Visite complete (1 journee)</li>
                                <li>Parties communes + facades</li>
                                <li>Rapport detaille illustre</li>
                                <li>Plan d'action priorise</li>
                                <li>Estimations budgetaires</li>
                            </ul>
                            <a href="<?php echo esc_url(home_url('/prendre-rendez-vous/')); ?>" class="btn btn-primary">
                                Demander un devis
                            </a>
                        </div>

                        <div class="tarif-card">
                            <h3 class="tarif-card-title">DTG Bati Ancien</h3>
                            <div class="tarif-card-price">Sur devis</div>
                            <div class="tarif-card-suffix">Selon surface et complexite</div>
                            <ul class="tarif-card-features">
                                <li>Diagnostic technique global</li>
                                <li>Plan pluriannuel travaux</li>
                                <li>Estimations budgetaires</li>
                                <li>Accompagnement AG</li>
                                <li>Conforme loi ALUR</li>
                            </ul>
                            <a href="<?php echo esc_url(home_url('/prendre-rendez-vous/')); ?>" class="btn btn-outline">
                                Demander un devis
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <!-- AMO -->
            <section class="section">
                <div class="container">
                    <h2 class="section-title text-center">Assistance a Maitrise d'Ouvrage</h2>

                    <div class="tarif-grid">
                        <div class="tarif-card">
                            <h3 class="tarif-card-title">AMO Copropriete</h3>
                            <div class="tarif-card-price">3 a 5%</div>
                            <div class="tarif-card-suffix">du montant des travaux HT</div>
                            <ul class="tarif-card-features">
                                <li>Analyse des devis</li>
                                <li>Aide au choix entreprise</li>
                                <li>Negociation technique</li>
                                <li>Suivi de chantier</li>
                                <li>Reception des travaux</li>
                            </ul>
                            <a href="<?php echo esc_url(home_url('/prendre-rendez-vous/')); ?>" class="btn btn-outline">
                                Demander un devis
                            </a>
                        </div>

                        <div class="tarif-card">
                            <h3 class="tarif-card-title">AMO Particulier</h3>
                            <div class="tarif-card-price">Sur devis</div>
                            <div class="tarif-card-suffix">Forfait ou pourcentage</div>
                            <ul class="tarif-card-features">
                                <li>Accompagnement personnalise</li>
                                <li>Verification devis et travaux</li>
                                <li>Protection de vos interets</li>
                                <li>Conseils techniques experts</li>
                                <li>Flexibilite d'intervention</li>
                            </ul>
                            <a href="<?php echo esc_url(home_url('/prendre-rendez-vous/')); ?>" class="btn btn-outline">
                                Demander un devis
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Modalites -->
            <section class="section section--stone">
                <div class="container">
                    <h2 class="section-title text-center">Modalites</h2>

                    <div class="modalites-grid">
                        <div class="modalites-item">
                            <h3>Conditions de reglement</h3>
                            <ul>
                                <li>Acompte de 30% a la commande</li>
                                <li>Solde a la remise du rapport</li>
                                <li>Paiement par virement ou cheque</li>
                                <li>Facture conforme TVA 20%</li>
                            </ul>
                        </div>

                        <div class="modalites-item">
                            <h3>Inclus dans nos tarifs</h3>
                            <ul>
                                <li>Deplacements zone IDF</li>
                                <li>Rapport d'expertise PDF</li>
                                <li>Photos et schemas</li>
                                <li>Echanges telephoniques</li>
                            </ul>
                        </div>

                        <div class="modalites-item">
                            <h3>Options supplementaires</h3>
                            <ul>
                                <li>Deplacements hors zone</li>
                                <li>Analyses labo (humidite, etc.)</li>
                                <li>Assistance reunion / AG</li>
                                <li>Expertise contradictoire</li>
                            </ul>
                        </div>
                    </div>

                    <div class="tarifs-note">
                        <strong>Note :</strong> Tous les tarifs indiques sont HT. TVA applicable : 20%.
                        Les tarifs definitifs sont etablis apres evaluation de votre situation lors du premier echange gratuit.
                    </div>
                </div>
            </section>

            <!-- FAQ Tarifs -->
            <section class="section">
                <div class="container">
                    <h2 class="section-title text-center">Questions sur nos tarifs</h2>

                    <div class="tarifs-faq">
                        <?php foreach ($faq_items as $item) : ?>
                        <details class="faq-item">
                            <summary><?php echo esc_html($item['question']); ?></summary>
                            <div class="faq-content">
                                <p><?php echo esc_html($item['answer']); ?></p>
                            </div>
                        </details>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>

            <?php if (get_the_content()) : ?>
            <div class="page-content">
                <div class="container container--content">
                    <?php the_content(); ?>
                </div>
            </div>
            <?php endif; ?>

        </article>

    <?php endwhile; ?>

    <!-- CTA -->
    <section class="section section--black">
        <div class="container text-center">
            <h2>Besoin d'un devis personnalise ?</h2>
            <p style="max-width: 500px; margin: 0 auto var(--spacing-lg);">
                Chaque situation est unique. Contactez-nous pour un devis adapte a votre projet.
            </p>
            <a href="<?php echo esc_url(home_url('/prendre-rendez-vous/')); ?>" class="btn btn-white">
                Prendre rendez-vous
            </a>
        </div>
    </section>

</main>

<?php
// Output Schema.org Service + FAQPage
$schema_services = array();
foreach ($services_schema as $service) {
    $service_schema = array(
        '@type' => 'Service',
        'name' => $service['name'],
        'description' => $service['description'],
        'provider' => array(
            '@type' => 'Organization',
            'name' => 'Cognysens',
        ),
        'areaServed' => array(
            array('@type' => 'City', 'name' => 'Paris'),
            array('@type' => 'AdministrativeArea', 'name' => 'Hauts-de-Seine'),
            array('@type' => 'AdministrativeArea', 'name' => 'Val-de-Marne'),
            array('@type' => 'AdministrativeArea', 'name' => 'Yvelines'),
        ),
    );

    if ($service['price']) {
        $service_schema['offers'] = array(
            '@type' => 'Offer',
            'price' => $service['price'],
            'priceCurrency' => $service['priceCurrency'],
            'priceSpecification' => array(
                '@type' => 'PriceSpecification',
                'price' => $service['price'],
                'priceCurrency' => $service['priceCurrency'],
                'valueAddedTaxIncluded' => false,
            ),
        );
    }

    $schema_services[] = $service_schema;
}

// FAQ Schema
$schema_faq = array();
foreach ($faq_items as $item) {
    $schema_faq[] = array(
        '@type' => 'Question',
        'name' => $item['question'],
        'acceptedAnswer' => array(
            '@type' => 'Answer',
            'text' => $item['answer'],
        ),
    );
}

$full_schema = array(
    '@context' => 'https://schema.org',
    '@graph' => array(
        array(
            '@type' => 'WebPage',
            'name' => get_the_title(),
            'description' => 'Tarifs et honoraires Cognysens pour expertise bati ancien et AMO',
            'mainEntity' => $schema_services,
        ),
        array(
            '@type' => 'FAQPage',
            'mainEntity' => $schema_faq,
        ),
    ),
);
?>
<script type="application/ld+json">
<?php echo wp_json_encode($full_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>
</script>

<?php get_footer(); ?>
