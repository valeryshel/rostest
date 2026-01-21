<?php
/**
 * rostest functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package rostest
 */



require get_template_directory() . '/includes/utils.php';
require get_template_directory() . '/includes/post-types.php';
require get_template_directory() . '/includes/taxonomies.php';

// 9 докторов на странице
function set_doctors_per_page($query) {
    if (!is_admin() && $query->is_main_query() && is_post_type_archive('doctors')) {
        $query->set('posts_per_page', 9);
    }
}
add_action('pre_get_posts', 'set_doctors_per_page');



// ФИЛЬТР ДОКТОРОВ

function filter_doctors_query($query) {
    if (!is_admin() && $query->is_main_query() && is_post_type_archive('doctors')) {

        // Фильтр по специализации
        if (!empty($_GET['specialization'])) {
            $query->set('tax_query', array(
                array(
                    'taxonomy' => 'specialization',
                    'field'    => 'slug',
                    'terms'    => sanitize_text_field($_GET['specialization']),
                )
            ));
        }

        // Фильтр по городу
        if (!empty($_GET['city'])) {
            $tax_query = $query->get('tax_query') ?: array();
            $tax_query[] = array(
                'taxonomy' => 'city',
                'field'    => 'slug',
                'terms'    => sanitize_text_field($_GET['city']),
            );
            $query->set('tax_query', $tax_query);
        }

        // Сортировка
        if (!empty($_GET['sort'])) {
            switch ($_GET['sort']) {
                case 'rating_desc':
                    $query->set('meta_key', 'rating');
                    $query->set('orderby', 'meta_value_num');
                    $query->set('order', 'DESC');
                    break;

                case 'price_asc':
                    $query->set('meta_key', 'price');
                    $query->set('orderby', 'meta_value_num');
                    $query->set('order', 'ASC');
                    break;

                case 'experience_desc':
                    $query->set('meta_key', 'experience');
                    $query->set('orderby', 'meta_value_num');
                    $query->set('order', 'DESC');
                    break;
            }
        }
    }
}
add_action('pre_get_posts', 'filter_doctors_query');