<div class="user-details">
	
	<?php if ($curauth->ID == $emp_otm_user['ID']) { ?>
	<div class="eotm-banner">
		<h3 class="text-center"><i class="fa fa-trophy fa-lg left"></i> Employee of the Month <i class="fa fa-trophy fa-lg right"></i></h3>
	</div>
	<?php } ?>

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
					<div class="text"><?php echo $user_display_name; ?><?php echo ($extention) ? '<span class="ext-num"><i class="fa fa-phone-square fa-lg"></i> '. $extention .'</span>':''; ?></div>
				</div>
				
			</div>
			
			<?php if (current_user_can("administrator") || $current_user->ID == $user_id ) { ?>
			
			<div class="row">	
				<div class="col-xs-5">
					<div class="info-label">Username:</div> 
				</div>
				<div class="col-xs-7">
					<div class="text"><?php echo $user_name; ?></div>
				</div>
			</div>
			
			<?php } ?>
			
			<?php if ($nickname != $user_name ) { ?>
			
			<div class="row">	
				<div class="col-xs-5">
					<div class="info-label">Nickname:</div> 
				</div>
				<div class="col-xs-7">
					<div class="text"><?php echo $nickname; ?></div>
				</div>
			</div>
			
			<?php } ?>
			
			<?php if (current_user_can("administrator") || $current_user->ID == $user_id || $current_user->ID == $rb_admin['ID']) { ?>
			
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
			
			<?php if ($curauth->ID != 60 && $curauth->ID != 1 && $current_user->ID == $user_id) { 
			$meetings_page = get_page_by_title("Meetings");
			$edit_profile = get_page_by_title("Edit Profile");	
			?>
			<div class="rule"></div>
			<div class="action-btns col-red">
				
				<a href="<?php echo get_permalink($meetings_page->ID); ?>" title="Book a meeting room" class="btn btn-default btn-block no-arrow"><i class="fa fa-clock-o fa-lg"></i>Book a meeting room</a>
					
				<a href="<?php echo get_permalink($edit_profile->ID); ?>" title="Change your Password" class="btn btn-default btn-block no-arrow"><i class="fa fa-shield fa-lg"></i>Change your Password</a>

			</div>
				<?php } ?>
			
			<div class="rule"></div>	

</div>