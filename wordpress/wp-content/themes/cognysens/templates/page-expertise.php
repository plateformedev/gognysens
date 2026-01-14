<?php
/**
 * Template Name: Page Expertise
 * Template Post Type: page
 *
 * Template for expertise pages (DTG, Amiable, Judiciaire, etc.)
 *
 * @package Cognysens
 */

get_header();
?>

<main id="main" class="site-main page-expertise">
    <?php while (have_posts()) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            <!-- Hero Section -->
            <header class="page-hero page-hero--expertise">
                <div class="container">
                    <?php cognysens_breadcrumb(); ?>
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

            <!-- Related Services -->
            <?php
            $related_services = cognysens_get_related_pages('expertise');
            if ($related_services->have_posts()) :
            ?>
            <section class="section section--related">
                <div class="container">
                    <h2 class="section-title">Autres expertises</h2>
                    <div class="cards-grid cards-grid--3">
                        <?php while ($related_services->have_posts()) : $related_services->the_post(); ?>
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
                        <h2>Besoin d'une expertise technique ?</h2>
                        <p>Prenez rendez-vous pour un premier echange gratuit de 15 minutes.</p>
                        <a href="<?php echo esc_url(home_url('/prendre-rendez-vous/')); ?>" class="btn btn-primary">
                            Prendre rendez-vous
                        </a>
                    </div>
                </div>
            </section>

        </article>

    <?php endwhile; ?>
</main>

<?php get_footer(); ?>
