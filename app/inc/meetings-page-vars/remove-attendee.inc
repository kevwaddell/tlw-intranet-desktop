<?php
if ( isset($_GET['meeting-actions']) && $_GET['meeting-actions'] == 'remove-attendee') {
	global $attendee_removed;
	global $show_alert;
	$m_id = $_REQUEST['meeting-id'];
	
	if (isset($_GET['client-key'])) {
	$client_key = $_REQUEST['client-key'];
	$attendees_clients_orig = get_field( 'attendees_clients', $m_id );
	
	$attendee_clients_key = acf_get_field_key('attendees_clients', $m_id);
	
		
		foreach ($attendees_clients_orig as $k => $ac) {
			if ($k == $client_key) {
				unset($attendees_clients_orig[$k]);
			}
		}
		
		update_field( $attendee_clients_key, $attendees_clients_orig, $m_id );
		$attendee_removed = true;
		$show_alert = true;
		//debug($attendees_clients_orig);
	
	}
	
	if (isset($_GET['user-id'])) {
	$user_id = $_REQUEST['user-id'];
	$attendees_staff_orig = get_field( 'attendees_staff', $m_id );
	$attendee_staff_key = acf_get_field_key('attendees_staff', $m_id);
		
		foreach ($attendees_staff_orig as $k => $as) {
			if ($as['attendee']['ID'] == $user_id) {
			unset($attendees_staff_orig[$k]);
			}
		}
		
		update_field( $attendee_staff_key, $attendees_staff_orig, $m_id );
		
		//debug($attendees_staff_orig);
		
	}
	
}	
?>