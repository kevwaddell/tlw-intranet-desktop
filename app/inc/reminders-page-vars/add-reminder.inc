<?php  
if ( $_GET['reminder-actions'] == 'add-reminder' ) {
	global $current_user;
	//debug($_POST);
	$timeZone = 'Europe/London';
	$now = time();
	$now_time = new DateTime(date(DATE_ATOM, $now + ((3600*2) - $now % 3600)), new DateTimeZone($timeZone));
			
	$counter = $_REQUEST['counter'] + 1;
	$reminder_title = "New reminder $counter";
	$reminder_group = $_REQUEST['group-id'];
	$reminder_date =  $now_time->format('Ymd');
	$reminder_time =  $now_time->format('G:i');
	$reminder_slug =  $current_user->ID."-".$reminder_group."-".time();
		
	$add_reminder_args = array (
	'post_name' => $reminder_slug,
	'post_title' => wp_strip_all_tags($reminder_title),
	'post_status' => 'publish',
	'post_author' => $current_user->ID,
	'post_type' => 'tlw_reminder'
	);

	$reminder_added = wp_insert_post($add_reminder_args);
	
	if ($reminder_added) {
	$group_title_key = acf_get_field_key('reminder_group', $reminder_added);
	$reminder_date_key = acf_get_field_key('reminder_date', $reminder_added);
	$reminder_time_key = acf_get_field_key('reminder_time', $reminder_added);
	$reminder_repeat_key = acf_get_field_key('reminder_repeat', $reminder_added);	
	$reminder_priority_key = acf_get_field_key('reminder_priority', $reminder_added);	
	$reminder_notes_key = acf_get_field_key('reminder_notes', $reminder_added);	
	
	add_post_meta($reminder_added, '_reminder_group', $group_title_key); 
	add_post_meta($reminder_added, 'reminder_group', $reminder_group); 
	add_post_meta($reminder_added, '_reminder_date', $reminder_date_key); 
	add_post_meta($reminder_added, 'reminder_date', $reminder_date); 
	add_post_meta($reminder_added, '_reminder_time', $reminder_time_key); 
	add_post_meta($reminder_added, 'reminder_time', $reminder_time); 
	add_post_meta($reminder_added, '_reminder_repeat', $reminder_repeat_key); 
	add_post_meta($reminder_added, 'reminder_repeat', 'never');
	add_post_meta($reminder_added, '_reminder_priority', $reminder_priority_key); 
	add_post_meta($reminder_added, 'reminder_priority', 'none');
	add_post_meta($reminder_added, '_reminder_notes', $reminder_notes_key); 
	add_post_meta($reminder_added, 'reminder_notes', '');
	}
	
	//debug($reminder_added);	
	
}		
?>