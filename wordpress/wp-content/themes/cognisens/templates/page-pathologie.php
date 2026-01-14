<?php
/**
 * Template Name: Page Pathologie
 * Template Post Type: page
 *
 * Template for pathology pages (Fissures, Humidite, Merule, etc.)
 *
 * @package Cognisens
 */

get_header();
?>

<main id="main" class="site-main page-pathologie">
    <?php while (have_posts()) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            <!-- Hero Section -->
            <header class="page-hero page-hero--pathologie">
                <div class="container">
                    <?php cognisens_breadcrumb(); ?>
                    <?php the_title('<h1 class="page-title">', '</h1>'); ?>
                    <?php if (has_excerpt()) : ?>
                        <p class="page-lead"><?php echo get_the_excerpt(); ?></p>
                    <?php endif; ?>
                </div>
            </header>

            <!-- Alert Box if urgent pathology -->
            <?php
            $slug = get_post_field('post_name', get_the_ID());
            $urgent_pathologies = array('bois-champignons-insectes-humidite', 'infiltrations-toiture');
            if (in_array($slug, $urgent_pathologies)) :
            ?>
            <div class="alert-box alert-box--warning">
                <div class="container">
                    <strong>Attention :</strong> Cette pathologie peut evoluer rapidement.
                    Un diagnostic precoce limite les degats et les couts de reparation.
                </div>
            </div>
            <?php endif; ?>

            <!-- Main Content -->
            <div class="page-content">
                <div class="container container--content">
                    <?php the_content(); ?>
                </div>
            </div>

            <!-- Diagnosis CTA -->
            <section class="section section--diagnosis">
                <div class="container">
                    <div class="diagnosis-box">
                        <div class="diagnosis-content">
                            <h2>Vous observez ce type de desordre ?</h2>
                            <p>Un diagnostic precis est indispensable avant toute intervention.
                               Nous analysons les causes pour preconiser le traitement adapte.</p>
                        </div>
                        <a href="<?php echo esc_url(home_url('/prendre-rendez-vous/')); ?>" class="btn btn-primary">
                            Demander un diagnostic
                        </a>
                    </div>
                </div>
            </section>

            <!-- Related Pathologies -->
            <?php
            $related_patho = cognisens_get_related_pages('pathologie');
            if ($related_patho->have_posts()) :
            ?>
            <section class="section section--related">
                <div class="container">
                    <h2 class="section-title">Autres pathologies</h2>
                    <div class="cards-grid cards-grid--3">
                        <?php while ($related_patho->have_posts()) : $related_patho->the_post(); ?>
                            <a href="<?php the_permalink(); ?>" class="card card--pathologie">
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

            <!-- Link to expertise -->
            <section class="section section--link-expertise">
                <div class="container">
                    <p class="section-note">
                        <strong>Expertise technique :</strong>
                        Consultez notre page
                        <a href="<?php echo esc_url(home_url('/expertise-amiable-bati-ancien/')); ?>">Expertise Amiable</a>
                        pour comprendre notre methode de diagnostic.
                    </p>
                </div>
            </section>

        </article>

    <?php endwhile; ?>
</main>

<?php get_footer(); ?>
