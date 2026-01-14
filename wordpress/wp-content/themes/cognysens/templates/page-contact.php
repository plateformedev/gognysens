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
                        <?php esc_html_e('Une question ? Un projet ? Contactez-nous.', 'cognysens'); ?>
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
                                <form class="cognysens-contact-form" method="post" action="">
                                    <div class="form-group">
                                        <label for="contact-name">Nom *</label>
                                        <input type="text" id="contact-name" name="name" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="contact-email">Email *</label>
                                        <input type="email" id="contact-email" name="email" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="contact-phone">Telephone</label>
                                        <input type="tel" id="contact-phone" name="phone">
                                    </div>

                                    <div class="form-group">
                                        <label for="contact-subject">Sujet *</label>
                                        <select id="contact-subject" name="subject" required>
                                            <option value="">Selectionnez</option>
                                            <option value="expertise">Demande d'expertise</option>
                                            <option value="amo">Demande d'AMO</option>
                                            <option value="devis">Demande de devis</option>
                                            <option value="autre">Autre</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="contact-message">Message *</label>
                                        <textarea id="contact-message" name="message" rows="5" required></textarea>
                                    </div>

                                    <div class="form-group form-group--checkbox">
                                        <input type="checkbox" id="contact-rgpd" name="rgpd" required>
                                        <label for="contact-rgpd">
                                            J'accepte que mes donnees soient traitees conformement a la
                                            <a href="<?php echo esc_url(home_url('/politique-de-confidentialite/')); ?>" target="_blank">politique de confidentialite</a>. *
                                        </label>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Envoyer</button>
                                </form>
                                <?php
                            }
                            ?>
                        </div>
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
</main>

<style>
.contact-grid {
    display: grid;
    grid-template-columns: 1fr 1.5fr;
    gap: 4rem;
}

.contact-info h2,
.contact-form h2 {
    margin-bottom: 2rem;
}

.contact-block {
    margin-bottom: 2rem;
}

.contact-block h3 {
    font-size: 1rem;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    margin-bottom: 0.75rem;
}

.contact-block address {
    font-style: normal;
    line-height: 1.8;
}

.contact-block ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.contact-block li {
    margin-bottom: 0.25rem;
}

/* Form styles */
.cognysens-contact-form .form-group {
    margin-bottom: 1.5rem;
}

.cognysens-contact-form label {
    display: block;
    font-size: 0.875rem;
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.cognysens-contact-form input[type="text"],
.cognysens-contact-form input[type="email"],
.cognysens-contact-form input[type="tel"],
.cognysens-contact-form select,
.cognysens-contact-form textarea {
    width: 100%;
    padding: 0.75rem 1rem;
    font-family: inherit;
    font-size: 1rem;
    border: 1px solid var(--color-gray-light);
    background: var(--color-white);
    transition: border-color 0.2s ease;
}

.cognysens-contact-form input:focus,
.cognysens-contact-form select:focus,
.cognysens-contact-form textarea:focus {
    outline: none;
    border-color: var(--color-black);
}

.form-group--checkbox {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
}

.form-group--checkbox input {
    width: auto;
    margin-top: 0.25rem;
}

.form-group--checkbox label {
    font-size: 0.875rem;
    font-weight: 400;
    margin-bottom: 0;
}

@media (max-width: 768px) {
    .contact-grid {
        grid-template-columns: 1fr;
        gap: 3rem;
    }
}
</style>

<?php
get_footer();
