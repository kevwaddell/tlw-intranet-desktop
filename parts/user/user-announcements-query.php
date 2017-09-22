<?php 
$your_announce_ids = array();

$announce_args = array(
'post_type' => 'post',
'posts_per_page' => -1,
'order'	=> 'DESC',
'orderby' => 'date',
'author'=> $user_id,
'category_name'	=> 'announcements'
);

if (!isset($_GET['an_sortby'])) {
$announce_args['post_status'] = array('pending', 'publish', 'draft');
}

if (isset($_GET['an_sortby']) && $_GET['an_sortby'] == 'publish') {
$announce_args['post_status'] = 'publish';
}

if (isset($_GET['an_sortby']) && $_GET['an_sortby'] == 'pending') {
$announce_args['post_status'] = 'pending';
}

if (isset($_GET['an_sortby']) && $_GET['an_sortby'] == 'draft') {
$announce_args['post_status'] = 'draft';
}

$announcments = get_posts($announce_args);

foreach ($announcments as $an) {
	
	if (!in_array($an->ID, $your_announce_ids)) {	
	array_push($your_announce_ids, $an->ID);
	}		
}

//echo '<pre>';print_r($your_announce_ids);echo '</pre>';

if (!empty($your_announce_ids)) {
$announce_max_num_pages = ceil( count($your_announce_ids)/10);

	if (isset($_GET['an_pg'])) {
	$slice_from = 10 * ($_GET['an_pg'] - 1);
	$announce_ids = array_slice($your_announce_ids, $slice_from , 10);	
	} else {
	$announce_ids = array_slice($your_announce_ids, 0 , 10);	
	}

$announce_args['post__in' ] = $announce_ids;
}

$announce_query = new WP_Query( $announce_args );
 ?>