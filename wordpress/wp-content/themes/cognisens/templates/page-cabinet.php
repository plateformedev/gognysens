<?php
/**
 * Template Name: Page Cabinet
 * Template Post Type: page
 *
 * Template for cabinet/about pages
 *
 * @package Cognisens
 */

get_header();
?>

<main id="main" class="site-main page-cabinet">
    <?php while (have_posts()) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            <!-- Hero Section -->
            <header class="page-hero page-hero--cabinet">
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

            <!-- Values Section (only on main cabinet page) -->
            <?php if (get_post_field('post_name', get_the_ID()) === 'cabinet-expertise-bati-ancien') : ?>
            <section class="section section--values">
                <div class="container">
                    <h2 class="section-title">Nos valeurs</h2>
                    <div class="values-grid">
                        <div class="value-item">
                            <h3>Independance</h3>
                            <p>Aucun lien avec les entreprises de travaux. Notre seul client, c'est vous.</p>
                        </div>
                        <div class="value-item">
                            <h3>Expertise</h3>
                            <p>Connaissance approfondie du bati ancien et de ses pathologies specifiques.</p>
                        </div>
                        <div class="value-item">
                            <h3>Pedagogie</h3>
                            <p>Des rapports clairs et des explications accessibles pour eclairer vos decisions.</p>
                        </div>
                        <div class="value-item">
                            <h3>Engagement</h3>
                            <p>Votre interet guide notre intervention, du diagnostic a la reception des travaux.</p>
                        </div>
                    </div>
                </div>
            </section>
            <?php endif; ?>

            <!-- Zone d'intervention -->
            <section class="section section--zone">
                <div class="container">
                    <h2 class="section-title">Zone d'intervention</h2>
                    <p class="section-intro">
                        Nous intervenons principalement en Ile-de-France, sur le bati ancien et patrimonial.
                    </p>
                    <div class="zone-grid">
                        <a href="<?php echo esc_url(home_url('/expert-bati-ancien-paris/')); ?>" class="zone-item">
                            <span class="zone-name">Paris</span>
                            <span class="zone-code">75</span>
                        </a>
                        <a href="<?php echo esc_url(home_url('/expert-bati-ancien-hauts-de-seine/')); ?>" class="zone-item">
                            <span class="zone-name">Hauts-de-Seine</span>
                            <span class="zone-code">92</span>
                        </a>
                        <a href="<?php echo esc_url(home_url('/expert-bati-ancien-val-de-marne/')); ?>" class="zone-item">
                            <span class="zone-name">Val-de-Marne</span>
                            <span class="zone-code">94</span>
                        </a>
                        <a href="<?php echo esc_url(home_url('/expert-bati-ancien-yvelines/')); ?>" class="zone-item">
                            <span class="zone-name">Yvelines</span>
                            <span class="zone-code">78</span>
                        </a>
                    </div>
                </div>
            </section>

            <!-- Contact CTA -->
            <section class="section section--cta">
                <div class="container">
                    <div class="cta-box cta-box--contact">
                        <div class="cta-content">
                            <h2>Une question ?</h2>
                            <p>Prenez rendez-vous pour un premier echange gratuit.</p>
                        </div>
                        <div class="cta-actions">
                            <a href="<?php echo esc_url(home_url('/prendre-rendez-vous/')); ?>" class="btn btn-primary">
                                Prendre rendez-vous
                            </a>
                        </div>
                    </div>
                </div>
            </section>

        </article>

    <?php endwhile; ?>
</main>

<?php get_footer(); ?>
