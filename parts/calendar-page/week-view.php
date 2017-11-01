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
'meta_value' => array($week_start->format('Ymd'), $week_end->format('Ymd')),
'meta_compare'	=> 'BETWEEN'
);
$meetings = get_posts($meetings_args);
foreach ($meetings as $m) {
$meeting_date = get_field('meeting_date', $m->ID);
$attendees_staff = get_field('attendees_staff', $m->ID);
//debug($meeting_date);
	if (date("mY", strtotime($meeting_date)) == $now_dateTime->format('mY')){
		
		if ($m->post_author == $current_user->ID) {
		$calendar_meetings[] = array($m->ID, date('j', strtotime($meeting_date)));	
		}
		
		foreach ($attendees_staff as $staff) { 
			if ($staff['attendee']['ID'] == $current_user->ID) {
			$calendar_meetings[] = array($m->ID, date('j', strtotime($meeting_date)));	
			}	
		}
	}
}

$reminders_completed_raw = get_user_meta($current_user->ID, 'reminders_completed', true);
$reminders_completed = unserialize($reminders_completed_raw);
$excluded_rems = array();
if (!empty($reminders_completed)) {
	foreach ($reminders_completed as $key => $rc) { 
	$rem_id = $rc['reminder-id'];
	$reminder_group = get_field('reminder_group', $rem_id);	
	$reminder_repeat = get_field('reminder_repeat', $rem_id);	
	$reminder_date = date("Ymd", strtotime(get_field('reminder_date', $rem_id)));
		if (!in_array($rem_id, $excluded_rems) && $reminder_repeat == "never") {
		$excluded_rems[] = $rem_id;
		}
		if (!in_array($rem_id, $excluded_rems) && $reminder_group == "meeting") {
		$excluded_rems[] = $rem_id;
		}
	}
}

$reminders_args = array(
'posts_per_page' => -1,
'post_type' => 'tlw_reminder',
'author'	=> $current_user->ID,
'exclude'	=> $excluded_rems,
'meta_key'	=> 'reminder_date',
'meta_value' => array($week_start->format('Ymd'), $week_end->format('Ymd')),
'meta_compare'	=> 'BETWEEN'
);
$reminders = get_posts($reminders_args);
//debug($meetings);

foreach ($reminders as $r) {
$reminder_date = get_field('reminder_date', $r->ID);
$reminder_time = get_field('reminder_time', $r->ID);
$reminder_group = get_field('reminder_group', $r->ID);	
//debug($meeting_date);
	if ($reminder_group != "meeting") {
	$calendar_reminders[] = array($r->ID, date('j', strtotime($reminder_date)), date('G', strtotime($reminder_time)));	
	}
}
//debug(date('j', strtotime($week_start->format("j M Y")." +2 day") ));
//debug($week_start->format("j"));
?>

<div class="calendar-header">
	<?php  get_template_part( 'parts/calendar-page/calendar', 'key' ); ?>
		
	<div class="header-date-title"><?php echo $week_start->format("D jS M Y"); ?> - <?php echo $week_end->format("D jS M Y"); ?></div>
		
	<?php  get_template_part( 'parts/calendar-page/calendar', 'actions' ); ?>
</div>

<div class="week-view">
	<div class="day-col pull-left<?php echo (date("j") == $week_start->format("j") && $current_week == 'this-week') ? ' today':''; ?>">
		<div class="day-label">Monday<br><small><?php echo $week_start->format("j M Y"); ?></small></div>
		<?php for ($t = $time_start; $t < $time_end; $t++) {?>
		<div class="hour">
			<span class="hour-number"><?php echo date("ga", strtotime($t.":00")); ?></span>
			<div class="events">
			<?php foreach ($calendar_meetings as $cm) { 
			$start_time = get_field('start_time', $cm[0]);
			?>
			<?php if ($cm[2] == $t && $cm[1] == $week_start->format("j")) { ?>
			<div class="label label-info">
				<a href="<?php echo get_permalink($meetings_pg->ID); ?>?meeting-id=<?php echo $cm[0]; ?>&meeting-day=<?php echo $month_start->format('Ymd'); ?>&meeting-day-to=<?php echo $month_end->format('Ymd');; ?>"><time><i class="fa fa-clock-o"></i> <?php echo $start_time; ?></time><span><?php echo get_the_title($cm[0]); ?></span></a>
			</div>					
			<?php } ?>
			<?php } ?>
			<?php foreach ($calendar_reminders as $cr) {
			$group = get_field('reminder_group', $cr[0]);  
			$rem_time = get_field('reminder_time', $cr[0]);	
			?>
			<?php if ($cr[2] == $t && $cr[1] == $week_start->format("j")) { ?>
			<div class="label label-primary">
				<a href="<?php echo get_permalink($reminders_pg->ID); ?>?group-id=<?php echo $group; ?>"><time><i class="fa fa-bell"></i> <?php echo $rem_time; ?></time><span><?php echo get_the_title($cr[0]); ?></span></a>
			</div>
			<?php } ?>
			<?php } ?>
			</div>
		</div>
		<?php } ?>
	</div>
	<div class="day-col pull-left<?php echo (date("j") == ($week_start->format("j") + 1 ) && $current_week == 'this-week') ? ' today':''; ?>">
		<div class="day-label">Tuesday<br><small><?php echo date('j M Y', strtotime($week_start->format("j M Y")." +1 day") ); ?></small></div>
		<?php for ($t = $time_start; $t < $time_end; $t++) {?>
		<div class="hour">
			<span class="hour-number"><?php echo date("ga", strtotime($t.":00")); ?></span>
			<div class="events">
			<?php foreach ($calendar_meetings as $cm) { 
			$start_time = get_field('start_time', $cm[0]);	
			?>
			<?php if ($cm[2] == $t && $cm[1] == ($week_start->format("j") + 1)) { ?>
			<div class="label label-info">
				<a href="<?php echo get_permalink($meetings_pg->ID); ?>?meeting-id=<?php echo $cm[0]; ?>&meeting-day=<?php echo $month_start->format('Ymd'); ?>&meeting-day-to=<?php echo $month_end->format('Ymd');; ?>"><time><i class="fa fa-clock-o"></i> <?php echo $start_time; ?></time><span><?php echo get_the_title($cm[0]); ?></span></a>
			</div>					
			<?php } ?>
			<?php } ?>
			<?php foreach ($calendar_reminders as $cr ) {
			$group = get_field('reminder_group', $cr[0]);  
			$rem_time = get_field('reminder_time', $cr[0]);
			?>
			<?php if ($cr[2] == $t && $cr[1] == ($week_start->format("j") + 1) ) { ?>
			<div class="label label-primary">
				<a href="<?php echo get_permalink($reminders_pg->ID); ?>?group-id=<?php echo $group; ?>"><time><i class="fa fa-bell"></i> <?php echo $rem_time; ?></time><span><?php echo get_the_title($cr[0]); ?></span></a>
			</div>
			<?php } ?>
			<?php } ?>
			</div>
		</div>
		<?php } ?>
	</div>
	<div class="day-col pull-left<?php echo (date("j") == ($week_start->format("j") + 2) && $current_week == 'this-week') ? ' today':''; ?>">
		<div class="day-label">Wednesday<br><small><?php echo date('j M Y', strtotime($week_start->format("j M Y")." +2 days") ); ?></small></div>
		<?php for ($t = $time_start; $t < $time_end; $t++) {?>
		<div class="hour">
			<span class="hour-number"><?php echo date("ga", strtotime($t.":00")); ?></span>
			<div class="events">
			<?php foreach ($calendar_meetings as $cm) { 
			$start_time = get_field('start_time', $cm[0]);	
			?>
			<?php if ($cm[2] == $t && $cm[1] == ($week_start->format("j") + 2)) { ?>
			<div class="label label-info">
				<a href="<?php echo get_permalink($meetings_pg->ID); ?>?meeting-id=<?php echo $cm[0]; ?>&meeting-day=<?php echo $month_start->format('Ymd'); ?>&meeting-day-to=<?php echo $month_end->format('Ymd');; ?>"><time><i class="fa fa-clock-o"></i> <?php echo $start_time; ?></time><span><?php echo get_the_title($cm[0]); ?></span></a>
			</div>					
			<?php } ?>
			<?php } ?>
			<?php foreach ($calendar_reminders as $cr) {
			$group = get_field('reminder_group', $cr[0]);  
			$rem_time = get_field('reminder_time', $cr[0]);
			?>
			<?php if ($cr[2] == $t && $cr[1] == ($week_start->format("j") + 2)) { ?>
			<div class="label label-primary">
				<a href="<?php echo get_permalink($reminders_pg->ID); ?>?group-id=<?php echo $group; ?>"><time><i class="fa fa-bell"></i> <?php echo $rem_time; ?></time><span><?php echo get_the_title($cr[0]); ?></span></a>
			</div>
			<?php } ?>
			<?php } ?>
			</div>
		</div>
		<?php } ?>
	</div>
	<div class="day-col pull-left<?php echo (date("j") == ($week_start->format("j") + 3) && $current_week == 'this-week') ? ' today':''; ?>">
		<div class="day-label">Thursday<br><small><?php echo date('j M Y', strtotime($week_start->format("j M Y")." +3 days") ); ?></small></div>
		<?php for ($t = $time_start; $t < $time_end; $t++) {?>
		<div class="hour">
			<span class="hour-number"><?php echo date("ga", strtotime($t.":00")); ?></span>
			<div class="events">
			<?php foreach ($calendar_meetings as $cm) { 
			$start_time = get_field('start_time', $cm[0]);		
			?>
			<?php if ($cm[2] == $t && $cm[1] == ($week_start->format("j") + 3)) { ?>
			<div class="label label-info">
				<a href="<?php echo get_permalink($meetings_pg->ID); ?>?meeting-id=<?php echo $cm[0]; ?>&meeting-day=<?php echo $month_start->format('Ymd'); ?>&meeting-day-to=<?php echo $month_end->format('Ymd');; ?>"><time><i class="fa fa-clock-o"></i> <?php echo $start_time; ?></time><span><?php echo get_the_title($cm[0]); ?></span></a>
			</div>					
			<?php } ?>
			<?php } ?>
			<?php foreach ($calendar_reminders as $cr) {
			$group = get_field('reminder_group', $cr[0]);
			$rem_time = get_field('reminder_time', $cr[0]);	
			?>
			<?php if ($cr[2] == $t && $cr[1] == ($week_start->format("j") + 3)) { ?>
			<div class="label label-primary">
				<a href="<?php echo get_permalink($reminders_pg->ID); ?>?group-id=<?php echo $group; ?>"><time><i class="fa fa-bell"></i> <?php echo $rem_time; ?></time><span><?php echo get_the_title($cr[0]); ?></span></a>
			</div>
			<?php } ?>
			<?php } ?>
			</div>
		</div>
		<?php } ?>
	</div>
	<div class="day-col pull-left<?php echo (date("j") == $week_end->format("j") && $current_week == 'this-week') ? ' today':''; ?>">
		<div class="day-label">Friday<br><small><?php echo $week_end->format("j M Y"); ?></small></div>
		<?php for ($t = $time_start; $t < $time_end; $t++) {?>
		<div class="hour">
			<span class="hour-number"><?php echo date("ga", strtotime($t.":00")); ?></span>
			<div class="events">
			<?php foreach ($calendar_meetings as $cm) { 
			$start_time = get_field('start_time', $cm[0]);	
			?>
			<?php if ($cm[2] == $t && $cm[1] == $week_end->format("j")) { ?>
			<div class="label label-info">
				<a href="<?php echo get_permalink($meetings_pg->ID); ?>?meeting-id=<?php echo $cm[0]; ?>&meeting-day=<?php echo $month_start->format('Ymd'); ?>&meeting-day-to=<?php echo $month_end->format('Ymd');; ?>"><time><i class="fa fa-clock-o"></i> <?php echo $start_time; ?></time><span><?php echo get_the_title($cm[0]); ?></span></a>
			</div>					
			<?php } ?>
			<?php } ?>
			<?php foreach ($calendar_reminders as $cr) {
			$group = get_field('reminder_group', $cr[0]); 
			$rem_time = get_field('reminder_time', $cr[0]);	
			?>
			<?php if ($cr[2] == $t && $cr[1] == $week_end->format("j")) { ?>
			<div class="label label-primary">
				<a href="<?php echo get_permalink($reminders_pg->ID); ?>?group-id=<?php echo $group; ?>"><time><i class="fa fa-bell"></i> <?php echo $rem_time; ?></time><span><?php echo get_the_title($cr[0]); ?></span></a>
			</div>
			<?php } ?>
			<?php } ?>
			</div>
		</div>
		<?php } ?>
	</div>
	
</div>