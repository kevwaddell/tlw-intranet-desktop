<?php
$edit_group_errors = array();
global $users_groups;
//ADD PRIVATE CONTACT META
if ( isset($_POST['edit-group']) ) {
	
	if (isset($_POST['group-title'])) {
	$group_title = strtoupper(trim($_POST['group-title']));
	$group_id = $_POST['group-id'];
	}
	
	if ( isset($_POST['group-title']) && empty( trim($_POST['group-title']) ) ) {
	$edit_group_errors['group-title'] = '<span class="help-block">Please enter a contact group name.</span>';	
	}
	
	if (in_array(array($group_id, $group_title), $users_groups)) {
	$edit_group_errors['group-title'] = '<span class="help-block">Group already exists</span>';		
	}
	
	if (empty($edit_group_errors)) {
		if (in_array(array($group_id, $group_title), $users_groups)) {
			
		}
/*
		$group_added = update_user_meta($current_user->ID, 'users_groups', serialize($users_groups), $users_groups_raw);	
		$users_groups_raw = get_user_meta($current_user->ID, 'users_groups', true);	
		$users_groups = unserialize($users_groups_raw);
		array_multisort($users_groups);
*/
	}
	
	echo '<pre class="debug">';
	print_r($users_groups);
	echo '</pre>';	
}	
?>