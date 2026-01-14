<?php
/**
 * Template Name: Page RDV
 * Template Post Type: page
 *
 * Template for appointment booking page
 *
 * @package Cognysens
 */

get_header();
?>

<main id="main" class="site-main page-rdv">
    <?php while (have_posts()) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            <!-- Hero Section -->
            <header class="page-hero">
                <div class="container">
                    <?php cognysens_breadcrumb(); ?>
                    <?php the_title('<h1 class="page-title">', '</h1>'); ?>
                    <p class="page-lead">
                        Premier echange gratuit de 15 minutes pour evaluer votre situation.
                    </p>
                </div>
            </header>

            <!-- RDV Content -->
            <section class="section">
                <div class="container">
                    <div class="rdv-grid">

                        <!-- Qualification Form -->
                        <div class="rdv-form">
                            <?php
                            // If Amelia or SSA booking plugin is active
                            if (shortcode_exists('ameliabooking')) {
                                echo do_shortcode('[ameliabooking]');
                            } elseif (shortcode_exists('ssa_booking')) {
                                echo do_shortcode('[ssa_booking]');
                            } else {
                                // Fallback qualification form
                                ?>
                                <!-- IA Notice -->
                                <div class="ia-notice">
                                    <strong>Information IA</strong>
                                    Une intelligence artificielle analysera votre demande pour mieux preparer notre echange.
                                    <a href="<?php echo esc_url(home_url('/donnees-personnelles-et-ia/')); ?>">En savoir plus</a>
                                </div>

                                <form class="cognysens-form cognysens-rdv-form" method="post" action="">
                                    <?php wp_nonce_field('cognysens_rdv', 'rdv_nonce'); ?>

                                    <!-- Section 1: Coordonnees -->
                                    <div class="form-section">
                                        <h3 class="form-section-title">Vos coordonnees</h3>

                                        <div class="form-row">
                                            <div class="form-group">
                                                <label for="rdv-nom">Nom *</label>
                                                <input type="text" id="rdv-nom" name="nom" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="rdv-prenom">Prenom *</label>
                                                <input type="text" id="rdv-prenom" name="prenom" required>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group">
                                                <label for="rdv-email">Email *</label>
                                                <input type="email" id="rdv-email" name="email" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="rdv-telephone">Telephone *</label>
                                                <input type="tel" id="rdv-telephone" name="telephone" required>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Section 2: Votre bien -->
                                    <div class="form-section">
                                        <h3 class="form-section-title">Votre bien</h3>

                                        <div class="form-group">
                                            <label for="rdv-type-bien">Type de bien *</label>
                                            <select id="rdv-type-bien" name="type_bien" required>
                                                <option value="">Selectionnez</option>
                                                <option value="appartement">Appartement</option>
                                                <option value="immeuble">Immeuble entier</option>
                                                <option value="maison">Maison ancienne</option>
                                                <option value="hotel-particulier">Hotel particulier</option>
                                                <option value="batiment-public">Batiment public/Monument</option>
                                                <option value="autre">Autre</option>
                                            </select>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group">
                                                <label for="rdv-code-postal">Code postal du bien *</label>
                                                <input type="text" id="rdv-code-postal" name="code_postal" required pattern="[0-9]{5}" maxlength="5">
                                            </div>
                                            <div class="form-group">
                                                <label for="rdv-annee">Annee de construction (approx.)</label>
                                                <select id="rdv-annee" name="annee_construction">
                                                    <option value="">Je ne sais pas</option>
                                                    <option value="avant-1850">Avant 1850</option>
                                                    <option value="1850-1900">1850 - 1900</option>
                                                    <option value="1900-1945">1900 - 1945</option>
                                                    <option value="1945-1970">1945 - 1970</option>
                                                    <option value="apres-1970">Apres 1970</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="rdv-qualite">Vous etes *</label>
                                            <select id="rdv-qualite" name="qualite" required>
                                                <option value="">Selectionnez</option>
                                                <option value="proprietaire">Proprietaire occupant</option>
                                                <option value="bailleur">Proprietaire bailleur</option>
                                                <option value="syndic">Syndic de copropriete</option>
                                                <option value="conseil-syndical">Conseil syndical</option>
                                                <option value="acquereur">Acquereur potentiel</option>
                                                <option value="professionnel">Professionnel (architecte, notaire...)</option>
                                                <option value="autre">Autre</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Section 3: Votre besoin -->
                                    <div class="form-section">
                                        <h3 class="form-section-title">Votre besoin</h3>

                                        <div class="form-group">
                                            <label>Type de prestation souhaitee *</label>
                                            <div class="radio-group">
                                                <div class="radio-option">
                                                    <input type="radio" id="rdv-expertise" name="prestation" value="expertise" required>
                                                    <label for="rdv-expertise">Expertise technique (diagnostic)</label>
                                                </div>
                                                <div class="radio-option">
                                                    <input type="radio" id="rdv-amo" name="prestation" value="amo">
                                                    <label for="rdv-amo">AMO (accompagnement travaux)</label>
                                                </div>
                                                <div class="radio-option">
                                                    <input type="radio" id="rdv-dtg" name="prestation" value="dtg">
                                                    <label for="rdv-dtg">DTG (Diagnostic Technique Global)</label>
                                                </div>
                                                <div class="radio-option">
                                                    <input type="radio" id="rdv-conseil" name="prestation" value="conseil">
                                                    <label for="rdv-conseil">Simple conseil / orientation</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="rdv-description">Decrivez votre situation *</label>
                                            <textarea id="rdv-description" name="description" rows="5" required
                                                placeholder="Ex: Fissures apparues sur la facade depuis 6 mois, infiltrations au dernier etage..."></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="rdv-urgence">Niveau d'urgence</label>
                                            <select id="rdv-urgence" name="urgence">
                                                <option value="normal">Normal (sous 2-3 semaines)</option>
                                                <option value="rapide">Rapide (sous 1 semaine)</option>
                                                <option value="urgent">Urgent (situation critique)</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Section 4: Creneau -->
                                    <div class="form-section">
                                        <h3 class="form-section-title">Creneau souhaite</h3>

                                        <div class="form-row">
                                            <div class="form-group">
                                                <label for="rdv-date">Date preferee</label>
                                                <input type="date" id="rdv-date" name="date_preferee" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="rdv-creneau">Creneau prefere</label>
                                                <select id="rdv-creneau" name="creneau">
                                                    <option value="">Peu importe</option>
                                                    <option value="matin">Matin (9h-12h)</option>
                                                    <option value="apres-midi">Apres-midi (14h-18h)</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- RGPD -->
                                    <div class="form-group form-group--checkbox">
                                        <input type="checkbox" id="rdv-rgpd" name="rgpd" required>
                                        <label for="rdv-rgpd">
                                            J'accepte que mes donnees soient traitees conformement a la
                                            <a href="<?php echo esc_url(home_url('/politique-de-confidentialite/')); ?>" target="_blank">politique de confidentialite</a>
                                            et analysees par une intelligence artificielle pour preparer notre echange. *
                                        </label>
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-lg">
                                        Demander un rendez-vous
                                    </button>
                                </form>
                                <?php
                            }
                            ?>
                        </div>

                        <!-- RDV Info Sidebar -->
                        <div class="rdv-info">
                            <h2>Comment ca se passe ?</h2>

                            <ol class="rdv-steps">
                                <li>
                                    <strong>Vous remplissez le formulaire</strong><br>
                                    Decrivez votre situation en quelques lignes.
                                </li>
                                <li>
                                    <strong>Analyse de votre demande</strong><br>
                                    Notre IA prepare un resume pour optimiser notre echange.
                                </li>
                                <li>
                                    <strong>Premier echange (15 min)</strong><br>
                                    Appel telephonique gratuit pour evaluer vos besoins.
                                </li>
                                <li>
                                    <strong>Proposition personnalisee</strong><br>
                                    Devis adapte a votre situation specifique.
                                </li>
                            </ol>

                            <div class="rdv-note">
                                <strong>Bon a savoir</strong><br>
                                Le premier echange de 15 minutes est gratuit et sans engagement.
                                Il nous permet de comprendre votre situation et de vous orienter vers la prestation adaptee.
                            </div>

                            <div style="margin-top: var(--spacing-lg);">
                                <h3 style="font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.75rem;">Zone d'intervention</h3>
                                <ul style="list-style: none; padding: 0; margin: 0; font-size: 0.9rem;">
                                    <li>Paris (75)</li>
                                    <li>Hauts-de-Seine (92)</li>
                                    <li>Val-de-Marne (94)</li>
                                    <li>Yvelines (78)</li>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </section>

            <!-- FAQ Section -->
            <section class="section section--stone">
                <div class="container container--content">
                    <h2 class="section-title text-center">Questions frequentes</h2>

                    <div class="faq-list">
                        <details class="faq-item">
                            <summary>Le premier echange est-il vraiment gratuit ?</summary>
                            <div class="faq-content">
                                <p>Oui, le premier echange telephonique de 15 minutes est entierement gratuit et sans engagement. Il nous permet de comprendre votre situation et de vous orienter vers la prestation la plus adaptee.</p>
                            </div>
                        </details>

                        <details class="faq-item">
                            <summary>Comment mes donnees sont-elles utilisees ?</summary>
                            <div class="faq-content">
                                <p>Vos donnees sont traitees conformement au RGPD. Une intelligence artificielle analyse votre demande pour preparer notre echange, mais aucune donnee n'est partagee avec des tiers. Consultez notre <a href="<?php echo esc_url(home_url('/donnees-personnelles-et-ia/')); ?>">page dediee</a> pour plus d'informations.</p>
                            </div>
                        </details>

                        <details class="faq-item">
                            <summary>Sous quel delai serai-je recontacte ?</summary>
                            <div class="faq-content">
                                <p>Nous nous engageons a vous recontacter sous 48h ouvrees. Pour les demandes urgentes, nous faisons notre maximum pour vous rappeler dans la journee.</p>
                            </div>
                        </details>

                        <details class="faq-item">
                            <summary>Intervenez-vous en dehors de l'Ile-de-France ?</summary>
                            <div class="faq-content">
                                <p>Notre zone d'intervention principale couvre Paris et la petite couronne (75, 92, 94, 78). Pour des interventions au-dela, contactez-nous pour etudier la faisabilite.</p>
                            </div>
                        </details>
                    </div>
                </div>
            </section>

        </article>

    <?php endwhile; ?>
</main>

<?php get_footer(); ?>
