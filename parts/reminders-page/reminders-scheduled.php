<div id="reminder-group-wrapper">
<h1><i class="fa fa-clock-o col-gray"></i> Scheduled</h1>
<div class="reminders">
	<div class="reminder-label bold">Today</div>
	<?php get_template_part( 'parts/reminders-page/schedules', 'today' ); ?>
	
	<?php get_template_part( 'parts/reminders-page/schedules', 'tomorrow' ); ?>
	
	<?php get_template_part( 'parts/reminders-page/schedules', 'later' ); ?>
	
</div>