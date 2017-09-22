<?php 
$your_events_ids = array();

$events_args = array(
'post_type' => 'post',
'posts_per_page' => -1,
'order'	=> 'DESC',
'orderby' => 'date',
'author'=> $user_id,
'category_name'	=> 'events'
);

if (!isset($_GET['events_sortby'])) {
$events_args['post_status'] = array('pending', 'publish', 'draft');
}

if (isset($_GET['events_sortby']) && $_GET['events_sortby'] == 'publish') {
$events_args['post_status'] = 'publish';
}

if (isset($_GET['events_sortby']) && $_GET['events_sortby'] == 'pending') {
$events_args['post_status'] = 'pending';
}

if (isset($_GET['events_sortby']) && $_GET['events_sortby'] == 'draft') {
$events_args['post_status'] = 'draft';
}

$events = get_posts($events_args);

foreach ($events as $event) {
	
	if (!in_array($event->ID, $your_events_ids)) {	
	array_push($your_events_ids, $event->ID);
	}		
}

//echo '<pre>';print_r($your_events_ids);echo '</pre>';

if (!empty($your_events_ids)) {
$events_max_num_pages = ceil( count($your_events_ids)/10);

	if (isset($_GET['ev_pg'])) {
	$slice_from = 10 * ($_GET['ev_pg'] - 1);
	$event_ids = array_slice($your_events_ids, $slice_from , 10);	
	} else {
	$event_ids = array_slice($your_events_ids, 0 , 10);	
	}

$events_args['post__in' ] = $event_ids;
}

$events_query = new WP_Query( $events_args );
 ?>