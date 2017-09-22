<?php if ( $_GET['action'] == 'remove_all_favs') {  
	
	$page_url = explode("?", $_SERVER['REQUEST_URI']);
	$message = "items";
	
	if ($_GET['type'] == 'tlw_meeting' && $fav->post_type == $_GET['type']) {
	$message = "meetings";
	}
	
	if ( isset($_GET['cat']) ) {
	$cat = get_category_by_slug( $_GET['cat'] );
	$message = $cat->name;
	}
	
	$favs = unserialize(get_user_meta($current_user->ID, 'user_favourites', true));
	//echo '<pre>';
	//print_r($cat);
	
	foreach ($favs as $key => $val) {
		$fav = get_post($val['post_id']);
		
		if ($_GET['type'] == 'tlw_meeting' && $fav->post_type == $_GET['type']) {
			if ( in_array_r($fav->ID,  $favs) ) {
			unset($favs[$key]);
			//print_r($favs[$key]);
			//echo '<br>';
			}	
		}
		
		if (isset($_GET['cat'])) {
		$post_cat = get_the_category( $val['post_id'] );
		//unset($favs[$key]);
		//print_r($post_cat);
		if ($post_cat[0]->slug == $_GET['cat'] && in_array_r($fav->ID,  $favs)) {
		unset($favs[$key]);
		//print_r($key);
		//echo '<br>';
		}
		
		}
	}
	//print_r($favs);
	//echo '</pre>';
	
	update_user_meta( $current_user->ID, 'user_favourites', serialize($favs) );
?>

<div class="alert alert-success text-center">
	
	<h4><i class="fa fa-check-circle fa-lg"></i> Success</h4>
	
	All <strong><?php echo $message;?></strong> has been removed from your favourites.<br><br>
	
	<div class="action-btns">
		<a href="<?php echo $page_url[0]; ?>" class="btn btn-success btn-block">Continue</a>
	</div>

</div>

<?php } ?>