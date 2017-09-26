<?php 
add_action( 'init', 'register_taxonomy_tlw_rooms_tax' );

function register_taxonomy_tlw_rooms_tax() {

    $labels = array( 
        'name' => _x( 'Rooms', 'tlw_rooms_tax' ),
        'singular_name' => _x( 'Room', 'tlw_rooms_tax' ),
        'search_items' => _x( 'Search Rooms', 'tlw_rooms_tax' ),
        'popular_items' => _x( 'Popular Rooms', 'tlw_rooms_tax' ),
        'all_items' => _x( 'All Rooms', 'tlw_rooms_tax' ),
        'parent_item' => _x( 'Parent Room', 'tlw_rooms_tax' ),
        'parent_item_colon' => _x( 'Parent Room:', 'tlw_rooms_tax' ),
        'edit_item' => _x( 'Edit Room', 'tlw_rooms_tax' ),
        'update_item' => _x( 'Update Room', 'tlw_rooms_tax' ),
        'add_new_item' => _x( 'Add New Room', 'tlw_rooms_tax' ),
        'new_item_name' => _x( 'New Room', 'tlw_rooms_tax' ),
        'separate_items_with_commas' => _x( 'Separate rooms with commas', 'tlw_rooms_tax' ),
        'add_or_remove_items' => _x( 'Add or remove rooms', 'tlw_rooms_tax' ),
        'choose_from_most_used' => _x( 'Choose from the most used rooms', 'tlw_rooms_tax' ),
        'menu_name' => _x( 'Rooms', 'tlw_rooms_tax' ),
    );

    $args = array( 
        'labels' => $labels,
        'public' => true,
        'show_in_nav_menus' => false,
        'show_ui' => true,
        'show_tagcloud' => false,
        'show_admin_column' => true,
        'hierarchical' => true,

        'rewrite' => array( 
            'slug' => 'meeting-rooms/room', 
            'with_front' => false,
            'hierarchical' => true
        ),
        'query_var' => 'rooms'
    );

    register_taxonomy( 'tlw_rooms_tax', array('tlw_meeting'), $args );
}
 ?>