<?php
/**
 * Metaboxes для типа записи "Доктор"
 * 
 * @package medpro
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Добавляем метабокс с полями
 */
function medpro_add_doctor_metabox() {
    add_meta_box(
        'doctor_info',            
        'Доп. поля',    
        'medpro_doctor_metabox_callback', 
        'doctors',            
        'normal',                  
        'high'                   
    );
}
add_action('add_meta_boxes', 'medpro_add_doctor_metabox');

/**
 * Callback функция - содержимое метабокса
 */
function medpro_doctor_metabox_callback($post) {
    wp_nonce_field('medpro_doctor_metabox', 'medpro_doctor_metabox_nonce');
    
    // Получаем сохраненные значения
    $experience = get_post_meta($post->ID, '_doctor_experience', true);
    $price_from = get_post_meta($post->ID, '_doctor_price_from', true);
    $rating = get_post_meta($post->ID, '_doctor_rating', true);
    
    // Устанавливаем значения по умолчанию
    $experience = $experience ?: '';
    $price_from = $price_from ?: '';
    $rating = $rating ?: '5';
    ?>

<div class="doctor-meta-fields" style="display: flex; flex-wrap: wrap; gap: 20px; flex-direction: column;">
    <!-- Стаж -->
    <div>
        <label for="doctor_experience" class="form-label">
            <strong>Стаж (лет)</strong>
        </label>
        <input type="number" id="doctor_experience" name="doctor_experience"
            value="<?php echo esc_attr($experience); ?>" class="form-control" min="0" max="60" step="1">
    </div>

    <!-- Цена -->
    <div>
        <label for="doctor_price_from" class="form-label">
            <strong>Цена от (руб)</strong>
        </label>
        <input type="number" id="doctor_price_from" name="doctor_price_from"
            value="<?php echo esc_attr($price_from); ?>" class="form-control" min="0" step="100">
    </div>

    <!-- Рейтинг -->
    <div>
        <label for="doctor_rating" class="form-label">
            <strong>Рейтинг (0-5)</strong>
        </label>
        <select id="doctor_rating" name="doctor_rating" class="form-select">
            <?php for ($i = 0; $i <= 5; $i++): ?>
            <option value="<?php echo $i; ?>" <?php selected($rating, $i); ?>>
                <?php echo $i; ?>
            </option>
            <?php endfor; ?>
        </select>
    </div>
</div>
<?php
}

/**
 * Сохраняем данные метабокса
 */
function medpro_save_doctor_metabox($post_id) {
    // Проверяем nonce
    if (!isset($_POST['medpro_doctor_metabox_nonce']) ||
        !wp_verify_nonce($_POST['medpro_doctor_metabox_nonce'], 'medpro_doctor_metabox')) {
        return;
    }
    
    // Проверяем автосохранение
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    // Проверяем права пользователя
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Проверяем тип записи
    if ($_POST['post_type'] !== 'doctors') {
        return;
    }
    
    // Сохраняем поля
    if (isset($_POST['doctor_experience'])) {
        $exp = intval($_POST['doctor_experience']);
        if ($exp < 0) $exp = 0;
        if ($exp > 60) $exp = 60;
        update_post_meta($post_id, '_doctor_experience', $exp);
    }
    
    if (isset($_POST['doctor_price_from'])) {
        $price = intval($_POST['doctor_price_from']);
        if ($price < 0) $price = 0;
        update_post_meta($post_id, '_doctor_price_from', $price);
    }
    
    if (isset($_POST['doctor_rating'])) {
        $rating = floatval($_POST['doctor_rating']);
        if ($rating < 0) $rating = 0;
        if ($rating > 5) $rating = 5;
        update_post_meta($post_id, '_doctor_rating', $rating);
    }
}
add_action('save_post', 'medpro_save_doctor_metabox');

// ===== КОЛОНКИ В АДМИНКЕ =====

/**
 * Добавляем колонки в список докторов
 */
function medpro_add_doctor_admin_columns($columns) {
    $new_columns = array();
    
    foreach ($columns as $key => $value) {
        $new_columns[$key] = $value;
        
        // Вставляем после заголовка
        if ($key === 'title') {
            $new_columns['specialization'] = 'Специализация';
            $new_columns['experience'] = 'Стаж';
            $new_columns['price'] = 'Цена от';
            $new_columns['rating'] = 'Рейтинг';
        }
    }
    
    return $new_columns;
}
add_filter('manage_doctors_posts_columns', 'medpro_add_doctor_admin_columns');

/**
 * Заполняем колонки данными
 */
function medpro_fill_doctor_admin_columns($column, $post_id) {
    switch ($column) {
        case 'specialization':
            $terms = get_the_terms($post_id, 'specialization');
            if ($terms && !is_wp_error($terms)) {
                $term_names = array();
                foreach ($terms as $term) {
                    $term_names[] = $term->name;
                }
                echo implode(', ', $term_names);
            } else {
                echo '—';
            }
            break;
            
        case 'experience':
            $exp = get_post_meta($post_id, '_doctor_experience', true);
            echo $exp ? $exp . ' лет' : '—';
            break;
            
        case 'price':
            $price = get_post_meta($post_id, '_doctor_price_from', true);
            echo $price ? number_format($price, 0, '', ' ') . ' руб' : '—';
            break;
            
        case 'rating':
            $rating = get_post_meta($post_id, '_doctor_rating', true);
            if ($rating) {
                echo '<div class="doctor-rating">';
                for ($i = 1; $i <= 5; $i++) {
                    echo $i <= $rating ? '★' : '☆';
                }
                echo ' (' . $rating . ')';
                echo '</div>';
            } else {
                echo '—';
            }
            break;
    }
}
add_action('manage_doctors_posts_custom_column', 'medpro_fill_doctor_admin_columns', 10, 2);

/**
 * Делаем колонки сортируемыми
 */
function medpro_make_doctor_columns_sortable($columns) {
    $columns['experience'] = 'experience';
    $columns['price'] = 'price';
    $columns['rating'] = 'rating';
    return $columns;
}
add_filter('manage_edit-doctors_sortable_columns', 'medpro_make_doctor_columns_sortable');

/**
 * Сортировка по кастомным полям
 */
function medpro_doctor_column_orderby($query) {
    if (!is_admin() || !$query->is_main_query()) {
        return;
    }
    
    $orderby = $query->get('orderby');
    
    switch ($orderby) {
        case 'experience':
            $query->set('meta_key', '_doctor_experience');
            $query->set('orderby', 'meta_value_num');
            break;
            
        case 'price':
            $query->set('meta_key', '_doctor_price_from');
            $query->set('orderby', 'meta_value_num');
            break;
            
        case 'rating':
            $query->set('meta_key', '_doctor_rating');
            $query->set('orderby', 'meta_value_num');
            break;
    }
}
add_action('pre_get_posts', 'medpro_doctor_column_orderby');