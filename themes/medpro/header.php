<?php
/**
 * @package medpro
 * @version 1.2.0
 * @since 21.01.2026
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?php wp_head(); ?>
</head>

<body <? if(is_front_page()) { ?>class="home"
    <?}?>>

    <header class="header">
        <nav class="py-2 bg-light border-bottom">
            <div class="container d-flex flex-wrap">
                <?php wp_nav_menu( [ 'theme_location' => 'primary', 'menu_id' => 'main-menu', 'menu_class' => 'nav me-auto', 'container' => false ] ); ?>
                <ul class="nav">
                    <li class="nav-item">
                        <a href="/doctors/" class="link-dark px-2">Врачи</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="link-dark px-2">Записаться на прием</a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="py-3 mb-4 border-bottom">
            <div class="container d-flex flex-wrap justify-content-center">
                <a href="/" class="d-flex align-items-center mb-3 mb-lg-0 me-lg-auto text-dark text-decoration-none">
                    <span class="fs-4"><?php bloginfo( 'name' );?></span>
                </a>
                <?php get_search_form(); ?>
            </div>
        </div>
    </header>

    <main class="main">

        <? if(!is_front_page()) { ?>
        <? medpro_breadcrumbs();?>
        <?}?>