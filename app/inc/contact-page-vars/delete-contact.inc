<?php
//DELETE CONTACT
if ( isset($_GET['contact-actions']) && $_GET['contact-actions'] == 'delete-contact') {
	foreach ($user_contacts as $k => $uc) {
		if ($uc['id'] == $_GET['private-id']) {
		$fname = $uc['fname'];
		$lname = $uc['lname'];
		unset( $user_contacts[ $k ] );
		}	
	}
	
	$contact_deleted = update_user_meta($current_user->ID, 'user_contacts', serialize($user_contacts), $user_contacts_raw);
	$user_contacts_raw = get_user_meta($current_user->ID, 'user_contacts', true);
	$user_contacts = unserialize($user_contacts_raw);
	array_multisort($user_contacts);
	
}	
?>