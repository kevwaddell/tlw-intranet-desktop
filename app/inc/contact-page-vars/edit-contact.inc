<?php
//ADD EDIT CONTACT META
if ( isset($_POST['edit-contact']) ) {
global $user_contacts_raw;
global $user_contacts;
//echo '<pre class="debug">';print_r($_POST);echo '</pre>';
	
	$fname = trim($_POST['fname']);
	$lname = trim($_POST['lname']);
	$email = trim($_POST['email']);
	$company = trim($_POST['company']);
	$tel = trim($_POST['tel']);
	$mobile = trim($_POST['mobile']);
	$group_id = $_POST['group-id'];
	$private_id = $_POST['private-id'];
	
		$edit_contact_details = array(
		'id'	=> $private_id,
		'group' => $group_id,
		'fname' => $fname,
		'lname' => $lname,
		'email' => $email,
		'company' => $company,
		'tel'	=> $tel,
		'mobile' => $mobile
		);	
		
	foreach ($user_contacts as $k => $uc) {
		if ($uc['id'] == $private_id) {
		$user_contacts[$k] = $edit_contact_details;
		$contact_updated = update_user_meta($current_user->ID, 'user_contacts', serialize($user_contacts), $user_contacts_raw);	
		}
	}
		
		$user_contacts_raw = get_user_meta($current_user->ID, 'user_contacts', true);
		$user_contacts = unserialize($user_contacts_raw);
		array_multisort($user_contacts);
		
	echo '<pre class="debug">';print_r($contact_updated);echo '</pre>';	
}	
?>