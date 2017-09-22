<?php
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$posts_per_page = 10;
$today = date('Ymd', strtotime("today"));
$tomorrow = date('Ymd', strtotime("tomorrow"));
$this_wk_strt = strtotime("Monday this week");
$this_wk_end = strtotime("Friday this week");
$next_wk_strt = strtotime("Monday next week");
$next_wk_end = strtotime("Friday next week");
$this_month_strt = strtotime("first day of this month");
$this_month_end = strtotime("last day of this month");
$next_month_strt = strtotime("first day of next month");
$next_month_end = strtotime("last day of next month");

//echo '<pre>';print_r($this_month_end);echo '</pre>';

$holidays_args = array(
'post_type' => 'tlw_holiday',
'post_status'	=> 'publish',
'posts_per_page' => $posts_per_page,
'order'	=> 'DESC',
'meta_key'	=> 'holiday_start_date',
'orderby' => 'meta_value_num',
'paged'	=> $paged
);

if (!isset($_GET['holiday_sortby'])) {
	$holidays_args['meta_query'] = array(
		
		'relation' => 'AND',
		array(
			'key' => 'holiday_start_date',
			'value' => $today,
			'compare' => '<=',
			'type' => 'NUMERIC'
		),
		array(
			'key' => 'holiday_end_date',
			'value' => $today,
			'compare' => '>=',
			'type' => 'NUMERIC'
		)
	);
}

if (isset($_GET['holiday_sortby']) && $_GET['holiday_sortby'] == "tomorrow") {
	$holidays_args['order'] = 'ASC';
	$holidays_args['meta_query'] = array(
		'relation' => 'AND',
		array(
			'key' => 'holiday_start_date',
			'value' => $tomorrow,
			'compare' => '<=',
			'type' => 'NUMERIC'
		),
		array(
			'key' => 'holiday_end_date',
			'value' => $tomorrow,
			'compare' => '>=',
			'type' => 'NUMERIC'
		)
	);
}

if (isset($_GET['holiday_sortby']) && $_GET['holiday_sortby'] == "this-week") {
	$holidays_args['order'] = 'ASC';
	$holidays_args['meta_query'] = array(
		'relation' => 'AND',
		array(
			'key' => 'holiday_start_date',
			'value' => $this_wk_end,
			'compare' => '<=',
			'type' => 'NUMERIC'
		),
		array(
			'key' => 'holiday_end_date',
			'value' => $this_wk_strt,
			'compare' => '>=',
			'type' => 'NUMERIC'
		)
	);
}

if (isset($_GET['holiday_sortby']) && $_GET['holiday_sortby'] == "next-week") {
	$holidays_args['order'] = 'ASC';
	$holidays_args['meta_query'] = array(
		'relation' => 'AND',
		array(
			'key' => 'holiday_start_date',
			'value' => $next_wk_end,
			'compare' => '<=',
			'type' => 'NUMERIC'
		),
		array(
			'key' => 'holiday_end_date',
			'value' => $next_wk_strt,
			'compare' => '>=',
			'type' => 'NUMERIC'
		)
	);
}

if (isset($_GET['holiday_sortby']) && $_GET['holiday_sortby'] == "this-month") {
	$holidays_args['order'] = 'ASC';
	$holidays_args['meta_query'] = array(
		'relation' => 'AND',
		array(
			'key' => 'holiday_start_date',
			'value' => $this_month_end,
			'compare' => '<=',
			'type' => 'NUMERIC'
		),
		array(
			'key' => 'holiday_end_date',
			'value' => $this_month_strt,
			'compare' => '>=',
			'type' => 'NUMERIC'
		)

	);
}


if (isset($_GET['holiday_sortby']) && $_GET['holiday_sortby'] == "next-month") {
	$holidays_args['order'] = 'ASC';
	$holidays_args['meta_query'] = array(
		'relation' => 'AND',
		array(
			'key' => 'holiday_start_date',
			'value' => $next_month_end,
			'compare' => '<=',
			'type' => 'NUMERIC'
		),
		array(
			'key' => 'holiday_end_date',
			'value' => $next_month_strt,
			'compare' => '>=',
			'type' => 'NUMERIC'
		)

	);
}

$holidays = new WP_Query($holidays_args);
$holidays_post_count = $holidays->found_posts;
$max_num_pages = $holidays->max_num_pages;

$pending_holidays_args = array(
'post_type' => 'tlw_holiday',
'post_status'	=> 'pending',
'posts_per_page' => $posts_per_page,
'order'	=> 'DESC',
'meta_key'	=> 'holiday_start_date',
'orderby' => 'meta_value_num',
'paged'	=> $paged,
'meta_query' => array(
		array(
			'key' => 'holiday_start_date',
			'value' => $today,
			'compare' => '>',
			'type' => 'NUMERIC'
		)
	)
);

$pending_hoidays = new WP_Query($pending_holidays_args);
$pending_holidays_post_count = $pending_hoidays->found_posts;
$pending_max_num_pages = $pending_hoidays->max_num_pages;

//echo '<pre>';print_r($pending_hoidays);echo '</pre>'; 

 ?>