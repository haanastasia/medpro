<?php

add_action('pre_get_posts', 'medpro_archive_settings');

function medpro_archive_settings($query) {

    if (is_admin() || !$query->is_main_query()) {
        return;
    }

    if (is_archive()) {
        $query->set('posts_per_page', 9);
    }
}