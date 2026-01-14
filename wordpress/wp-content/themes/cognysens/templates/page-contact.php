<?php
/**
 * Template Name: Page Contact
 * Template Post Type: page
 *
 * @package Cognysens
 */

get_header();
?>

<main id="main" class="site-main page-contact">
    <?php while (have_posts()) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            <header class="page-hero">
                <div class="container">
                    <?php cognysens_breadcrumb(); ?>
                    <?php the_title('<h1 class="page-title">', '</h1>'); ?>
                    <p class="page-lead">
                        Une question ? Un projet ? Contactez-nous.
                    </p>
                </div>
            </header>

            <section class="section">
                <div class="container">
                    <div class="contact-grid">
                        <div class="contact-info">
                            <h2>Coordonnees</h2>

                            <div class="contact-block">
                                <h3>Adresse</h3>
                                <address>
                                    COGNYSENS<br>
                                    109 chemin de Ronde<br>
                                    78290 Croissy-sur-Seine
                                </address>
                            </div>

                            <div class="contact-block">
                                <h3>Zone d'intervention</h3>
                                <ul>
                                    <li>Paris (75)</li>
                                    <li>Hauts-de-Seine (92)</li>
                                    <li>Val-de-Marne (94)</li>
                                    <li>Yvelines (78)</li>
                                </ul>
                            </div>

                            <div class="contact-block">
                                <h3>Rendez-vous</h3>
                                <p>
                                    Pour un premier echange gratuit de 15 minutes,
                                    prenez rendez-vous en ligne.
                                </p>
                                <a href="<?php echo esc_url(home_url('/prendre-rendez-vous/')); ?>" class="btn btn-primary">
                                    Prendre rendez-vous
                                </a>
                            </div>
                        </div>

                        <div class="contact-form">
                            <h2>Formulaire de contact</h2>

                            <?php
                            // If Gravity Forms is active, display form
                            if (function_exists('gravity_form')) {
                                gravity_form(1, false, false, false, null, true);
                            } else {
                                // Fallback form
                                ?>
                                <form class="cognysens-form cognysens-contact-form" method="post" action="">
                                    <?php wp_nonce_field('cognysens_contact', 'contact_nonce'); ?>

                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="contact-name">Nom complet *</label>
                                            <input type="text" id="contact-name" name="name" required placeholder="Votre nom et prenom">
                                        </div>
                                        <div class="form-group">
                                            <label for="contact-email">Email *</label>
                                            <input type="email" id="contact-email" name="email" required placeholder="votre@email.fr">
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="contact-phone">Telephone</label>
                                            <input type="tel" id="contact-phone" name="phone" placeholder="06 12 34 56 78">
                                        </div>
                                        <div class="form-group">
                                            <label for="contact-subject">Sujet *</label>
                                            <select id="contact-subject" name="subject" required>
                                                <option value="">Selectionnez</option>
                                                <option value="expertise">Demande d'expertise</option>
                                                <option value="amo">Demande d'AMO</option>
                                                <option value="devis">Demande de devis</option>
                                                <option value="autre">Autre question</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Qualification fields -->
                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="contact-type-bien">Type de bien (optionnel)</label>
                                            <select id="contact-type-bien" name="type_bien">
                                                <option value="">Non precise</option>
                                                <option value="appartement">Appartement</option>
                                                <option value="immeuble">Immeuble / Copropriete</option>
                                                <option value="maison">Maison ancienne</option>
                                                <option value="autre">Autre</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="contact-code-postal">Code postal du bien (optionnel)</label>
                                            <input type="text" id="contact-code-postal" name="code_postal" pattern="[0-9]{5}" maxlength="5" placeholder="75001">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="contact-message">Message *</label>
                                        <textarea id="contact-message" name="message" rows="5" required
                                            placeholder="Decrivez votre projet ou votre question..."></textarea>
                                    </div>

                                    <div class="form-group form-group--checkbox">
                                        <input type="checkbox" id="contact-rgpd" name="rgpd" required>
                                        <label for="contact-rgpd">
                                            J'accepte que mes donnees soient traitees conformement a la
                                            <a href="<?php echo esc_url(home_url('/politique-de-confidentialite/')); ?>" target="_blank">politique de confidentialite</a>. *
                                        </label>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Envoyer le message</button>
                                </form>
                                <?php
                            }
                            ?>
                        </div>
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
</main>

<?php get_footer(); ?>
