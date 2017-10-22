<?php
global $current_user;
global $reminders_completed_raw;
global $reminders_completed;
global $timeZone;
//debug($reminders_completed);
//debug($_POST);
if ( isset($_POST['status']) && !isset($_POST['reminder-title'])) {
	
	$date_format = get_option('date_format');
	$reminder_id = $_POST['status'];
	$reminder = get_post($reminder_id);
	$reminder_date = get_field('reminder_date', $reminder_id);
	$reminder_time = get_field('reminder_time', $reminder_id);
	$reminder_repeat = get_field('reminder_repeat', $reminder_id); 
	$comp_dateTime = new DateTime("now", new DateTimeZone($timeZone));
	$ts = $comp_dateTime->getTimestamp();
	$comp_ts = strtotime($comp_dateTime->format($date_format.' '.$time_format));
	
	$reminders_completed[] = array('reminder-id' => $reminder_id, 'group-id' => $_POST['group-id'], 'reminder-date' => $reminder_date, 'reminder-time' => $reminder_time, 'completed' => $comp_ts);
	
	if ($reminder_repeat != 'never') {
	$reminder_date_key = acf_get_field_key('reminder_date', $reminder_added);	
		if ($reminder_repeat == 'day') {
		$next_date = date('Ymd', strtotime("tomorrow"));	
		}
		if ($reminder_repeat == 'week') {
		$next_date = date('Ymd', strtotime($reminder_date ." + 1 week"));	
		}
		if ($reminder_repeat == 'weeks') {
		$next_date = date('Ymd', strtotime($reminder_date ." + 2 weeks"));	
		}
		if ($reminder_repeat == 'month') {
		$next_date = date('Ymd', strtotime($reminder_date ." + 1 month"));	
		}
		if ($reminder_repeat == 'year') {
		$next_date = date('Ymd', strtotime($reminder_date ." + 1 year"));	
		}
		
		//debug(date($date_format, strtotime($next_date)));
		
		update_field($reminder_date_key,  $next_date, $reminder_id); 
	}
	
	$status_added = update_user_meta($current_user->ID, 'reminders_completed', serialize($reminders_completed), $reminders_completed_raw); 
	$reminders_completed_raw = get_user_meta($current_user->ID, 'reminders_completed', true);	
	
	$reminders_completed = unserialize($reminders_completed_raw);
	
	if ($status_added) {
	wp_redirect( '?group-id='.$_POST['group-id']."&reminder-updated=1" );
	exit;	
	}
	//debug($_POST);
}
//debug($_POST);
if ( isset($_POST['change-status']) && !isset($_POST['reminder-title'])) {
	//debug($_POST);
	
	foreach ($reminders_completed as $k => $rc) { 
		if ($rc['reminder-id'] == $_POST['change-status']) {
		unset($reminders_completed[$k]);
		$reminder_date_key = acf_get_field_key('reminder_date',  $rc['reminder-id']);
		update_field($reminder_date_key, $rc['reminder-date'], $rc['reminder-id']); 	
		}	
	}
	
	//debug($reminders_completed);
	$status_added = update_user_meta($current_user->ID, 'reminders_completed', serialize($reminders_completed), $reminders_completed_raw); 
	$reminders_completed_raw = get_user_meta($current_user->ID, 'reminders_completed', true);
	
	$reminders_completed = unserialize($reminders_completed_raw);
}
if ( isset($_POST['update-reminder'])) {
	
	//debug(strtotime($_POST['reminder-date'])." ------ ".strtotime($_POST['orig-date']));
	
	$orig_date = $_POST['orig-date'];
	$orig_time = $_POST['orig-time']; 
	$orig_priority = $_POST['orig-priority'];
	$orig_group = $_POST['orig-group'];
	$orig_repeat = $_POST['orig-repeat'];
	$orig_notes = $_POST['orig-notes'];
	$reminder_id = $_POST['reminder-id'];
	
	$reminder_title = trim($_POST['reminder-title']);
	$title_changed = true;
	
	if (empty($reminder_title)) {
	$reminder_title = $_POST['orig-title'];
	}
	
	if ($reminder_title == $_POST['orig-title']) {
	$title_changed = false;	
	}
	
	if ($title_changed) {
	
		$update_reminder_args = array (
		'ID' => $_POST['reminder-id'],
		'post_title' => wp_strip_all_tags($reminder_title)
		);

		$reminder_updated = wp_update_post($update_reminder_args);
	
	}
	//debug( date('Ymd', strtotime($_POST['reminder-date']) )." ----- ".$orig_date);
	if (strtotime($_POST['reminder-date']) != strtotime($orig_date)) {	
	$reminder_date_key = acf_get_field_key('reminder_date', $reminder_id);
	update_field($reminder_date_key,  date('Ymd', strtotime($_POST['reminder-date'])), $reminder_id); 
	}
	
	if ($_POST['reminder-time'] != $orig_time) {
	//debug($_POST['reminder-time']);	
	$reminder_time_key = acf_get_field_key('reminder_time', $reminder_id);
	update_field($reminder_time_key,  $_POST['reminder-time'], $reminder_id); 
	}
	
	if ($_POST['reminder-priority'] != $orig_priority) {
	//debug($_POST['reminder-priority']);	
	$reminder_priority_key = acf_get_field_key('reminder_priority', $reminder_id);
	update_field($reminder_priority_key,  $_POST['reminder-priority'], $reminder_id); 
	}
	
	if ($_POST['reminder-repeat'] != $orig_repeat) {
	//debug($_POST['reminder-repeat']);	
	$reminder_repeat_key = acf_get_field_key('reminder_repeat', $reminder_id);
	update_field($reminder_repeat_key,  $_POST['reminder-repeat'], $reminder_id); 
	}
	
	if (wp_strip_all_tags($_POST['reminder-notes']) != wp_strip_all_tags($orig_notes)) {
	//debug(wp_strip_all_tags($_POST['reminder-notes']));
	$reminder_notes_key = acf_get_field_key('reminder_notes', $reminder_id);	
	update_field($reminder_notes_key,  wp_strip_all_tags($_POST['reminder-notes']), $reminder_id); 	
	}
	
	if ($_POST['change-group'] != $orig_group) {
	//debug($_POST['change-group']);	
	$group_title_key = acf_get_field_key('reminder_group', $reminder_id);
	update_field($group_title_key,  $_POST['change-group'], $reminder_id); 
	}
		
	wp_redirect( '?group-id='.$_POST['change-group']."&reminder-updated=1" );
	exit;
	
	//debug($_POST);	
}	
?>