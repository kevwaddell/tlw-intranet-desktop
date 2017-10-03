<?php
$add_group_errors = array();
global $users_groups;
//ADD PRIVATE CONTACT META
if ( isset($_POST['add-group']) ) {
	
	if (isset($_POST['group-title'])) {
	$group_title = strtoupper(trim($_POST['group-title']));
	$group_id = $_POST['group-id'];
	}
	
	if ( isset($_POST['group-title']) && empty( trim($_POST['group-title']) ) ) {
	$add_group_errors['group-title'] = '<span class="help-block">Please enter a contact group name.</span>';	
	}
	
	if (in_array(array($group_id, $group_title), $users_groups)) {
	$add_group_errors['group-title'] = '<span class="help-block">Group already exists</span>';		
	}
	
	if (empty($add_group_errors)) {
		array_push($users_groups, array($group_id, $group_title));
		$group_added = update_user_meta($current_user->ID, 'users_groups', serialize($users_groups), $users_groups_raw);	
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