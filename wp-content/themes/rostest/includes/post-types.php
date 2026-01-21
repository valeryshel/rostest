<?php
/**
 * Регистрация кастомных типов записей
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Защита от прямого доступа
}

// Регистрация типа записи "Доктор"
function register_doctor_post_type() {

    $labels = array(
        'name'               => __('Доктора', 'rostest'),
        'singular_name'      => __('Доктор',  'rostest'),
        'menu_name'          => __('Доктора', 'rostest'),
        'name_admin_bar'     => __('Доктор', 'rostest'),
        'add_new'            => __('Добавить нового доктора', 'rostest'),
        'add_new_item'       => __('Добавить нового доктора', 'rostest'),
        'edit_item'          => __('Редактировать доктора', 'rostest'),
        'new_item'           => __('Новый доктор', 'rostest'),
        'all_items'          => __('Все доктора', 'rostest'),
        'view_item'          => __('Посмотреть доктора', 'rostest'),
        'search_items'       => __('Найти доктора', 'rostest'),
        'not_found'          => __('Докторов не найдено', 'rostest'),
        'not_found_in_trash' => __('В корзине аккаунта доктора не найдено', 'rostest'),
    );

    $args = array(
        'labels'      => $labels,
        'public'      => true,
        'has_archive' => true,
        'supports'    => array('title', 'editor', 'excerpt', 'thumbnail'),
        'show_in_rest'=> true,
        'rewrite'     => array('slug' => 'doctors'),
    );

    register_post_type('doctors', $args);
}
add_action('init', 'register_doctor_post_type');