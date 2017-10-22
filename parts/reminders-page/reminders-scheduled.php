<div id="reminder-group-wrapper">
<h1>Scheduled</h1>
<div class="reminders">
	<div class="reminder-label bold">Today</div>
	<?php get_template_part( 'parts/reminders-page/schedules', 'today' ); ?>
	<div class="reminder-footer">
		<a href="?reminder-actions=add-reminder&when=today" class="btn btn-default">New item <i class="fa fa-plus"></i></a>
	</div>
	<div class="reminder-label bold">Tomorrow</div>
	<?php  get_template_part( 'parts/reminders-page/schedules', 'tomorrow' ); ?>
	<div class="reminder-footer">
		<a href="?reminder-actions=add-reminder&when=tomorrow" class="btn btn-default">New item <i class="fa fa-plus"></i></a>
	</div>
	<?php get_template_part( 'parts/reminders-page/schedules', 'later' ); ?>
	<div class="reminder-footer">
		<a href="?reminder-actions=add-reminder" class="btn btn-default">New item <i class="fa fa-plus"></i></a>
	</div>
</div>
</div>