<div id="reminder-group-wrapper">
<h1><i class="fa fa-calendar-check-o col-gray"></i> Meetings</h1>
<div class="reminders">
	<div class="reminder-label bold">Today</div>
	<?php get_template_part( 'parts/reminders-page/meetings', 'today' ); ?>
	
	<?php get_template_part( 'parts/reminders-page/meetings', 'tomorrow' ); ?>
	
	<?php get_template_part( 'parts/reminders-page/meetings', 'later' ); ?>
	
</div>