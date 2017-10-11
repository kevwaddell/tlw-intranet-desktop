<?php
global $add_meeting_errors;
if ( isset($_POST['add-meeting']) ) {
	
	$location_id = $_POST['location-id'];
	$meeting_title = trim($_POST['meeting-title']);
	$meeting_description = trim($_POST['meeting-description']);
	$meeting_date = date('Ymd', strtotime( trim($_POST['meeting-date']) ) );
	$meeting_year = date('Y', strtotime( trim($_POST['meeting-date']) ) );
	$start_time = date('G:i', strtotime(trim($_POST['start-time'])));
	$end_time = date('G:i', strtotime(trim($_POST['end-time'])));
	$booked_by = $_POST['booked-by-id'];
	
	$p_name = $meeting_title." ".strtotime($meeting_date);
	$timeZone = 'Europe/London';
	$start_dt = new DateTime($meeting_date." ".$start_time, new DateTimeZone($timeZone));
	$end_dt = new DateTime($meeting_date." ".$end_time, new DateTimeZone($timeZone));
	$m_date = $meeting_date;
	$s_time = $start_dt->format('G:i:s');
	$e_time = $end_dt->format('G:i:s');
	$room = get_term( $location_id, 'tlw_rooms_tax' );
	
	if ( empty($location_id) ) {
	$add_meeting_errors['location'] = '<span class="help-block">Please choose a meeting room.</span>';	
	}
	
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
	$add_meeting_errors['booked'] = true;		
	}
	
	//debug($add_meeting_errors);
			
	if (empty($add_meeting_errors)) {
	
		$add_meeting_args = array(
		'post_name' => sanitize_title($p_name),
		'post_title' => wp_strip_all_tags($meeting_title),
		'post_status'   => 'publish',
		'post_author'   => $booked_by,
		'post_type'     => 'tlw_meeting'
		);
		
		//debug($add_meeting_args);
		
		$meeting_added = wp_insert_post($add_meeting_args);
		$meeting_description_key = acf_get_field_key('meeting_description', $meeting_added);
		$meeting_date_key = acf_get_field_key('meeting_date', $meeting_added);
		$meeting_year_key = acf_get_field_key('meeting_year', $meeting_added);
		$start_time_key = acf_get_field_key('start_time', $meeting_added);
		$end_time_key = acf_get_field_key('end_time', $meeting_added);
		$attendees_staff_key = acf_get_field_key('attendees_staff', $meeting_added);
		$attendees_clients_key = acf_get_field_key('attendees_clients', $meeting_added);
		
		if ($meeting_added) {
		wp_set_post_terms( $meeting_added, array($location_id), 'tlw_rooms_tax');
		add_post_meta($meeting_added, '_meeting_description', $meeting_description_key); 
		add_post_meta($meeting_added, 'meeting_description', $meeting_description); 
		add_post_meta($meeting_added, '_meeting_date', $meeting_date_key);  
		add_post_meta($meeting_added, 'meeting_date', $meeting_date); 
		add_post_meta($meeting_added, '_meeting_year', $meeting_year_key); 
		add_post_meta($meeting_added, 'meeting_year', $meeting_year); 
		add_post_meta($meeting_added, '_start_time', $start_time_key);  
		add_post_meta($meeting_added, 'start_time', $s_time);  
		add_post_meta($meeting_added, '_end_time', $end_time_key); 
		add_post_meta($meeting_added, 'end_time', $e_time); 
		add_post_meta($meeting_added, '_attendees_staff', $attendees_staff_key);
		add_post_meta($meeting_added, 'attendees_staff', '');
		add_post_meta($meeting_added, '_attendees_clients', $attendees_clients_key);
		add_post_meta($meeting_added, 'attendees_clients', '');
		}
		
	}
	
}
?>