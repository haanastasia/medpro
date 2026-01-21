<?php
/**
 * Архив "Доктора"
 *
 * @package medpro
 * @version 1.2.0
 * @since 21.01.2026
 */

get_header();
?>

<div class="container">
    <div class="single-content">
        <h1 class="headline caption"><?php echo esc_html(get_the_archive_title()); ?></h1>

        <div class="main-text">

            <!-- Фильтр -->
            <div class="doctors-filters bg-light rounded p-4 mb-4">
                <form method="get" id="doctors-filter-form" class="row g-3"
                    action="<?= esc_url(get_post_type_archive_link('doctors')); ?>">

                    <!-- Специализация -->
                    <div class="col-md-4">
                        <label for="specialization" class="form-label">Специализация</label>
                        <select id="specialization" name="specialization" class="form-select">
                            <option value="">Все специализации</option>
                            <?php
                            $specializations = get_terms([
                                'taxonomy'   => 'specialization',
                                'hide_empty' => false,
                            ]);

                            if (!is_wp_error($specializations)) :
                                foreach ($specializations as $spec) :
                            ?>
                            <option value="<?= esc_attr($spec->slug); ?>"
                                <?= selected($_GET['specialization'] ?? '', $spec->slug, false); ?>>
                                <?= esc_html($spec->name); ?>
                            </option>
                            <?php
                                endforeach;
                            endif;
                            ?>
                        </select>
                    </div>

                    <!-- Город -->
                    <div class="col-md-4">
                        <label for="city" class="form-label">Город</label>
                        <select id="city" name="city" class="form-select">
                            <option value="">Все города</option>
                            <?php
                            $cities = get_terms([
                                'taxonomy'   => 'city',
                                'hide_empty' => true,
                            ]);

                            if (!is_wp_error($cities)) :
                                foreach ($cities as $city) :
                            ?>
                            <option value="<?= esc_attr($city->slug); ?>"
                                <?= selected($_GET['city'] ?? '', $city->slug, false); ?>>
                                <?= esc_html($city->name); ?>
                            </option>
                            <?php
                                endforeach;
                            endif;
                            ?>
                        </select>
                    </div>

                    <!-- Сортировка -->
                    <div class="col-md-4">
                        <label for="sort" class="form-label">Сортировка</label>
                        <select id="sort" name="sort" class="form-select">
                            <option value="">По умолчанию</option>
                            <option value="rating_desc" <?= selected($_GET['sort'] ?? '', 'rating_desc', false); ?>>
                                По рейтингу (высокий)
                            </option>
                            <option value="price_asc" <?= selected($_GET['sort'] ?? '', 'price_asc', false); ?>>
                                По цене (низкая)
                            </option>
                            <option value="experience_desc"
                                <?= selected($_GET['sort'] ?? '', 'experience_desc', false); ?>>
                                По стажу
                            </option>
                        </select>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Применить фильтры</button>
                        <a href="<?= esc_url(get_post_type_archive_link('doctors')); ?>"
                            class="btn btn-outline-secondary">Сбросить</a>
                    </div>
                </form>
            </div>

            <!-- Список врачей -->
            <div class="doctors-list">
                <?php if (have_posts()) : ?>
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">

                    <?php while (have_posts()) : the_post(); ?>

                    <div class="col">
                        <div class="doctor-card card h-100 shadow-sm border-0">

                            <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>" title="<?= esc_attr(get_the_title()); ?>">
                                <?php
                                the_post_thumbnail('medium', [
                                    'class' => 'doctor-card-image',
                                    'alt'   => esc_attr(get_the_title()),
                                ]);
                                ?>
                            </a>
                            <?php endif; ?>

                            <div class="card-body d-flex flex-column">

                                <h3 class="card-title h5">
                                    <a href="<?php the_permalink(); ?>" class="text-decoration-none text-dark">
                                        <?= esc_html(get_the_title()); ?>
                                    </a>
                                </h3>

                                <?php
                                        $specializations = get_the_terms(get_the_ID(), 'specialization');
                                        if ($specializations && !is_wp_error($specializations)) :
                                            $names = array_map(fn($s) => esc_html($s->name), $specializations);
                                            $visible = array_slice($names, 0, 2);
                                        ?>
                                <div class="doctor-specialization mb-2">
                                    <small class="text-muted">
                                        <?= implode(', ', $visible); ?>
                                        <?= count($names) > 2 ? '…' : ''; ?>
                                    </small>
                                </div>
                                <?php endif; ?>

                                <div class="doctor-info mb-3">
                                    <?php
                                            $experience = absint(get_post_meta(get_the_ID(), '_doctor_experience', true));
                                            $price      = absint(get_post_meta(get_the_ID(), '_doctor_price_from', true));
                                            $rating     = (float) get_post_meta(get_the_ID(), '_doctor_rating', true);
                                            ?>

                                    <?php if ($experience) : ?>
                                    <small><strong>Стаж:</strong> <?= esc_html($experience); ?> лет</small><br>
                                    <?php endif; ?>

                                    <?php if ($price) : ?>
                                    <small><strong>Цена от:</strong>
                                        <?= esc_html(number_format($price, 0, '', ' ')); ?> руб</small><br>
                                    <?php endif; ?>

                                    <?php if ($rating) : ?>
                                    <small><strong>Рейтинг:</strong>
                                        <span class="text-warning">
                                            <?php
                                                        for ($i = 1; $i <= 5; $i++) {
                                                            echo $i <= $rating ? '★' : '☆';
                                                        }
                                                        ?>
                                        </span>
                                        (<?= esc_html($rating); ?>)
                                    </small>
                                    <?php endif; ?>
                                </div>

                                <a href="<?php the_permalink(); ?>" class="btn btn-outline-primary mt-auto w-100">
                                    Записаться
                                </a>
                            </div>
                        </div>
                    </div>

                    <?php endwhile; ?>
                </div>

                <!-- Пагинация -->
                <?php
                    $links = paginate_links([
                        'total'     => $wp_query->max_num_pages,
                        'current'   => max(1, get_query_var('paged')),
                        'prev_text' => 'Предыдущая',
                        'next_text' => 'Следующая',
                        'type'      => 'array',
                    ]);

                    if ($links) :
                    ?>
                <nav class="mt-5">
                    <ul class="pagination justify-content-center">
                        <?php foreach ($links as $link) :
                                    $active   = strpos($link, 'current') !== false ? ' active' : '';
                                    $disabled = strpos($link, 'dots') !== false ? ' disabled' : '';
                                ?>
                        <li class="page-item<?= $active . $disabled; ?>">
                            <?= str_replace('page-numbers', 'page-link', $link); ?>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </nav>
                <?php endif; ?>

                <?php else : ?>
                <div class="alert alert-info">
                    Врачей не найдено. Попробуйте изменить параметры фильтрации.
                </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</div>

<?php get_footer(); ?>