<section class="page-section section-closed">
	<h3 class="section-header"><i class="fa fa-info-circle fa-lg"></i>Past <?php echo $meetings->post_title; ?></h3>
	<button class="close-section-btn"><i class="fa fa-minus-circle fa-lg"></i><i class="fa fa-chevron-circle-down fa-lg"></i></button>
		
		<?php if ( $past_query->have_posts() ): ?>	
		
		<div class="data-list-header <?php echo ($past_post_count > 4) ? ' is-scrollable':''; ?>">
			
			<table class="table table-bordered">
				<tbody>
				<tr>
					<td class="room">Room</td>
					<td class="description">Meeting Description</td>
					<td class="time">Date</td>
					<td class="booked-by">Booked by</td>
					<?php if (is_user_logged_in()) { ?>
					<td class="view">Details</td>
					<?php } ?>
				</tr>
				</tbody>
			</table>
			
		</div>
		
		<?php endif; ?>

		<div class="data-list">
		
			<div class="data-list-wrap<?php echo ($past_post_count > 4) ? ' scrollable':''; ?>">
		
				<table class="data-list-table table table-bordered">
				
				<tbody>
				
				<?php if ( $past_query->have_posts() ): while ( $past_query->have_posts() ) :$past_query->the_post(); ?>	
				
				<?php 
				//echo '<pre>';print_r($post);echo '</pre>';
				$booked_by = get_user_by('id', $post->post_author);
				$description = get_field('meeting_description');
				$date_raw = get_field('meeting_date');
				$date_convert = strtotime($date_raw);
				$room = wp_get_post_terms( $post->ID, 'tlw_rooms_tax');
				$colspan = 4;
				if (is_user_logged_in()) {
				$colspan = 5;
				}
		 		//echo '<pre>';print_r($room);echo '</pre>';
				 ?>	
					<tr id="pm-tr-<?php echo $past_post_counter; ?>" class="approved<?php echo ($past_post_counter >= 10) ? ' tr-hidden':' tr-not-hidden'; ?>">
						<td class="room">
							<a href="<?php echo get_term_link( $room[0]->term_id, $room[0]->taxonomy );?>"><?php echo $room[0]->name;?></a>
						</td>
						<td class="description">
							<?php echo $description; ?>
						</td>
						<td class="date">
							<span class="booked-date"><?php echo date('D jS F Y', $date_convert);?></span>
						</td>
						<td class="booked-by">
						<a href="<?php echo get_author_posts_url($booked_by->data->ID);?>"><?php echo $booked_by->data->display_name; ?></a>
						</td>
						<?php if (is_user_logged_in()) { ?>
						<td class="view">
							<a href="<?php the_permalink();?>" class="btn btn-default view"><i class="fa fa-eye"></i></a>
						</td>
						<?php } ?>
					</tr>
			
				<?php 
				$past_post_counter++;
				endwhile; ?>
				
				<?php else: ?>
					<tr>
						<td>
							<div class="well">There are no meetings booked today.</div>
						</td>
					</tr>
				<?php endif; ?>
				
				</tbody>
				
				</table>
				
				<?php if ($past_post_count > 10) { ?>

	 			<div class="action-btns col-purple" style="margin-top:10px;">
	 				<button id="pm-load-more-btn" class="btn btn-default btn-block no-arrow"><i class="fa fa-refresh fa-lg"></i>Load More</button>
	 			</div>
			 			
			 	<?php } ?>
				
			
			</div>
	
		</div>	
		
</section>