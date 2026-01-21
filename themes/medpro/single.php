<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package medpro
 * @version 1.2.0
 * @since 21.01.2026
 */

get_header();
?>
<div class="container">
    <div class="single-content">
        <h1 class="headline caption"><?php the_title(); ?></h1>
        <div class="main-text">
            <? the_content(); ?>
        </div>
    </div>
</div>
<?
get_footer();