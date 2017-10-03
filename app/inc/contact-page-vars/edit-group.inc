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
	$edit_group_errors['group-title'] = '<span class="help-block">Group name unchanged.</span>';		
	}
	
	if (empty($edit_group_errors)) {
	$users_groups[in_array_key($group_id, $users_groups)] = array($group_id, $group_title);
	$group_updated = update_user_meta($current_user->ID, 'users_groups', serialize($users_groups), $users_groups_raw);	
	$users_groups_raw = get_user_meta($current_user->ID, 'users_groups', true);	
	$users_groups = unserialize($users_groups_raw);
	}
/*
	echo '<pre class="debug">';
	print_r($users_groups);
	echo '</pre>';
*/
}	
?>