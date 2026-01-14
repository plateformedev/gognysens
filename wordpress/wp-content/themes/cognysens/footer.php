<?php
/**
 * Footer Template
 *
 * @package Cognysens
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

    <footer id="colophon" class="site-footer">
        <div class="footer-inner">
            <div class="footer-main">
                <div class="footer-brand">
                    <span class="footer-logo">COGNYSENS</span>
                    <p class="footer-tagline">
                        <?php esc_html_e('Cabinet independant d\'expertise et d\'AMO specialise dans le bati ancien et patrimonial.', 'cognysens'); ?>
                    </p>
                </div>

                <div class="footer-nav">
                    <div class="footer-col">
                        <h4><?php esc_html_e('Services', 'cognysens'); ?></h4>
                        <ul>
                            <li><a href="<?php echo esc_url(home_url('/expertise-amiable-bati-ancien/')); ?>"><?php esc_html_e('Expertise Amiable', 'cognysens'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/amo-bati-ancien-patrimonial/')); ?>"><?php esc_html_e('AMO Bati Ancien', 'cognysens'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/dtg-bati-ancien-copropriete/')); ?>"><?php esc_html_e('DTG', 'cognysens'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/honoraires-tarifs-expertise-amo/')); ?>"><?php esc_html_e('Tarifs', 'cognysens'); ?></a></li>
                        </ul>
                    </div>

                    <div class="footer-col">
                        <h4><?php esc_html_e('Zone d\'intervention', 'cognysens'); ?></h4>
                        <ul>
                            <li><a href="<?php echo esc_url(home_url('/expert-bati-ancien-paris/')); ?>"><?php esc_html_e('Paris (75)', 'cognysens'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/expert-bati-ancien-hauts-de-seine/')); ?>"><?php esc_html_e('Hauts-de-Seine (92)', 'cognysens'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/expert-bati-ancien-val-de-marne/')); ?>"><?php esc_html_e('Val-de-Marne (94)', 'cognysens'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/expert-bati-ancien-yvelines/')); ?>"><?php esc_html_e('Yvelines (78)', 'cognysens'); ?></a></li>
                        </ul>
                    </div>

                    <div class="footer-col">
                        <h4><?php esc_html_e('Contact', 'cognysens'); ?></h4>
                        <address class="footer-address">
                            109 chemin de Ronde<br>
                            78290 Croissy-sur-Seine
                        </address>
                        <a href="<?php echo esc_url(home_url('/prendre-rendez-vous/')); ?>" class="btn btn-outline">
                            <?php esc_html_e('Prendre rendez-vous', 'cognysens'); ?>
                        </a>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <div class="footer-legal">
                    <nav class="legal-nav">
                        <a href="<?php echo esc_url(home_url('/mentions-legales/')); ?>"><?php esc_html_e('Mentions legales', 'cognysens'); ?></a>
                        <a href="<?php echo esc_url(home_url('/politique-de-confidentialite/')); ?>"><?php esc_html_e('Confidentialite', 'cognysens'); ?></a>
                        <a href="<?php echo esc_url(home_url('/politique-cookies/')); ?>"><?php esc_html_e('Cookies', 'cognysens'); ?></a>
                        <a href="<?php echo esc_url(home_url('/conditions-generales-utilisation/')); ?>"><?php esc_html_e('CGU', 'cognysens'); ?></a>
                        <a href="<?php echo esc_url(home_url('/conditions-generales-prestations/')); ?>"><?php esc_html_e('CGP', 'cognysens'); ?></a>
                        <a href="<?php echo esc_url(home_url('/donnees-personnelles-et-ia/')); ?>"><?php esc_html_e('IA & Donnees', 'cognysens'); ?></a>
                    </nav>
                    <?php if (function_exists('cmplz_manage_consent_button')) : ?>
                        <button class="cmplz-manage-consent footer-cookies-btn"><?php esc_html_e('Gerer les cookies', 'cognysens'); ?></button>
                    <?php endif; ?>
                </div>
                <div class="footer-copyright">
                    <p>&copy; <?php echo esc_html(date('Y')); ?> Cognysens. <?php esc_html_e('Tous droits reserves.', 'cognysens'); ?></p>
                </div>
            </div>
        </div>
    </footer>

</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
