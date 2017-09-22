<?php
$today = date('Ymd', strtotime("today"));	
$next_month = date('Ymd', strtotime("2 months"));	

$feat_cat_args = array(
'posts_per_page' => 3,
'category'	=> $cat_id
);

if ($slug == 'events') {	
	
	$feat_cat_args['posts_per_page'] = -1;
	$feat_cat_args['meta_key'] = 'event_date';
	$feat_cat_args['orderby'] = 'meta_value_num';
	$feat_cat_args['order'] = 'ASC';
	
	$feat_cat_args['meta_query'] = array(
		'relation' => 'AND',
		array(
			'key' => 'event_date',
			'value' => $today,
			'compare' => '>=',
			'type' => 'NUMERIC'
		),
		array(
			'key' => 'event_date',
			'value' => $next_month,
			'compare' => '<',
			'type' => 'NUMERIC'
		)
	);
}

$feat_cats = get_posts($feat_cat_args);

//echo '<pre>';print_r($feat_cats);echo '</pre>';

foreach ($feat_cats as $feat_cat) {
	
	if (!in_array($feat_cat->ID, $exclude_posts)) {
		array_push($exclude_posts, $feat_cat->ID);
	}
}

if ( count($exclude_posts) == 0 ) {
$posts_per_page = 10;
} else {
$posts_per_page = get_query_var('posts_per_page');	
}

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$args = array(
'posts_per_page' => $posts_per_page,
'cat'	=> $cat_id,
'paged'	=> $paged
);

if ($slug != 'events') {
$args['post__not_in'] = $exclude_posts;
}

if ($slug == 'events') {
	$args['meta_key'] = 'event_date';
	$args['orderby'] = 'meta_value_num';
	$args['meta_query'] = array(
		array(
			'key' => 'event_date',
			'value' => $today,
			'compare' => '<',
			'type' => 'NUMERIC'
		)
	);
}

$wp_query = NULL;
$wp_query = new WP_Query( $args );

/*
echo '<pre>';
print_r($exclude_posts);
echo '<br>';
print_r($post_count);
echo '</pre>';
*/

//echo '<pre>';print_r($wp_query);echo '</pre>';

 ?>