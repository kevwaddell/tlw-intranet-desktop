<?php if ( $_GET['action'] == 'remove_from_favs') {  
	
	$page_url = explode("?", $_SERVER['REQUEST_URI']);
	
	$favs = unserialize(get_user_meta($current_user->ID, 'user_favourites', true));
	
	$fav_post = get_post($_GET['postid']);

	if ( in_array_r($fav_post->ID,  $favs) ) {
	
		foreach ($favs as $key => $val) {
			
			if ($val['post_id'] == $fav_post->ID) {
			unset($favs[$key]);
			}
		}
		
	}
	
	update_user_meta( $current_user->ID, 'user_favourites', serialize($favs) );
?>

<div class="alert alert-success text-center">
	
	<h4><i class="fa fa-check-circle fa-lg"></i> Success</h4>
	
	<strong><?php echo $fav_post->post_title; ?></strong><br>has been removed from your favourites.<br><br>
	
	<div class="action-btns">
		<a href="<?php echo $page_url[0]; ?>" class="btn btn-success btn-block">Continue</a>
	</div>

</div>

<?php } ?>