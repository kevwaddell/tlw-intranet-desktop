<?php

$holidays_args = array(
'post_type' => 'tlw_holiday',
'posts_per_page' => -1,
'author'	=> $curauth->ID,
'order'	=> 'DESC',
'meta_key'	=> 'holiday_start_date',
'orderby' => 'meta_value_num',
);

//echo '<pre>';print_r($holidays_args);echo '</pre>';

if (!isset($_GET['holiday_sortby'])) {
	$holidays_args['post_status'] = 'publish';
	$holidays_args['meta_query'] = array(
		
		'relation' => 'AND',
		array(
			'key' => 'holiday_start_date',
			'value' => $start_of_year,
			'compare' => '>'
		),
		array(
			'key' => 'holiday_end_date',
			'value' => $end_of_year,
			'compare' => '<'
		)
	);
}
if (isset($_GET['holiday_sortby']) && $_GET['holiday_sortby'] == "next-year") {
	$holidays_args['post_status'] = 'publish';
	$holidays_args['order'] = 'ASC';
	$holidays_args['meta_query'] = array(
		
		'relation' => 'AND',
		array(
			'key' => 'holiday_start_date',
			'value' => $end_of_year,
			'compare' => '>'
		),
		array(
			'key' => 'holiday_end_date',
			'value' => $end_of_nxt_year,
			'compare' => '<'
		)
	);
}

if (isset($_GET['holiday_sortby']) && $_GET['holiday_sortby'] == "pending") {
	$holidays_args['post_status'] = 'pending';
	$holidays_args['order'] = 'ASC';
	$holidays_args['meta_query'] = array(
		
		'relation' => 'AND',
		array(
			'key' => 'holiday_start_date',
			'value' => $today,
			'compare' => '>'
		),
		array(
			'key' => 'holiday_end_date',
			'value' => $end_of_nxt_year,
			'compare' => '<'
		)
	);
}

if (isset($_GET['holiday_sortby']) && $_GET['holiday_sortby'] == "canceled") {
	$holidays_args['post_status'] = 'draft';
	$holidays_args['order'] = 'ASC';
	$holidays_args['meta_query'] = array(
		
		'relation' => 'AND',
		array(
			'key' => 'holiday_start_date',
			'value' => $start_of_year,
			'compare' => '>'
		),
		array(
			'key' => 'holiday_end_date',
			'value' => $end_of_nxt_year,
			'compare' => '<'
		)
	);
}

if (isset($_GET['holiday_sortby']) && $_GET['holiday_sortby'] == "all") {
	$holidays_args['post_status'] = array('draft', 'publish', 'pending');
	$holidays_args['meta_query'] = array(
		
		'relation' => 'AND',
		array(
			'key' => 'holiday_start_date',
			'value' => $start_of_year,
			'compare' => '>'
		),
		array(
			'key' => 'holiday_end_date',
			'value' => $end_of_nxt_year,
			'compare' => '<'
		)
	);
}

$holidays = get_posts($holidays_args);
//echo '<pre>';print_r($holidays_args);echo '</pre>';

 ?>