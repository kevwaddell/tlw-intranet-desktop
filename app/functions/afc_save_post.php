<?php
add_action('acf/save_post', 'my_acf_save_post', 1);

function my_acf_save_post( $post_id )
{
	global $current_screen;
	// vars	
	
	//var_dump($current_screen);
	
	if ($current_screen->id == 'tlw_meeting') {
	
		$slug = sanitize_title($_POST['acf']['field_5395d707861af'].' '.$_POST['acf']['field_533be32c54fbc']); 
		$title = $_POST['fields']['field_5395d707861af'];
		
		wp_update_post( array( 'ID' => $post_id, 'post_title' => $title, 'post_name' => $slug) );
	}	
	
	if ($current_screen->id == 'tlw_holiday') {
	
		//echo '<pre>';print_r(strtotime($_POST['acf']['field_53c67357805e5']));echo '</pre>';
		$user_info = get_userdata($_POST['post_author']);
		$username = $user_info->display_name;
		$slug = sanitize_title($username .' '. strtotime($_POST['acf']['field_53c67357805e5']) .' '. strtotime($_POST['acf']['field_53c673b0805e6']) ); 
		$title = $username;
		
		//echo '<pre>';print_r($slug);echo '</pre>';
		//echo '<pre>';print_r($end_date);echo '</pre>';
		//exit;
		wp_update_post( array( 'ID' => $post_id, 'post_title' => $title, 'post_name' => $slug) );
	}	
	
}
 
?>