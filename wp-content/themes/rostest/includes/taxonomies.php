<?php
// Регистрация таксономий


function theme_register_taxonomies() {

    // 1. Специализация (иерархическая, как рубрики)
    register_taxonomy('specialization', ['doctors'], [
        'labels' => [
            'name'          => 'Специализации',
            'singular_name' => 'Специализация',
            'menu_name'     => 'Специализации',
            'all_items'     => 'Все специализации',
            'edit_item'     => 'Редактировать специализацию',
            'add_new_item'  => 'Добавить новую специализацию',
            'search_items'  => 'Найти специализацию',
        ],
        'public'            => true,
        'hierarchical'      => true,
        'show_admin_column' => true,
        'show_in_rest'      => true,
        'rewrite'           => ['slug' => 'specialization'],
    ]);

    // 2. Город (неиерархическая, как теги - нет смысла в иерархии,если мы добавляем город в одной стране или крае)
    // TODO: Если понадобится иерархия, можно сменить hierarchical на true

    register_taxonomy('city', ['doctors'], [
        'labels' => [
            'name'          => 'Города',
            'singular_name' => 'Город',
            'menu_name'     => 'Города',
            'all_items'     => 'Все города',
            'edit_item'     => 'Редактировать город',
            'add_new_item'  => 'Добавить новый город',
            'search_items'  => 'Найти город',
        ],
        'public'            => true,
        'hierarchical'      => false,
        'show_admin_column' => true,
        'show_in_rest'      => true,
        'rewrite'           => ['slug' => 'city'],
    ]);
}
add_action('init', 'theme_register_taxonomies');