<?php
/**
 * Template Name: Page Tarifs
 * Template Post Type: page
 *
 * @package Cognysens
 */

get_header();
?>

<main id="main" class="site-main page-tarifs">
    <?php
    while (have_posts()) :
        the_post();
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            <header class="page-header">
                <div class="container">
                    <?php cognysens_breadcrumb(); ?>
                    <?php the_title('<h1 class="page-title">', '</h1>'); ?>
                    <p class="lead">
                        <?php esc_html_e('Tarifs transparents et honoraires clairs. Devis personnalise sur demande.', 'cognysens'); ?>
                    </p>
                </div>
            </header>

            <section class="section">
                <div class="container">
                    <div class="tarifs-intro">
                        <p>
                            Nos honoraires sont calcules en fonction de la complexite de la mission,
                            de la surface concernee et de la nature des desordres a analyser.
                            Les tarifs ci-dessous sont indicatifs et HT.
                        </p>
                    </div>
                </div>
            </section>

            <section class="section section--stone">
                <div class="container">
                    <h2 class="text-center">Expertises</h2>

                    <div class="tarif-grid">
                        <div class="tarif-card">
                            <h3 class="tarif-card-title">Expertise Appartement</h3>
                            <div class="tarif-card-price">800 &euro;</div>
                            <div class="tarif-card-suffix">HT - A partir de</div>
                            <ul class="tarif-card-features">
                                <li>Visite sur site</li>
                                <li>Analyse des desordres</li>
                                <li>Rapport d'expertise</li>
                                <li>Preconisations techniques</li>
                            </ul>
                            <a href="<?php echo esc_url(home_url('/prendre-rendez-vous/')); ?>" class="btn btn-outline">
                                Demander un devis
                            </a>
                        </div>

                        <div class="tarif-card">
                            <h3 class="tarif-card-title">Expertise Immeuble</h3>
                            <div class="tarif-card-price">1 500 &euro;</div>
                            <div class="tarif-card-suffix">HT - A partir de</div>
                            <ul class="tarif-card-features">
                                <li>Visite complete</li>
                                <li>Parties communes</li>
                                <li>Rapport detaille</li>
                                <li>Plan d'action</li>
                            </ul>
                            <a href="<?php echo esc_url(home_url('/prendre-rendez-vous/')); ?>" class="btn btn-outline">
                                Demander un devis
                            </a>
                        </div>

                        <div class="tarif-card">
                            <h3 class="tarif-card-title">DTG Bati Ancien</h3>
                            <div class="tarif-card-price">Sur devis</div>
                            <div class="tarif-card-suffix">Selon surface et complexite</div>
                            <ul class="tarif-card-features">
                                <li>Diagnostic complet</li>
                                <li>Plan pluriannuel</li>
                                <li>Estimations budgetaires</li>
                                <li>Accompagnement AG</li>
                            </ul>
                            <a href="<?php echo esc_url(home_url('/prendre-rendez-vous/')); ?>" class="btn btn-outline">
                                Demander un devis
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <section class="section">
                <div class="container">
                    <h2 class="text-center">Assistance a Maitrise d'Ouvrage</h2>

                    <div class="tarif-grid">
                        <div class="tarif-card">
                            <h3 class="tarif-card-title">AMO Copropriete</h3>
                            <div class="tarif-card-price">3 a 5%</div>
                            <div class="tarif-card-suffix">du montant des travaux HT</div>
                            <ul class="tarif-card-features">
                                <li>Analyse des devis</li>
                                <li>Negociation</li>
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
                                <li>Verification technique</li>
                                <li>Protection interets</li>
                                <li>Conseils experts</li>
                            </ul>
                            <a href="<?php echo esc_url(home_url('/prendre-rendez-vous/')); ?>" class="btn btn-outline">
                                Demander un devis
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <section class="section section--stone">
                <div class="container container--narrow">
                    <h2 class="text-center">Modalites</h2>

                    <div class="modalites-content">
                        <h3>Conditions de reglement</h3>
                        <ul>
                            <li>Acompte de 30% a la commande</li>
                            <li>Solde a la remise du rapport</li>
                            <li>Paiement par virement ou cheque</li>
                        </ul>

                        <h3>Ce qui est inclus</h3>
                        <ul>
                            <li>Deplacements en zone d'intervention</li>
                            <li>Rapport d'expertise PDF</li>
                            <li>Echanges telephoniques</li>
                        </ul>

                        <h3>Ce qui est en option</h3>
                        <ul>
                            <li>Deplacements hors zone</li>
                            <li>Analyses complementaires (labo)</li>
                            <li>Assistance reunion / AG</li>
                        </ul>
                    </div>
                </div>
            </section>

            <?php if (get_the_content()) : ?>
            <div class="entry-content">
                <?php the_content(); ?>
            </div>
            <?php endif; ?>

        </article>
        <?php
    endwhile;
    ?>

    <!-- CTA -->
    <section class="section section--black">
        <div class="container text-center">
            <h2 style="color: white;">Besoin d'un devis personnalise ?</h2>
            <p style="color: rgba(255,255,255,0.8); max-width: 500px; margin: 0 auto 2rem;">
                Chaque situation est unique. Contactez-nous pour un devis adapte a votre projet.
            </p>
            <a href="<?php echo esc_url(home_url('/prendre-rendez-vous/')); ?>" class="btn btn-white">
                Prendre rendez-vous
            </a>
        </div>
    </section>

</main>

<style>
.tarifs-intro {
    max-width: 700px;
    margin: 0 auto;
    text-align: center;
}

.modalites-content h3 {
    margin-top: 2rem;
    margin-bottom: 1rem;
}

.modalites-content ul {
    margin: 0;
    padding-left: 1.5rem;
}

.modalites-content li {
    margin-bottom: 0.5rem;
}
</style>

<?php
get_footer();
