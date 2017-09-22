<div class="page-section section-open">
	
	<h3 class="section-header"><i class="fa fa-clock-o fa-lg"></i><?php echo $meetings->post_title; ?></h3>
	<button class="close-section-btn"><i class="fa fa-minus-circle fa-lg"></i><i class="fa fa-chevron-circle-down fa-lg"></i></button>
	
	<div id="meetings-section-inner" class="section-inner">
	
		<div id="meetings-section-wrap" class="section-wrap">
		
			<!-- DATA KEY -->
			<?php include (STYLESHEETPATH . '/_/inc/meeting-rooms/data-list-key.php'); ?>
			<!-- DATA KEY -->
		
				
			<div class="data-list-key">
			
				<div class="actions-key">
					<?php if (is_user_logged_in()) { ?>
					<span class="actions"><i class="fa fa-cogs"></i> Actions</span>
					<?php } ?>
					<span class="status"><i class="fa fa-info-circle"></i> Status</span>
				</div>
				
				<div class="status-key">
					<span class="approved">Approved</span>
					<span class="pending">Pending approval</span>
					<span class="canceled">Canceled</span>
				</div>
				
			</div>
				
			<?php if ( $main_query->have_posts() ): ?>	
		
			<div class="data-list">
			
				<div class="data-list-wrap">
					
					<table class="data-list-table">
					
					<thead class="data-list-header">
						<tr>
							<?php if (is_user_logged_in()) { ?>
							<th class="settings"><i class="fa fa-cogs fa-lg"></i></th>
							<?php } ?>
							<th class="marker"><i class="fa fa-info-circle fa-lg"></i></th>
							<th class="room">Room</th>
							<th class="description">Description</th>
							<th class="date">Date</th>
							<th class="time">Time</th>
							<th class="booked-by">Booked by</th>
						</tr>
					</thead>
					
					<tbody>
					
					<?php while ( $main_query->have_posts() ) :$main_query->the_post(); ?>	
					
					<?php 
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
					/*
					echo '<pre>';
					print_r($now_local);
					print_r( date('D jS F Y H:i' ,$now_local[tm_hour]) );
					echo '</pre>';
					*/
		
					date_default_timezone_set($default_tz);
					 ?>	
						 <tr class="entry-tr<?php echo ( $date_raw == date('Ymd' ,strtotime("today")) && isset($_GET['sortby']) ) ? " col-purple":"" ; ?>">
							 <td colspan="<?php echo (is_user_logged_in()) ? "7":"6" ; ?>">
							 
								<table class="table table-bordered">
									<tbody>
									<tr class="info-tr">
										<?php if (is_user_logged_in()) { ?>
										<td class="settings">
											<a href="#" id="view-btn-<?php echo get_the_ID(); ?>"class="btn btn-default settings"><i class="fa fa-cogs"></i></a>
										</td>
										<?php } ?>
										<td class="marker <?php echo $post->post_status;?>">
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
											<!-- <span class="time"><?php echo date('D jS F Y H:i', $start_time);?></span><br> -->
											<span class="time"><?php echo date('H:i', $start_time);?> - <?php echo date('H:i', $end_time);?></span>
										</td>
										<td class="booked-by">
										<a href="<?php echo get_author_posts_url($booked_by->data->ID);?>"><?php echo $booked_by->data->display_name; ?></a>
										</td>
									</tr>
									
									<?php if (is_user_logged_in()) { ?>
									
									<tr class="actions-tr actions-tr-closed" id="actions-tr-<?php echo get_the_ID(); ?>">
										<td colspan="7">
											
											<?php if ( $start_time > $now && $post->post_author == $current_user_ID ) { ?>
											<a href="<?php echo get_permalink($meetings->ID); ?>?request=edit_meeting&meetingid=<?php echo get_the_ID();?>" class="btn btn-default edit action-btn"><i class="fa fa-pencil"></i> Edit</a>
											<?php } ?>
											
											<?php if ( $start_time > $now && $post->post_author == $current_user_ID && ($post->post_status == "publish" || $post->post_status == "pending") ) { ?>
											<a href="<?php echo get_permalink($meetings->ID); ?>?request=cancel_meeting&meetingid=<?php echo get_the_ID();?>" class="btn btn-default cancel action-btn"><i class="fa fa-times"></i> Cancel</a>
											<?php } ?>
											
											<?php if ( $post->post_status == "draft" && ( $post->post_author == $current_user_ID || current_user_can("administrator") || $current_user_ID == $rb_admin['ID']) ) { ?>
											<a href="<?php echo get_permalink($meetings->ID); ?>?request=delete_meeting&meetingid=<?php echo get_the_ID();?>" class="btn btn-default delete action-btn"><i class="fa fa-trash-o"></i> Delete</a>
											<?php } ?>
											
											<?php if ( $post->post_status == "publish" ) { ?>
											<a href="<?php the_permalink(); ?>" class="btn btn-default view"><i class="fa fa-eye"></i> View details</a>
											<?php } ?>
											
											<?php if ( ($post->post_status == "pending" && $start_time > $now) && (current_user_can("administrator") || $current_user_ID == $rb_admin['ID']) ) { ?>
											<a href="<?php echo get_permalink($meetings->ID); ?>?request=reject_meeting&meetingid=<?php echo get_the_ID();?>" class="btn btn-default reject action-btn"><i class="fa fa-thumbs-o-down"></i> Reject</a>
											<?php } ?>
											
											<?php if ( (($post->post_status == "pending" || $post->post_status == "draft")) && (current_user_can("administrator") || $current_user_ID == $rb_admin['ID']) ) { ?>
											<a href="<?php echo get_permalink($meetings->ID); ?>?request=approve_meeting&meetingid=<?php echo get_the_ID();?>" class="btn btn-default approve action-btn"><i class="fa fa-thumbs-o-up"></i> Approve</a>
											<?php } ?>
											
											<?php if ( $current_user_ID != $post->post_author && $current_user_ID != $rb_admin['ID'] && !current_user_can("administrator")) { ?>
												
												<?php if ( $post->post_status == "draft") { ?>
												<small>This meeting has been canceled.</small>
												<?php } ?>
												
													<?php if ( $post->post_status == "pending") { ?>
												<small>This meeting is awaiting approval.</small>
												<?php } ?>
												
											<?php } ?>
										</td>
									</tr>
									<?php } ?>
		
									</tbody>
								</table>
							 </td>
						 </tr>
					<?php endwhile; ?>
					
					</tbody>
					
					</table>
					
					<?php if ($main_post_count > $posts_per_page) { ?>
		
					<div class="pagination-links pagination-actions">
					<?php 
					if (isset($_GET['sortby'])) {
					$format = '&paged=%#%';	
					} else {
					$format = '?paged=%#%';		
					}
					echo paginate_links(array(  
				                  'base' => get_pagenum_link(1) . '%_%',  
				                  'format' => $format,  
				                  'current' => $paged,  
				                  'total' => $max_num_pages,  
				                  'prev_text' => '&laquo; Previous',  
				                  'next_text' => 'Next &raquo;'  
				                )); 
				                
				     ?>
					</div>	
					
					<?php } ?>
		
		
				</div>
		
			</div>
			
			<?php else: ?>
			<div class="well text-center">
			
			<?php 
				switch ( $_GET['sortby'] ) { 
				case "pending": $message = "There are no meetings awaiting approval.";
				break;
				case "future": $message = "There are no future meetings at the moment.";
				break;
				case "past": $message = "There are no past meetings at the moment.";
				break;
				case "canceled": $message = "There are no canceled meetings at the moment.";
				break;
				case "all": $message = "There are no meetings booked at the moment";
				break;
				default: $message = "There are no meetings booked for today.";
				}  
			 ?>
			 
			 <?php echo $message; ?>
			 
			</div>
			<?php endif; ?>
	
		</div><!-- Section inner wrap -->
		
	</div><!-- Section inner -->
	
</div>
