<?php
function medpro_breadcrumbs() {
    echo '<nav aria-label="breadcrumb" class="breadcrumbs">';
    echo '<div class="container">';
    echo '<ol class="breadcrumb mb-0 py-3">';

    // Главная
    echo '<li class="breadcrumb-item"><a href="' . esc_url(home_url('/')) . '">Главная</a></li>';

    if (is_single() || is_page()) {

        if (get_post_type() === 'doctors') {
            // Ссылка на архив врачей
            echo '<li class="breadcrumb-item"><a href="' . esc_url(get_post_type_archive_link('doctors')) . '">Наши врачи</a></li>';
        } elseif (is_single() && get_post_type() === 'post') {
            $categories = get_the_category();
            if (!empty($categories)) {
                $category = $categories[0];
                echo '<li class="breadcrumb-item"><a href="' . esc_url(get_category_link($category->term_id)) . '">' . esc_html($category->name) . '</a></li>';
            }
        }

        // Текущая страница
        echo '<li class="breadcrumb-item active" aria-current="page">' . esc_html(get_the_title()) . '</li>';

    } elseif (is_category()) {
        echo '<li class="breadcrumb-item active" aria-current="page">' . esc_html(single_cat_title('', false)) . '</li>';

    } elseif (is_tax('specialization')) {
        echo '<li class="breadcrumb-item"><a href="' . esc_url(get_post_type_archive_link('doctors')) . '">Наши врачи</a></li>';
        echo '<li class="breadcrumb-item active" aria-current="page">' . esc_html(single_term_title('', false)) . '</li>';

    } elseif (is_post_type_archive('doctors')) {
        echo '<li class="breadcrumb-item active" aria-current="page">Наши врачи</li>';

    } elseif (is_archive()) {
        if (is_post_type_archive()) {
            $post_type = get_post_type_object(get_post_type());
            echo '<li class="breadcrumb-item active" aria-current="page">' . esc_html($post_type->labels->name) . '</li>';
        } elseif (is_tag()) {
            echo '<li class="breadcrumb-item active" aria-current="page">' . esc_html(single_tag_title('Метка: ', false)) . '</li>';
        } else {
            echo '<li class="breadcrumb-item active" aria-current="page">' . esc_html(get_the_archive_title()) . '</li>';
        }

    } elseif (is_search()) {
        echo '<li class="breadcrumb-item active" aria-current="page">Результаты поиска</li>';

    } elseif (is_404()) {
        echo '<li class="breadcrumb-item active" aria-current="page">Страница не найдена</li>';
    }

    echo '</ol>';
    echo '</div>';
    echo '</nav>';
}