<?php
/**
 * Front Page Template
 *
 * @package Cognisens
 */

get_header();
?>

<main id="main" class="site-main">

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1 class="hero-title">Expertise et AMO<br>Bati Ancien & Patrimonial</h1>
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
                        En savoir plus &rarr;
                    </a>
                </div>

                <div class="card">
                    <h3 class="card-title">AMO Copropriete</h3>
                    <p class="card-text">
                        Accompagnement technique des coproprietes pour eviter de surpayer
                        leurs travaux de renovation et de restauration.
                    </p>
                    <a href="<?php echo esc_url(home_url('/amo-copropriete-eviter-surpayer-travaux/')); ?>" class="card-link">
                        En savoir plus &rarr;
                    </a>
                </div>

                <div class="card">
                    <h3 class="card-title">DTG Bati Ancien</h3>
                    <p class="card-text">
                        Diagnostic Technique Global adapte aux specificites du bati ancien
                        et aux enjeux patrimoniaux de votre immeuble.
                    </p>
                    <a href="<?php echo esc_url(home_url('/dtg-bati-ancien-copropriete/')); ?>" class="card-link">
                        En savoir plus &rarr;
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Section -->
    <section class="section section--stone">
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
                        Cognisens n'a aucun lien avec les entreprises de travaux.
                        Notre avis est strictement technique et objectif.
                    </p>
                </div>
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

            <div class="text-center" style="margin-top: 2rem;">
                <a href="<?php echo esc_url(home_url('/honoraires-tarifs-expertise-amo/')); ?>" class="btn btn-primary">
                    Tous nos tarifs
                </a>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="section section--black">
        <div class="container">
            <div class="cta-content text-center">
                <h2 style="color: white;">Besoin d'un avis d'expert ?</h2>
                <p style="color: rgba(255,255,255,0.8); max-width: 500px; margin: 0 auto 2rem;">
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

<style>
/* Front page specific styles */
.services-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
}

.card-link {
    font-size: 0.875rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.why-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 3rem;
}

.why-item h3 {
    font-size: 1.25rem;
    margin-bottom: 1rem;
}

.why-item p {
    color: var(--color-gray-medium);
}

.zone-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.5rem;
}

.zone-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 2rem;
    border: 1px solid var(--color-gray-light);
    background: var(--color-white);
    transition: all 0.3s ease;
}

.zone-card:hover {
    border-color: var(--color-black);
}

.zone-department {
    font-family: var(--font-heading);
    font-size: 2.5rem;
    font-weight: 500;
    color: var(--color-black);
    line-height: 1;
    margin-bottom: 0.5rem;
}

.zone-name {
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    color: var(--color-gray-medium);
}

.tarif-table {
    width: 100%;
    max-width: 700px;
    margin: 0 auto;
    border-collapse: collapse;
    background: var(--color-white);
}

.tarif-table th,
.tarif-table td {
    padding: 1rem 1.5rem;
    text-align: left;
    border-bottom: 1px solid var(--color-gray-light);
}

.tarif-table th {
    font-weight: 500;
    text-transform: uppercase;
    font-size: 0.875rem;
    letter-spacing: 0.05em;
    background: var(--color-gray-lighter);
}

@media (max-width: 768px) {
    .zone-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}
</style>

<?php
get_footer();
