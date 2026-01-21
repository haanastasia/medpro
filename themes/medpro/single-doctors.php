<?php
/**
 * Template Name: Шаблон врача
 * Template Post Type: doctors
 *
 * @package medpro
 */

get_header();
?>

<div class="container">

    <article class="doctor-card bg-light rounded shadow-sm p-4 mb-4">

        <!-- Заголовок -->
        <div class="doctor-header mb-4">
            <h1 class="doctor-title h2 mb-3"><?= esc_html(get_the_title()); ?></h1>

            <!-- Рейтинг -->
            <?php 
            $rating = (float) get_post_meta(get_the_ID(), '_doctor_rating', true);
            if ($rating): ?>
            <div class="doctor-rating mb-3 d-flex align-items-center">
                <div class="stars" style="color: #ffc107; font-size: 1.5rem;">
                    <?php 
                        for ($i = 1; $i <= 5; $i++) {
                            echo $i <= $rating ? '★' : '☆';
                        }
                        ?>
                </div>
                <span class="rating-value ms-2 text-muted">
                    Рейтинг: <?= esc_html($rating); ?>/5
                </span>
            </div>
            <?php endif; ?>
        </div>

        <div class="row">

            <!-- Изображение -->
            <?php if (has_post_thumbnail()): ?>
            <div class="doctor-image mb-4 col-12 col-md-4">
                <a href="<?= esc_url(get_permalink()); ?>" title="<?= esc_attr(get_the_title()); ?>">
                    <?php
                        the_post_thumbnail('large', [
                            'class' => 'img-fluid rounded',
                            'alt'   => esc_attr(get_the_title())
                        ]);
                        ?>
                </a>
            </div>
            <?php endif; ?>

            <div class="doctor-info mb-4 col-12 col-md-8">
                <h3 class="h4 mb-3">Информация</h3>

                <div class="row">
                    <!-- Город -->
                    <?php 
                    $cities = get_the_terms(get_the_ID(), 'city');
                    if ($cities && !is_wp_error($cities)): ?>
                    <div class="col-md-6 mb-3">
                        <div class="info-item">
                            <strong>Город:</strong>
                            <div class="mt-1">
                                <?php foreach ($cities as $city): ?>
                                <span class="badge bg-secondary me-1 mb-1">
                                    <?= esc_html($city->name); ?>
                                </span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Специализация -->
                    <?php 
                    $specializations = get_the_terms(get_the_ID(), 'specialization');
                    if ($specializations && !is_wp_error($specializations)): ?>
                    <div class="col-md-6 mb-3">
                        <div class="info-item">
                            <strong>Специализация:</strong>
                            <div class="mt-1">
                                <?php foreach ($specializations as $spec): ?>
                                <span class="badge bg-primary me-1 mb-1">
                                    <?= esc_html($spec->name); ?>
                                </span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Стаж -->
                    <?php 
                    $experience = absint(get_post_meta(get_the_ID(), '_doctor_experience', true));
                    if ($experience): ?>
                    <div class="col-md-6 mb-3">
                        <div class="info-item">
                            <strong>Стаж работы:</strong>
                            <span class="ms-2"><?= esc_html($experience); ?> лет</span>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Цена -->
                    <?php 
                    $price = absint(get_post_meta(get_the_ID(), '_doctor_price_from', true));
                    if ($price): ?>
                    <div class="col-md-6 mb-3">
                        <div class="info-item">
                            <strong>Цена:</strong>
                            <span class="ms-2">от <?= esc_html(number_format($price, 0, '', ' ')); ?> руб.</span>
                        </div>
                    </div>
                    <?php endif; ?>

                </div>

                <!-- Краткое описание -->
                <?php if (has_excerpt()): ?>
                <div class="doctor-excerpt lead mt-4 mb-4 p-3 bg-white rounded border">
                    <?= esc_html(get_the_excerpt()); ?>
                </div>
                <?php endif; ?>

            </div>
        </div>

        <!-- Основной контент -->
        <div class="doctor-content mb-4">
            <?php
            the_content();
            ?>
        </div>

    </article>
</div>

<?php get_footer(); ?>