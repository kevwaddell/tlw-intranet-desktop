<?php
global $current_user;
global $reminder_groups_raw;
global $reminder_groups;

if (isset($_GET['reminder-actions']) && $_GET['reminder-actions'] == 'add-group') {
	
	$colors = array('red', 'purple', 'green', 'pink', 'orange', 'blue' );
	
	$add_group_ar = array('group-id' => $_GET['group-id'], 'title' => 'New Group', 'color'	=> $colors[rand(0, count($colors)-1)] );
	
	$reminder_groups[] = $add_group_ar;
	
	$group_added = update_user_meta($current_user->ID, 'reminder_groups', serialize($reminder_groups), $reminder_groups_raw); 
	
	if ($group_added) {
	wp_redirect( '?group-id='.$_GET['group-id']."&group-added=1" );
	exit;	
	}
}	
?>