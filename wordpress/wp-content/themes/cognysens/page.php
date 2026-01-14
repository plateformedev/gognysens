<?php
/**
 * Default Page Template
 *
 * @package Cognysens
 */

get_header();
?>

<main id="main" class="site-main">
    <?php
    while (have_posts()) :
        the_post();
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            <header class="page-header">
                <div class="container">
                    <?php cognysens_breadcrumb(); ?>
                    <?php the_title('<h1 class="page-title">', '</h1>'); ?>
                    <?php if (has_excerpt()) : ?>
                        <p class="lead"><?php echo esc_html(get_the_excerpt()); ?></p>
                    <?php endif; ?>
                </div>
            </header>

            <div class="entry-content">
                <div class="container container--content">
                    <?php the_content(); ?>
                </div>
            </div>

        </article>
        <?php
    endwhile;
    ?>
</main>

<?php
get_footer();
