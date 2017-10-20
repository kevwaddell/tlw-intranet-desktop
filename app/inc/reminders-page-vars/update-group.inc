<?php
global $current_user;
global $reminder_groups_raw;
global $reminder_groups;

if ( isset($_POST['update-group']) && !empty(trim($_POST['group-title'])) ) {

	//debug($_POST['group-color']);
	
	foreach ($reminder_groups as $k => $rg) { 
		
		if ($rg['group-id'] == $_GET['group-id']) {
		$reminder_groups[$k]['title'] = trim($_POST['group-title']);
		$reminder_groups[$k]['color'] = $_POST['group-color'][0];
		}
	}
	
	$group_updated = update_user_meta($current_user->ID, 'reminder_groups', serialize($reminder_groups), $reminder_groups_raw); 
	$reminder_groups_raw = get_user_meta($current_user->ID, 'reminder_groups', true);	
	
	$reminder_groups = unserialize($reminder_groups_raw);
	
	if ($group_updated) {
	wp_redirect( '?group-id='.$_GET['group-id']."&group-updated=1" );
	exit;	
	}
}		
?>