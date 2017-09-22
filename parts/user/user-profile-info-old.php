<div class="user-details">

	<div class="row">
		
		<div class="col-xs-2">
		
			<div class="user-avatar">  
			 <?php echo get_avatar( $user_id, 200 ); ?>      
			</div> 
			
		</div>
		
		<div class="col-xs-10">
			
			<div class="row">	
				
				<div class="col-xs-5">
					<div class="info-label">Name:</div> 
				</div>
				<div class="col-xs-7">
					<div class="text"><?php echo $user_display_name; ?></div>
				</div>
				
			</div>
			
			<?php if (current_user_can("administrator") || $current_user->ID == $user_id || $current_user->ID == $rb_admin['ID']) { ?>
			
			<div class="row">	
				<div class="col-xs-5">
					<div class="info-label">Username:</div> 
				</div>
				<div class="col-xs-7">
					<div class="text"><?php echo $user_name; ?></div>
				</div>
			</div>
			
			<?php if (!empty($user_start_date_raw)) { ?>
			<div class="row">
				<div class="col-xs-5">
					<div class="info-label">Start date:</div> 
				</div>
				<div class="col-xs-7">
					<div class="text"><?php echo $user_start_date; ?></div>
				</div>
			</div>
			<?php } ?>
			
			<?php if ($user_crossover_holidays > 0) { ?>
			<div class="row">
				<div class="col-xs-5">
					<div class="info-label">Holidays from <?php echo date("Y", strtotime("last year")); ?>:</div> 
				</div>
				<div class="col-xs-7">
					<div class="text"><?php echo $user_crossover_holidays; ?></div>
				</div>
			</div>
			<?php } ?>
			
			<?php if (current_user_can("subscriber") || current_user_can("editor") || current_user_can("administrator") || $current_user->ID == $hb_admin['ID']) { ?>
			
			<?php if ($curauth->ID != 60 && $curauth->ID != 1) { ?>
			
			<div class="row">
				<div class="col-xs-5">
					<div class="info-label">Total holidays for <?php echo date("Y", time()); ?>:</div> 
				</div>
				<div class="col-xs-7">
					<div class="text">
					<?php 
					$total_holidays = $user_total_holidays;
					if ($user_crossover_holidays > 0) {
					$total_holidays += $user_crossover_holidays;	
					}
					
					if ($extra_days > 0) {
					$total_holidays += $extra_days;	
					}
					echo $total_holidays; 
					?></div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-xs-5">
					<div class="info-label">Holidays <?php echo date("Y", time()); ?>:</div> 
				</div>
				<div class="col-xs-7">
					<div class="text">
					Used <span class="badge"><?php echo $holidays_used; ?></span> | 
					booked <span class="badge"><?php echo $holidays_booked; ?></span> | 
					remaining <span class="badge"><?php echo $holidays_left; ?></span>
					</div>
				</div>
			</div>
			
			<?php if ($xty_holidays_booked > 0) { ?>
			
			<div class="row">
				<div class="col-xs-5">
					<div class="info-label">Holidays <?php echo date("Y", strtotime("next year")); ?>:</div> 
				</div>
				<div class="col-xs-7">
					<div class="text">
					booked <span class="badge"><?php echo $xty_holidays_booked; ?></span>
					</div>
				</div>
			</div>
			
			<?php } ?>
			
			<?php } ?>
			
			<?php } ?>
			
			<?php } ?>
			
			<div class="row">	
				
				<div class="col-xs-5">
					<div class="info-label">Email:</div> 
				</div>
				<div class="col-xs-7">
					<div class="text"><i class="fa fa-envelope"></i> <a href="mailto:<?php echo $user_email; ?>"><?php echo $user_email; ?></a></div>
				</div>
				
			</div>
			
			<?php if (!empty($user_job_title)) { ?>
			<div class="row">	
				
				<div class="col-xs-5">
					<div class="info-label">Job title:</div> 
				</div>
				<div class="col-xs-7">
					<div class="text"><?php echo $user_job_title; ?></div>
				</div>
				
			</div>
			<?php } ?>
			
			<?php if (!empty($user_department)) { 
			$dep_counter = 0;	
			?>
			<div class="row">	
				
				<div class="col-xs-5">
					<div class="info-label">
					<?php if (count($user_department) > 1) { ?>
					Departments:
					<?php } else { ?>
					Department:
					<?php } ?>
					</div> 
				</div>
				<div class="col-xs-7">
					<div class="text">
						<?php foreach($user_department as $dep) {
						$dep_page = get_page($dep);	
						$dep_counter++;
						?>
						
						<?php if ($dep_counter > 1) { echo " | ";} ?>
						<a href="<?php echo get_permalink($dep); ?>" title="View <?php echo $dep_page->post_title; ?> department"><?php echo $dep_page->post_title; ?></a>
						<?php } ?>
					</div>
				</div>
				
			</div>
			<?php } ?>
			
			<?php if ($job_description) { ?>
			
			<div class="job-info">
			<h4>Job Description</h4>
			<div class="txt"><?php echo $job_description; ?></div>
			</div>
			<?php } ?>
			
		</div>
		
	</div>
	
		<?php if ($current_user->ID == $curauth->ID || current_user_can("administrator")) { 
			$holiday_request_pg = get_page_by_title("Holiday Requests");
			$meetings_page = get_page_by_title("Meetings");
			$edit_profile = get_page_by_title("Edit Profile");
			//echo '<pre>';print_r(!is_super_admin());echo '</pre>';
			?>
			
			<?php if ($curauth->ID != 60 && $curauth->ID != 1) { ?>
			<div class="rule"></div>
			<div class="action-btns col-red">
				<?php if (in_array_r($current_user->ID, $partners) || $current_user->ID == $hb_admin['ID'] || current_user_can("administrator")) { ?>
					
					<?php if (in_array_r($current_user->ID, $partners)) { ?>
				<a href="?request=add_holiday&userid=<?php echo $current_user->ID; ?>" title="Make a holiday request" class="btn btn-default btn-block no-arrow btn-action"><i class="fa fa-plane fa-lg"></i>Add a holiday</a>
					<?php } else { ?>
					<a href="?request=add_holiday&userid=<?php echo $curauth->ID; ?>" title="Make a holiday request" class="btn btn-default btn-block no-arrow btn-action"><i class="fa fa-plane fa-lg"></i>Add a holiday</a>
					<?php } ?>
				
				<?php } else { ?>
				
				<a href="?request=add_holiday&userid=<?php echo $current_user->ID; ?>" title="Make a holiday request" class="btn btn-default btn-block no-arrow btn-action"><i class="fa fa-plane fa-lg"></i>Make a holiday request</a>

				<?php } ?>
				
				<a href="<?php echo get_permalink($meetings_page->ID); ?>" title="Book a meeting room" class="btn btn-default btn-block no-arrow"><i class="fa fa-clock-o fa-lg"></i>Book a meeting room</a>
					
				<?php if ($curauth->ID != $rb_admin['ID'] && !is_super_admin()) { ?>
				<a href="<?php echo get_permalink($edit_profile->ID); ?>" title="Change your Password" class="btn btn-default btn-block no-arrow"><i class="fa fa-shield fa-lg"></i>Change your Password</a>
				<?php } ?>

			</div>
				<?php } ?>
			
			<?php } ?>
			
			<div class="rule"></div>	

</div>