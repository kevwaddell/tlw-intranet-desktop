<?php
if ( isset($_POST['edit-meeting']) ) {
	global $edit_meeting_errors;
	global $meeting_updated;
	global $show_alert;
	
	$meeting_id = $_POST['meeting-id'];
	$location_id = $_POST['location-id'];
	$meeting_title = trim($_POST['meeting-title']);
	$meeting_description = trim($_POST['meeting-description']);
	$meeting_date = date('Ymd', strtotime( trim($_POST['meeting-date']) ) );
	$meeting_year = date('Y', strtotime( trim($_POST['meeting-date']) ) );
	$start_time = date('G:i', strtotime(trim($_POST['start-time'])));
	$end_time = date('G:i', strtotime(trim($_POST['end-time'])));
	$booked_by = $_POST['booked-by-id'];
	$attendees_staff_orig = get_field( 'attendees_staff', $meeting_id );
		
	//debug($start_time_orig);
	
	$p_name = $meeting_title." ".strtotime($meeting_date);
	$timeZone = 'Europe/London';
	$start_dt = new DateTime($meeting_date." ".$start_time, new DateTimeZone($timeZone));
	$end_dt = new DateTime($meeting_date." ".$end_time, new DateTimeZone($timeZone));
	$m_date = $meeting_date;
	$s_time = $start_dt->format('G:i:s');
	$e_time = $end_dt->format('G:i:s');
	$room = get_term( $location_id, 'tlw_rooms_tax' );
	
	if ( !empty($attendees_staff_orig) ) {
		foreach($attendees_staff_orig as $k => $staff) {
			if ($staff['status'] == 'accepted') {
			$attendees_staff_orig[$k]['status'] = "pending";	
			}
		}
	}
	
	if ( empty($location_id) ) {
	$edit_meeting_errors['location'] = '<span class="help-block">Please choose a meeting room.</span>';	
	}
	
	if ( empty($meeting_title) ) {
	$edit_meeting_errors['meeting-title'] = '<span class="help-block">Please enter a meeting title.</span>';	
	}
	
	if ( empty($meeting_date) ) {
	$$edit_meeting_errors['meeting-date'] = '<span class="help-block">Please choose a meeting date.</span>';	
	}
	
	if ( empty($start_time) ) {
	$edit_meeting_errors['start-time'] = '<span class="help-block">Please choose a meeting start time.</span>';	
	}
	
	if ( empty($end_time) ) {
	$edit_meeting_errors['end-time'] = '<span class="help-block">Please choose a meeting end time.</span>';	
	}	
	
	$check_args = array(
		'post_type' => 'tlw_meeting',
		'posts_per_page' => 1,
		'meta_key' => 'meeting_date',
		'meta_query' => array(
			'relation'  => 'AND',
			array('key'	=> 'meeting_date', 'value' => $meeting_date, 'compare' => '=', 'type' => 'NUMERIC'),
			array('key'	=> 'start_time', 'value' => $s_time, 'compare' => '=', 'type' => 'TIME')
		),
		'tax_query' => array( 
			array('taxonomy' => 'tlw_rooms_tax','field' => 'term_id', 'terms' => $location_id)
		)
	);
	
	$check_posts = get_posts($check_args);
	
	if (!empty($check_posts)) {
	$edit_meeting_errors['booked'] = true;		
	}
	
	//debug($edit_meeting_errors);
			
	if (empty($edit_meeting_errors)) {
		
		$meeting_description_key = acf_get_field_key('meeting_description', $meeting_id);
		$meeting_date_key = acf_get_field_key('meeting_date', $meeting_id);
		$meeting_year_key = acf_get_field_key('meeting_year', $meeting_id);
		$start_time_key = acf_get_field_key('start_time', $meeting_id);
		$end_time_key = acf_get_field_key('end_time', $meeting_id);
		$attendees_staff_key = acf_get_field_key('attendees_staff', $meeting_id);
		$attendees_clients_key = acf_get_field_key('attendees_clients', $meeting_id);
		
		wp_set_post_terms( $meeting_id, array($location_id), 'tlw_rooms_tax');
		update_field($meeting_description_key,  $meeting_description, $meeting_id); 
		update_field($meeting_date_key, $meeting_date, $meeting_id);  
		update_field($meeting_year_key, $meeting_year, $meeting_id);  
		update_field($start_time_key, $s_time, $meeting_id);   
		update_field($end_time_key, $e_time, $meeting_id); 
		update_field($attendees_staff_key, $attendees_staff_orig, $meeting_id);
		
		$meeting_updated = true;
		$show_alert = true;
		
	}
	
}
?>