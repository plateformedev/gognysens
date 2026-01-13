<?php
/**
 * Default Page Template
 *
 * @package Cognisens
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
                    <?php cognisens_breadcrumb(); ?>
                    <?php the_title('<h1 class="page-title">', '</h1>'); ?>
                    <?php if (has_excerpt()) : ?>
                        <p class="lead"><?php echo esc_html(get_the_excerpt()); ?></p>
                    <?php endif; ?>
                </div>
            </header>

            <div class="entry-content">
                <?php the_content(); ?>
            </div>

        </article>
        <?php
    endwhile;
    ?>
</main>

<?php
get_footer();
