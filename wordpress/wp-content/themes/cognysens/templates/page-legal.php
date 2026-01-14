<?php
/**
 * Template Name: Page Legale
 * Template Post Type: page
 *
 * @package Cognysens
 */

get_header();
?>

<main id="main" class="site-main page-legal">
    <?php
    while (have_posts()) :
        the_post();
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            <header class="page-header page-header--minimal">
                <div class="container container--narrow">
                    <?php cognysens_breadcrumb(); ?>
                    <?php the_title('<h1 class="page-title">', '</h1>'); ?>
                </div>
            </header>

            <div class="entry-content legal-content">
                <?php the_content(); ?>

                <?php
                // Auto-generate content based on page slug if empty
                $slug = get_post_field('post_name', get_the_ID());

                if (!get_the_content()) :
                    switch ($slug) :
                        case 'mentions-legales':
                            ?>
                            <h2>Editeur du site</h2>
                            <p>
                                <strong>COGNYSENS</strong><br>
                                109 chemin de Ronde<br>
                                78290 Croissy-sur-Seine<br>
                                France
                            </p>

                            <h2>Hebergement</h2>
                            <p>
                                [Nom de l'hebergeur]<br>
                                [Adresse]
                            </p>

                            <h2>Propriete intellectuelle</h2>
                            <p>
                                L'ensemble du contenu de ce site (textes, images, structure)
                                est protege par le droit d'auteur. Toute reproduction est interdite
                                sans autorisation prealable.
                            </p>
                            <?php
                            break;

                        case 'politique-de-confidentialite':
                            ?>
                            <h2>Collecte des donnees</h2>
                            <p>
                                Cognysens collecte uniquement les donnees necessaires au traitement
                                de vos demandes : nom, email, telephone, details de votre projet.
                            </p>

                            <h2>Utilisation des donnees</h2>
                            <p>Vos donnees sont utilisees pour :</p>
                            <ul>
                                <li>Repondre a vos demandes de contact</li>
                                <li>Etablir des devis</li>
                                <li>Assurer le suivi de nos prestations</li>
                            </ul>

                            <h2>Conservation</h2>
                            <p>
                                Vos donnees sont conservees pendant 3 ans apres le dernier contact,
                                sauf obligation legale contraire.
                            </p>

                            <h2>Vos droits</h2>
                            <p>
                                Conformement au RGPD, vous disposez d'un droit d'acces, de rectification,
                                d'effacement et de portabilite de vos donnees.
                            </p>
                            <?php
                            break;

                        case 'politique-cookies':
                            ?>
                            <h2>Qu'est-ce qu'un cookie ?</h2>
                            <p>
                                Un cookie est un petit fichier texte depose sur votre navigateur
                                lors de la visite d'un site web.
                            </p>

                            <h2>Cookies utilises</h2>
                            <h3>Cookies essentiels</h3>
                            <p>Necessaires au fonctionnement du site. Pas de consentement requis.</p>

                            <h3>Cookies analytiques</h3>
                            <p>
                                Avec votre consentement, nous utilisons des cookies pour mesurer
                                l'audience du site.
                            </p>

                            <h2>Gerer vos preferences</h2>
                            <p>
                                Vous pouvez modifier vos preferences a tout moment via le bandeau cookies
                                ou les parametres de votre navigateur.
                            </p>
                            <?php
                            break;

                        case 'donnees-personnelles-et-ia':
                            ?>
                            <h2>Utilisation de l'Intelligence Artificielle</h2>
                            <p>
                                Cognysens utilise des outils d'intelligence artificielle pour
                                faciliter la qualification de vos demandes et optimiser nos
                                reponses.
                            </p>

                            <h2>Ce que fait l'IA</h2>
                            <ul>
                                <li>Resume les informations que vous fournissez</li>
                                <li>Classe votre demande (expertise, AMO, pathologie)</li>
                                <li>Propose des creneaux de rendez-vous adaptes</li>
                            </ul>

                            <h2>Ce que l'IA ne fait pas</h2>
                            <ul>
                                <li>Aucune analyse technique de votre situation</li>
                                <li>Aucune decision engageante</li>
                                <li>Aucun diagnostic automatise</li>
                            </ul>

                            <h2>Vos droits</h2>
                            <p>
                                Vous pouvez demander a tout moment une intervention humaine
                                ou refuser le traitement automatise de vos donnees.
                            </p>
                            <?php
                            break;

                    endswitch;
                endif;
                ?>
            </div>

        </article>
        <?php
    endwhile;
    ?>
</main>

<style>
.page-header--minimal {
    padding: 3rem 0;
    background: var(--color-stone);
}

.legal-content {
    max-width: var(--content-width);
    margin: 0 auto;
    padding: 4rem 1.5rem;
}

.legal-content h2 {
    margin-top: 3rem;
    padding-top: 2rem;
    border-top: 1px solid var(--color-gray-light);
}

.legal-content h2:first-of-type {
    margin-top: 0;
    padding-top: 0;
    border-top: none;
}

.legal-content h3 {
    margin-top: 2rem;
}

.legal-content ul {
    padding-left: 1.5rem;
}

.legal-content li {
    margin-bottom: 0.5rem;
}
</style>

<?php
get_footer();
