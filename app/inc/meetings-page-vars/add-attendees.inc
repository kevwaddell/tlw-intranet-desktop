<?php
global $add_attendee_errors;
$notify_staff = false;

if ( isset($_POST['add-attendees']) ) {
$meeting_id = $_POST['meeting-id'];
$attendees_staff_total = get_post_meta($meeting_id , 'attendees_staff', true);
$attendees_clients_total = get_post_meta($meeting_id , 'attendees_clients', true);

	//echo '<pre class="debug">';
	//print_r((empty($attendees_staff_total)) ? 0 : $attendees_staff_total);
	//print_r("<br>---------------------<br>");
	//print_r((empty($attendees_clients_total)) ? 0 : $attendees_clients_total);
	//print_r("<br>---------------------<br>");
	
	if (empty($_POST['attendees-staff'][0]) && empty($_POST['attendees-clients'][0])) {
	$add_attendee_errors['no-attendees'] = "You have not chosen or entered any attendees.";	
	}
	
	if (empty($add_attendee_errors)) {
	$attendees_staff = $_POST['attendees-staff'];
	$as_counter = (empty($attendees_staff_total)) ? 0 : $attendees_staff_total;
	if (!empty(trim($_POST['attendees-clients']))) {
	$attendees_clients = preg_split('/\r\n|[\r\n]/', $_POST['attendees-clients']) ;	
	}
	$ac_counter = (empty($attendees_clients_total)) ? 0 : $attendees_clients_total;
	
	//print_r($attendees_staff);
	//print_r($attendees_clients);
		
		if (!empty($attendees_staff)) {
			foreach ($attendees_staff as $s_attendee) {
			//print_r('attendees_staff_'.$as_counter.'_attendee_staff = '.ucwords($s_attendee));
			//print_r("<br>");
			//print_r('attendees_staff_'.$as_counter.'_status = pending');
			//print_r("<br>---------------------<br>");
			add_post_meta($meeting_id, '_attendees_staff_'.$as_counter.'_attendee_staff', 'field_539878dcfecd9');
			add_post_meta($meeting_id, 'attendees_staff_'.$as_counter.'_attendee_staff', $s_attendee);
			add_post_meta($meeting_id, '_attendees_staff_'.$as_counter.'_status', 'field_5399ae2a892eb');
			add_post_meta($meeting_id, 'attendees_staff_'.$as_counter.'_status', 'pending');
			$as_counter++;
			}	
		}
		
		if (!empty($attendees_clients)) {
			foreach ($attendees_clients as $c_attendee) {
			//print_r('attendees_clients_'.$ac_counter.'_attendee_client = '.$c_attendee);
			//print_r("<br>---------------------<br>");
			add_post_meta($meeting_id, '_attendees_clients_'.$ac_counter.'_attendee_client', 'field_539878fafecda');
			add_post_meta($meeting_id, 'attendees_clients_'.$ac_counter.'_attendee_client', $c_attendee);
			$ac_counter++;
			}	
		}
		
		if ($as_counter > $attendees_staff_total) {
		//print_r($as_counter);
		update_post_meta( $meeting_id, 'attendees_staff', $as_counter, $attendees_staff_total);
		}
		
		if ($ac_counter > $attendees_clients_total) {
		//print_r("<br>---------------------<br>");
		//print_r($ac_counter);
		update_post_meta( $meeting_id, 'attendees_clients', $ac_counter, $attendees_clients_total);
		}
		
	}
	
	//echo '</pre>';
}
	
?>