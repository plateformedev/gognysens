<?php
/**
 * Header Template
 *
 * @package Cognisens
 */

if (!defined('ABSPATH')) {
    exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#main">
        <?php esc_html_e('Aller au contenu', 'cognisens'); ?>
    </a>

    <header id="masthead" class="site-header">
        <div class="header-inner">
            <div class="site-branding">
                <?php if (has_custom_logo()) : ?>
                    <?php the_custom_logo(); ?>
                <?php else : ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="site-title-link">
                        <span class="site-title">COGNISENS</span>
                    </a>
                <?php endif; ?>
            </div>

            <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                <span class="menu-toggle-icon"></span>
                <span class="screen-reader-text"><?php esc_html_e('Menu', 'cognisens'); ?></span>
            </button>

            <nav id="site-navigation" class="main-navigation">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu_id'        => 'primary-menu',
                    'menu_class'     => 'primary-menu',
                    'container'      => false,
                    'depth'          => 2,
                    'fallback_cb'    => false,
                ));
                ?>
            </nav>

            <div class="header-cta">
                <a href="<?php echo esc_url(home_url('/prendre-rendez-vous/')); ?>" class="btn btn-primary">
                    <?php esc_html_e('Rendez-vous', 'cognisens'); ?>
                </a>
            </div>
        </div>
    </header>
