<?php
global $add_meeting_errors;
if ( isset($_POST['add-meeting']) ) {
	
	$location_id = $_POST['location-id'];
	$meeting_title = trim($_POST['meeting-title']);
	$meeting_description = trim($_POST['meeting-description']);
	$meeting_date = date('Ymd', strtotime( trim($_POST['meeting-date']) ) );
	$start_time = date('G:i', strtotime(trim($_POST['start-time'])));
	$end_time = date('G:i', strtotime(trim($_POST['end-time'])));
	$attendees_internal = $_POST['attendees-internal'];
	$attendees_clients = trim($_POST['attendees-clients']);
	$booked_by = $_POST['booked-by-id'];
	$meeting_approved = $_POST['meeting-approved'];
	
	if ( empty($meeting_title) ) {
	$add_meeting_errors['meeting-title'] = '<span class="help-block">Please enter a meeting title.</span>';	
	}
	
	if ( empty($meeting_date) ) {
	$add_meeting_errors['meeting-date'] = '<span class="help-block">Please choose a meeting date.</span>';	
	}
	
	if ( empty($start_time) ) {
	$add_meeting_errors['start-time'] = '<span class="help-block">Please choose a meeting start time.</span>';	
	}
	
	if ( empty($end_time) ) {
	$add_meeting_errors['end-time'] = '<span class="help-block">Please choose a meeting end time.</span>';	
	}	
	if (empty($add_meeting_errors)) {
	$p_name = $meeting_title." ".strtotime($meeting_date);
	$timeZone = 'Europe/London';
	$start_dt = new DateTime($meeting_date." ".$start_time, new DateTimeZone($timeZone));
	$end_dt = new DateTime($meeting_date." ".$end_time, new DateTimeZone($timeZone));
	$m_date = $meeting_date;
	$s_time = $start_dt->format('Y-m-d G:i:s');
	$e_time = $end_dt->format('Y-m-d G:i:s');
	
		$add_meeting_args = array(
		'post_name' => sanitize_title($p_name),
		'post_title' => wp_strip_all_tags($meeting_title),
		'post_status'   => 'publish',
		'post_author'   => $booked_by,
		'post_type'     => 'tlw_meeting'
		);
		
		$m_id = wp_insert_post($add_meeting_args);
		
		if ($m_id) {
		wp_set_post_terms( $m_id, array($location_id), 'tlw_rooms_tax');
		add_post_meta($m_id, '_meeting_description', 'field_5395d707861af'); 
		add_post_meta($m_id, 'meeting_description', $meeting_description); 
		add_post_meta($m_id, '_meeting_date', 'field_533be32c54fbc');  
		add_post_meta($m_id, 'meeting_date', $meeting_date);  
		add_post_meta($m_id, '_start_time', 'field_533be5353ffec');  
		add_post_meta($m_id, 'start_time', $s_time);  
		add_post_meta($m_id, '_end_time', 'field_533be5d13ffed'); 
		add_post_meta($m_id, 'end_time', $e_time); 
		add_post_meta($m_id, '_meeting_approved', 'field_59db5f47c611e'); 
		add_post_meta($m_id, 'meeting_approved', $meeting_approved); 
		}
		
	}
}
?>