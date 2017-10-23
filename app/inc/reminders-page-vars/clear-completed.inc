<?php
global $current_user;
global $reminders_completed_raw;
global $reminders_completed;

if (isset($_GET['reminder-actions']) && $_GET['reminder-actions'] == 'clear-completed') {

	foreach ($reminders_completed as $k => $rc) {
		if ($rc['group-id'] == $_GET['group-id']) {
		unset($reminders_completed[$k]);
		}
	}
	sort($reminders_completed);
	$completed_cleared = update_user_meta($current_user->ID, 'reminders_completed', serialize($reminders_completed), $reminders_completed_raw); 
	
	if ($completed_cleared) {
	wp_redirect( '?group-id='.$_GET['group-id']."&completed_cleared=1" );
	exit;		
	}
}	
?>