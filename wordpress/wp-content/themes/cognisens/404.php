<?php
/**
 * 404 Template
 *
 * @package Cognisens
 */

get_header();
?>

<main id="main" class="site-main">
    <article class="error-404">
        <header class="page-header">
            <div class="container">
                <h1 class="page-title"><?php esc_html_e('Page introuvable', 'cognisens'); ?></h1>
            </div>
        </header>

        <div class="entry-content">
            <div class="container container--narrow text-center">
                <p class="lead">
                    <?php esc_html_e('La page que vous recherchez n\'existe pas ou a ete deplacee.', 'cognisens'); ?>
                </p>

                <div style="margin-top: 2rem;">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary">
                        <?php esc_html_e('Retour a l\'accueil', 'cognisens'); ?>
                    </a>
                </div>

                <div style="margin-top: 3rem;">
                    <h2><?php esc_html_e('Vous cherchez peut-etre', 'cognisens'); ?></h2>
                    <ul style="list-style: none; padding: 0; margin-top: 1.5rem;">
                        <li style="margin-bottom: 0.5rem;">
                            <a href="<?php echo esc_url(home_url('/le-cabinet/')); ?>">
                                <?php esc_html_e('Le Cabinet', 'cognisens'); ?>
                            </a>
                        </li>
                        <li style="margin-bottom: 0.5rem;">
                            <a href="<?php echo esc_url(home_url('/expertise-amiable-bati-ancien/')); ?>">
                                <?php esc_html_e('Nos Expertises', 'cognisens'); ?>
                            </a>
                        </li>
                        <li style="margin-bottom: 0.5rem;">
                            <a href="<?php echo esc_url(home_url('/honoraires-tarifs-expertise-amo/')); ?>">
                                <?php esc_html_e('Nos Tarifs', 'cognisens'); ?>
                            </a>
                        </li>
                        <li style="margin-bottom: 0.5rem;">
                            <a href="<?php echo esc_url(home_url('/contact/')); ?>">
                                <?php esc_html_e('Contact', 'cognisens'); ?>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </article>
</main>

<?php
get_footer();
