<?php
/**
 * Главная страница темы MedPro
 *
 * @package medpro
 * @version 1.0.1
 */

get_header();
?>

<div class="container py-5">
    <!-- Блок: Выберите специализацию -->
    <?php
    $specializations_list = get_terms(array(
        'taxonomy'   => 'specialization',
        'hide_empty' => false,
    ));

    if (!empty($specializations_list) && !is_wp_error($specializations_list)) : ?>
    <section class="mb-5">
        <h2 class="mb-4">Выберите специализацию врача</h2>
        <div class="d-flex flex-wrap gap-2">
            <?php foreach ($specializations_list as $spec) : ?>
            <a href="<?php echo esc_url(add_query_arg('specialization', $spec->slug, get_post_type_archive_link('doctors'))); ?>"
                class="btn btn-outline-secondary mb-2">
                <?php echo esc_html($spec->name); ?>
            </a>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

    <!-- Блок: Лучшие врачи -->
    <?php
    $best_doctors = new WP_Query(array(
        'post_type'      => 'doctors',
        'posts_per_page' => 3,
        'meta_key'       => '_doctor_rating',
        'orderby'        => 'meta_value_num',
        'order'          => 'DESC',
    ));

    if ($best_doctors->have_posts()) : ?>
    <section class="mb-5">
        <h2 class="mb-4">Наши лучшие врачи</h2>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php while ($best_doctors->have_posts()) : $best_doctors->the_post(); ?>
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <?php if (has_post_thumbnail()) : ?>
                    <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail('medium', [
                                        'class' => 'doctor-card-image',
                                        'alt'   => esc_attr(get_the_title())
                                    ]); ?>
                    </a>
                    <?php endif; ?>

                    <div class="card-body d-flex flex-column">
                        <h3 class="card-title h5">
                            <a href="<?php the_permalink(); ?>" class="text-decoration-none text-dark">
                                <?php the_title(); ?>
                            </a>
                        </h3>

                        <?php 
                                $rating = get_post_meta(get_the_ID(), '_doctor_rating', true);
                                if ($rating) : ?>
                        <div class="mb-2">
                            <small class="text-warning">
                                <?php
                                            for ($i = 1; $i <= 5; $i++) {
                                                echo $i <= intval($rating) ? '★' : '☆';
                                            }
                                            ?>
                            </small>
                            <small class="text-muted ms-2">(<?php echo intval($rating); ?>)</small>
                        </div>
                        <?php endif; ?>

                        <?php 
                                $specializations = get_the_terms(get_the_ID(), 'specialization');
                                if ($specializations && !is_wp_error($specializations)) :
                                    $spec_names = wp_list_pluck($specializations, 'name'); ?>
                        <div class="mb-2">
                            <small class="text-muted"><?php echo esc_html(implode(', ', $spec_names)); ?></small>
                        </div>
                        <?php endif; ?>

                        <a href="<?php the_permalink(); ?>" class="btn btn-outline-primary mt-auto">Записаться</a>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </section>
    <?php wp_reset_postdata(); ?>
    <?php endif; ?>

</div>

<?php get_footer(); ?>