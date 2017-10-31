<?php 
if (!is_admin()) {

	function tlw_scripts() {
		
		$holidays_pg = get_page_by_path('holidays');
		$reminders_pg = get_page_by_path('reminders');
		$meetings_pg = get_page_by_path('meetings');
		$departments_pg = get_page_by_path('departments');
		$notes_pg = get_page_by_path('notes');
		$contacts_pg = get_page_by_path('contacts');
		
		global $post;
		// Load stylesheets.
		wp_enqueue_style( 'bootstrap-select', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css', null, '1.12.4', 'screen' );
		wp_enqueue_style( 'bootstrap-toggle', 'https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css', null, '2.2.2', 'screen' );
		wp_enqueue_style( 'datepicker-css', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css', null, '4.17.47', 'screen' );
		wp_enqueue_style( 'styles', get_stylesheet_directory_uri().'/app/css/styles.css', null, filemtime( get_stylesheet_directory().'/app/css/styles.css' ), 'screen' );
		
		// Load JS
		$functions_dep = array(
		'jquery',
		'bootstrap-min',
		'bootstrap-select-min'
		);
		wp_deregister_script('jquery-core');
		wp_deregister_script('jquery');
	    wp_enqueue_script('jquery', 'https://code.jquery.com/jquery-2.2.4.min.js', array(), '2.2.4', true);
	    wp_enqueue_script( 'modernizr-min', get_template_directory_uri() . '/app/js/modernizr-min.js', array(), '2.8.3', false );
		wp_enqueue_script( 'bootstrap-min', get_template_directory_uri() . '/app/js/bootstrap-min.js', array('jquery'), '2.8.3', true );
		wp_enqueue_script( 'bootstrap-select-min', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/js/bootstrap-select.min.js', array('jquery'), '1.11.2', true );
		wp_enqueue_script( 'bootstrap-toggle-min', 'https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js', array('jquery'), '2.2.2', true );
		wp_enqueue_script( 'moment', 'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js', array('jquery', 'bootstrap-min'), '2.18.1', true );
		wp_enqueue_script( 'bootstrap-datepicker', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js', array('jquery', 'bootstrap-min'), '4.17.47', true );
		
		wp_enqueue_script( 'jquery-form', 'https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js', array('jquery'), '4.2.2', true );
		wp_enqueue_script( 'functions', get_stylesheet_directory_uri() . '/app/js/functions-min.js', $functions_dep, filemtime( get_stylesheet_directory().'/app/js/functions.js' ), true );
		
		if ($post->ID == $contacts_pg->ID) {
		wp_enqueue_script( 'contact-functions', get_stylesheet_directory_uri() . '/app/js/contact-functions-min.js', $functions_dep, filemtime( get_stylesheet_directory().'/app/js/contact-functions.js' ), true );	
		}
		
		if ($post->ID == $notes_pg->ID) {
		wp_enqueue_script( 'drag-functions', 'https://cdnjs.cloudflare.com/ajax/libs/interact.js/1.2.9/interact.min.js', $functions_dep, '1.2.9', true);
		wp_enqueue_script( 'notes-functions', get_stylesheet_directory_uri() . '/app/js/notes-functions-min.js', array('drag-functions'), filemtime( get_stylesheet_directory().'/app/js/notes-functions.js' ), true );	
		}
		
		if ($post->ID == $departments_pg->ID) {
		wp_enqueue_script( 'departments-functions', get_stylesheet_directory_uri() . '/app/js/departments-functions-min.js', $functions_dep, filemtime( get_stylesheet_directory().'/app/js/departments-functions.js' ), true );	
		}
		
		if ($post->ID == $meetings_pg->ID) {
		wp_enqueue_script( 'meetings-functions', get_stylesheet_directory_uri() . '/app/js/meetings-functions-min.js', $functions_dep, filemtime( get_stylesheet_directory().'/app/js/meetings-functions.js' ), true );	
		}
		
		if ($post->ID == $reminders_pg->ID) {
		wp_enqueue_script( 'reminders-functions', get_stylesheet_directory_uri() . '/app/js/reminders-functions-min.js', $functions_dep, filemtime( get_stylesheet_directory().'/app/js/reminders-functions.js' ), true );	
		}
		
		if ($post->ID == $holidays_pg->ID) {
		wp_enqueue_script( 'holiday-functions', get_stylesheet_directory_uri() . '/app/js/holiday-functions-min.js', $functions_dep, filemtime( get_stylesheet_directory().'/app/js/holiday-functions.js' ), true );	
		}
		
	}
	add_action( 'wp_enqueue_scripts', 'tlw_scripts' );
}
?>