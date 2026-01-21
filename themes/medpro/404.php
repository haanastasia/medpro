<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package medpro
 * @version 1.2.0
 * @since 21.01.2026
 */

get_header();
?>
<div class="container">

    <div class="single-content">
        <h1 class="headline caption">404 – Ой! Мы заблудились</h1>
        <div class="main-text">
            <p>Кажется, эта страничка потерялась. Давайте попробуем вернуться на <a
                    href="<?php echo esc_url(home_url('/')); ?>">главную</a> или воспользуемся поиском.</p>
            <?php get_search_form(); ?>
        </div>
    </div>

</div>

<?php
get_footer();