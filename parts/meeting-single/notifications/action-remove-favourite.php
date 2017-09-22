<?php if ( isset($_GET['action']) && $_GET['action'] == 'remove_from_favs') {  
	
	$favs = unserialize(get_user_meta($current_user->ID, 'user_favourites', true));

	if ( in_array_r($_GET['postid'],  $favs) ) {
	
		foreach ($favs as $key => $val) {
			
			if ($val['post_id'] == $_GET['postid']) {
			unset($favs[$key]);
			print_r($key); echo ' = '; print_r($val);	
			echo '<br>';
			}
		}
		
	}
	
	update_user_meta( $current_user->ID, 'user_favourites', serialize($favs) );
?>

<div class="alert alert-success text-center">
	
<strong><?php echo $post->post_title; ?></strong><br>has been removed from your favourites.<br><br>
	
	<div class="action-btns">
		<a href="<?php the_permalink(); ?>" class="btn btn-success btn-block">Continue</a>
	</div>

</div>

<?php } ?>