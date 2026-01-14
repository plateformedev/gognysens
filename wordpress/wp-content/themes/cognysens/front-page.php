<?php
/**
 * Front Page Template
 *
 * @package Cognysens
 */

get_header();
?>

<main id="main" class="site-main page-home">

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1 class="hero-title">Expertise & AMO<br>Bati Ancien</h1>
            <p class="hero-text">
                Cabinet independant d'expertise technique et d'assistance a maitrise d'ouvrage
                specialise dans le bati ancien et patrimonial en Ile-de-France.
            </p>
            <div class="hero-buttons">
                <a href="<?php echo esc_url(home_url('/prendre-rendez-vous/')); ?>" class="btn btn-primary">
                    Prendre rendez-vous
                </a>
                <a href="<?php echo esc_url(home_url('/honoraires-tarifs-expertise-amo/')); ?>" class="btn btn-outline">
                    Voir les tarifs
                </a>
            </div>
        </div>
    </section>

    <!-- Trust Indicators -->
    <section class="section section--stone">
        <div class="container">
            <div class="trust-grid">
                <div class="trust-item">
                    <div class="trust-number">100%</div>
                    <div class="trust-label">Independant</div>
                </div>
                <div class="trust-item">
                    <div class="trust-number">15+</div>
                    <div class="trust-label">Ans d'experience</div>
                </div>
                <div class="trust-item">
                    <div class="trust-number">4</div>
                    <div class="trust-label">Departements couverts</div>
                </div>
                <div class="trust-item">
                    <div class="trust-number">48h</div>
                    <div class="trust-label">Delai de reponse</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Nos expertises</h2>
                <p class="section-subtitle">
                    Conseil, diagnostic et accompagnement technique pour la preservation de votre patrimoine bati.
                </p>
            </div>

            <div class="services-grid">
                <div class="card">
                    <h3 class="card-title">Expertise Amiable</h3>
                    <p class="card-text">
                        Diagnostic technique independant pour identifier les desordres,
                        analyser leurs causes et proposer des solutions adaptees.
                    </p>
                    <a href="<?php echo esc_url(home_url('/expertise-amiable-bati-ancien/')); ?>" class="card-link">
                        En savoir plus
                    </a>
                </div>

                <div class="card">
                    <h3 class="card-title">AMO Copropriete</h3>
                    <p class="card-text">
                        Accompagnement technique des coproprietes pour eviter de surpayer
                        leurs travaux de renovation et de restauration.
                    </p>
                    <a href="<?php echo esc_url(home_url('/amo-copropriete-eviter-surpayer-travaux/')); ?>" class="card-link">
                        En savoir plus
                    </a>
                </div>

                <div class="card">
                    <h3 class="card-title">DTG Bati Ancien</h3>
                    <p class="card-text">
                        Diagnostic Technique Global adapte aux specificites du bati ancien
                        et aux enjeux patrimoniaux de votre immeuble.
                    </p>
                    <a href="<?php echo esc_url(home_url('/dtg-bati-ancien-copropriete/')); ?>" class="card-link">
                        En savoir plus
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Pathologies Section -->
    <section class="section section--stone">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Pathologies du bati ancien</h2>
                <p class="section-subtitle">
                    Expertise technique des desordres courants sur immeubles anciens et patrimoniaux.
                </p>
            </div>

            <div class="pathologies-preview">
                <a href="<?php echo esc_url(home_url('/fissures-facade-immeuble-ancien/')); ?>" class="pathology-link">
                    <span>Fissures de facade</span>
                </a>
                <a href="<?php echo esc_url(home_url('/infiltrations-toiture-zinc-ardoise/')); ?>" class="pathology-link">
                    <span>Infiltrations toiture</span>
                </a>
                <a href="<?php echo esc_url(home_url('/bois-champignons-insectes-humidite/')); ?>" class="pathology-link">
                    <span>Champignons & insectes</span>
                </a>
                <a href="<?php echo esc_url(home_url('/pierre-qui-se-delite/')); ?>" class="pathology-link">
                    <span>Degradation pierre</span>
                </a>
                <a href="<?php echo esc_url(home_url('/decollement-enduit-facade/')); ?>" class="pathology-link">
                    <span>Decollement enduit</span>
                </a>
                <a href="<?php echo esc_url(home_url('/desordres-apres-ravalement/')); ?>" class="pathology-link">
                    <span>Desordres apres travaux</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Why Section -->
    <section class="section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Pourquoi un expert independant ?</h2>
            </div>

            <div class="why-grid">
                <div class="why-item">
                    <h3>Eviter de surpayer</h3>
                    <p>
                        Sans expertise prealable, vous risquez d'accepter des devis gonfles
                        ou des travaux inutiles. Un expert analyse objectivement vos besoins.
                    </p>
                </div>

                <div class="why-item">
                    <h3>Eviter les erreurs techniques</h3>
                    <p>
                        Le bati ancien a ses propres regles. Des travaux inadaptes peuvent
                        aggraver les desordres au lieu de les resoudre.
                    </p>
                </div>

                <div class="why-item">
                    <h3>Aucun conflit d'interet</h3>
                    <p>
                        Cognysens n'a aucun lien avec les entreprises de travaux.
                        Notre avis est strictement technique et objectif.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Domaines d'expertise -->
    <section class="section section--stone">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Domaines d'expertise</h2>
                <p class="section-subtitle">
                    Specialisation dans les techniques traditionnelles du bati ancien.
                </p>
            </div>

            <div class="domains-grid">
                <a href="<?php echo esc_url(home_url('/expertise-pierre-pierre-de-taille/')); ?>" class="domain-tag">Pierre de taille</a>
                <a href="<?php echo esc_url(home_url('/expertise-charpente-traditionnelle/')); ?>" class="domain-tag">Charpente</a>
                <a href="<?php echo esc_url(home_url('/expertise-couverture-zinc-ardoise/')); ?>" class="domain-tag">Couverture zinc/ardoise</a>
                <a href="<?php echo esc_url(home_url('/expertise-pan-de-bois-colombage/')); ?>" class="domain-tag">Pan de bois</a>
                <a href="<?php echo esc_url(home_url('/expertise-stucs-parisiens/')); ?>" class="domain-tag">Stucs parisiens</a>
                <a href="<?php echo esc_url(home_url('/expertise-modenatures/')); ?>" class="domain-tag">Modenatures</a>
            </div>
        </div>
    </section>

    <!-- Zone Section -->
    <section class="section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Zone d'intervention</h2>
                <p class="section-subtitle">
                    Nous intervenons principalement en Ile-de-France,
                    au coeur du patrimoine bati francilien.
                </p>
            </div>

            <div class="zone-grid">
                <a href="<?php echo esc_url(home_url('/expert-bati-ancien-paris/')); ?>" class="zone-card">
                    <span class="zone-department">75</span>
                    <span class="zone-name">Paris</span>
                </a>
                <a href="<?php echo esc_url(home_url('/expert-bati-ancien-hauts-de-seine/')); ?>" class="zone-card">
                    <span class="zone-department">92</span>
                    <span class="zone-name">Hauts-de-Seine</span>
                </a>
                <a href="<?php echo esc_url(home_url('/expert-bati-ancien-val-de-marne/')); ?>" class="zone-card">
                    <span class="zone-department">94</span>
                    <span class="zone-name">Val-de-Marne</span>
                </a>
                <a href="<?php echo esc_url(home_url('/expert-bati-ancien-yvelines/')); ?>" class="zone-card">
                    <span class="zone-department">78</span>
                    <span class="zone-name">Yvelines</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Pricing Preview -->
    <section class="section section--stone">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Nos honoraires</h2>
                <p class="section-subtitle">
                    Tarifs transparents. Devis personnalise sur demande.
                </p>
            </div>

            <div class="tarif-preview">
                <table class="tarif-table">
                    <thead>
                        <tr>
                            <th>Prestation</th>
                            <th>Tarif indicatif</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Expertise amiable - Appartement</td>
                            <td>A partir de 800 &euro; HT</td>
                        </tr>
                        <tr>
                            <td>Expertise amiable - Immeuble</td>
                            <td>A partir de 1 500 &euro; HT</td>
                        </tr>
                        <tr>
                            <td>DTG Bati Ancien</td>
                            <td>Sur devis</td>
                        </tr>
                        <tr>
                            <td>AMO Copropriete</td>
                            <td>% du montant travaux</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="text-center" style="margin-top: var(--spacing-lg);">
                <a href="<?php echo esc_url(home_url('/honoraires-tarifs-expertise-amo/')); ?>" class="btn btn-outline">
                    Tous nos tarifs
                </a>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="section section--black">
        <div class="container">
            <div class="cta-content text-center">
                <h2>Besoin d'un avis d'expert ?</h2>
                <p style="max-width: 500px; margin: 0 auto var(--spacing-lg);">
                    Prenez rendez-vous pour un premier echange gratuit de 15 minutes
                    afin d'evaluer votre situation.
                </p>
                <a href="<?php echo esc_url(home_url('/prendre-rendez-vous/')); ?>" class="btn btn-white">
                    Prendre rendez-vous
                </a>
            </div>
        </div>
    </section>

</main>

<?php
get_footer();
