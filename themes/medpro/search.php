<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package medpro
 * @version 1.2.0
 * @since 21.01.2026
 */

get_header();
?>

<div class="container">

    <div class="single-content">
        <h1 class="headline caption">
            Результаты поиска по слову: <?=esc_html( get_search_query() )?>
        </h1>
        <div class="main-text">
            <?
						if ( have_posts() ) {
							while ( have_posts() ) {
								the_post(); ?>
            <article id="post-<?php the_ID(); ?>">
                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" alt="">
                    <?php the_title( '<h2>', '</h2>' ); ?>
                </a>
            </article>
            <?
							} 
						} else {
							?>
            <p>Ничего не найдено</p>
            <?
						}
						?>
        </div>
    </div>

</div>
<?
get_footer();