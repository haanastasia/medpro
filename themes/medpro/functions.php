<?php
/**
 * Functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package medpro
 * @version 1.2.0
 * @since 21.01.2026
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function medpro_theme_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'menus' );
	add_theme_support( 'post-thumbnails' );
	
	register_nav_menus(
		array(
			'primary' => __( 'Основное меню', 'medpro' ),
			'footer'  => __( 'Футер', 'medpro' ),
		)
	);
}
add_action( 'after_setup_theme', 'medpro_theme_setup' );

// чистим h1 в архивах
add_filter( 'get_the_archive_title', function( $title ){
	return preg_replace('~^[^:]+: ~', '', strip_tags($title) );
});

add_action( 'wp_enqueue_scripts', 'medpro_assets' );
function medpro_assets(){
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', '', '', true );
    wp_enqueue_script( 'custom', get_template_directory_uri() . '/assets/js/custom.js', '', '', true );

    wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css', '', '' );
    wp_enqueue_style( 'style', get_template_directory_uri() . '/style.css', '', '' );
} 

// Чистим лишние теги
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'wp_shortlink_wp_head' ); 
remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );

// Предупреждения
require_once get_template_directory() . '/inc/admin-notices.php';

// Кастомные типы записей
require_once get_template_directory() . '/inc/custom-post-types.php';

// Метабоксы
require_once get_template_directory() . '/inc/metaboxes.php';

// Хлебные крошки
require_once get_template_directory() . '/inc/breadcrumbs.php';

// Настройки
require_once get_template_directory() . '/inc/setup/archive-settings.php';

// Сортировка+Фильтр
require_once get_template_directory() . '/inc/queries/doctors-query.php';