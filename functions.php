<?php 
require_once(STYLESHEETPATH . '/app/functions/theme-init.php');

add_theme_support( 'title-tag' );
add_theme_support('html5', array('search-form'));

function my_theme_add_editor_styles() {
    add_editor_style( get_stylesheet_directory_uri().'/app/css/custom-editor-style.css' );
}
add_action( 'after_setup_theme', 'my_theme_add_editor_styles' );

add_action( 'wp_print_styles', 'my_deregister_styles', 100 );
 
function my_deregister_styles() {
	wp_deregister_style( 'wp-admin' );
}

if ( function_exists( 'register_nav_menus' ) ) {
		register_nav_menus(
			array(
			  'main_links_menu' => 'Main Menu',
			  'launchpad_links_menu' => 'Launch Pad menu'
			)
		);
}

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

function custom_excerpt_length( $length ) {
	return 30;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

/* GRAVITY FORMS FUNCTIONS */
require_once(STYLESHEETPATH . '/app/functions/gravity-forms-functions.php');
require_once(STYLESHEETPATH . '/app/functions/gravity-forms-delete-entry.php');

/* MEETINGS CPT */
require_once(STYLESHEETPATH . '/app/functions/meetings-cpt.php');
require_once(STYLESHEETPATH . '/app/functions/custom-posts-order.php');

/* REMINDERS CPT */
require_once(STYLESHEETPATH . '/app/functions/reminders-cpt.php');

/* ROOMS TAX */
require_once(STYLESHEETPATH . '/app/functions/rooms-tax.php');

/* CHANGE META BOX TITLES */
require_once(STYLESHEETPATH . '/app/functions/change-meta-box-title.php');

/* AFC FUNCTIONS */
require_once(STYLESHEETPATH . '/app/functions/afc_save_post.php');
require_once(STYLESHEETPATH . '/app/functions/afc_relationship_filter.php');
require_once(STYLESHEETPATH . '/app/functions/afc_options_functions.php');

/* CUSTOM ROW ACTIONS */
require_once(STYLESHEETPATH . '/app/functions/post_row_actions.php');

/* GET GRAVATAR URL FUNCTION */
//require_once(STYLESHEETPATH . '/app/functions/get-gravatar-url.php');

//holder_add_theme( 'wordpress', '333333', 'eeeeee' );
holder_add_theme( 'lite-gray', '888888', 'eeeeee' );

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

function in_array_r($item , $array){
    return preg_match('/"'.$item.'"/i' , json_encode($array));
}

function in_array_key($item , $array){

	foreach ($array as $key => $val) {
    	if (in_array($item, $val)) {
	    return $key;
    	}
    }
   
}

function getArraykey($item, $array) {
   foreach ($array as $key => $val) {
       if ($val['id'] === $item) {
           return $key;
       } 
   }
   return null;
}

function cmp($a, $b) {
	return strcmp($a[1], $b[1]);
}

function debug($data) {
	global $current_user;
	$user = get_user_by_email( 'kwaddell@tlwsolicitors.co.uk' );
	
	if (current_user_can("administrator") || $current_user->ID == $user->ID) {
	echo '<pre class="debug">';
	print_r($data);	
	echo '</pre>';	
	}
}

function console_log( $data ){
  echo '<script>';
  echo 'console.log('. json_encode( $data ) .')';
  echo '</script>';
}

function acf_get_field_key($field_name, $post_id)
{
    global $wpdb;
    $acf_fields = $wpdb->get_results($wpdb->prepare('SELECT ID,post_parent,post_name FROM ' . $wpdb->posts . ' WHERE post_excerpt=%s AND post_type=%s', $field_name, 'acf-field'));
    switch (count($acf_fields)) {
        case 0:
            return false;
        case 1:
            return $acf_fields[0]->post_name;
    }
    $field_groups_ids = array();
    $field_groups = acf_get_field_groups(array(
        'post_id' => $post_id,
    ));
    foreach ($field_groups as $field_group) {
        $field_groups_ids[] = $field_group['ID'];
    }
    foreach ($acf_fields as $acf_field) {
        if (in_array($acf_field->post_parent, $field_groups_ids)) {
            return $acf_field->post_name;
        }
    }
    return false;
}
if ($_SERVER[SERVER_ADMIN] != "home-laptop@localhost") {
add_action( 'phpmailer_init', 'mailer_config', 10, 1);
function mailer_config(PHPMailer $mailer){
  $mailer->IsSMTP();
  if ($_SERVER[SERVER_ADMIN] == "home-laptop@localhost") {
	  $mailer->Host = gethostbyname("nsgateway.tlwsolicitors.co.uk"); // your SMTP server 
  } else {
	$mailer->Host = gethostbyname("tlwserv02.tlwsolicitors.local"); // your SMTP server   
}
  $mailer->SMTPDebug = 0;
  $mailer->Port = 25;
  $mailer->CharSet = "utf-8";
  $mailer->Username = 'kwaddell';
  $mailer->Password = '1609legal';
  $mailer->SMTPAuth = false;
  $mailer->SMTPSecure = 'tls';
  $mailer->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
	);
}
 }
?>