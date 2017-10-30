<?php
global $current_user;
global $current_view;	
global $current_day;
$timeZone = 'Europe/London';
$time_start = 9;
$time_end = 18;
if ($current_day == 'tomorrow') {
	if (date('w', strtotime("tomorrow")) == 5 || date('w', strtotime("tomorrow")) == 6) {
	$now_dateTime = new DateTime("Monday next week", new DateTimeZone($timeZone));	
	} else {
	$now_dateTime = new DateTime("tomorrow", new DateTimeZone($timeZone));	
	}
} else {
$now_dateTime = new DateTime("today", new DateTimeZone($timeZone));	
}

$calendar_meetings = array();
$calendar_reminders = array();
$meetings_args = array(
'post_type'	=> 'tlw_meeting',
'posts_per_page' => -1,	
'meta_key'	=> 'meeting_date',
'meta_value'	=> $now_dateTime->format('Ymd')
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

$reminders_args = array(
'posts_per_page' => -1,
'post_type' => 'tlw_reminder',
'author'	=> $current_user->ID,
'exclude'	=> $excluded_rems,
'meta_key'	=> 'reminder_date',
'meta_value' => $now_dateTime->format('Ymd')
);
$reminders = get_posts($reminders_args);
//debug($meetings);

foreach ($reminders as $r) {
$reminder_date = get_field('reminder_date', $r->ID);
$reminder_time = get_field('reminder_time', $r->ID);
$reminder_group = get_field('reminder_group', $r->ID);	
//debug($meeting_date);
	if ($reminder_group != "meeting") {
	$calendar_reminders[] = array($r->ID, date('G', strtotime($reminder_time)));	
	}
}
//debug(date('j', strtotime($week_start->format("j M Y")." +2 day") ));
//debug($calendar_meetings);
?>

<div class="calendar-header">
	<?php  get_template_part( 'parts/calendar-page/calendar', 'key' ); ?>
		
	<div class="header-date-title"><?php echo $now_dateTime->format("l jS F Y"); ?></div>
		
	<?php  get_template_part( 'parts/calendar-page/calendar', 'actions' ); ?>
</div>

<div class="day-view">
	<?php for ($t = $time_start; $t < $time_end; $t++) {?>
	<div class="hour-col pull-left">
		<div class="hour-label"><?php echo date("g:i a", strtotime($t.":00")); ?></div>
		<div class="mins first-half-hr">
			<div class="events">
			<?php foreach ($calendar_meetings as $cm) { ?>
			<?php
			$start_time = get_field('start_time', $cm[0]); 	
			?>
			<?php if ($cm[1] == $t && date('i', strtotime($start_time)) == '00') { ?>
			<div class="label label-info">
				<a href="<?php echo get_permalink($meetings_pg->ID); ?>?meeting-id=<?php echo $cm[0]; ?>&meeting-day=<?php echo $month_start->format('Ymd'); ?>&meeting-day-to=<?php echo $month_end->format('Ymd');; ?>"><time><i class="fa fa-clock-o"></i> <?php echo $start_time; ?></time><span><?php echo get_the_title($cm[0]); ?></span></a>
			</div>					
			<?php } ?>
			<?php } ?>	
			<?php foreach ($calendar_reminders as $cr) { ?>
			<?php
			$group = get_field('reminder_group', $cr[0]);
			$rem_time = get_field('reminder_time', $cr[0]); 	
			?>
			<?php if ($cr[1] == $t && date('i', strtotime($rem_time)) == '00') { ?>
			<?php //echo '<pre>';print_r( $start_time );echo '</pre>'; ?>
			<div class="label label-primary">
				<a href="<?php echo get_permalink($reminders_pg->ID); ?>?group-id=<?php echo $group; ?>"><time><i class="fa fa-bell"></i> <?php echo $rem_time; ?></time><span><?php echo get_the_title($cr[0]); ?></span></a>
			</div>
			<?php } ?>
			<?php } ?>
			</div>
		</div>	
		<div class="mins second-half-hr">
		<div class="min-number"><?php echo date("g:i a", strtotime($t.":30")); ?></div>	
			<div class="events">
			<?php foreach ($calendar_meetings as $cm) { ?>
			<?php
			$start_time = get_field('start_time', $cm[0]); 	
			?>
			<?php if ($cm[1] == $t && date('i', strtotime($start_time)) == '30') { ?>
			<div class="label label-info">
				<a href="<?php echo get_permalink($meetings_pg->ID); ?>?meeting-id=<?php echo $cm[0]; ?>&meeting-day=<?php echo $month_start->format('Ymd'); ?>&meeting-day-to=<?php echo $month_end->format('Ymd');; ?>"><time><i class="fa fa-clock-o"></i> <?php echo $start_time; ?></time><span><?php echo get_the_title($cm[0]); ?></span></a>
			</div>					
			<?php } ?>
			<?php } ?>
			<?php foreach ($calendar_reminders as $cr) { ?>
			<?php
			$group = get_field('reminder_group', $cr[0]);
			$rem_time = get_field('reminder_time', $cr[0]); 	
			?>
			<?php if ($cr[1] == $t && date('i', strtotime($rem_time)) == '30') { ?>
			<div class="label label-primary">
				<a href="<?php echo get_permalink($reminders_pg->ID); ?>?group-id=<?php echo $group; ?>"><time><i class="fa fa-bell"></i> <?php echo $rem_time; ?></time><span><?php echo get_the_title($cr[0]); ?></span></a>
			</div>
			<?php } ?>
			<?php } ?>	
			</div>
		</div>	
	</div>
	<?php } ?>
</div>
