<div class="page-section <?php echo (isset($_GET['sortby']) || isset($_GET['view'])) ? 'section-open':'section-closed'; ?>">

	<h3 class="section-header"><i class="fa fa-clock-o fa-lg"></i>Your Meetings</h3>
	<button class="close-section-btn"><i class="fa fa-minus-circle fa-lg"></i><i class="fa fa-plus-circle fa-lg"></i></button>
	
	<div id="meetings-section-inner" class="section-inner">
	
		<div id="meetings-section-wrap" class="section-wrap">
				
			<div class="data-list-key">
			
				<div class="filters col-red">
					<span><a href="<?php echo get_author_posts_url($user_id);?>" <?php echo (!isset($_GET['sortby'])) ? " class=\"active\"":""; ?>>Today's</a></span>
					<span><a href="<?php echo get_author_posts_url($user_id);?>?sortby=pending"<?php echo (isset($_GET['sortby']) && $_GET['sortby'] == "pending") ? " class=\"active\"":""; ?>>Pending</a></span>
					<span><a href="<?php echo get_author_posts_url($user_id);?>?sortby=future"<?php echo (isset($_GET['sortby']) && $_GET['sortby'] == "future") ? " class=\"active\"":""; ?>>Future</a></span>
					<span><a href="<?php echo get_author_posts_url($user_id);?>?sortby=past"<?php echo (isset($_GET['sortby']) && $_GET['sortby'] == "past") ? " class=\"active\"":""; ?>>Past</a></span>
					<span><a href="<?php echo get_author_posts_url($user_id);?>?sortby=canceled"<?php echo (isset($_GET['sortby']) && $_GET['sortby'] == "canceled") ? " class=\"active\"":""; ?>>Canceled</a></span>
					<span><a href="<?php echo get_author_posts_url($user_id);?>?sortby=all"<?php echo (isset($_GET['sortby']) && $_GET['sortby'] == "all") ? " class=\"active\"":""; ?>>All</a></span>
				</div>
			
			</div>
			
			<?php //echo '<pre>';print_r( ceil( $meetings_post_count/10) );echo '</pre>'; ?>
		
			<div class="data-list-key">
				
				<div class="actions-key">
					<span class="actions"><i class="fa fa-cogs"></i> Actions</span>
					<span class="status"><i class="fa fa-info-circle"></i> Status</span>
				</div>
				
				<div class="status-key">
					<span class="approved">Approved</span>
					<span class="pending">Pending approval</span>
					<span class="canceled">Canceled</span>
				</div>
					
			</div>
		
		<?php if ( $meetings_query->have_posts() ):
		$meetings_count = 0;
		//echo '<pre>';print_r($your_meeting_ids);echo '</pre>';
		?>
		
		<div class="data-list">
			
				<div class="data-list-wrap">
			
					<table class="data-list-table">
					
						<thead class="data-list-header">
							<tr>
								<th class="settings"><i class="fa fa-cogs fa-lg"></i></th>
								<th class="marker"><i class="fa fa-info-circle fa-lg"></i></th>
								<th class="room">Room</th>
								<th class="description">Description</th>
								<th class="date">Date</th>
								<th class="time">Time</th>
								<th class="booked-by">Booked by</th>
							</tr>
						</thead>
					
					<tbody>
					
					<?php while ( $meetings_query->have_posts() ) : $meetings_query->the_post(); 
					$meetings_count++;
					?>	
					
					<?php 
					//echo '<pre>';print_r($post);echo '</pre>';
					$booked_by = get_user_by('id', $post->post_author);
					$description = get_field('meeting_description');
					$date_raw = get_field('meeting_date');
					$date_convert = strtotime($date_raw);
					$start_time = get_field('start_time');
					$end_time = get_field('end_time');
					$room = wp_get_post_terms( $post->ID, 'tlw_rooms_tax');
					$default_tz = date_default_timezone_get();
					date_default_timezone_set('Europe/London'); 
					$now_local = localtime(time(), true);
					$now = strtotime("today ".sprintf('%02d', $now_local[tm_hour]).":".sprintf('%02d', $now_local[tm_min]));
					$staff_attendees = get_field('attendees_staff');
					$status = $post->post_status;
					if ( in_array_r($current_user->ID, $staff_attendees) ) {
						
						foreach ($staff_attendees as $staff_attendee) {
							if ($staff_attendee['attendee_staff']['ID'] == $current_user->ID && $staff_attendee['status'] == 'pending') {
							$status = $staff_attendee['status'];	
							}
						}
					
					}
					date_default_timezone_set($default_tz);
					 ?>	
					<tr id="entry-tr-<?php echo $meetings_count; ?>" class="entry-tr<?php echo ( $date_raw == date('Ymd' ,strtotime("today")) && isset($_GET['sortby']) ) ? " col-blue":"" ; ?>">
						 <td colspan="7">
						 
							<table class="table table-bordered">
								<tbody>
									<tr class="info-tr">
										<td class="settings">
											<a href="#" id="view-btn-<?php echo get_the_ID(); ?>"class="btn btn-default settings"><i class="fa fa-cogs"></i></a>
										</td>
										<td class="marker <?php echo $status;?>">
											<i class="fa fa-square"></i>
										</td>
										<td class="room">
										<?php echo $room[0]->name;?>
										</td>
										<td class="description">
										<?php echo $description; ?>
										</td>
										<td class="date">
											<span class="booked-date"><?php echo date('D jS F Y', $date_convert);?></span>
										</td>
										<td class="time">
											<span class="time"><?php echo date('H:i', $start_time);?> - <?php echo date('H:i', $end_time);?></span>
										</td>
										<td class="booked-by">
										
										<?php if ($post->post_author == $user_id) { ?>
										You
										<?php } else { ?>
										<a href="<?php echo get_author_posts_url($booked_by->data->ID);?>"><?php echo $booked_by->data->display_name; ?></a>
										<?php } ?>
										
										</td>
						
									</tr>
									
									<tr class="actions-tr actions-tr-closed" id="actions-tr-<?php echo get_the_ID(); ?>">
										<td colspan="7">
											
										<?php if ( $start_time > $now && $post->post_author == $current_user->ID ) { ?>
											<a href="<?php echo get_author_posts_url($user_id);?>?request=edit&meetingid=<?php echo get_the_ID();?>" class="btn btn-default edit action-btn"><i class="fa fa-pencil"></i> Edit</a>
											
											<a href="<?php echo get_author_posts_url($user_id);?>?request=cancel&meetingid=<?php echo get_the_ID();?>" class="btn btn-default cancel action-btn"><i class="fa fa-times"></i> Cancel</a>					
											<?php if ( $post->post_status == "draft" ) { ?>
											<a href="<?php echo get_author_posts_url($user_id);?>?request=delete&meetingid=<?php echo get_the_ID();?>" class="btn btn-default delete action-btn"><i class="fa fa-trash-o"></i> Delete</a>
											<?php } ?>
	
										<?php } ?>
											
											
										<?php if ( $post->post_status == "publish" ) { ?>
											<a href="<?php the_permalink(); ?>" class="btn btn-default view"><i class="fa fa-eye"></i> View details</a>
										<?php } ?>
											
										</td>
									</tr>
									
									</tbody>
								</table>
							 </td>
						 </tr>
	
					<?php endwhile; ?>
					
					</tbody>
					
					</table>
					
					<?php if (count($your_meeting_ids) > 10) { 
						
						if (isset($_GET['sortby'])) {
						$url_format = '&sortby='.$_GET['sortby'];	
						}
						
					?>
	
					<div class="pagination-links pagination-actions">
					<?php if ( isset($_GET['pg']) && $_GET['pg'] > 1 ) { ?>
					
					<a class="prev page-numbers" href="?pg=<?php echo ($_GET['pg'] - 1); ?><?php echo $url_format; ?>">&laquo; Previous</a>
					
					<?php } ?>
					
					<?php for ($p = 1; $p <= $meetings_max_num_pages; $p++) { ?>
						
						<?php if ( !isset($_GET['pg']) ) { ?>
							
							<?php if ( $p == 1) { ?>
							
							<span class="page-numbers current"><?php echo $p; ?></span>
							
							<?php } ?>
							
							<?php if ( $p != 1) { ?>
							
							<a class="page-numbers" href="?pg=<?php echo $p; ?><?php echo $url_format; ?>"><?php echo $p; ?></a>
								
							<?php } ?>
							
						<?php } else { ?>
							
							<?php if ( $p == $_GET['pg'] ) { ?>
							<span class="page-numbers current"><?php echo $p; ?></span>
							<?php } else { ?>
							<a class="page-numbers" href="?pg=<?php echo $p; ?><?php echo $url_format; ?>"><?php echo $p; ?></a>
							<?php } ?>
							
						<?php } ?>

					<?php } ?>
					
					<?php if ( !isset($_GET['pg']) || $_GET['pg'] < $meetings_max_num_pages ) { ?>
					
					<a class="next page-numbers" href="?pg=<?php echo (isset($_GET['pg'])) ? ($_GET['pg'] + 1): "2"; ?><?php echo $url_format; ?>">Next &raquo;</a>
					
					<?php } ?>
					
					</div>	
				
					<?php } ?>

					
				</div>
		
			</div>
			
		<?php else: ?>
		
		<div class="well text-center">
		
		<?php 
			switch ( $_GET['sortby'] ) { 
			case "pending": $message = "You have no meetings awaiting approval.";
			break;
			case "future": $message = "You have no future meetings at the moment.";
			break;
			case "past": $message = "You have no past meetings at the moment.";
			break;
			case "canceled": $message = "You have no canceled meetings at the moment.";
			break;
			case "all": $message = "You have no meetings booked at the moment";
			break;
			default: $message = "You have no meetings booked for today.";
			}  
		 ?>
		 
		 <?php echo $message; ?>
		 
		</div>

		
		<?php endif; ?>
			
		</div><!-- Section inner wrap -->
		
	</div><!-- Section inner -->
	
</div><!-- Section outer -->
