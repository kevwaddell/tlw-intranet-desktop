<div class="post-actions">
		
	<a href="javascript:window.print()" title="Print page" class="btn"><span>Print</span><i class="fa fa-print fa-lg"></i></a>
	
	<?php if (is_user_logged_in()) { 
		if ($cat[0]->slug == 'office-news' || $cat[0]->slug == 'company-news') {
		$add_post_pg = get_page_by_title("Add Article");	
		}
		
		if ($cat[0]->slug == 'events') {
		$add_post_pg = get_page_by_title("Add Event");	
		}
		
		if ($cat[0]->slug == 'announcements') {
		$add_post_pg = get_page_by_title("Add Announcement");	
		}
		
	?>
	<?php if (in_array_r(get_the_ID(),  $user_favs)) { ?>
	<a href="?request=remove_from_favs&postid=<?php the_ID(); ?>" class="btn active" title="Remove Favourite"><span>Remove Favourite</span><i class="fa fa-star fa-lg"></i></a>
	<?php } else { ?>
	<a href="?request=add_to_favs&postid=<?php the_ID(); ?>&type=<?php echo $post->post_type; ?>" class="btn" title="Add to Favourites"><span>Add to Favourites</span><i class="fa fa-star fa-lg"></i></a>
	<?php } ?>
	
	<?php if (current_user_can("administrator") || current_user_can("editor") ) : ?>
	<a href="<?php echo get_permalink($add_post_pg->ID); ?>?httpref=<?php urlencode(the_permalink()); ?>" title="Add Post" class="btn"><span><?php echo $add_post_pg->post_title; ?></span><i class="fa fa-plus-circle fa-lg"></i></a>
	<?php endif; ?>
	
	<?php } ?>
	
	<?php if (current_user_can("administrator") || current_user_can("editor") ) { ?>
	<a href="<?php the_permalink(); ?>?edit_request=edit_post&userid=<?php echo $current_user->ID; ?>" title="Edit Post" class="btn"><span>Edit Post</span><i class="fa fa-pencil fa-lg"></i></a>
	
	<?php } ?>
	
</div>