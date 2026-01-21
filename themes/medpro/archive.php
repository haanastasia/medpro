<?php
/**
 * Шаблон для отображения архивных страниц
 *
 * @package medpro
 * @version 1.2.0
 * @since 21.01.2026
 */

get_header();
?>
<div class="container">

    <div class="single-content">
        <h1 class="headline caption"><?php the_archive_title(); ?></h1>
        <div class="main-text">
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                <?php while ( have_posts() ) : ?>
                <?php the_post(); ?>
                <div class="col">
                    <div class="card h-100 shadow-sm border-0">
                        <?php if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail()) ) : ?>
                        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" alt="<?php the_title(); ?>">
                            <?php the_post_thumbnail('medium', [
                                'class' => 'card-img-top',
                                'alt' => get_the_title()
                            ]); ?>
                        </a>
                        <?php endif; ?>
                        <div class="news-item__container">
                            <a class="news-item__title" href="<?php the_permalink() ?>"><?php the_title(); ?></a>
                            <div class="news-item__content"><?php the_excerpt();?></div>
                            <a class="news-item__link" href="<?php the_permalink() ?>">Читать далее</a>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>


</div>
<?php 
get_footer(); 