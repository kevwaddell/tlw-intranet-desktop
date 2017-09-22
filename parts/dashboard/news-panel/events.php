<div id="carousel-events-news" class="carousel slide" data-ride="carousel">
  
  <?php if (count($events) > 1) { ?>
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <?php for ($ev = 0; $ev < count($events); $ev++) { ?>
	<li data-target="#carousel-events-news" data-slide-to="<?php echo $ev; ?>"<?php echo ($ev == 0) ? ' class="active"':''; ?>></li>
  	<?php } ?>
  </ol>
  <?php } ?>
  
  <!-- Wrapper for slides -->
  <div class="carousel-inner">
  
  <?php 
  global $post;
  foreach ($events as $post) : 
  setup_postdata($post);  
  $event_date_raw = get_field('event_date');
  $event_date = date("F j, Y", strtotime($event_date_raw ));
  $event_time = get_field('event_time');
  $event_time_end = get_field('event_time_end');
  
  	if (has_post_thumbnail()) {
	$post_thumbnail_id = get_post_thumbnail_id();
	$img_src = wp_get_attachment_image_src($post_thumbnail_id, 'img-3-col-crop');		
  	} else {
  	$img_src = wp_get_attachment_image_src($events_feat_img['id'], 'img-3-col-crop'); 	
  	}
  	$img_url =  $img_src[0];
  	
  	//echo '<pre>';print_r($img_url);echo '</pre>';
  ?>
  
  	<?php if ($post == reset($events)) { ?>
  	<div class="item active">
  	<?php } else { ?>
  	<div class="item">
  	<?php } ?>
  		
    	<div class="row">
    		<div class="col-xs-3">
		    	<div class="img" style="background-image: url(<?php echo $img_url; ?>);"></div>
    		</div>
	    	<div class="col-xs-9">
	    		<div class="txt">
					<h3><?php the_title(); ?></h3>
					<time class="post-date">
						<span>Event details:</span> <?php echo $event_date; ?> @ <?php echo $event_time; ?><?php echo ($event_time_end) ? ' - '.$event_time_end:''; ?></time>
					<?php the_excerpt(); ?>
					<a href="<?php the_permalink(); ?>" class="post-link">View Article</a>
	    		</div>
	    	</div>
    	</div>
    </div>  	
  	
 <?php 
 endforeach; 
 wp_reset_postdata(); 
 ?>

  </div>

</div>

<div class="panel-btns">

	<?php if (is_user_logged_in() && current_user_can("administrator") || current_user_can("editor") ) { ?>
	
	<div class="row">
		<div class="col-xs-6">
			<a href="<?php echo get_category_link( $ev_cat_id ); ?>" class="btn btn-default btn-block"><i class="fa fa-eye fa-lg"></i>All Events</a>
		</div>
		
		<div class="col-xs-6">
			<a href="<?php echo get_permalink($add_event_pg->ID); ?>?httpref=<?php echo $home_url; ?>" class="btn btn-default btn-block"><i class="fa fa-plus-circle fa-lg"></i>Submit an Event</a>
		</div>
		
	</div>
	
	<?php } else { ?>
	<a href="<?php echo get_category_link( $ev_cat_id ); ?>" class="btn btn-default btn-block"><i class="fa fa-eye fa-lg"></i>All Events</a>
	<?php } ?>
	
</div>