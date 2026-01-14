<?php
/**
 * Template Name: Combien Coute
 * Template for pricing/cost detail pages
 *
 * Sections:
 * 1. Hero with price range
 * 2. What makes the price vary
 * 3. What's included
 * 4. Scenarios/Examples
 * 5. When AMO is useful
 * 6. FAQ
 * 7. CTA RDV
 *
 * @package Cognysens
 */

get_header();

// Get custom fields (ACF or meta)
$price_from = get_post_meta(get_the_ID(), '_price_from', true) ?: '800';
$price_to = get_post_meta(get_the_ID(), '_price_to', true) ?: '2500';
$price_unit = get_post_meta(get_the_ID(), '_price_unit', true) ?: 'HT';
?>

<main id="main" class="site-main page-combien-coute">

    <!-- Hero Section -->
    <header class="page-hero page-hero--pricing">
        <div class="container">
            <?php cognysens_breadcrumb(); ?>

            <div class="pricing-hero-content">
                <h1 class="page-title"><?php the_title(); ?></h1>

                <?php if (has_excerpt()) : ?>
                    <p class="page-lead"><?php echo esc_html(get_the_excerpt()); ?></p>
                <?php endif; ?>

                <div class="price-highlight">
                    <span class="price-label">A partir de</span>
                    <span class="price-value"><?php echo esc_html($price_from); ?> - <?php echo esc_html($price_to); ?> &euro;</span>
                    <span class="price-unit"><?php echo esc_html($price_unit); ?></span>
                </div>

                <p class="price-note">
                    Prix indicatif. Chaque situation est unique, nous etablissons un devis personnalise apres echange.
                </p>
            </div>
        </div>
    </header>

    <!-- What varies the price -->
    <section class="section section--white">
        <div class="container">
            <h2 class="section-title">Ce qui fait varier le prix</h2>

            <div class="factors-grid">
                <div class="factor-card">
                    <div class="factor-icon">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <rect x="3" y="3" width="18" height="18" rx="2"/>
                            <path d="M3 9h18M9 21V9"/>
                        </svg>
                    </div>
                    <h3>Surface et complexite</h3>
                    <p>La superficie du batiment et la complexite architecturale influencent directement le temps d'analyse necessaire.</p>
                </div>

                <div class="factor-card">
                    <div class="factor-icon">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                            <path d="M2 17l10 5 10-5"/>
                            <path d="M2 12l10 5 10-5"/>
                        </svg>
                    </div>
                    <h3>Nombre de pathologies</h3>
                    <p>Un probleme isole ou plusieurs desordres a analyser : chaque pathologie necessite une expertise specifique.</p>
                </div>

                <div class="factor-card">
                    <div class="factor-icon">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <circle cx="12" cy="12" r="10"/>
                            <path d="M12 6v6l4 2"/>
                        </svg>
                    </div>
                    <h3>Urgence</h3>
                    <p>Une intervention en urgence peut necessiter une reorganisation de planning et des frais supplementaires.</p>
                </div>

                <div class="factor-card">
                    <div class="factor-icon">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                            <line x1="16" y1="13" x2="8" y2="13"/>
                            <line x1="16" y1="17" x2="8" y2="17"/>
                        </svg>
                    </div>
                    <h3>Livrables demandes</h3>
                    <p>Rapport simple, rapport detaille avec plans, note technique pour avocat : le niveau de detail impacte le tarif.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- What's included -->
    <section class="section section--stone">
        <div class="container">
            <h2 class="section-title">Ce qui est toujours inclus</h2>

            <div class="included-grid">
                <div class="included-item">
                    <span class="check-icon">&#10003;</span>
                    <span>Visite sur site par l'expert</span>
                </div>
                <div class="included-item">
                    <span class="check-icon">&#10003;</span>
                    <span>Analyse documentaire (plans, historique)</span>
                </div>
                <div class="included-item">
                    <span class="check-icon">&#10003;</span>
                    <span>Rapport d'expertise detaille</span>
                </div>
                <div class="included-item">
                    <span class="check-icon">&#10003;</span>
                    <span>Preconisations techniques</span>
                </div>
                <div class="included-item">
                    <span class="check-icon">&#10003;</span>
                    <span>Estimation budgetaire des travaux</span>
                </div>
                <div class="included-item">
                    <span class="check-icon">&#10003;</span>
                    <span>Echange telephonique post-rapport</span>
                </div>
            </div>

            <div class="not-included">
                <h3>Non inclus (en option)</h3>
                <ul>
                    <li>Sondages destructifs et analyses en laboratoire</li>
                    <li>Releve geometre / plans cotes</li>
                    <li>Assistance lors de reunion contradictoire</li>
                    <li>Suivi de travaux (AMO)</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Scenarios -->
    <section class="section section--white">
        <div class="container">
            <h2 class="section-title">Exemples de missions</h2>

            <div class="scenarios-grid">
                <div class="scenario-card">
                    <div class="scenario-header">
                        <span class="scenario-label">Cas simple</span>
                        <span class="scenario-price">800 - 1200 &euro; HT</span>
                    </div>
                    <h3>Fissure isolee sur facade</h3>
                    <p>Appartement parisien, une fissure a analyser, rapport pour copropriete.</p>
                    <ul>
                        <li>1 visite sur site</li>
                        <li>Rapport 10-15 pages</li>
                        <li>Delai : 10 jours</li>
                    </ul>
                </div>

                <div class="scenario-card scenario-card--featured">
                    <div class="scenario-header">
                        <span class="scenario-label">Cas courant</span>
                        <span class="scenario-price">1500 - 2500 &euro; HT</span>
                    </div>
                    <h3>Expertise complete immeuble</h3>
                    <p>Petit immeuble haussmannien, plusieurs pathologies, contexte pre-travaux.</p>
                    <ul>
                        <li>2 visites sur site</li>
                        <li>Rapport 25-40 pages</li>
                        <li>Delai : 3 semaines</li>
                    </ul>
                </div>

                <div class="scenario-card">
                    <div class="scenario-header">
                        <span class="scenario-label">Cas complexe</span>
                        <span class="scenario-price">3000+ &euro; HT</span>
                    </div>
                    <h3>Expertise judiciaire contradictoire</h3>
                    <p>Litige avec entreprise, expertise detaillee pour avocat, possible audience.</p>
                    <ul>
                        <li>Visites multiples</li>
                        <li>Rapport technique complet</li>
                        <li>Assistance juridique</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- When AMO is useful -->
    <section class="section section--stone">
        <div class="container">
            <div class="amo-promo">
                <div class="amo-promo-content">
                    <h2>Quand une AMO devient pertinente ?</h2>
                    <p>
                        Si les travaux recommandes depassent <strong>30 000 &euro;</strong>, une
                        Assistance a Maitrise d'Ouvrage peut vous faire economiser bien plus que son cout.
                    </p>

                    <ul class="amo-benefits">
                        <li>
                            <strong>Economies moyennes constatees :</strong> 15-25% sur le montant des travaux
                        </li>
                        <li>
                            <strong>Securisation :</strong> cahier des charges precis, selection artisans qualifies
                        </li>
                        <li>
                            <strong>Serenite :</strong> un expert a vos cotes pendant toute la duree du chantier
                        </li>
                    </ul>

                    <a href="<?php echo esc_url(home_url('/amo-bati-ancien-patrimonial/')); ?>" class="btn btn-outline">
                        En savoir plus sur l'AMO
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content (FAQ or additional info) -->
    <?php if (get_the_content()) : ?>
    <section class="section section--white">
        <div class="container container--narrow">
            <div class="entry-content">
                <?php the_content(); ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- CTA Section -->
    <section class="section section--cta">
        <div class="container">
            <div class="cta-box">
                <h2>Obtenez un devis personnalise</h2>
                <p>
                    Chaque batiment est unique. Decrivez-nous votre situation pour recevoir
                    une estimation precise et sans engagement.
                </p>

                <div class="cta-actions">
                    <a href="<?php echo esc_url(home_url('/prendre-rendez-vous/')); ?>" class="btn btn-primary">
                        Prendre rendez-vous
                    </a>
                    <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn-outline">
                        Nous contacter
                    </a>
                </div>

                <p class="cta-reassurance">
                    Reponse sous 48h &bull; Devis gratuit &bull; Sans engagement
                </p>
            </div>
        </div>
    </section>

</main>

<?php
// Schema.org for pricing page
$schema = array(
    '@context' => 'https://schema.org',
    '@type' => 'Service',
    'name' => get_the_title(),
    'provider' => array(
        '@type' => 'Organization',
        'name' => 'Cognysens',
        'address' => array(
            '@type' => 'PostalAddress',
            'streetAddress' => '109 chemin de Ronde',
            'addressLocality' => 'Croissy-sur-Seine',
            'postalCode' => '78290',
            'addressCountry' => 'FR',
        ),
    ),
    'areaServed' => array(
        array('@type' => 'City', 'name' => 'Paris'),
        array('@type' => 'AdministrativeArea', 'name' => 'Hauts-de-Seine'),
        array('@type' => 'AdministrativeArea', 'name' => 'Val-de-Marne'),
        array('@type' => 'AdministrativeArea', 'name' => 'Yvelines'),
    ),
    'offers' => array(
        '@type' => 'Offer',
        'priceSpecification' => array(
            '@type' => 'PriceSpecification',
            'price' => $price_from,
            'priceCurrency' => 'EUR',
            'minPrice' => $price_from,
            'maxPrice' => $price_to,
        ),
    ),
);

echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>';

get_footer();
