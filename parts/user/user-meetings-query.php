<?php 
$today_start = strtotime("Today 08:00");
$today_end = strtotime("Today 18:00");

$post_type = "tlw_meeting";
$your_meetings = array();
$your_meeting_ids = array();

$meetings_args = array(
'post_type' => $post_type,
'posts_per_page' => -1,
'order'	=> 'ASC',
'meta_key'	=> 'start_time',
'orderby' => 'meta_value_num'
);

if (!isset($_GET['sortby'])) {
	$meetings_args['post_status'] = 'publish';
	$meetings_args['meta_query'] = array(
		'relation' => 'AND',
		array(
			'key' => 'start_time',
			'value' => $today_start,
			'compare' => '>'
		),
		array(
			'key' => 'end_time',
			'value' => $today_end,
			'compare' => '<'
		)
	);
}

/* PENDING ARGS */
if (isset($_GET['sortby']) && $_GET['sortby'] == "pending") {
	$meetings_args['post_status'] = 'pending';
	$meetings_args['meta_query'] = array(
		array(
			'key' => 'start_time',
			'value' => $today_start,
			'compare' => '>'
		)
	);
}

/* FUTURE ARGS */
if (isset($_GET['sortby']) && $_GET['sortby'] == "future") {
	$meetings_args['post_status'] = 'publish';
	$meetings_args['meta_query'] = array(
		'relation' => 'AND',
		array(
			'key' => 'start_time',
			'value' => $today_end,
			'compare' => '>'
		)
	);
}
/* PAST ARGS */
if (isset($_GET['sortby']) && $_GET['sortby'] == "past") {
	
	$meetings_args['post_status'] = 'publish';
	$meetings_args['order'] = 'DESC';
	
	$meetings_args['meta_query'] = array(
		'relation' => 'AND',
		array(
			'key' => 'start_time',
			'value' => $today_start,
			'compare' => '<'
		)
	);
}

/* CANCELED ARGS */
if (isset($_GET['sortby']) && $_GET['sortby'] == "canceled") {
	$meetings_args['post_status'] = 'draft';
	$meetings_args['order'] = 'ASC';
	
	$meetings_args['meta_query'] = array(
		'relation' => 'AND',
		array(
			'key' => 'start_time',
			'value' => $today_start,
			'compare' => '>'
		)
	);
}

/* ALL ARGS */
if (isset($_GET['sortby']) && $_GET['sortby'] == "all") {
	$meetings_args['post_status'] = array('publish','pending','draft');
	$meetings_args['order'] = 'DESC';	
}

$meetings = get_posts($meetings_args);

foreach ($meetings as $meet) {
	
	$staff_attendees = get_field('attendees_staff', $meet->ID);
	
	foreach ($staff_attendees as $staff_attendee) {
		if ($staff_attendee[attendee_staff][ID] == $user_id && $staff_attendee[status] == 'accepted' || $staff_attendee[status] == 'pending') {
			if (!in_array($meet->ID, $your_meeting_ids)) {
				array_push($your_meeting_ids, $meet->ID);	
			}
		}
	}
	
	if ($meet->post_author == $user_id && !in_array($meet->ID, $your_meeting_ids)) {	
	array_push($your_meeting_ids, $meet->ID);
	}		
}

if (!empty($your_meeting_ids)) {
$meetings_max_num_pages = ceil( count($your_meeting_ids)/10);

	if (isset($_GET['pg'])) {
	$slice_from = 10 * ($_GET['pg'] - 1);
	$meeting_ids = array_slice($your_meeting_ids, $slice_from , 10);	
	} else {
	$meeting_ids = array_slice($your_meeting_ids, 0 , 10);	
	}

$meetings_args['post__in' ] = $meeting_ids;
} else {
$meetings_args['author'] = $user_id;
}

$meetings_query = new WP_Query( $meetings_args );
//echo '<pre>';print_r($meetings_args);echo '</pre>';

 ?>