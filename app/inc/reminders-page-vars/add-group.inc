<?php
global $current_user;
global $reminder_groups_raw;
global $reminder_groups;

if (isset($_GET['reminder-actions']) && $_GET['reminder-actions'] == 'add-group') {
	$group_num = count($reminder_groups) + 1;
	$add_group_ar = array('group-id' => $_GET['group-id'], 'title' => 'New Group '.$group_num, 'color'	=> 'red');
	
	$reminder_groups[] = $add_group_ar;
	
	$reminders_added = update_user_meta($current_user->ID, 'reminder_groups', serialize($reminder_groups), $reminder_groups_raw); 
	$reminder_groups_raw = get_user_meta($current_user->ID, 'reminder_groups', true);	
	
	$reminder_groups = unserialize($reminder_groups_raw);
	
	//debug($reminder_groups);
}	
?>