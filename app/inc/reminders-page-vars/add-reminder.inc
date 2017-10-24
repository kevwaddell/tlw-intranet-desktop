<?php  
if ( $_GET['reminder-actions'] == 'add-reminder' && !empty($_REQUEST['group-id'])) {
	global $current_user;
	//debug($_POST);
	$timeZone = 'Europe/London';
	$now = strtotime("+1 hour");
	$nextFullHour = date(DATE_ATOM, $now + (3600 - $now % 3600));
	$now_time = new DateTime($nextFullHour, new DateTimeZone($timeZone));
	//debug($now_time->format('D jS M Y'));
			
	$reminder_title = "New reminder";
	$reminder_group = $_REQUEST['group-id'];
	$reminder_date =  $now_time->format('Ymd');
	$reminder_time =  $now_time->format('G:i');
	$reminder_slug =  $current_user->ID."-".$reminder_group."-".$now_time->getTimestamp();
		
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
	$remind_later_key = acf_get_field_key('remind_later', $reminder_added);
	$reminder_repeat_key = acf_get_field_key('reminder_repeat', $reminder_added);	
	$reminder_priority_key = acf_get_field_key('reminder_priority', $reminder_added);	
	$reminder_notes_key = acf_get_field_key('reminder_notes', $reminder_added);	
	
	add_post_meta($reminder_added, '_reminder_group', $group_title_key); 
	add_post_meta($reminder_added, 'reminder_group', $reminder_group); 
	add_post_meta($reminder_added, '_reminder_date', $reminder_date_key); 
	add_post_meta($reminder_added, 'reminder_date', $reminder_date); 
	add_post_meta($reminder_added, '_reminder_time', $reminder_time_key); 
	add_post_meta($reminder_added, 'reminder_time', $reminder_time); 
	add_post_meta($reminder_added, '_remind_later', $remind_later_key); 
	add_post_meta($reminder_added, 'remind_later', ""); 
	add_post_meta($reminder_added, '_reminder_repeat', $reminder_repeat_key); 
	add_post_meta($reminder_added, 'reminder_repeat', 'never');
	add_post_meta($reminder_added, '_reminder_priority', $reminder_priority_key); 
	add_post_meta($reminder_added, 'reminder_priority', 'none');
	add_post_meta($reminder_added, '_reminder_notes', $reminder_notes_key); 
	add_post_meta($reminder_added, 'reminder_notes', '');
	
		wp_redirect( '?group-id='.$reminder_group."&reminder-id=".$reminder_added."&reminder-added=1" );
		exit;	
	}
	
	//debug($reminder_added);	
	
}		
?>