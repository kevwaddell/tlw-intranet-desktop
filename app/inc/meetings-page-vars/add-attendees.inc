<?php
global $add_attendee_errors;
$attendees_added = false;

if ( isset($_POST['add-attendees']) ) {
$m_id = $_POST['meeting-id'];
$attendees_staff_total = intval(get_post_meta($m_id , 'attendees_staff', true));
$attendees_staff_orig = get_field( 'attendees_staff', $m_id );
$attendees_clients_total = intval(get_post_meta($m_id , 'attendees_clients', true));
$attendees_clients_orig = get_field( 'attendees_clients', $m_id );
$staff_updates = array();
$client_updates = array();
//echo '<pre class="debug">';
//VARS FOR ADDING AND UPDATING META
$update_attendees_staff = $_POST['attendees-staff'];
$as_counter = (empty($attendees_staff_total)) ? 0 : $attendees_staff_total;
if (!empty(trim($_POST['attendees-clients']))) {
$update_attendees_clients = preg_split('/\r\n|[\r\n]/', ucwords($_POST['attendees-clients'])) ;	
}
$ac_counter = (empty($attendees_clients_total)) ? 0 : $attendees_clients_total;
//print_r($attendees_clients_orig);
	
	if (!empty($attendees_staff_orig) && !empty($update_attendees_staff)) {
		foreach($attendees_staff_orig as $k => $staff) {
			
			if ( !in_array($staff['attendee']['ID'], $update_attendees_staff ) ) {
			$staff_updates[] = $staff;	
			} else {
			unset($attendees_staff_orig[$k]);	
			}
			
		}
	}
	
	if (!empty($attendees_clients_orig) && !empty($update_attendees_clients)) {
		foreach($attendees_clients_orig as $k => $client) {
			
			if ( !in_array($client['attendee_client'], $update_attendees_clients ) ) {
			$client_updates[] = $client;	
			} else {
			unset($attendees_clients_orig[$k]);	
			}
		}
	}
	//print_r($attendees_staff_orig);
	//print_r($add_attendee_errors);
	//print_r("<br>---------------------<br>");
	//print_r((empty($attendees_clients_total)) ? 0 : $attendees_clients_total);
	//print_r("<br>---------------------<br>");
	
	if (empty($_POST['attendees-staff'][0]) && empty($_POST['attendees-clients'][0])) {
	$add_attendee_errors['no-attendees'] = '<i class="fa fa-times-circle"></i> You have not chosen or entered any attendees.';	
	}
	
	if (empty($add_attendee_errors)) {
	$attendee_staff_key = acf_get_field_key('attendees_staff', $m_id);
	$attendee_clients_key = acf_get_field_key('attendees_clients', $m_id);
	//print_r($attendee_key);
	//print_r("<br>---------------------<br>");
	//print_r($status_key);
		
		if (!empty($update_attendees_staff)) {
			foreach ($update_attendees_staff as $k => $s_attendee) {
				$user_data = get_userdata( $s_attendee );
				$user = array();
				$user['ID'] = $s_attendee;
				$user['user_firstname'] = $user_data->user_firstname;
				$user['user_lastname'] = $user_data->user_lastname;
				$user['nickname'] = $user_data->nickname;
				$user['user_nicename'] = $user_data->user_nicename;
				$user['display_name'] = $user_data->display_name;
				$user['user_email'] = $user_data->user_email;
				$user['user_url'] = $user_data->user_url;
				$user['user_registered'] = $user_data->user_registered;
				$user['user_description'] = $user_data->user_description;
				$user['user_avatar'] = get_avatar( $user_id );
				$staff_updates[] = array('attendee' => $user, 'status' => 'pending');
			}	
			//print_r($staff_updates);
			//print_r($attendee_staff_key);
			update_field( $attendee_staff_key, $staff_updates, $m_id );
		}
		
		if (!empty($update_attendees_clients)) {
			foreach ($update_attendees_clients as $c_attendee) {
			$client_updates[] = array('attendee_client' => $c_attendee);
			}
			//print_r($client_updates);
			//print_r($attendee_clients_key);	
			update_field( $attendee_clients_key, $client_updates, $m_id );
		}
			
		$attendees_added = true;
		
		//print_r($attendees_added);
	}
	//echo '</pre>';
}
	
?>