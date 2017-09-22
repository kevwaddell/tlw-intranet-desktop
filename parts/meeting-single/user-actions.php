<div class="post-actions">
		
	<a href="javascript:window.print()" title="Print page" class="btn"><span>Print</span><i class="fa fa-print fa-lg"></i></a>
	
	<?php if (is_user_logged_in()) { ?>
	<?php if (in_array_r(get_the_ID(),  $user_favs)) { ?>
	<a href="?request=remove_from_favs&postid=<?php the_ID(); ?>" class="btn active" title="Remove Favourite"><span>Remove Favourite</span><i class="fa fa-star fa-lg"></i></a>
	<?php } else { ?>
	<a href="?request=add_to_favs&postid=<?php the_ID(); ?>&type=<?php echo $post->post_type; ?>" class="btn" title="Add to Favourites"><span>Add to Favourites</span><i class="fa fa-star fa-lg"></i></a>
	<?php } ?>
	<?php } ?>
	
</div>