<?php
/**
 * Template Name: Page GEO
 * Template Post Type: page
 *
 * Template for geographic/local SEO pages (Paris, 92, 94, 78)
 *
 * @package Cognisens
 */

get_header();

// Get location data from slug
$slug = get_post_field('post_name', get_the_ID());
$location_data = cognisens_get_location_data($slug);
?>

<main id="main" class="site-main page-geo">
    <?php while (have_posts()) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            <!-- Hero Section with location -->
            <header class="page-hero page-hero--geo">
                <div class="container">
                    <?php cognisens_breadcrumb(); ?>
                    <?php the_title('<h1 class="page-title">', '</h1>'); ?>
                    <?php if ($location_data['tagline']) : ?>
                        <p class="page-lead"><?php echo esc_html($location_data['tagline']); ?></p>
                    <?php endif; ?>
                </div>
            </header>

            <!-- Local Business Schema -->
            <?php cognisens_local_business_schema($location_data); ?>

            <!-- Main Content -->
            <div class="page-content">
                <div class="container container--content">
                    <?php the_content(); ?>
                </div>
            </div>

            <!-- Services in this area -->
            <section class="section section--services-local">
                <div class="container">
                    <h2 class="section-title">Nos services <?php echo esc_html($location_data['preposition']); ?> <?php echo esc_html($location_data['name']); ?></h2>
                    <div class="cards-grid cards-grid--3">
                        <div class="card card--service">
                            <h3 class="card-title">Expertise Bati Ancien</h3>
                            <p class="card-text">Diagnostic technique des desordres sur immeubles anciens et patrimoniaux.</p>
                            <a href="<?php echo esc_url(home_url('/expertise-amiable-bati-ancien/')); ?>" class="card-link">En savoir plus</a>
                        </div>
                        <div class="card card--service">
                            <h3 class="card-title">AMO Copropriete</h3>
                            <p class="card-text">Accompagnement technique pour vos travaux de ravalement, toiture, renovation.</p>
                            <a href="<?php echo esc_url(home_url('/amo-copropriete-eviter-surpayer-travaux/')); ?>" class="card-link">En savoir plus</a>
                        </div>
                        <div class="card card--service">
                            <h3 class="card-title">DTG Bati Ancien</h3>
                            <p class="card-text">Diagnostic Technique Global adapte aux specificites du bati ancien.</p>
                            <a href="<?php echo esc_url(home_url('/dtg-bati-ancien-copropriete/')); ?>" class="card-link">En savoir plus</a>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Pathologies courantes -->
            <section class="section section--pathologies-local">
                <div class="container">
                    <h2 class="section-title">Pathologies courantes <?php echo esc_html($location_data['preposition']); ?> <?php echo esc_html($location_data['name']); ?></h2>
                    <div class="pathologies-list">
                        <a href="<?php echo esc_url(home_url('/fissures-facade-immeuble-ancien/')); ?>">Fissures de facade</a>
                        <a href="<?php echo esc_url(home_url('/infiltrations-toiture-zinc-ardoise/')); ?>">Infiltrations toiture</a>
                        <a href="<?php echo esc_url(home_url('/bois-champignons-insectes-humidite/')); ?>">Champignons et insectes</a>
                        <a href="<?php echo esc_url(home_url('/pierre-qui-se-delite/')); ?>">Degradation de la pierre</a>
                        <a href="<?php echo esc_url(home_url('/decollement-enduit-facade/')); ?>">Decollement d'enduit</a>
                    </div>
                </div>
            </section>

            <!-- Other zones -->
            <section class="section section--other-zones">
                <div class="container">
                    <h2 class="section-title">Nous intervenons egalement</h2>
                    <div class="zone-links">
                        <?php
                        $all_zones = array(
                            'expert-bati-ancien-paris' => 'Paris (75)',
                            'expert-bati-ancien-hauts-de-seine' => 'Hauts-de-Seine (92)',
                            'expert-bati-ancien-val-de-marne' => 'Val-de-Marne (94)',
                            'expert-bati-ancien-yvelines' => 'Yvelines (78)',
                        );
                        foreach ($all_zones as $zone_slug => $zone_name) :
                            if ($zone_slug !== $slug) :
                        ?>
                            <a href="<?php echo esc_url(home_url('/' . $zone_slug . '/')); ?>"><?php echo esc_html($zone_name); ?></a>
                        <?php
                            endif;
                        endforeach;
                        ?>
                    </div>
                </div>
            </section>

            <!-- CTA -->
            <section class="section section--cta">
                <div class="container">
                    <div class="cta-box">
                        <h2>Expert bati ancien <?php echo esc_html($location_data['preposition']); ?> <?php echo esc_html($location_data['name']); ?></h2>
                        <p>Cabinet independant base a Croissy-sur-Seine. Deplacements inclus.</p>
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
