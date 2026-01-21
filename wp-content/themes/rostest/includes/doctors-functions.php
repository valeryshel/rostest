<?php
// 9 врачей на странице + фильтр

function handle_doctors_archive_query($query) {
    if (is_admin() || !$query->is_main_query() || !is_post_type_archive('doctors')) {
        return;
    }


    if (isset($_GET['_wpnonce'])) {
        if (!wp_verify_nonce(sanitize_text_field($_GET['_wpnonce']), 'filter_doctors')) {
            return; // Невалидный nonce - игнорируем фильтры
        }
    }

    // Выводим 9 докторов на страницу
    $query->set('posts_per_page', 9);

    $tax_query = array('relation' => 'AND');

    if (!empty($_GET['specialization'])) {
        $specialization = sanitize_text_field($_GET['specialization']);
        $tax_query[] = array(
            'taxonomy' => 'specialization',
            'field'    => 'slug',
            'terms'    => $specialization,
        );
    }

    if (!empty($_GET['city'])) {
        $city = sanitize_text_field($_GET['city']);
        $tax_query[] = array(
            'taxonomy' => 'city',
            'field'    => 'slug',
            'terms'    => $city,
        );
    }

    if (count($tax_query) > 1) {
        $query->set('tax_query', $tax_query);
    }

    // Сортировка с валидацией
    if (!empty($_GET['sort'])) {
        $sort = sanitize_key($_GET['sort']); // Допустимы только буквы, цифры, _

        switch ($sort) {
            case 'rating_desc':
                $query->set('meta_key', 'rating');
                $query->set('orderby', array('meta_value_num' => 'DESC', 'date' => 'DESC'));
                break;

            case 'price_asc':
                $query->set('meta_key', 'price');
                $query->set('orderby', array('meta_value_num' => 'ASC', 'date' => 'DESC'));
                break;

            case 'experience_desc':
                $query->set('meta_key', 'experience');
                $query->set('orderby', array('meta_value_num' => 'DESC', 'date' => 'DESC'));
                break;

            default:
                // по умолчанию
                $query->set('orderby', 'date');
                $query->set('order', 'DESC');
                break;
        }
    }
}
add_action('pre_get_posts', 'handle_doctors_archive_query', 20);