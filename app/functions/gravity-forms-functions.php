<?php
/* BEFORE MEETING POSTED FUNCTION 
This function changes the meeting slug and title
and adds the post meta to the post.	
*/
add_action('gform_after_submission_2', 'add_meeting_data', 10, 2);

function add_meeting_data($entry, $form) {
	
	$post = get_post($entry['post_id']);
	$user_email = $entry['7'];
	$user = get_user_by( 'email', $user_email );
	$date_raw = $entry['2'];
	$date = date('Ymd',strtotime($date_raw));
	$start_time_hrs_raw = $entry['11'];
	$start_time_min_raw = $entry['12'];
	$start_time = strtotime($date_raw.' '.$start_time_hrs_raw.':'.$start_time_min_raw);
	$end_time_hrs_raw = $entry['13'];
	$end_time_min_raw = $entry['14'];
	$end_time = strtotime($date_raw.' '.$end_time_hrs_raw.':'.$end_time_min_raw); 
	
	$post_update = array(
      'ID'           => $entry['post_id'],
      'post_name' => sanitize_title($post->post_title.' '.$date),
      'post_title'	=> $post->post_title
	);
	wp_update_post( $post_update  );
	
	add_post_meta($entry['post_id'], '_meeting_description', 'field_5395d707861af', true); 
	add_post_meta($entry['post_id'], 'meeting_description', $post->post_title, true); 
	add_post_meta($entry['post_id'], '_meeting_date', 'field_533be32c54fbc', true);  
	add_post_meta($entry['post_id'], 'meeting_date', $date, true);  
	add_post_meta($entry['post_id'], '_start_time', 'field_533be5353ffec', true);  
	add_post_meta($entry['post_id'], 'start_time', $start_time, true);  
	add_post_meta($entry['post_id'], '_end_time', 'field_533be5d13ffed', true); 
	add_post_meta($entry['post_id'], 'end_time', $end_time, true); 
}

/* USER NOTIFICATION FUNCTIONS 
This function checks to see if the primary person who gets
the notification email is in the office.
If not it will got to the next person and so on.
*/

/*
add_filter("gform_notification_2", "change_notification", 10, 2);

function change_notification( $notification, $form, $entry ) {
		
	   if($notification["name"] == "User Notification"){
	  // echo '<pre>';print_r($notification);echo '</pre>';
	   $notification['from'] = "kevwadd21@gmail.com";
	   $notification['fromName'] = "Kev Waddza";
	   $notification['replyTo'] = "kevwadd21@gmail.com";
	   }
	   
	   return $notification;

}
*/

?>