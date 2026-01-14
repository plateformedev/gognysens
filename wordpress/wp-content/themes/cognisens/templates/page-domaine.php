<?php
/**
 * Template Name: Page Domaine
 * Template Post Type: page
 *
 * Template for domain expertise pages (Pierre, Charpente, Couverture, etc.)
 *
 * @package Cognisens
 */

get_header();
?>

<main id="main" class="site-main page-domaine">
    <?php while (have_posts()) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            <!-- Hero Section -->
            <header class="page-hero page-hero--domaine">
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

            <!-- Expertise Box -->
            <section class="section section--expertise-box">
                <div class="container">
                    <div class="expertise-highlight">
                        <h2>Notre expertise dans ce domaine</h2>
                        <ul class="expertise-list">
                            <li>Diagnostic et identification des pathologies</li>
                            <li>Evaluation de l'etendue des desordres</li>
                            <li>Preconisations de traitement adaptees</li>
                            <li>Estimation budgetaire des travaux</li>
                            <li>Suivi de realisation si AMO</li>
                        </ul>
                    </div>
                </div>
            </section>

            <!-- Related Domains -->
            <?php
            $related_domains = cognisens_get_related_pages('domaine');
            if ($related_domains->have_posts()) :
            ?>
            <section class="section section--related">
                <div class="container">
                    <h2 class="section-title">Autres domaines d'expertise</h2>
                    <div class="cards-grid cards-grid--4">
                        <?php while ($related_domains->have_posts()) : $related_domains->the_post(); ?>
                            <a href="<?php the_permalink(); ?>" class="card card--domaine">
                                <h3 class="card-title"><?php the_title(); ?></h3>
                                <span class="card-link">Decouvrir</span>
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
                        <h2>Un projet concernant ce domaine ?</h2>
                        <p>Expertise technique ou accompagnement AMO, nous vous conseillons.</p>
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
