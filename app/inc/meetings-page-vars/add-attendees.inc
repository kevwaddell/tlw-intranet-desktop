<?php
global $add_attendee_errors;

if ( isset($_POST['add-attendees']) ) {
	debug($_POST);
	if (empty($_POST['attendees-staff'][0]) && empty($_POST['attendees-clients'][0])) {
	$add_attendee_errors['no-attendees'] = "<p>You have not chosen or entered any attendess.</p>";	
	}
	
	if (empty($add_attendee_errors)) {
		debug($_POST['attendees-staff']);
	} else {
		debug($add_attendee_errors);
	}
}
	
?>