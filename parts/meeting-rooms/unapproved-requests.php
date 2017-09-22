<?php if ( current_user_can("administrator") && $unapproved_count > 0) { ?>

<section class="page-section section-closed">
	
	<h3 class="section-header"><i class="fa fa-info-circle fa-lg"></i>Past Unapproved <?php echo $meetings->post_title; ?></h3>
	<button class="close-section-btn"><i class="fa fa-minus-circle fa-lg"></i><i class="fa fa-chevron-circle-down fa-lg"></i></button>
		
		<div class="data-list-header <?php echo ($unapproved_count > 3) ? ' is-scrollable':''; ?>">
			<table class="table table-bordered">
				<tbody>
				<tr>
					<td class="room">Room</td>
					<td class="description">Meeting Description</td>
					<td class="time">Date/Time</td>
					<td class="booked-by">Booked by</td>
					<?php if (is_user_logged_in()) { ?>
					<td class="actions">Actions</td>
					<?php } ?>
				</tr>
				</tbody>
			</table>
		</div>
	
	<div class="data-list">
		
		<div class="data-list-wrap<?php echo ($unapproved_count > 3) ? ' scrollable':''; ?>">
		
			<table class="data-list-table table table-bordered">
				<tbody>
					
					<?php if ( $unapproved_query->have_posts() ): while ( $unapproved_query->have_posts() ) :$unapproved_query->the_post(); ?>	
				
					<?php 
					$booked_by = get_user_by('id', $post->post_author);
					$description = get_field('meeting_description');
					$date_raw = get_field('meeting_date');
					$date_convert = strtotime($date_raw);
					$start_time = get_field('start_time');
					$end_time = get_field('end_time');
					$room = wp_get_post_terms( $post->ID, 'tlw_rooms_tax');
					 ?>	
					
					<tr class="pending">
						<td class="room">
							<a href="<?php echo get_term_link( $room[0]->term_id, $room[0]->taxonomy );?>"><?php echo $room[0]->name;?></a>
						</td>
						<td class="description">
							<?php echo $description; ?>
						</td>
						<td class="time">
							<span class="booked-date"><?php echo date('D jS F Y', $date_convert);?></span>
							<span class="time"><?php echo date('H:i', $start_time);?> - <?php echo date('H:i', $end_time);?></span>
						</td>
						<td class="booked-by">
						<a href="<?php echo get_author_posts_url($booked_by->data->ID);?>"><?php echo $booked_by->data->display_name; ?></a>
						</td>
						<td class="actions">
							
							<a href="<?php echo get_permalink($meetings->ID); ?>?request=cancel&meetingid=<?php echo get_the_ID();?>&type=past_unapproved" class="btn btn-default cancel action-btn"><i class="fa fa-times"></i></a>
						</td>
					</tr>
					<?php endwhile; ?>
					
				<?php endif; ?>
					
				</tbody>
			</table>
			
		</div>
		
	</div>

</section>

<?php } ?>