<div class="user-filters">
			
	<div class="row">
		<div class="col-xs-10">
			<div class="row">
				
				<div class="col-xs-4">
					<div class="form-group">
						<form action="<?php echo get_permalink($staff_members_pg->ID);?>" method="get">
							<select class="form-control selectpicker" name="by-department" id="by-department">			
								<option value="0">All Departments</option>
								<!-- <option value="0">By Department</option> -->
								<?php foreach ($departments as $department) { ?>
								<option value="<?php echo $department->ID; ?>"<?php echo (isset($_GET['by-department']) && $_GET['by-department'] == $department->ID) ? ' selected="selected"':'' ; ?>><?php echo $department->post_title; ?></option>
								<?php } ?>
							</select>
							
							<?php if (isset($_GET['list_style'])) { ?>
								<input type="hidden" name="list_style" value="<?php echo $_GET['list_style']; ?>">
							<?php } ?>
							
						</form>
					</div>
				</div>
				
				<div class="col-xs-4">
					<div class="form-group">
					<form action="<?php echo get_permalink($staff_members_pg->ID);?>" method="get">
						<select class="form-control selectpicker" name="by-name" data-live-search="true" id="by-name">
							<option value="0">All Staff</option>
							<?php foreach ($select_users as $user) { ?>
							<option value="<?php echo $user->ID; ?>"<?php echo (isset($_GET['by-name']) && $_GET['by-name'] == $user->ID) ? ' selected="selected"':'' ; ?>><?php echo $user->data->display_name; ?></option>
							<?php } ?>
						</select>
						
						<?php if (isset($_GET['list_style'])) { ?>
							<input type="hidden" name="list_style" value="<?php echo $_GET['list_style']; ?>">
						<?php } ?>
					</form>
					</div>
				</div>
				
				<div class="col-xs-4">
					<div class="form-group">
					<form action="<?php echo get_permalink($staff_members_pg->ID);?>" method="get">
						<select class="form-control selectpicker" name="by-job-title" id="by-job-title">
							<option value="0">All Job titles</option>
							<?php foreach ($job_titles as $job_title) { ?>
							<option value="<?php echo $job_title; ?>"<?php echo (isset($_GET['by-job-title']) && $_GET['by-job-title'] == $job_title) ? ' selected="selected"':'' ; ?>><?php echo $job_title; ?></option>
							<?php } ?>
						</select>
						
						<?php if (isset($_GET['list_style'])) { ?>
							<input type="hidden" name="list_style" value="<?php echo $_GET['list_style']; ?>">
						<?php } ?>
					</form>
					</div>
				</div>
			</div>
		
		
		</div>
		
		<div class="col-xs-2">
			
			<div class="filter-actions">
				<?php 
				$parameters = '';
				
				if (isset($_GET['by-department'])) {
				$parameters = '&by-department='.$_GET['by-department'];	
				}	
				
				if (isset($_GET['by-name'])) {
				$parameters = '&by-name='.$_GET['by-name'];	
				}	
				
				if (isset($_GET['by-job-title'])) {
				$parameters = '&by-job-title='.urlencode($_GET['by-job-title']);	
				}
				
				if (get_query_var('paged')) {
				$parameters = '&paged='.$paged;	
				}	
				?>
				
				<a href="<?php echo get_permalink($staff_members_pg->ID);?>?list_style=grid<?php echo $parameters;?>" class="btn<?php echo ( !isset($_GET['list_style']) || $_GET['list_style'] == 'grid') ? " active":""; ?>" title="Grid"><i class="fa fa-th fa-lg"></i></a>
				
				<a href="<?php echo get_permalink($staff_members_pg->ID);?>?list_style=list<?php echo $parameters;?>" class="btn<?php echo ($_GET['list_style'] == 'list') ? " active":""; ?>" title="List"><i class="fa fa-list fa-lg"></i></a>
			</div>
			
		</div>
	</div>
</div>


