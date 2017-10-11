<?php
global $add_attendee_errors;
$attendees_added = false;

if ( isset($_POST['add-attendees']) ) {
$m_id = $_POST['meeting-id'];
$attendees_staff_total = intval(get_post_meta($m_id , 'attendees_staff', true));
$attendees_staff_orig = get_field( 'attendees_staff', $m_id );
$attendees_clients_total = intval(get_post_meta($m_id , 'attendees_clients', true));
$attendees_clients_orig = get_field( 'attendees_clients', $m_id );

//VARS FOR ADDING AND UPDATING META
$update_attendees_staff = $_POST['attendees-staff'];
$as_counter = (empty($attendees_staff_total)) ? 0 : $attendees_staff_total;
if (!empty(trim($_POST['attendees-clients']))) {
$update_attendees_clients = preg_split('/\r\n|[\r\n]/', ucwords($_POST['attendees-clients'])) ;	
}
$ac_counter = (empty($attendees_clients_total)) ? 0 : $attendees_clients_total;
	
	if (!empty($attendees_staff_orig)) {
	foreach($attendees_staff_orig as $staff) {
		if ( in_array_r($staff['attendee_staff']['ID'], $update_attendees_staff) ) {
		$fname = get_user_meta( $staff['attendee_staff']['ID'], "first_name", true );
		$lname = get_user_meta( $staff['attendee_staff']['ID'], "last_name", true );
		$add_attendee_errors['attendee-exists'][] = '<i class="fa fa-times-circle"></i> '.$fname.' '. $lname .' is already attending.';		
		}
	}
	}
	
	if (!empty($attendees_clients_orig)) {
		foreach($attendees_clients_orig as $client) {
			if ( in_array_r($client['attendee_client'], $update_attendees_clients) ) {
			$add_attendee_errors['attendee-exists'][] = '<i class="fa fa-times-circle"></i> '. $client['attendee_client'] .' is already attending.';		
			}
		}
	}

	echo '<pre class="debug">';
	//print_r($attendees_staff_orig);
	//print_r($add_attendee_errors);
	//print_r("<br>---------------------<br>");
	//print_r((empty($attendees_clients_total)) ? 0 : $attendees_clients_total);
	//print_r("<br>---------------------<br>");
	
	if (empty($_POST['attendees-staff'][0]) && empty($_POST['attendees-clients'][0])) {
	$add_attendee_errors['no-attendees'] = '<i class="fa fa-times-circle"></i> You have not chosen or entered any attendees.';	
	}
	
	if (empty($add_attendee_errors)) {
	$attendee_key = acf_get_field_key('attendee', $m_id);
	$status_key = acf_get_field_key('status', $m_id);
	$attendee_client_key = acf_get_field_key('attendee_client', $m_id);
	//print_r($attendee_key);
	//print_r("<br>---------------------<br>");
	//print_r($status_key);
		
		if (!empty($update_attendees_staff)) {
			foreach ($update_attendees_staff as $s_attendee) {
			add_post_meta($m_id, '_attendees_staff_'.$as_counter.'_attendee', $attendee_key);
			add_post_meta($m_id, 'attendees_staff_'.$as_counter.'_attendee', $s_attendee);
			add_post_meta($m_id, '_attendees_staff_'.$as_counter.'_status', $status_key);
			add_post_meta($m_id, 'attendees_staff_'.$as_counter.'_status', 'pending');
			$as_counter++;
			}	
		}
		
		if (!empty($update_attendees_clients)) {
			foreach ($update_attendees_clientss as $c_attendee) {
			add_post_meta($m_id, '_attendees_clients_'.$ac_counter.'_attendee_client', $attendee_client_key);
			add_post_meta($m_id, 'attendees_clients_'.$ac_counter.'_attendee_client', $c_attendee);
			$ac_counter++;
			}	
		}
			
		if ($as_counter > $attendees_staff_total) {
		$attendees_staff_updated = update_post_meta( $m_id, 'attendees_staff', $as_counter, $attendees_staff_total);
		}
		
		if ($ac_counter > $attendees_clients_total) {
		$attendees_clients_updated = update_post_meta( $m_id, 'attendees_clients', $ac_counter, $attendees_clients_total);
		}
		
		if ($attendees_clients_updated || $attendees_staff_updated) {
		$attendees_added = true;
		
		}
		
		print_r($attendees_added);
	}
	echo '</pre>';
}
	
?>