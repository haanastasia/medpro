<?php
/**
 * @package medpro
 * @version 1.2.0
 * @since 21.01.2026
 */
?>
</main><!-- #main -->

<footer class="footer py-5 mt-5 bg-light border-top">

    <div class="container">

        <?php
        $specializations = get_terms([
            'taxonomy'   => 'specialization',
        ]);

        if (!is_wp_error($specializations) && !empty($specializations)) :
        ?>
        <ul class="nav col-12 col-lg-auto me-lg-auto mb-4 justify-content-center">
            <?php foreach ($specializations as $spec) : ?>
                <li class="nav-item">
                    <a
                        href="<?= esc_url(get_post_type_archive_link('doctors')); ?>?specialization=<?= esc_attr($spec->slug) ?>"
                        class="nav-link link-dark px-2"
                    >
                        <?= esc_html($spec->name) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
        <?php wp_nav_menu( [ 'theme_location' => 'footer', 'menu_id' => 'footer-menu', 'menu_class' => 'footer__menu nav mb-3 justify-content-center', 'container' => false, 'depth' => 1 ] ); ?>
        <div class="footer__documents text-center">
            <a class="link link--light" href="/privacy-policy/">Политика конфиденциальности</a>
        </div>
        <div class="footer__copyright text-center">©<?=date('Y')?> <?php bloginfo( 'name' );?></div>
    </div>

</footer>

<?php wp_footer(); ?>

</body>

</html>