<?php
//ADD DELETE GROUP
global $users_groups_raw;
global $users_groups;

if ( $_GET['contact-actions'] == 'delete-group') {
	
	foreach ($users_groups as $k => $ug) {
	
		if ($_GET['group-id'] == $ug[0]) {
		unset( $users_groups[ $k ] );
		}	
	}
	
	$group_deleted = update_user_meta($current_user->ID, 'users_groups', serialize($users_groups), $users_groups_raw);
	$users_groups_raw = get_user_meta($current_user->ID, 'users_groups', true);	
	$users_groups = unserialize($users_groups_raw);
	
}	
?>