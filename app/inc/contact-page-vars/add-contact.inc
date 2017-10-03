<?php
//ADD PRIVATE CONTACT META
if ( isset($_POST['add-contact']) ) {
$add_contact_errors = array();
global $users_groups_raw;
global $users_groups;
global $user_contacts_raw;
global $user_contacts;
	//echo '<pre class="debug">';print_r($_POST);echo '</pre>';
	
	$fname = trim($_POST['fname']);
	$lname = trim($_POST['lname']);
	$email = trim($_POST['email']);
	$company = trim($_POST['company']);
	$tel = trim($_POST['tel']);
	$mobile = trim($_POST['mobile']);
	$id = $_POST['private-id'];
	
	//Check if required fields are empty and show error if they are
	if ( $_POST['group-id'] == '0' ) {
	$add_contact_errors['group-id'] = '<span class="help-block">Please choose a contact group to add to.</span>';	
	}
	if (empty($fname)) {
	$add_contact_errors['fname'] = '<span class="help-block">Please enter a contact first name.</span>';	
	}

	if (empty($add_contact_errors)) {
		
		$nc_group_id = $_POST['group-id'];
	
		$contact_details = array(
		'id'	=> $id,
		'group' => $nc_group_id,
		'fname' => $fname,
		'lname' => $lname,
		'email' => $email,
		'company' => $company,
		'tel'	=> $tel,
		'mobile' => $mobile
		);
		
		if (!in_array($contact_details, $user_contacts)) {
		array_push($user_contacts,$contact_details);
		$contact_added = update_user_meta($current_user->ID, 'user_contacts', serialize($user_contacts), $user_contacts_raw); 
		$user_contacts_raw = get_user_meta($current_user->ID, 'user_contacts', true);
		$user_contacts = unserialize($user_contacts_raw);
		array_multisort($user_contacts);
		}
	}
}	
?>