<?php //echo '<pre>';print_r($_POST);echo '</pre>'; ?>

<div class="row">
		
	<div class="col-xs-12">
			
		<div class="dash-panel col-red panel-open">
			<h2 class="panel-head"><i class="fa fa-rss fa-lg"></i>Latest News and Events from TLW</h2>
			<button class="close-panel-btn"><i class="fa fa-minus-circle fa-lg"></i><i class="fa fa-plus-circle fa-lg"></i></button>
			
			<div class="panel-content">
			<?php include (STYLESHEETPATH . '/_/inc/dashboard/news-panel/latest-news-panel.php'); ?>
			</div>
		</div>
	
	</div>
	
	<div class="col-xs-6">
				
		<div class="dash-panel col-aqua panel-closed">
			<h2 class="panel-head"><i class="fa fa-bullhorn fa-lg"></i>Announcements</h2>
			<button class="close-panel-btn"><i class="fa fa-minus-circle fa-lg"></i><i class="fa fa-plus-circle fa-lg"></i></button>
			
			<div class="panel-content">
			<?php include (STYLESHEETPATH . '/_/inc/dashboard/announcments-panel.php'); ?>
			</div>
		</div>
		
		<div class="dash-panel col-orange <?php echo (isset($_POST['is_submit_3'])) ? 'panel-open':'panel-closed'; ?>">
			<h2 class="panel-head"><i class="fa fa-bar-chart-o fa-lg"></i>Question of the day</h2>
			<button class="close-panel-btn"><i class="fa fa-minus-circle fa-lg"></i><i class="fa fa-plus-circle fa-lg"></i></button>
			
			<div class="panel-content">
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Dashboard question of the day') ) : ?><?php endif; ?>
			</div>
		</div>
		
		<div class="dash-panel col-blue panel-closed">
			<h2 class="panel-head"><i class="fa fa-briefcase fa-lg"></i>Jobs board</h2>
			<button class="close-panel-btn"><i class="fa fa-minus-circle fa-lg"></i><i class="fa fa-plus-circle fa-lg"></i></button>
			
			<div class="panel-content">
			<?php include (STYLESHEETPATH . '/_/inc/dashboard/jobs-board-panel.php'); ?>
			</div>
		</div>
		
	</div>
	
	<div class="col-xs-6">
	
		<div class="dash-panel col-purple panel-closed">
			<h2 class="panel-head"><i class="fa fa-clock-o fa-lg"></i>Meetings</h2>
			<button class="close-panel-btn"><i class="fa fa-minus-circle fa-lg"></i><i class="fa fa-plus-circle fa-lg"></i></button>
			
			<div class="panel-content">
			<?php include (STYLESHEETPATH . '/_/inc/dashboard/meeting-rooms-panel.php'); ?>
			</div>
		</div>
				
		<div id="quiz-panel" class="dash-panel col-pink <?php echo (isset($_POST['is_submit_4'])) ? 'panel-open':'panel-closed'; ?>">
			<h2 class="panel-head"><i class="fa fa-puzzle-piece fa-lg"></i>Quiz of the day</h2>
			<button class="close-panel-btn"><i class="fa fa-minus-circle fa-lg"></i><i class="fa fa-plus-circle fa-lg"></i></button>
			
			<div class="panel-content">
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Quiz of the day') ) : ?><?php endif; ?>
			</div>
		</div>

		<div id="eotm-panel" class="dash-panel col-green panel-closed">
			<h2 class="panel-head"><i class="fa fa-trophy fa-lg"></i>Employee of the month</h2>
			<button class="close-panel-btn"><i class="fa fa-minus-circle fa-lg"></i><i class="fa fa-plus-circle fa-lg"></i></button>
			
			<div class="panel-content">
			<?php include (STYLESHEETPATH . '/_/inc/dashboard/employee-of-month-panel.php'); ?>
			</div>
		</div>

	</div>
		
</div>