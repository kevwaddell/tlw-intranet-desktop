<?php 
//echo '<pre>';print_r($slug);echo '</pre>';

	if ($slug == 'office-news' || $slug == 'company-news') {
	$add_post_pg = get_page_by_title("Add Article");	
	}
	
	if ($slug == 'events') {
	$add_post_pg = get_page_by_title("Add Event");	
	}
	
	if ($slug == 'announcements') {
	$add_post_pg = get_page_by_title("Add Announcement");	
	}
	
?>

<a href="<?php echo get_permalink($add_post_pg->ID); ?>?httpref=<?php echo urlencode(get_category_link( $cat_id )); ?>&catid=<?php echo $cat_id; ?>" title="<?php echo $add_post_pg->post_title; ?>" class="btn btn-default btn-block"><?php echo $add_post_pg->post_title; ?><i class="fa fa-plus-circle fa-lg"></i></a>
