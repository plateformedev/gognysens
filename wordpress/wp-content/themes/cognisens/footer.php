<?php
/**
 * Footer Template
 *
 * @package Cognisens
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

    <footer id="colophon" class="site-footer">
        <div class="footer-inner">
            <div class="footer-main">
                <div class="footer-brand">
                    <span class="footer-logo">COGNISENS</span>
                    <p class="footer-tagline">
                        <?php esc_html_e('Cabinet independant d\'expertise et d\'AMO specialise dans le bati ancien et patrimonial.', 'cognisens'); ?>
                    </p>
                </div>

                <div class="footer-nav">
                    <div class="footer-col">
                        <h4><?php esc_html_e('Services', 'cognisens'); ?></h4>
                        <ul>
                            <li><a href="<?php echo esc_url(home_url('/expertise-amiable-bati-ancien/')); ?>"><?php esc_html_e('Expertise Amiable', 'cognisens'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/amo-bati-ancien-patrimonial/')); ?>"><?php esc_html_e('AMO Bati Ancien', 'cognisens'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/dtg-bati-ancien-copropriete/')); ?>"><?php esc_html_e('DTG', 'cognisens'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/honoraires-tarifs-expertise-amo/')); ?>"><?php esc_html_e('Tarifs', 'cognisens'); ?></a></li>
                        </ul>
                    </div>

                    <div class="footer-col">
                        <h4><?php esc_html_e('Zone d\'intervention', 'cognisens'); ?></h4>
                        <ul>
                            <li><a href="<?php echo esc_url(home_url('/expert-bati-ancien-paris/')); ?>"><?php esc_html_e('Paris (75)', 'cognisens'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/expert-bati-ancien-hauts-de-seine/')); ?>"><?php esc_html_e('Hauts-de-Seine (92)', 'cognisens'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/expert-bati-ancien-val-de-marne/')); ?>"><?php esc_html_e('Val-de-Marne (94)', 'cognisens'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/expert-bati-ancien-yvelines/')); ?>"><?php esc_html_e('Yvelines (78)', 'cognisens'); ?></a></li>
                        </ul>
                    </div>

                    <div class="footer-col">
                        <h4><?php esc_html_e('Contact', 'cognisens'); ?></h4>
                        <address class="footer-address">
                            109 chemin de Ronde<br>
                            78290 Croissy-sur-Seine
                        </address>
                        <a href="<?php echo esc_url(home_url('/prendre-rendez-vous/')); ?>" class="btn btn-outline">
                            <?php esc_html_e('Prendre rendez-vous', 'cognisens'); ?>
                        </a>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <div class="footer-legal">
                    <nav class="legal-nav">
                        <a href="<?php echo esc_url(home_url('/mentions-legales/')); ?>"><?php esc_html_e('Mentions legales', 'cognisens'); ?></a>
                        <a href="<?php echo esc_url(home_url('/politique-de-confidentialite/')); ?>"><?php esc_html_e('Confidentialite', 'cognisens'); ?></a>
                        <a href="<?php echo esc_url(home_url('/politique-cookies/')); ?>"><?php esc_html_e('Cookies', 'cognisens'); ?></a>
                        <a href="<?php echo esc_url(home_url('/conditions-generales-utilisation/')); ?>"><?php esc_html_e('CGU', 'cognisens'); ?></a>
                        <a href="<?php echo esc_url(home_url('/conditions-generales-prestations/')); ?>"><?php esc_html_e('CGP', 'cognisens'); ?></a>
                        <a href="<?php echo esc_url(home_url('/donnees-personnelles-et-ia/')); ?>"><?php esc_html_e('IA & Donnees', 'cognisens'); ?></a>
                    </nav>
                    <?php if (function_exists('cmplz_manage_consent_button')) : ?>
                        <button class="cmplz-manage-consent footer-cookies-btn"><?php esc_html_e('Gerer les cookies', 'cognisens'); ?></button>
                    <?php endif; ?>
                </div>
                <div class="footer-copyright">
                    <p>&copy; <?php echo esc_html(date('Y')); ?> Cognisens. <?php esc_html_e('Tous droits reserves.', 'cognisens'); ?></p>
                </div>
            </div>
        </div>
    </footer>

</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
