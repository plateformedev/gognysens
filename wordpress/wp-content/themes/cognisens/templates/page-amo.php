<?php
/**
 * Template Name: Page AMO
 * Template Post Type: page
 *
 * Template for AMO pages (Assistance Maitrise d'Ouvrage)
 *
 * @package Cognisens
 */

get_header();
?>

<main id="main" class="site-main page-amo">
    <?php while (have_posts()) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            <!-- Hero Section -->
            <header class="page-hero page-hero--amo">
                <div class="container">
                    <?php cognisens_breadcrumb(); ?>
                    <?php the_title('<h1 class="page-title">', '</h1>'); ?>
                    <?php if (has_excerpt()) : ?>
                        <p class="page-lead"><?php echo get_the_excerpt(); ?></p>
                    <?php endif; ?>
                </div>
            </header>

            <!-- Main Content -->
            <div class="page-content">
                <div class="container container--content">
                    <?php the_content(); ?>
                </div>
            </div>

            <!-- AMO Process -->
            <section class="section section--process">
                <div class="container">
                    <h2 class="section-title">Notre accompagnement</h2>
                    <div class="process-steps">
                        <div class="process-step">
                            <span class="step-number">1</span>
                            <h3>Definition</h3>
                            <p>Analyse de vos besoins et definition du programme</p>
                        </div>
                        <div class="process-step">
                            <span class="step-number">2</span>
                            <h3>Consultation</h3>
                            <p>Cahier des charges et analyse des offres</p>
                        </div>
                        <div class="process-step">
                            <span class="step-number">3</span>
                            <h3>Suivi</h3>
                            <p>Verification de la conformite sur chantier</p>
                        </div>
                        <div class="process-step">
                            <span class="step-number">4</span>
                            <h3>Reception</h3>
                            <p>Assistance et levee des reserves</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Related AMO Services -->
            <?php
            $related_amo = cognisens_get_related_pages('amo');
            if ($related_amo->have_posts()) :
            ?>
            <section class="section section--related">
                <div class="container">
                    <h2 class="section-title">Autres accompagnements AMO</h2>
                    <div class="cards-grid cards-grid--3">
                        <?php while ($related_amo->have_posts()) : $related_amo->the_post(); ?>
                            <a href="<?php the_permalink(); ?>" class="card card--service">
                                <h3 class="card-title"><?php the_title(); ?></h3>
                                <?php if (has_excerpt()) : ?>
                                    <p class="card-text"><?php echo get_the_excerpt(); ?></p>
                                <?php endif; ?>
                                <span class="card-link">En savoir plus</span>
                            </a>
                        <?php endwhile; wp_reset_postdata(); ?>
                    </div>
                </div>
            </section>
            <?php endif; ?>

            <!-- CTA Section -->
            <section class="section section--cta">
                <div class="container">
                    <div class="cta-box">
                        <h2>Un projet de travaux ?</h2>
                        <p>Evitez de surpayer. Faites-vous accompagner par un expert independant.</p>
                        <a href="<?php echo esc_url(home_url('/prendre-rendez-vous/')); ?>" class="btn btn-primary">
                            Demander un accompagnement
                        </a>
                    </div>
                </div>
            </section>

        </article>

    <?php endwhile; ?>
</main>

<?php get_footer(); ?>
