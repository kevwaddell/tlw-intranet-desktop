<?php 
$post_type = "tlw_meeting";
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$posts_per_page = get_query_var('posts_per_page');

//echo '<pre>';print_r($posts_per_page);echo '</pre>';

/* MAIN QUERY */

$args = array(
'post_type' => $post_type,
'posts_per_page' => $posts_per_page,
'order'	=> 'ASC',
'meta_key'	=> 'start_time',
'orderby' => 'meta_value_num',
'paged'	=> $paged
);

/* TODAY QUERY */

if (!isset($_GET['sortby'])) {
	$args['post_status'] = 'publish';
	$args['meta_query'] = array(
		'relation' => 'AND',
		array(
			'key' => 'start_time',
			'value' => $today_start,
			'compare' => '>',
			'type'	=> 'NUMERIC'
		),
		array(
			'key' => 'end_time',
			'value' => $today_end,
			'compare' => '<',
			'type'	=> 'NUMERIC'
		)
	);
}

/* PENDING ARGS */
if (isset($_GET['sortby']) && $_GET['sortby'] == "pending") {
	$args['post_status'] = 'pending';
	$args['meta_query'] = array(
		array(
			'key' => 'start_time',
			'value' => $today_start,
			'compare' => '>',
			'type'	=> 'NUMERIC'
		)
	);
}

/* FUTURE ARGS */
if (isset($_GET['sortby']) && $_GET['sortby'] == "future") {
	$args['post_status'] = 'publish';
	$args['meta_query'] = array(
		array(
			'key' => 'start_time',
			'value' => $today_end,
			'compare' => '>',
			'type'	=> 'NUMERIC'
		)
	);
}

/* PAST ARGS */
if (isset($_GET['sortby']) && $_GET['sortby'] == "past") {
	
	$args['post_status'] = 'publish';
	$args['order'] = 'DESC';
	
	$args['meta_query'] = array(
		array(
			'key' => 'start_time',
			'value' => $today_start,
			'compare' => '<',
			'type'	=> 'NUMERIC'
		)
	);
}

/* CANCELED ARGS */
if (isset($_GET['sortby']) && $_GET['sortby'] == "canceled") {
	$args['post_status'] = 'draft';
	$args['order'] = 'ASC';
	
	$args['meta_query'] = array(
		array(
			'key' => 'start_time',
			'value' => $today_start,
			'compare' => '>'
		)
	);
}

/* ALL ARGS */
if (isset($_GET['sortby']) && $_GET['sortby'] == "all") {
	$args['post_status'] = array('publish','pending','draft');
	$args['order'] = 'DESC';	
}


if (isset($_GET['meetingid']) && $_GET['request'] == "booking_request" && is_user_logged_in()) {
$args['posts_per_page'] = 1;	
$args['p'] = $_GET['meetingid'];
}

//echo '<pre>';print_r($args);echo '</pre>';

$main_query = new WP_Query( $args );
$main_post_count = $main_query->found_posts;

$max_num_pages = $main_query->max_num_pages;

//echo '<pre>';print_r($main_query);echo '</pre>';
 ?>