<?php
global $current_user;
global $current_view;	
global $current_month;
$timeZone = 'Europe/London';
if ($current_month == 'next-month') {
$now_dateTime = new DateTime("next month", new DateTimeZone($timeZone));
$month_before = new DateTime("this month", new DateTimeZone($timeZone));
$month_start = new DateTime("first day of next month", new DateTimeZone($timeZone));
$month_end = new DateTime("last day of next month", new DateTimeZone($timeZone));
$next_month = new DateTime("+2 months", new DateTimeZone($timeZone));		
$last_week_of_last_month = date('W', strtotime("last day of ".$month_before->format("F")));
$first_week_of_this_month = date('W', strtotime($month_start->format("F jS")));
$first_week_of_next_month = date('W', strtotime("first day of ".$next_month->format("F")));
$number_of_week_days = $first_week_of_next_month - $last_week_of_last_month;
} else {
$now_dateTime = new DateTime("now", new DateTimeZone($timeZone));
$month_before = new DateTime("last month", new DateTimeZone($timeZone));
$month_start = new DateTime("first day of this month", new DateTimeZone($timeZone));
$month_end = new DateTime("last day of this month", new DateTimeZone($timeZone));
$next_month = new DateTime("next month", new DateTimeZone($timeZone));	
$last_week_of_last_month = date('W', strtotime("last day of ".$month_before->format("F")));
$first_week_of_this_month = date('W', strtotime($month_start->format("F jS")));
$first_week_of_next_month = date('W', strtotime("first day of ".$next_month->format("F")));
$number_of_week_days = $first_week_of_next_month - $last_week_of_last_month;
}
//debug($number_of_week_days);
$mons_counter = 0;
$tues_counter = 0;
$weds_counter = 0;
$thurs_counter = 0;
$fris_counter = 0;
$sats_counter = 0;
$suns_counter = 0;
$calendar_meetings = array();
$calendar_reminders = array();
$meetings_args = array(
'post_type'	=> 'tlw_meeting',
'posts_per_page' => -1	
);
$meetings = get_posts($meetings_args);
//debug($meetings);
foreach ($meetings as $m) {
$meeting_date = get_field('meeting_date', $m->ID);
//debug($meeting_date);
	if (date("mY", strtotime($meeting_date)) == $now_dateTime->format('mY')){
	$calendar_meetings[] = array($m->ID, date('j', strtotime($meeting_date)));	
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
'meta_value' => array($month_start->format('Ymd'), $month_end->format('Ymd')),
'meta_compare'	=> 'BETWEEN'
);
$reminders = get_posts($reminders_args);
//debug($meetings);

foreach ($reminders as $r) {
$reminder_date = get_field('reminder_date', $r->ID);
$reminder_group = get_field('reminder_group', $r->ID);	
//debug($meeting_date);
	if ($reminder_group != "meeting") {
	$calendar_reminders[] = array($r->ID, date('j', strtotime($reminder_date)));	
	}		
}
//debug($calendar_reminders);
?>

<div class="calendar-header">
	
	<?php  get_template_part( 'parts/calendar-page/calendar', 'key' ); ?>

	<div class="header-date-title"><?php echo $now_dateTime->format("F Y"); ?></div>

	<?php  get_template_part( 'parts/calendar-page/calendar', 'actions' ); ?>	
</div>
		
<div class="month-view weeks-count-<?php echo $number_of_week_days;?>">
		<div class="day-col pull-left">
			<div class="day-label">Monday</div>
			<?php for ($i = 1; $i <= $month_end->format("j"); $i++) {?>
			<?php 
			$weekNum_of_this_day = date('W', strtotime($now_dateTime->format("F")." ".$i."S"));	
			if ($last_week_of_last_month < $weekNum_of_this_day && $mons_counter == 0) { 
			$mons_counter++;
			?>
			<div class="day dim-day">
				<span class="day-number"><?php echo date("j", strtotime('last mon of '.$month_before->format("F"))); ?></span>
			</div>	
			<?php } ?>
			<?php if (date("N",strtotime($now_dateTime->format("F")." ".$i."S" ) ) == 1) { 
			$mons_counter++;	
			?>
				<div class="day<?php echo ($i == $now_dateTime->format('j') && $current_month == 'this-month') ? ' today': ''; ?>">
					<span class="day-number"><?php echo $i; ?></span>
					<?php// echo '<pre>';print_r($last_weekNum_of_this_month ." -----". $first_weekNum_of_next_month);echo '</pre>'; ?>
					<div class="events">
						<?php foreach ($calendar_meetings as $cm) { 
						$start_time = get_field('start_time', $cm[0]); 	
						?>
						<?php if ($cm[1] == $i) { ?>
						<div class="label label-info">
							<span><i class="fa fa-clock-o"></i> <?php echo $start_time; ?>:</span> <a href=""><?php echo get_the_title($cm[0]); ?></a>
						</div>					
						<?php } ?>
						<?php } ?>
						<?php foreach ($calendar_reminders as $cr) { 
						$rem_time = get_field('reminder_time', $cr[0]); 
						?>
						<?php if ($cr[1] == $i) { ?>
						<div class="label label-primary">
							<span><i class="fa fa-bell"></i> <?php echo $rem_time; ?>:</span> <a href=""><?php echo get_the_title($cr[0]); ?></a>
						</div>
						<?php } ?>
						<?php } ?>
					</div>
				</div>	
				<?php if ($i == date('j',strtotime('last mon of '.$now_dateTime->format("F"))) && $mons_counter == $number_of_week_days) { ?>
				<div class="day dim-day">
				<span class="day-number"><?php echo date("j", strtotime('first mon of '.$next_month->format("F"))); ?></span>
				</div>	
				<?php } ?>
			<?php } ?>

			<?php } ?>
		</div>	
		<div class="day-col pull-left">
			<div class="day-label">Tuesday</div>
			<?php for ($i = 1; $i <= $month_end->format("j"); $i++) {?>
			<?php 
			$weekNum_of_this_day = date('W', strtotime($now_dateTime->format("F")." ".$i."S"));	
			if ($last_week_of_last_month < $weekNum_of_this_day && $tues_counter == 0) { 
			$tues_counter++;
			?>
			<div class="day dim-day">
				<span class="day-number"><?php echo date("j", strtotime('last tue of '.$month_before->format("F"))); ?></span>
			</div>	
			<?php } ?>
			<?php if (date("N",strtotime($now_dateTime->format("F")." ".$i."S" ) ) == 2) { 
			$tues_counter++;	
			?>
				<div class="day<?php echo ($i == $now_dateTime->format('j') && $current_month == 'this-month') ? ' today': ''; ?>">
					<span class="day-number"><?php echo $i; ?></span>
					<div class="events">
						<?php foreach ($calendar_meetings as $cm) { 
						$start_time = get_field('start_time', $cm[0]); 	
						?>
						<?php if ($cm[1] == $i) { ?>
						<div class="label label-info">
							<span><i class="fa fa-clock-o"></i> <?php echo $start_time; ?>:</span> <a href=""><?php echo get_the_title($cm[0]); ?></a>
						</div>					
						<?php } ?>
						<?php } ?>
						<?php foreach ($calendar_reminders as $cr) { 
						$rem_time = get_field('reminder_time', $cr[0]); 	
						?>
						<?php if ($cr[1] == $i) { ?>
						<div class="label label-primary">
							<span><i class="fa fa-bell"></i> <?php echo $rem_time; ?>:</span> <a href=""><?php echo get_the_title($cr[0]); ?></a>
						</div>
						<?php } ?>
						<?php } ?>
					</div>
				</div>	
				<?php if ($i == date('j',strtotime('last tue of '.$now_dateTime->format("F"))) && $tues_counter == $number_of_week_days) { ?>
				<div class="day dim-day">
				<span class="day-number"><?php echo date("j", strtotime('first tue of '.$next_month->format("F"))); ?></span>
				</div>	
				<?php } ?>
			<?php } ?>

			<?php } ?>
		</div>	
		<div class="day-col pull-left">
			<div class="day-label">Wednesday</div>
			<?php for ($i = 1; $i <= $month_end->format("j"); $i++) {?>
			<?php 
			$weekNum_of_this_day = date('W', strtotime($now_dateTime->format("F")." ".$i."S"));	
			if ($last_week_of_last_month < $weekNum_of_this_day && $weds_counter == 0) {
			$weds_counter++;
			?>
			<div class="day dim-day">
				<span class="day-number"><?php echo date("j", strtotime('last wed of '.$month_before->format("F"))); ?></span>
			</div>	
			<?php } ?>
			<?php if (date("N",strtotime($now_dateTime->format("F")." ".$i."S" ) ) == 3) { 
			$weds_counter++;	
			?>
				<div class="day<?php echo ($i == $now_dateTime->format('j') && $current_month == 'this-month') ? ' today': ''; ?>">
					<span class="day-number"><?php echo $i; ?></span>
					<div class="events">
						<?php foreach ($calendar_meetings as $cm) { 
						$start_time = get_field('start_time', $cm[0]); 	
						?>
						<?php if ($cm[1] == $i) { ?>
						<div class="label label-info">
							<span><i class="fa fa-clock-o"></i> <?php echo $start_time; ?>:</span> <a href=""><?php echo get_the_title($cm[0]); ?></a>
						</div>					
						<?php } ?>
						<?php } ?>
						<?php foreach ($calendar_reminders as $cr) { 
						$rem_time = get_field('reminder_time', $cr[0]); 	
						?>
						<?php if ($cr[1] == $i) { ?>
						<div class="label label-primary">
							<span><i class="fa fa-bell"></i> <?php echo $rem_time; ?>:</span> <a href=""><?php echo get_the_title($cr[0]); ?></a>
						</div>
						<?php } ?>
						<?php } ?>
					</div>
				</div>	
				<?php if ($i == date('j',strtotime('last wed of '.$now_dateTime->format("F"))) && $weds_counter == $number_of_week_days) { ?>
				<div class="day dim-day">
				<span class="day-number"><?php echo date("j", strtotime('first wed of '.$next_month->format("F"))); ?></span>
				</div>	
				<?php } ?>
			<?php } ?>

			<?php } ?>
		</div>	
		<div class="day-col pull-left">
			<div class="day-label">Thursday</div>
			<?php for ($i = 1; $i <= $month_end->format("j"); $i++) {?>
			<?php 
			$weekNum_of_this_day = date('W', strtotime($now_dateTime->format("F")." ".$i."S"));	
			if ($last_week_of_last_month < $weekNum_of_this_day && $thurs_counter == 0) { 
			$thurs_counter++;
			?>
			<div class="day dim-day">
				<span class="day-number"><?php echo date("j", strtotime('last thu of '.$month_before->format("F"))); ?></span>
				
			</div>	
			<?php } ?>
			<?php if (date("N",strtotime($now_dateTime->format("F")." ".$i."S" ) ) == 4) { 
			$thurs_counter++;	
			?>
				<div class="day<?php echo ($i == $now_dateTime->format('j') && $current_month == 'this-month') ? ' today': ''; ?>">
					<span class="day-number"><?php echo $i; ?></span>
					<div class="events">
						<?php foreach ($calendar_meetings as $cm) { 
						$start_time = get_field('start_time', $cm[0]); 	
						?>
						<?php if ($cm[1] == $i) { ?>
						<div class="label label-info">
							<span><i class="fa fa-clock-o"></i> <?php echo $start_time; ?>:</span> <a href=""><?php echo get_the_title($cm[0]); ?></a>
						</div>					
						<?php } ?>
						<?php } ?>
						<?php foreach ($calendar_reminders as $cr) { 
						$rem_time = get_field('reminder_time', $cr[0]); 	
						?>
						<?php if ($cr[1] == $i) { ?>
						<div class="label label-primary">
							<span><i class="fa fa-bell"></i> <?php echo $rem_time; ?>:</span> <a href=""><?php echo get_the_title($cr[0]); ?></a>
						</div>
						<?php } ?>
						<?php } ?>
					</div>
				</div>	
				<?php if ($i == date('j',strtotime('last thu of '.$now_dateTime->format("F"))) && $thurs_counter == $number_of_week_days) { ?>
				<div class="day dim-day">
				<span class="day-number"><?php echo date("j", strtotime('first thu of '.$next_month->format("F"))); ?></span>
				</div>	
				<?php } ?>
			<?php } ?>

			<?php } ?>
		</div>	
		<div class="day-col pull-left">
			<div class="day-label">Friday</div>
			<?php for ($i = 1; $i <= $month_end->format("j"); $i++) {?>
			<?php 
			$weekNum_of_this_day = date('W', strtotime($now_dateTime->format("F")." ".$i."S"));	
			if ($last_week_of_last_month < $weekNum_of_this_day && $fris_counter == 0) { 
			$fris_counter++;
			?>
			<div class="day dim-day">
				<span class="day-number"><?php echo date("j", strtotime('last fri of '.$month_before->format("F"))); ?></span>
			</div>	
			<?php } ?>
			<?php if (date("N",strtotime($now_dateTime->format("F")." ".$i."S" ) ) == 5) { 
			$fris_counter++;	
			?>
				<div class="day<?php echo ($i == $now_dateTime->format('j') && $current_month == 'this-month') ? ' today': ''; ?>">
					<span class="day-number"><?php echo $i; ?></span>
					<div class="events">
						<?php foreach ($calendar_meetings as $cm) { 
						$start_time = get_field('start_time', $cm[0]); 	
						?>
						<?php if ($cm[1] == $i) { ?>
						<div class="label label-info">
							<span><i class="fa fa-clock-o"></i> <?php echo $start_time; ?>:</span> <a href=""><?php echo get_the_title($cm[0]); ?></a>
						</div>					
						<?php } ?>
						<?php } ?>
						<?php foreach ($calendar_reminders as $cr) {
						$rem_time = get_field('reminder_time', $cr[0]); 	
						?>
						<?php if ($cr[1] == $i) { ?>
						<div class="label label-primary">
							<span><i class="fa fa-bell"></i> <?php echo $rem_time; ?>:</span> <a href=""><?php echo get_the_title($cr[0]); ?></a>
						</div>
						<?php } ?>
						<?php } ?>
					</div>
				</div>	
				<?php if ($i == date('j',strtotime('last fri of '.$now_dateTime->format("F"))) && $fris_counter == $number_of_week_days) { ?>
				<div class="day dim-day">
				<span class="day-number"><?php echo date("j", strtotime('first fri of '.$next_month->format("F"))); ?></span>
				</div>	
				<?php } ?>
			<?php } ?>

			<?php } ?>
		</div>	
		 		
</div>