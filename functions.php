<?php 

if ( !function_exists(core_mods) ) {
	function core_mods() {
		if ( !is_admin() ) {
			wp_register_style( 'styles', get_stylesheet_directory_uri().'/_/css/styles.css', null, filemtime( get_stylesheet_directory().'/_/css/styles.css' ) );
			wp_register_style( 'datepicker-css', 'http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css', null );
			wp_register_style( 'select-css', 'http://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.css', null );
			/* wp_register_style( 'timepicker', 'http://jdewit.github.io/bootstrap-timepicker/css/bootstrap-timepicker.min.css', null ); */
			wp_register_script( 'slim-scroll', get_stylesheet_directory_uri() . '/_/js/jquery.slimscroll.min.js', array('jquery'), '1.0.0', true );
			wp_register_script( 'scroll-to', get_stylesheet_directory_uri() . '/_/js/jquery.scrollTo.min.js', array('jquery'), '1.0.0', true );
			wp_register_script( 'bootstrap-datepicker', 'http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js', array('jquery', 'bootstrap-all-min'), '1.0.0', true );
			wp_register_script( 'bootstrap-select', 'http://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.js', array('jquery', 'bootstrap-all-min'), '1.0.0', true );
			/* wp_register_script( 'bootstrap-timepicker', 'http://jdewit.github.io/bootstrap-timepicker/js/bootstrap-timepicker.js', array('jquery', 'bootstrap-all-min'), '1.0.0', true ); */
			wp_register_script( 'bootstrap-tabs', get_stylesheet_directory_uri() . '/_/js/bootstrap-tabs.js', array('jquery'), '1.0.0', true );
			wp_register_script( 'bootstrap-tooltip', get_stylesheet_directory_uri() . '/_/js/bootstrap-tooltip.js', array('jquery'), '1.0.0', true );
			wp_register_script( 'functions', get_stylesheet_directory_uri() . '/_/js/functions.js', array('jquery', 'bootstrap-all-min', 'slim-scroll', 'scroll-to', 'bootstrap-tabs', 'bootstrap-tooltip'), '1.0.1', true );
			//wp_register_script( 'img-fit', get_stylesheet_directory_uri() . '/_/js/jquery.imagefit.js', array('jquery'), '1.0.0', true );
			
			wp_enqueue_style('styles');
			wp_enqueue_style('datepicker-css');
			wp_enqueue_style('select-css');
			/* wp_enqueue_style('timepicker'); */
			wp_enqueue_script('slim-scroll');
			wp_enqueue_script('scroll-to');
			wp_enqueue_script('bootstrap-datepicker');
			wp_enqueue_script('bootstrap-select');
			/* wp_enqueue_script('bootstrap-timepicker'); */
			wp_enqueue_script('bootstrap-tabs');
			wp_enqueue_script('bootstrap-tooltip');
			wp_enqueue_script('functions');
			//wp_enqueue_script('img-fit');
			
			http://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.css
		}
	}
	core_mods();
}

add_theme_support('html5', array('search-form'));

add_action( 'wp_print_styles', 'my_deregister_styles', 100 );
 
function my_deregister_styles() {
	wp_deregister_style( 'wp-admin' );
}


if ( function_exists( 'register_nav_menus' ) ) {
		register_nav_menus(
			array(
			  'main_links_menu' => 'Main Menu Version 2'
			)
		);
}

function in_array_r($needle, $haystack, $strict = false) {
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
            return true;
        }
    }

    return false;
}

function disable_scripts () {
	wp_dequeue_script('jquery-ui-core');
	wp_deregister_script('jquery-ui-core');
}
add_action('wp_enqueue_scripts','disable_scripts');

if ( function_exists( 'register_sidebar' ) ) {
	
	$login_sb_args = array(
	'name'          => "User actions",
	'id'            => "user-actions",
	'description'   => 'Area for logged in user widget',
	'class'         => 'user-links',
	'before_widget' => '',
	'after_widget'  => '',
	'before_title'  => '<div class="user-title">',
	'after_title'   => '</div>' 
	);
	
	register_sidebar( $login_sb_args );	
	
	$question_pan_args = array(
	'name'          => "Dashboard question of the day",
	'id'            => "dashboard-poll",
	'description'   => 'Panel for dashboard question of the day',
	'class'         => 'dash-panel',
	'before_widget' => '',
	'after_widget'  => '',
	'before_title'  => '',
	'after_title'   => '' 
	);
	
	register_sidebar( $question_pan_args );	
	
	$quiz_pan_args = array(
	'name'          => "Quiz of the day",
	'id'            => "quiz-of-the-day",
	'description'   => 'Panel for dashboard quiz of the day',
	'class'         => 'dash-panel',
	'before_widget' => '',
	'after_widget'  => '',
	'before_title'  => '',
	'after_title'   => '' 
	);
	
	register_sidebar( $quiz_pan_args );	

	
}

// Use shortcodes in text widgets.
add_filter('widget_text', 'do_shortcode');

add_theme_support( 'post-thumbnails', array( 'page', 'post' ) );

if( function_exists('add_term_ordering_support') ) {
add_term_ordering_support ('category');
add_term_ordering_support ('tlw_rooms_tax');
}


function add_feat_img ( $post ) {	
	
	if (has_post_thumbnail($post->ID)) {
		
		$post_thumbnail_id = get_post_thumbnail_id( $post->ID );
		$attachment = get_post( $post_thumbnail_id );
		$alt = get_post_meta($post_thumbnail_id, '_wp_attachment_image_alt', true);
		
		//echo '<pre>';print_r($attachment->post_excerpt);echo '</pre>';
		
		
		$img_atts = array(
		'class'	=> "img-responsive"
		);
		
		if (!empty($alt)){
		$img_atts['alt'] = 	trim(strip_tags( $alt ));
		}
		
		if (!empty($attachment->post_title)){
		$img_atts['title'] = 	trim(strip_tags( $attachment->post_title ));
		}
		
		echo get_the_post_thumbnail($post->ID ,'feat-img', $img_atts );
	
	}
	
}

function add_gravityforms_style() {
	global $post;
	$form = get_field('form', $post->ID);
	
	if (!empty($form)) {
		wp_enqueue_style("gforms_css", GFCommon::get_base_url() . "/css/forms.css", null, GFCommon::$version);
	}
	
}
add_action('wp_print_styles', 'add_gravityforms_style');

function custom_excerpt_length( $length ) {
	return 30;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

function my_theme_add_editor_styles() {
    add_editor_style( get_stylesheet_directory_uri().'/_/css/custom-editor-style.css' );
}
add_action( 'after_setup_theme', 'my_theme_add_editor_styles' );

/* GRAVITY FORMS FUNCTIONS */
require_once(STYLESHEETPATH . '/_/functions/gravity-forms-functions.php');
require_once(STYLESHEETPATH . '/_/functions/gravity-forms-delete-entry.php');

/* MEETINGS CPT */
require_once(STYLESHEETPATH . '/_/functions/meetings-cpt.php');
//require_once(STYLESHEETPATH . '/_/functions/holidays-cpt.php');
require_once(STYLESHEETPATH . '/_/functions/custom-posts-order.php');

/* ROOMS TAX */
require_once(STYLESHEETPATH . '/_/functions/rooms-tax.php');

/* CHANGE META BOX TITLES */
require_once(STYLESHEETPATH . '/_/functions/change-meta-box-title.php');

/* AFC FUNCTIONS */
require_once(STYLESHEETPATH . '/_/functions/afc_save_post.php');
require_once(STYLESHEETPATH . '/_/functions/afc_relationship_filter.php');
require_once(STYLESHEETPATH . '/_/functions/afc_options_functions.php');

/* CUSTOM ROW ACTIONS */
require_once(STYLESHEETPATH . '/_/functions/post_row_actions.php');

//holder_add_theme( 'wordpress', '333333', 'eeeeee' );
holder_add_theme( 'lite-gray', '888888', 'eeeeee' );

function bm_bbp_no_breadcrumb ($param) {
return true;
}

add_filter ('bbp_no_breadcrumb', 'bm_bbp_no_breadcrumb');

function change_author_permalinks() {

    global $wp_rewrite;

    // Change the value of the author permalink base to whatever you want here
    $wp_rewrite->author_base = 'staff-members';

    $wp_rewrite->flush_rules();
}

add_action('init','change_author_permalinks');

// Add to the admin_init action hook
add_filter('current_screen', 'my_current_screen' );
 
function my_current_screen($screen) {
    if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) return $screen;
    //echo '<pre>';print_r($screen);echo '</pre>';
    return $screen;
}

function floorToFraction($number, $denominator = 1) {
    $x = $number * $denominator;
    $x = floor($x);
    $x = $x / $denominator;
    return $x;
}

function calculateBankHolidays($yr) {

    $bankHols = Array();

    // New year's:
    switch ( date("w", strtotime("$yr-01-01 12:00:00")) ) {
        case 6:
            $bankHols[] = "$yr-01-03";
            break;
        case 0:
            $bankHols[] = "$yr-01-02";
            break;
        default:
            $bankHols[] = "$yr-01-01";
    }

    // Good friday:
    $bankHols[] = date("Y-m-d", strtotime( "+".(easter_days($yr) - 2)." days", strtotime("$yr-03-21 12:00:00") ));

    // Easter Monday:
    $bankHols[] = date("Y-m-d", strtotime( "+".(easter_days($yr) + 1)." days", strtotime("$yr-03-21 12:00:00") ));

    // May Day:
    if ($yr == 1995) {
        $bankHols[] = "1995-05-08"; // VE day 50th anniversary year exception
    } else {
        switch (date("w", strtotime("$yr-05-01 12:00:00"))) {
            case 0:
                $bankHols[] = "$yr-05-02";
                break;
            case 1:
                $bankHols[] = "$yr-05-01";
                break;
            case 2:
                $bankHols[] = "$yr-05-07";
                break;
            case 3:
                $bankHols[] = "$yr-05-06";
                break;
            case 4:
                $bankHols[] = "$yr-05-05";
                break;
            case 5:
                $bankHols[] = "$yr-05-04";
                break;
            case 6:
                $bankHols[] = "$yr-05-03";
                break;
        }
    }

    // Whitsun:
    if ($yr == 2002) { // exception year
        $bankHols[] = "2002-06-03";
        $bankHols[] = "2002-06-04";
    } else {
        switch (date("w", strtotime("$yr-05-31 12:00:00"))) {
            case 0:
                $bankHols[] = "$yr-05-25";
                break;
            case 1:
                $bankHols[] = "$yr-05-31";
                break;
            case 2:
                $bankHols[] = "$yr-05-30";
                break;
            case 3:
                $bankHols[] = "$yr-05-29";
                break;
            case 4:
                $bankHols[] = "$yr-05-28";
                break;
            case 5:
                $bankHols[] = "$yr-05-27";
                break;
            case 6:
                $bankHols[] = "$yr-05-26";
                break;
        }
    }

    // Summer Bank Holiday:
    switch (date("w", strtotime("$yr-08-31 12:00:00"))) {
        case 0:
            $bankHols[] = "$yr-08-25";
            break;
        case 1:
            $bankHols[] = "$yr-08-31";
            break;
        case 2:
            $bankHols[] = "$yr-08-30";
            break;
        case 3:
            $bankHols[] = "$yr-08-29";
            break;
        case 4:
            $bankHols[] = "$yr-08-28";
            break;
        case 5:
            $bankHols[] = "$yr-08-27";
            break;
        case 6:
            $bankHols[] = "$yr-08-26";
            break;
    }

    // Christmas:
    switch ( date("w", strtotime("$yr-12-25 12:00:00")) ) {
        case 5:
            $bankHols[] = "$yr-12-25";
            $bankHols[] = "$yr-12-28";
            break;
        case 6:
            $bankHols[] = "$yr-12-27";
            $bankHols[] = "$yr-12-28";
            break;
        case 0:
            $bankHols[] = "$yr-12-26";
            $bankHols[] = "$yr-12-27";
            break;
        default:
            $bankHols[] = "$yr-12-25";
            $bankHols[] = "$yr-12-26";
    }

    // Millenium eve
    if ($yr == 1999) {
        $bankHols[] = "1999-12-31";
    }

    return $bankHols;

}

 ?>