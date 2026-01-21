<?php
/**
 * Custom Post Types и Таксономии для темы MedPro
 *
 * @package medpro
 * @version 1.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Регистрация Custom Post Type "Доктор"
 */
function medpro_register_doctor_cpt() {

    $labels = array(
        'name'                  => __('Доктора', 'medpro'),
        'singular_name'         => __('Доктор', 'medpro'),
        'menu_name'             => __('Доктора', 'medpro'),
        'all_items'             => __('Все доктора', 'medpro'),
        'add_new'               => __('Добавить', 'medpro'),
        'add_new_item'          => __('Добавить нового доктора', 'medpro'),
        'edit_item'             => __('Редактировать', 'medpro'),
        'new_item'              => __('Новый доктор', 'medpro'),
        'view_item'             => __('Просмотр', 'medpro'),
        'search_items'          => __('Найти', 'medpro'),
        'not_found'             => __('Не найдено', 'medpro'),
        'not_found_in_trash'    => __('В корзине пусто', 'medpro'),
        'featured_image'        => __('Фото доктора', 'medpro'),
        'set_featured_image'    => __('Установить фото', 'medpro'),
        'remove_featured_image' => __('Удалить фото', 'medpro'),
    );

    $args = array(
        'labels'             => $labels,
        'description'        => __('Врачи клиники', 'medpro'),
        'public'             => true,
        'has_archive'        => true,
        'menu_position'      => 20,
        'menu_icon'          => 'dashicons-id-alt',
        'supports'           => array('title', 'editor', 'excerpt', 'thumbnail'),
        'show_in_rest'       => true,
        'rewrite'            => array(
            'slug'       => 'doctors',
            'with_front' => false,
        ),
    );

    register_post_type('doctors', $args);
}
add_action('init', 'medpro_register_doctor_cpt');

/**
 * Таксономия "Специализация" (иерархическая)
 */
function medpro_register_specialization_taxonomy() {

    $labels = array(
        'name'              => __('Специализации', 'medpro'),
        'singular_name'     => __('Специализация', 'medpro'),
        'search_items'      => __('Поиск', 'medpro'),
        'all_items'         => __('Все специализации', 'medpro'),
        'parent_item'       => __('Родительская специализация', 'medpro'),
        'parent_item_colon' => __('Родительская специализация:', 'medpro'),
        'edit_item'         => __('Редактировать', 'medpro'),
        'update_item'       => __('Обновить', 'medpro'),
        'add_new_item'      => __('Добавить новую специализацию', 'medpro'),
        'new_item_name'     => __('Название', 'medpro'),
        'menu_name'         => __('Специализации', 'medpro'),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'show_in_rest'      => true,
        'rewrite'           => array('slug' => 'specialization', 'with_front' => false),
    );

    register_taxonomy('specialization', array('doctors'), $args);
}
add_action('init', 'medpro_register_specialization_taxonomy');

/**
 * Таксономия "Город" (неиерархическая)
 */
function medpro_register_city_taxonomy() {

    $labels = array(
        'name'              => __('Города', 'medpro'),
        'singular_name'     => __('Город', 'medpro'),
        'search_items'      => __('Поиск городов', 'medpro'),
        'all_items'         => __('Все города', 'medpro'),
        'edit_item'         => __('Редактировать город', 'medpro'),
        'update_item'       => __('Обновить город', 'medpro'),
        'add_new_item'      => __('Добавить новый город', 'medpro'),
        'new_item_name'     => __('Название нового города', 'medpro'),
        'menu_name'         => __('Города', 'medpro'),
        'popular_items'     => __('Популярные города', 'medpro'),
    );

    $args = array(
        'hierarchical'      => false,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'show_in_rest'      => true,
        'rewrite'           => array('slug' => 'city', 'with_front' => false),
    );

    register_taxonomy('city', array('doctors'), $args);
}
add_action('init', 'medpro_register_city_taxonomy');