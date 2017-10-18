<?php 
add_action( 'init', 'register_cpt_tlw_reminder' );

function register_cpt_tlw_reminder() {

    $labels = array( 
        'name' => _x( 'Reminders', 'tlw_reminder' ),
        'singular_name' => _x( 'Reminder', 'tlw_reminder' ),
        'add_new' => _x( 'Add New', 'tlw_reminder' ),
        'add_new_item' => _x( 'Add New Reminder', 'tlw_reminder' ),
        'edit_item' => _x( 'Edit Reminder', 'tlw_reminder' ),
        'new_item' => _x( 'New Reminder', 'tlw_reminder' ),
        'view_item' => _x( 'View Reminder', 'tlw_reminder' ),
        'search_items' => _x( 'Search Reminders', 'tlw_reminder' ),
        'not_found' => _x( 'No Reminders found', 'tlw_reminder' ),
        'not_found_in_trash' => _x( 'No Reminders found in Trash', 'tlw_reminder' ),
        'parent_item_colon' => _x( 'Parent Reminder:', 'tlw_reminder' ),
        'menu_name' => _x( 'Reminders', 'tlw_reminder' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        'description' => 'TLW Intranet Reminder CPT.',
        'supports' => array( 'author', 'title' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-list-view',
        'show_in_nav_menus' => false,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => false,
        'query_var' => 'reminder',
        'can_export' => true,
        'rewrite' => array( 
            'slug' => 'reminder', 
            'with_front' => false,
            'feeds' => true,
            'pages' => true
        ),
        'capability_type' => 'post'
    );

    register_post_type( 'tlw_reminder', $args );
	
	add_filter('bulk_actions-edit-tlw_reminder','tlw_reminder_custom_bulk_actions');
	 
	 	function tlw_reminder_custom_bulk_actions($actions){
		 //echo '<pre>';print_r($actions);echo '</pre>';
       	unset( $actions['edit'] );
        return $actions;
    }
} 
?>