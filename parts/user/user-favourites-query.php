<?php 
$favs = unserialize( get_user_meta($current_user->ID, 'user_favourites', true) );	
$original_favs = $favs;

foreach ($favs as $key => $fav) {
$item = get_post($fav['post_id']);
	if (!$item) {
		unset($favs[$key]);
	}

}
		
$diff_favs = array_diff($original_favs, $favs);
	
if (count($diff_favs) > 0) {
$user_meta_update = update_user_meta( $current_user->ID, 'user_favourites', serialize($favs) );	
$favs = unserialize( get_user_meta($current_user->ID, 'user_favourites', true) );
}

$fav_ids = array();
$fav_types = array();

$fav_args = array(
'posts_per_page'	=> -1,
'order'	=> 'DESC',
'orderby' => 'date'
);

foreach ($favs as $fav) {
	
	if (!in_array($fav['post_id'], $fav_ids)) {
		
		if (!isset($_GET['fav_sortby'])) {
		array_push($fav_ids, $fav['post_id']);	
		} else {
			
			if ($_GET['fav_sortby'] == $fav['post_type'] && $_GET['fav_sortby'] == 'tlw_meeting') {
			array_push($fav_ids, $fav['post_id']);		
			}	
			
			if ($_GET['fav_sortby'] == $fav['post_type'] && $_GET['fav_sortby'] == 'post') {
			$cats = wp_get_post_categories( $fav['post_id'], 'fields=slugs' );
			
				if (in_array($_GET['cat'], $cats)) {
				array_push($fav_ids, $fav['post_id']);	
				}
				
			}	
		}
	}
	
	if (!in_array($fav['post_type'], $fav_types)) {
	array_push($fav_types, $fav['post_type']);
	}	
}

//echo '<pre>';print_r($fav_ids);echo '</pre>';
	
$your_fav_ids = $fav_ids;

if (!isset($_GET['fav_sortby'])) {
$fav_args['post_type'] = $fav_types;
}

if (isset($_GET['fav_sortby'])) {

	if ($_GET['fav_sortby'] == 'tlw_meeting') {
	$fav_args['post_type'] = 'tlw_meeting';	
	}
	
	if ($_GET['fav_sortby'] == 'post') {
	$fav_args['post_type'] = 'post';
	$fav_args['category_name'] = $_GET['cat'];
	}
}

if (!empty($fav_ids)) {
$favs_max_num_pages = ceil( count($fav_ids)/10);

	if (isset($_GET['fav_pg'])) {
	$slice_from = 10 * ($_GET['fav_pg'] - 1);
	$fav_ids = array_slice($fav_ids, $slice_from , 10);	
	} else {
	$fav_ids = array_slice($fav_ids, 0 , 10);	
	}

$fav_args['post__in' ] = $fav_ids;
}
$favs_query = new WP_Query( $fav_args );
//echo '<pre>';print_r($favs_query);echo '</pre>';
 ?>