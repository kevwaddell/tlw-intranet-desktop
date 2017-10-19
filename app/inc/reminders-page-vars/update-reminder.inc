<?php
global $current_user;
global $reminders_completed_raw;
global $reminders_completed;
//debug($reminders_completed);
if ( isset($_POST['status']) && !isset($_POST['reminder-title'])) {
	
	$reminder = get_post($_POST['status']);

	$reminders_completed[] = array('reminder-id' => $_POST['status'], 'group-id' => $_POST['group-id'], 'completed'	=> time());
	
	//$status_added = update_user_meta($current_user->ID, 'reminders_completed', serialize($reminders_completed), $reminders_completed_raw); 
	//$reminders_completed_raw = get_user_meta($current_user->ID, 'reminders_completed', true);	
	
	//$reminders_completed = unserialize($reminders_completed_raw);
	
	debug($_POST);
}
if ( isset($_POST['reminder-title'])) {
	
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
	
	if (date('Ymd', strtotime($_POST['reminder-date'])) != $orig_date) {
	//debug($_POST['reminder-date']);	
	$reminder_date_key = acf_get_field_key('reminder_date', $reminder_added);
	update_field($reminder_date_key,  date('Ymd', strtotime($_POST['reminder-date'])), $reminder_id); 
	}
	
	if ($_POST['reminder-time'] != $orig_time) {
	//debug($_POST['reminder-time']);	
	$reminder_time_key = acf_get_field_key('reminder_time', $reminder_added);
	update_field($reminder_time_key,  $_POST['reminder-time'], $reminder_id); 
	}
	
	if ($_POST['reminder-priority'] != $orig_priority) {
	//debug($_POST['reminder-priority']);	
	$reminder_priority_key = acf_get_field_key('reminder_priority', $reminder_added);
	update_field($reminder_priority_key,  $_POST['reminder-priority'], $reminder_id); 
	}
	
	if ($_POST['reminder-repeat'] != $orig_repeat) {
	//debug($_POST['reminder-repeat']);	
	$reminder_repeat_key = acf_get_field_key('reminder_repeat', $reminder_added);
	update_field($reminder_repeat_key,  $_POST['reminder-repeat'], $reminder_id); 
	}
	
	if (wp_strip_all_tags($_POST['reminder-notes']) != wp_strip_all_tags($orig_notes)) {
	//debug(wp_strip_all_tags($_POST['reminder-notes']));
	$reminder_notes_key = acf_get_field_key('reminder_notes', $reminder_added);	
	update_field($reminder_notes_key,  wp_strip_all_tags($_POST['reminder-notes']), $reminder_id); 	
	}
	
	if ($_POST['change-group'] != $orig_group) {
	//debug($_POST['change-group']);	
	$group_title_key = acf_get_field_key('reminder_group', $reminder_added);
	update_field($group_title_key,  $_POST['change-group'], $reminder_id); 
	}
	
	//debug($_POST);	
}	
?>