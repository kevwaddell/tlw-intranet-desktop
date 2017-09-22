<div class="page-section <?php echo (isset($_GET['holiday_sortby']) ? 'section-open':'section-closed'); ?>" style="margin-top: 10px;">
	
	<h3 class="section-header"><i class="fa fa-plane fa-lg"></i>Your Holidays</h3>
	<button class="close-section-btn"><i class="fa fa-minus-circle fa-lg"></i><i class="fa fa-chevron-circle-down fa-lg"></i></button>
	
	<div id="holidays-section-inner" class="section-inner">
	
		<div id="holidays-section-wrap" class="section-wrap">
				
			<div class="data-list-key">
			
				<div class="filters col-red">
					<span><a href="<?php echo get_author_posts_url($user_id);?>" <?php echo (!isset($_GET['holiday_sortby'])) ? " class=\"active\"":""; ?>><?php echo date('Y');?></a></span>
					<span><a href="<?php echo get_author_posts_url($user_id);?>?holiday_sortby=next-year"<?php echo (isset($_GET['holiday_sortby']) && $_GET['holiday_sortby'] == "next-year") ? " class=\"active\"":""; ?>><?php echo date('Y', strtotime("next year"));?></a></span>
					<span><a href="<?php echo get_author_posts_url($user_id);?>?holiday_sortby=pending"<?php echo (isset($_GET['holiday_sortby']) && $_GET['holiday_sortby'] == "pending") ? " class=\"active\"":""; ?>>Pending</a></span>
					<span><a href="<?php echo get_author_posts_url($user_id);?>?holiday_sortby=canceled"<?php echo (isset($_GET['holiday_sortby']) && $_GET['holiday_sortby'] == "canceled") ? " class=\"active\"":""; ?>>Canceled</a></span>
					<span><a href="<?php echo get_author_posts_url($user_id);?>?holiday_sortby=all"<?php echo (isset($_GET['holiday_sortby']) && $_GET['holiday_sortby'] == "all") ? " class=\"active\"":""; ?>>All</a></span>
				</div>
			
			</div>
		
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
		
		<?php 
		//echo '<pre>';print_r(count($your_meetings));echo '</pre>';
		if ( !empty($holidays) ){ 
		global $post;
		$holidays_count = 0;
		$total_days = 0;
		?>
		
		<div class="data-list">
			
				<div class="data-list-wrap">
			
					<table class="data-list-table">
					
						<thead class="data-list-header">
							<tr>
								<th class="settings"><i class="fa fa-cogs fa-lg"></i></th>
								<th class="marker"><i class="fa fa-info-circle fa-lg"></i></th>
								<th class="date-long">Start date</th>
								<th class="date-long">End date</th>
								<th>Days</th>
							</tr>
						</thead>
					
					<tbody>
					
					<?php foreach ( $holidays as $post ) { 
					setup_postdata($post); 
					$holidays_count++;
					?>	
					
					<?php 
					//echo '<pre>';print_r($post);echo '</pre>';
					$start_date = get_field('holiday_start_date');
					$end_date = get_field('holiday_end_date');
					$num_days = get_field('number_of_days');
					$total_days += $num_days;
					$today_raw = strtotime("today");
					$today = date('Ymd', $today_raw);
					 ?>	
					<tr id="entry-tr-<?php echo $holidays_count; ?>" class="entry-tr">
						 <td colspan="5">
						 
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
										<td class="date-long">
											<span class="start-date"><?php echo date('D jS F Y', strtotime($start_date) );?></span>
										</td>
										<td class="date-long">
											<span class="end-date"><?php echo date('D jS F Y', strtotime($end_date) );?></span>
										</td>
										<td>
											<span class="time"><?php echo $num_days;?></span>
										</td>
						
									</tr>
									
									<tr class="actions-tr actions-tr-closed" id="actions-tr-<?php echo get_the_ID(); ?>">
										<td colspan="5">
											
										<?php if ( $start_date > $today ) { ?>
											<?php if ( $post->post_status == "pending") { ?>
											<a href="<?php echo get_author_posts_url($user_id);?>?request=edit_holiday&holidayid=<?php echo get_the_ID();?>" class="btn btn-default edit action-btn"><i class="fa fa-pencil"></i> Edit</a>
											<?php } ?>
											
											<a href="<?php echo get_author_posts_url($user_id);?>?request=cancel_holiday&num_days=<?php echo $num_days;?>&holidayid=<?php echo get_the_ID();?>" class="btn btn-default cancel action-btn"><i class="fa fa-times"></i> Cancel</a>	
										<?php } ?>		
												
										<?php if ( $end_date < $today || $post->post_status == "draft") { ?>
											 <a href="<?php echo get_author_posts_url($user_id);?>?request=delete_holiday&holidayid=<?php echo get_the_ID();?>" class="btn btn-default delete action-btn"><i class="fa fa-trash-o"></i> Delete</a>
										<?php } ?>
	
											
										</td>
									</tr>
									
									</tbody>
								</table>
							 </td>
						 </tr>
	
					<?php }
					wp_reset_postdata();
					 ?>
					 
					 <?php if ( !isset($_GET['holiday_sortby']) || $_GET['holiday_sortby'] == 'next-year' ) { ?>
					 <tfoot class="data-list-footer">
					 	<tr>
					 		<td colspan="4" class="total">Total days</td>
					 		<td><?php echo $total_days;?></td>
					 	</tr>
					 </tfoot>
					<?php } ?>
					
					</tbody>
					
					</table>
									
				</div>
		
			</div>
			
		<?php } else { ?>
		
		<div class="well text-center">
		
		<?php 
			switch ( $_GET['holiday_sortby'] ) { 
			case "pending": $message = "You have no holidays awaiting approval.";
			break;
			case "next-year": $message = "You have no holidays booked for next year.";
			break;
			case "canceled": $message = "You have no canceled holidays at the moment.";
			break;
			case "all": $message = "You have no holidays booked at the moment";
			break;
			default: $message = "You have no holidays booked for this year.";
			}  
		 ?>
		 
		 <?php echo $message; ?>
		 
		</div>

		
		<?php } ?>
			
		</div><!-- Section inner wrap -->
		
	</div><!-- Section inner -->
	
</div><!-- Section outer -->
