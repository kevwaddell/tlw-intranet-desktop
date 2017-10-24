<?php
if ( $_GET['meeting-actions'] == 'add-reminder') {
	$add_reminder_error = false;
	global $show_alert;
	global $current_user;
	$timeZone = 'Europe/London';
	$now = strtotime("+1 hour");
	$nextFullHour = date(DATE_ATOM, $now + (3600 - $now % 3600));
	$now_time = new DateTime($nextFullHour, new DateTimeZone($timeZone));
		
	$m_id = $_REQUEST['meeting-id'];
	$meeting = get_post($m_id);
	$reminder_title = get_the_title($m_id);
	$reminder_date = get_field( 'meeting_date', $m_id );
	$reminder_time = get_field( 'start_time', $m_id );
	$reminder_notes = get_field( 'meeting_description', $m_id );
	$reminder_slug =  $current_user->ID."-meeting-".$now_time->getTimestamp();
	$reminder_group = "meeting";
	$reminder_owner = $current_user->ID;
	if (isset($_GET['user-id'])) {
	$reminder_owner = $_GET['user-id'];	
	}
	
	$check_reminders_args = array(
	'posts_per_page' => -1,
	'author'	=> $reminder_owner,
	'post_type' => 'tlw_reminder'	
	);
	
	$check_reminders = get_posts($check_reminders_args);
	
	foreach ($check_reminders as $k => $rem) { 
		if ($rem->post_title == $reminder_title) {
		$add_reminder_error = true;	
		$show_alert = true;
		}	
	}
	
	//console_log($add_reminder_error);
	
	if (!$add_reminder_error) {
	$add_reminder_args = array (
	'post_name' => $reminder_slug,
	'post_title' => wp_strip_all_tags($reminder_title),
	'post_status' => 'publish',
	'post_author' => $current_user->ID,
	'post_type' => 'tlw_reminder'
	);

	//debug($add_reminder_args);

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
		add_post_meta($reminder_added, 'reminder_priority', 'high');
		add_post_meta($reminder_added, '_reminder_notes', $reminder_notes_key); 
		add_post_meta($reminder_added, 'reminder_notes', $reminder_notes);
		
		$show_alert = true;
	}			
	}

}	
?>