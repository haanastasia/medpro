<?php

add_action('pre_get_posts', 'medpro_doctors_archive_query');

function medpro_doctors_archive_query($query) {

    if (is_admin() || !$query->is_main_query()) {
        return;
    }

    if (!is_post_type_archive('doctors')) {
        return;
    }

    $tax_query = [];

    if (!empty($_GET['specialization'])) {
        $tax_query[] = [
            'taxonomy' => 'specialization',
            'field'    => 'slug',
            'terms'    => sanitize_text_field($_GET['specialization']),
        ];
    }

    if (!empty($_GET['city'])) {
        $tax_query[] = [
            'taxonomy' => 'city',
            'field'    => 'slug',
            'terms'    => sanitize_text_field($_GET['city']),
        ];
    }

    if ($tax_query) {
        $query->set('tax_query', $tax_query);
    }

    if (!empty($_GET['sort'])) {

        switch ($_GET['sort']) {

            case 'price_asc':
                $query->set('meta_key', '_doctor_price_from');
                $query->set('orderby', 'meta_value_num');
                $query->set('order', 'ASC');
                break;

            case 'experience_desc':
                $query->set('meta_key', '_doctor_experience');
                $query->set('orderby', 'meta_value_num');
                $query->set('order', 'DESC');
                break;

            case 'rating_desc':
                $query->set('meta_key', '_doctor_rating');
                $query->set('orderby', 'meta_value_num');
                $query->set('order', 'DESC');
                break;
        }
    }
}