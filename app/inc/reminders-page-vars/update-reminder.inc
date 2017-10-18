<?php
global $current_user;
global $reminders_completed_raw;
global $reminders_completed;
if ( isset($_POST['status']) ) {
	$reminders_completed[] = array('reminder-id' => $_POST['status'], 'group-id' => $_POST['group-id']);
	
	$status_added = update_user_meta($current_user->ID, 'reminders_completed', serialize($reminders_completed), $reminders_completed_raw); 
	$reminders_completed_raw = get_user_meta($current_user->ID, 'reminders_completed', true);	
	
	$reminders_completed = unserialize($reminders_completed_raw);

	//debug($reminders_completed);
}	
?>