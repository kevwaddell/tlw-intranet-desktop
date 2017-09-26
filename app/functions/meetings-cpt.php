<?php 
add_action( 'init', 'register_cpt_tlw_meeting' );

function register_cpt_tlw_meeting() {

    $labels = array( 
        'name' => _x( 'Meetings', 'tlw_meeting' ),
        'singular_name' => _x( 'Meeting', 'tlw_meeting' ),
        'add_new' => _x( 'Add New', 'tlw_meeting' ),
        'add_new_item' => _x( 'Add New Meeting', 'tlw_meeting' ),
        'edit_item' => _x( 'Edit Meeting', 'tlw_meeting' ),
        'new_item' => _x( 'New Meeting', 'tlw_meeting' ),
        'view_item' => _x( 'View Meeting', 'tlw_meeting' ),
        'search_items' => _x( 'Search Meetings', 'tlw_meeting' ),
        'not_found' => _x( 'No meetings found', 'tlw_meeting' ),
        'not_found_in_trash' => _x( 'No meetings found in Trash', 'tlw_meeting' ),
        'parent_item_colon' => _x( 'Parent Meeting:', 'tlw_meeting' ),
        'menu_name' => _x( 'Meetings', 'tlw_meeting' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        'description' => 'TLW Intranet Meeting CPT.',
        'supports' => array( 'author' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-clock',
        'show_in_nav_menus' => false,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => false,
        'query_var' => 'meeting',
        'can_export' => true,
        'rewrite' => array( 
            'slug' => 'meeting', 
            'with_front' => false,
            'feeds' => true,
            'pages' => true
        ),
        'capability_type' => 'post'
    );

    register_post_type( 'tlw_meeting', $args );
	
	add_filter('bulk_actions-edit-tlw_meeting','tlw_meetings_custom_bulk_actions');
	 
	 	function tlw_meetings_custom_bulk_actions($actions){
		 //echo '<pre>';print_r($actions);echo '</pre>';
       	unset( $actions['edit'] );
        return $actions;
    }
} 
?>