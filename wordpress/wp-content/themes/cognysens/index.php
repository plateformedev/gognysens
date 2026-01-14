<?php
/**
 * Main template file
 *
 * @package Cognysens
 */

get_header();
?>

<main id="main" class="site-main">
    <?php
    if (have_posts()) :
        while (have_posts()) :
            the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
                </header>

                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            </article>
            <?php
        endwhile;
    else :
        ?>
        <article class="no-results">
            <header class="entry-header">
                <h1 class="entry-title"><?php esc_html_e('Contenu introuvable', 'cognysens'); ?></h1>
            </header>
            <div class="entry-content">
                <p><?php esc_html_e('Le contenu demande n\'a pas ete trouve.', 'cognysens'); ?></p>
            </div>
        </article>
        <?php
    endif;
    ?>
</main>

<?php
get_footer();
