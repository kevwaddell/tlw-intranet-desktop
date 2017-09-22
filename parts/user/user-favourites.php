<?php  
$all_cats = get_categories('hide_empty=0&exclude=1');	
//echo '<pre>';print_r($all_cats);echo '</pre>';	
?>
<div class="page-section <?php echo (isset($_GET['fav_sortby']) ? 'section-open':'section-closed'); ?>" style="margin-top: 10px;">
	
	<h3 class="section-header"><i class="fa fa-star fa-lg"></i>Your favourites</h3>
	<button class="close-section-btn"><i class="fa fa-minus-circle fa-lg"></i><i class="fa fa-plus-circle fa-lg"></i></button>
	
	<div id="favs-section-inner" class="section-inner">
	
		<div id="favs-section-wrap" class="section-wrap">
		
			<div class="data-list-key">
			
				<div class="favs-filters-key filters col-red">
					<span><a href="<?php echo get_author_posts_url($user_id);?>" <?php echo (!isset($_GET['fav_sortby'])) ? " class=\"active\"":""; ?>>All</a></span>
					<?php foreach ($all_cats as $cat) { ?>
					<span><a href="<?php echo get_author_posts_url($user_id);?>?fav_sortby=post&cat=<?php echo $cat->slug; ?>"<?php echo (isset($_GET['cat']) && $_GET['cat'] == $cat->slug) ? " class=\"active\"":""; ?>><?php echo $cat->name; ?></a></span>
					<?php } ?>
					<span><a href="<?php echo get_author_posts_url($user_id);?>?fav_sortby=tlw_meeting"<?php echo (isset($_GET['fav_sortby']) && $_GET['fav_sortby'] == "tlw_meeting") ? " class=\"active\"":""; ?>>Meetings</a></span>
				</div>
			
			</div>

	
			<div class="data-list-key">
			
				<div class="actions-key">
					<span class="actions"><i class="fa fa-cogs"></i> Actions</span>
					
					<?php if ( !empty($fav_ids) ) { ?>
					
					<?php if (!isset($_GET['fav_sortby']) ) { ?>
					<a href="?request=remove_all_favs" title="Remove all favourites"><i class="fa fa-trash"></i> Remove All</a>
					<?php } ?>
					<?php if (isset($_GET['fav_sortby']) ) { 
					$url = "?request=remove_all_favs&type=".$_GET['fav_sortby'];	
					$label = "All";
					
					if ($_GET['fav_sortby'] == "post") { 
						$url .= "&cat=".$_GET['cat'];
						$cat = get_category_by_slug( $_GET['cat'] );
						$label = $label." ".$cat->name;
					}
					
					if ($_GET['fav_sortby'] == "tlw_meeting") {
					$label = $label." Meetings";	
					}
					/*

										
					echo '<pre>';
					print_r($url);
					echo '<br>';
					print_r($label);
					echo '</pre>';
*/
					?>
						
						<a href="<?php echo $url;?>" title="Remove all favourites"><i class="fa fa-trash"></i> Remove <?php echo $label;?></a>
					
					<?php } ?>
					<?php } ?>
					
				</div>
		
			</div>
			<?php if (!empty($fav_ids) && $favs_query->have_posts() ): 
			$favs_count == 0;	
			?>
			<div class="data-list">
				<div class="data-list-wrap">
				
					<table class="data-list-table">
						<thead class="data-list-header">
							<tr>
								<th class="settings"><i class="fa fa-cogs fa-lg"></i></th>
								<th class="description">Favourite title</th>
								<?php if (!isset($_GET['fav_sortby'])) { ?>
								<th class="type">Type</th>
								<?php } ?>
								<th class="time">Last viewed</th>
							</tr>
						</thead>
					
						<tbody>
					<?php while ( $favs_query->have_posts() ) : $favs_query->the_post(); 
					$favs_count++;	
					$date_raw = strtotime(get_the_date());
					$date_raw = date('Ymd' , $date_raw);
					if ($post->post_type == 'tlw_meeting') {
					$type = "Meeting";	
					}
					
					if ($post->post_type == 'post') {
					$post_categories = wp_get_post_categories( get_the_ID() );
					$post_category = get_category($post_categories[0]);
					$type = $post_category->name;	
					}
					?>	
						<tr id="entry-tr-<?php echo $favs_count; ?>" class="entry-tr">
							<td colspan="4">
								 <table class="table table-bordered">
										<tbody>
									<tr class="info-tr">	
										<td class="settings">
											<a href="#" id="view-btn-<?php echo get_the_ID(); ?>"class="btn btn-default settings"><i class="fa fa-cogs"></i></a>
										</td>
										<td class="description">
											<?php the_title(); ?>
										</td>
										<?php if (!isset($_GET['fav_sortby'])) { ?>
										<td class="type">
											<?php echo $type;?>
										</td>
										<?php } ?>
										<td class="time">
											<?php echo get_the_date();?>
										</td>
									</tr>
									<tr class="actions-tr actions-tr-closed" id="actions-tr-<?php echo get_the_ID(); ?>">
										<td colspan="4">
										
											<?php if ($current_user->ID == $user_id) { ?>
											<a href="?request=remove_from_favs&postid=<?php echo get_the_ID();?>" class="btn btn-default edit"><i class="fa fa-pencil"></i> Remove favourite</a>
											<?php } ?>
											
											<a href="<?php the_permalink();?>" class="btn btn-default view"><i class="fa fa-eye"></i> View favourite</a>
										
										</td>
									</tr>
									</tbody>
								</table>
							</td>
						</tr>
					<?php endwhile; ?>
						</tbody>
					</table>
					
					<?php if (count($your_fav_ids) > 10) { 
						
						if (isset($_GET['fav_sortby'])) {
						$url_format = '&fav_sortby='.$_GET['fav_sortby'];	
						}
						
					?>
	
					<div class="pagination-links pagination-actions">
					
					<?php if ( isset($_GET['fav_pg']) && $_GET['fav_pg'] > 1 ) { ?>
					
					<a class="prev page-numbers" href="?fav_pg=<?php echo ($_GET['fav_pg'] - 1); ?><?php echo $url_format; ?>">&laquo; Previous</a>
					
					<?php } ?>
					
					<?php for ($fp = 1; $fp <= $favs_max_num_pages; $fp++) { ?>
						
						<?php if ( !isset($_GET['fav_pg']) ) { ?>
							
							<?php if ( $fp == 1) { ?>
							
							<span class="page-numbers current"><?php echo $fp; ?></span>
							
							<?php } ?>
							
							<?php if ( $fp != 1) { ?>
							
							<a class="page-numbers" href="?fav_pg=<?php echo $fp; ?><?php echo $url_format; ?>"><?php echo $fp; ?></a>
								
							<?php } ?>
							
						<?php } else { ?>
							
							<?php if ( $fp == $_GET['fav_pg'] ) { ?>
							<span class="page-numbers current"><?php echo $fp; ?></span>
							<?php } else { ?>
							<a class="page-numbers" href="?fav_pg=<?php echo $fp; ?><?php echo $url_format; ?>"><?php echo $fp; ?></a>
							<?php } ?>
							
						<?php } ?>
							
					<?php } ?>
					
					<?php if ( !isset($_GET['fav_pg']) || $_GET['fav_pg'] < $favs_max_num_pages ) { ?>
					
					<a class="next page-numbers" href="?fav_pg=<?php echo (isset($_GET['fav_pg'])) ? ($_GET['fav_pg'] + 1): "2"; ?><?php echo $url_format; ?>">Next &raquo;</a>
					
					<?php } ?>
					
					</div>	
				
					<?php } ?>
					
				
				</div>
			</div>
			
		 <?php else: ?>
		 
		 <div class="well text-center">
		
		<?php 
			$message = "You have no favourites at the moment.";
			
			switch ( $_GET['cat'] ) { 
			case "news": $message = "You have no favourite news at the moment.";
			break;
			case "events": $message = "You have no favourite events at the moment.";
			break;
			case "announcements": $message = "You have no favourite announcements at the moment.";
			break;
			}  
			
			switch ( $_GET['fav_sortby'] ) { 
			case "meetings": $message = "You have no favourite meetings at the moment.";
			break;
			}  
		 ?>
		 
		 <?php echo $message; ?>
		 
		</div>
			
		 <?php endif;
		 wp_reset_postdata();
		  ?>
	
		</div><!-- Section inner wrap -->

	</div><!-- Section inner -->
	
</div>
