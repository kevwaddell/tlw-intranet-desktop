<?php
if ( isset($_POST['update-attendee'])) {
	global $attendee_updated;
	global $show_alert;
	$m_id = $_POST['meeting-id'];
	$client_key = $_POST['client-key'];
	$attendees_clients_orig = get_field( 'attendees_clients', $m_id );
	$attendee_clients_key = acf_get_field_key('attendees_clients', $m_id);
	
	//debug($_POST);
	
	if (empty(trim($_POST['attendee-client']))) {

		foreach ($attendees_clients_orig as $k => $ac) {
			if ($k == $client_key) {
			unset($attendees_clients_orig[$k]);	
			}
		}
		//debug($attendees_clients_orig);
	
	} else {
		
		foreach ($attendees_clients_orig as $k => $ac) {
			if ($k == $client_key) {
				$attendees_clients_orig[$k]['attendee_client'] = ucwords( trim($_POST['attendee-client']) );
			}
		}
		
	}
	
	//debug($attendees_clients_orig);
		
	update_field( $attendee_clients_key, $attendees_clients_orig, $m_id );
			
	$attendee_updated = true;
	$show_alert = true;
}	
?>