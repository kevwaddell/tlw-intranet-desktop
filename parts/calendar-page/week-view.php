<?php
global $current_user;
global $current_view;	
global $current_week;
$timeZone = 'Europe/London';
$time_start = 9;
$time_end = 18;
if ($current_week == 'next-week') {
$now_dateTime = new DateTime("next week", new DateTimeZone($timeZone));
$week_start = new DateTime("Monday next week", new DateTimeZone($timeZone));
$week_end = new DateTime("Friday next week", new DateTimeZone($timeZone));
$last_week = new DateTime("last week", new DateTimeZone($timeZone));		
} else {
$now_dateTime = new DateTime("now", new DateTimeZone($timeZone));
$week_start = new DateTime("Monday this week", new DateTimeZone($timeZone));
$week_end = new DateTime("Friday this week", new DateTimeZone($timeZone));
$next_week = new DateTime("next week", new DateTimeZone($timeZone));	
}

$calendar_meetings = array();
$calendar_reminders = array();
$meetings_args = array(
'post_type'	=> 'tlw_meeting',
'posts_per_page' => -1,	
'meta_key'	=> 'meeting_date',
'meta_query'	=> array(
	'value'	=> 	array($week_start->format('Ymd'), $week_end->format('Ymd')),
	'compare'	=> 'BETWEEN',
)
);
$meetings = get_posts($meetings_args);
foreach ($meetings as $m) {
$meeting_date = get_field('meeting_date', $m->ID);
$start_time = get_field('start_time', $m->ID);
//debug($meeting_date);
	$calendar_meetings[] = array($m->ID, date('j', strtotime($meeting_date)), date('G', strtotime($start_time)));	
}

$reminders_args = array(
'posts_per_page' => -1,
'post_type' => 'tlw_reminder',
'author'	=> $current_user->ID,
'meta_key'	=> 'reminder_date',
'meta_value' => array($week_start->format('Ymd'), $week_end->format('Ymd')),
'meta_compare'	=> 'BETWEEN'
);
$reminders = get_posts($reminders_args);
//debug($meetings);
$reminders_completed_raw = get_user_meta($current_user->ID, 'reminders_completed', true);
$reminders_completed = unserialize($reminders_completed_raw);

foreach ($reminders as $r) {
$reminder_date = get_field('reminder_date', $r->ID);
$reminder_time = get_field('reminder_time', $r->ID);
$reminder_repeat = get_field('reminder_repeat', $r->ID);
//debug($meeting_date);
	if (date("mY", strtotime($reminder_date)) == $now_dateTime->format('mY')) {
		if ($reminder_repeat != 'never' && in_array_r($r->ID , $reminders_completed)) {
		$calendar_reminders[] = array($r->ID, date('j', strtotime($reminder_date)), date('G', strtotime($reminder_time)));	
		}
	}
}
//debug($calendar_meetings);
//debug($calendar_reminders);
?>

<div class="calendar-header">
	<?php  get_template_part( 'parts/calendar-page/calendar', 'key' ); ?>
		
	<div class="header-date-title"><?php echo $week_start->format("D jS M Y"); ?> - <?php echo $week_end->format("D jS M Y"); ?></div>
		
	<?php  get_template_part( 'parts/calendar-page/calendar', 'actions' ); ?>
</div>

<div class="week-view">
	<div class="day-col pull-left">
		<div class="day-label">Monday<br><small><?php echo $week_start->format("j M Y"); ?></small></div>
		<?php for ($t = $time_start; $t < $time_end; $t++) {?>
		<div class="hour">
			<span class="hour-number"><?php echo date("G:i", strtotime($t.":00")); ?></span>
			<div class="events">
			<?php foreach ($calendar_meetings as $cm) { ?>
			<?php if ($cm[2] == $t && $cm[1] ==$week_start->format("j")) { ?>
			<div class="label label-info">
				<span><i class="fa fa-clock-o"></i> <?php echo get_the_title($cm[0]); ?></span>
			</div>					
			<?php } ?>
			<?php } ?>
			<?php foreach ($calendar_reminders as $cr) { ?>
			<?php if ($cr[2] == $t && $cm[1] ==$week_start->format("j")) { ?>
			<div class="label label-primary">
				<span><i class="fa fa-bell"></i> <?php echo get_the_title($cr[0]); ?></span>
			</div>
			<?php } ?>
			<?php } ?>
			</div>
		</div>
		<?php } ?>
	</div>
	<div class="day-col pull-left">
		<div class="day-label">Tuesday<br><small><?php echo date('j M Y', strtotime($week_start->format("j M Y")." +1 day") ); ?></small></div>
		<?php for ($t = $time_start; $t < $time_end; $t++) {?>
		<div class="hour">
			<span class="hour-number"><?php echo date("G:i", strtotime($t.":00")); ?></span>
			<div class="events">
			<?php foreach ($calendar_meetings as $cm) { ?>
			<?php if ($cm[2] == $t && $cm[1] == date('j', strtotime($week_start->format("j M Y")." +1 day") )) { ?>
			<div class="label label-info">
				<span><i class="fa fa-clock-o"></i> <?php echo get_the_title($cm[0]); ?></span>
			</div>					
			<?php } ?>
			<?php } ?>
			<?php foreach ($calendar_reminders as $cr ) { ?>
			<?php if ($cr[2] == $t && $cm[1] == date('j', strtotime($week_start->format("j M Y")." +1 day") ) ) { ?>
			<div class="label label-primary">
				<span><i class="fa fa-bell"></i> <?php echo get_the_title($cr[0]); ?></span>
			</div>
			<?php } ?>
			<?php } ?>
			</div>
		</div>
		<?php } ?>
	</div>
	<div class="day-col pull-left">
		<div class="day-label">Wednesday<br><small><?php echo date('j M Y', strtotime($week_start->format("j M Y")." +2 day") ); ?></small></div>
		<?php for ($t = $time_start; $t < $time_end; $t++) {?>
		<div class="hour">
			<span class="hour-number"><?php echo date("G:i", strtotime($t.":00")); ?></span>
			<div class="events">
			<?php foreach ($calendar_meetings as $cm) { ?>
			<?php if ($cm[2] == $t && $cm[1] == date('j', strtotime($week_start->format("j M Y")." +2 day") )) { ?>
			<div class="label label-info">
				<span><i class="fa fa-clock-o"></i> <?php echo get_the_title($cm[0]); ?></span>
			</div>					
			<?php } ?>
			<?php } ?>
			<?php foreach ($calendar_reminders as $cr) { ?>
			<?php if ($cr[2] == $t && $cm[1] == date('j', strtotime($week_start->format("j M Y")." +2 day") )) { ?>
			<div class="label label-primary">
				<span><i class="fa fa-bell"></i> <?php echo get_the_title($cr[0]); ?></span>
			</div>
			<?php } ?>
			<?php } ?>
			</div>
		</div>
		<?php } ?>
	</div>
	<div class="day-col pull-left">
		<div class="day-label">Thursday<br><small><?php echo date('j M Y', strtotime($week_start->format("j M Y")." +3 day") ); ?></small></div>
		<?php for ($t = $time_start; $t < $time_end; $t++) {?>
		<div class="hour">
			<span class="hour-number"><?php echo date("G:i", strtotime($t.":00")); ?></span>
			<div class="events">
			<?php foreach ($calendar_meetings as $cm) { ?>
			<?php if ($cm[2] == $t && $cm[1] == date('j', strtotime($week_start->format("j M Y")." +3 day"))) { ?>
			<div class="label label-info">
				<span><i class="fa fa-clock-o"></i> <?php echo get_the_title($cm[0]); ?></span>
			</div>					
			<?php } ?>
			<?php } ?>
			<?php foreach ($calendar_reminders as $cr) { ?>
			<?php if ($cr[2] == $t && $cm[1] ==date('j', strtotime($week_start->format("j M Y")." +3 day"))) { ?>
			<div class="label label-primary">
				<span><i class="fa fa-bell"></i> <?php echo get_the_title($cr[0]); ?></span>
			</div>
			<?php } ?>
			<?php } ?>
			</div>
		</div>
		<?php } ?>
	</div>
	<div class="day-col pull-left">
		<div class="day-label">Friday<br><small><?php echo $week_end->format("j M Y"); ?></small></div>
		<?php for ($t = $time_start; $t < $time_end; $t++) {?>
		<div class="hour">
			<span class="hour-number"><?php echo date("G:i", strtotime($t.":00")); ?></span>
			<div class="events">
			<?php foreach ($calendar_meetings as $cm) { ?>
			<?php if ($cm[2] == $t && $cm[1] == $week_end->format("j")) { ?>
			<div class="label label-info">
				<span><i class="fa fa-clock-o"></i> <?php echo get_the_title($cm[0]); ?></span>
			</div>					
			<?php } ?>
			<?php } ?>
			<?php foreach ($calendar_reminders as $cr) { ?>
			<?php if ($cr[2] == $t && $cm[1] == $week_end->format("j")) { ?>
			<div class="label label-primary">
				<span><i class="fa fa-bell"></i> <?php echo get_the_title($cr[0]); ?></span>
			</div>
			<?php } ?>
			<?php } ?>
			</div>
		</div>
		<?php } ?>
	</div>
	
</div>