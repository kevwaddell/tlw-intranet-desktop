<?php
global $current_user;
$timeZone = 'Europe/London';
$now_dateTime = new DateTime("now", new DateTimeZone($timeZone));
$month_before = new DateTime("last month", new DateTimeZone($timeZone));
$month_start = new DateTime("first day of this month", new DateTimeZone($timeZone));
$month_end = new DateTime("last day of this month", new DateTimeZone($timeZone));
$next_month = new DateTime("next month", new DateTimeZone($timeZone));
//debug(date("j", strtotime('last sat of '.$month_before->format("F"))));
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
	if (date("mY", strtotime($meeting_date)) == date('mY')){
	$calendar_meetings[] = array($m->ID, date('j', strtotime($meeting_date)));	
	}
}
$reminders_args = array(
'posts_per_page' => -1,
'post_type' => 'tlw_reminder',
'author'	=> $current_user->ID
);
$reminders = get_posts($reminders_args);
//debug($meetings);
foreach ($reminders as $r) {
$reminder_date = get_field('reminder_date', $r->ID);
//debug($meeting_date);
	if (date("mY", strtotime($reminder_date)) == date('mY')){
	$calendar_reminders[] = array($r->ID, date('j', strtotime($reminder_date)));	
	}
}
//debug($calendar_reminders);
?>

<div class="calendar-header">
	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-2">
				
			</div>
			<div class="col-xs-8">
			<?php echo $now_dateTime->format("F Y"); ?>
			</div>
			<div class="col-xs-2">
				
			</div>
		</div>
	</div>		
</div>
		
<div class="month-view">
		<div class="day-col pull-left">
			<div class="day-label">Monday</div>
			<?php for ($i = 1; $i <= $month_end->format("j"); $i++) {?>
			<?php if ($i == 1 && $mons_counter == 0) { 
			$mons_counter++;
			?>
			<div class="day dim-day">
				<span class="day-number"><?php echo date("j", strtotime('last mon of '.$month_before->format("F"))); ?></span>
			</div>	
			<?php } ?>
			<?php if (date("N",strtotime($now_dateTime->format("F")." ".$i."S" ) ) == 1) { 
			$mons_counter++;	
			?>
				<div class="day">
					<span class="day-number<?php echo ($i == date('j')) ? ' today': ''; ?>"><?php echo $i; ?></span>
					<div class="events">
						<?php if (in_array_r($i, $calendar_meetings)) { 
						$k = in_array_key($i, $calendar_meetings);
						?>
						<div class="label label-info block">
							<?php echo get_the_title($calendar_meetings[$k][0]); ?>
						</div>
						<?php } ?>
						<?php if (in_array_r($i, $calendar_reminders)) { 
						$k = in_array_key($i,$calendar_reminders);
						?>
						<div class="label label-primary block">
							<?php echo get_the_title($calendar_reminders[$k][0]); ?>
						</div>
						<?php } ?>
					</div>
				</div>	
				<?php if ($i == date('j',strtotime('last mon of '.$now_dateTime->format("F"))) && $mons_counter < 6) { ?>
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
			<?php if ($i == 2 && $tues_counter == 0) { 
			$tues_counter++;
			?>
			<div class="day dim-day">
				<span class="day-number"><?php echo date("j", strtotime('last tue of '.$month_before->format("F"))); ?></span>
			</div>	
			<?php } ?>
			<?php if (date("N",strtotime($now_dateTime->format("F")." ".$i."S" ) ) == 2) { 
			$tues_counter++;	
			?>
				<div class="day">
					<span class="day-number<?php echo ($i == date('j')) ? ' today': ''; ?>"><?php echo $i; ?></span>
					<div class="events">
						<?php if (in_array_r($i, $calendar_meetings)) { 
						$k = in_array_key($i, $calendar_meetings);
						?>
						<div class="label label-info block">
							<?php echo get_the_title($calendar_meetings[$k][0]); ?>
						</div>
						<?php } ?>
						<?php if (in_array_r($i, $calendar_reminders)) { 
						$k = in_array_key($i,$calendar_reminders);
						?>
						<div class="label label-primary block">
							<?php echo get_the_title($calendar_reminders[$k][0]); ?>
						</div>
						<?php } ?>
					</div>
				</div>	
				<?php if ($i == date('j',strtotime('last tue of '.$now_dateTime->format("F"))) && $tues_counter < 6) { ?>
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
			<?php if ($i == 3 && $weds_counter == 0) { 
			$weds_counter++;
			?>
			<div class="day dim-day">
				<span class="day-number"><?php echo date("j", strtotime('last wed of '.$month_before->format("F"))); ?></span>
			</div>	
			<?php } ?>
			<?php if (date("N",strtotime($now_dateTime->format("F")." ".$i."S" ) ) == 3) { 
			$weds_counter++;	
			?>
				<div class="day">
					<span class="day-number<?php echo ($i == date('j')) ? ' today': ''; ?>"><?php echo $i; ?></span>
					<div class="events">
						<?php if (in_array_r($i, $calendar_meetings)) { 
						$k = in_array_key($i, $calendar_meetings);
						?>
						<div class="label label-info block">
							<?php echo get_the_title($calendar_meetings[$k][0]); ?>
						</div>
						<?php } ?>
						<?php if (in_array_r($i, $calendar_reminders)) { 
						$k = in_array_key($i,$calendar_reminders);
						?>
						<div class="label label-primary block">
							<?php echo get_the_title($calendar_reminders[$k][0]); ?>
						</div>
						<?php } ?>
					</div>
				</div>	
				<?php if ($i == date('j',strtotime('last wed of '.$now_dateTime->format("F"))) && $weds_counter < 6) { ?>
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
			<?php if ($i == 4 && $thurs_counter == 0) { 
			$thurs_counter++;
			?>
			<div class="day dim-day">
				<span class="day-number"><?php echo date("j", strtotime('last thu of '.$month_before->format("F"))); ?></span>
				<div class="events">
					<?php if (in_array_r($i, $calendar_meetings)) { 
						$k = in_array_key($i, $calendar_meetings);
						?>
						<div class="label label-info block">
							<?php echo get_the_title($calendar_meetings[$k][0]); ?>
						</div>
						<?php } ?>
						<?php if (in_array_r($i, $calendar_reminders)) { 
						$k = in_array_key($i,$calendar_reminders);
						?>
						<div class="label label-primary block">
							<?php echo get_the_title($calendar_reminders[$k][0]); ?>
						</div>
						<?php } ?>	
				</div>
			</div>	
			<?php } ?>
			<?php if (date("N",strtotime($now_dateTime->format("F")." ".$i."S" ) ) == 4) { 
			$thurs_counter++;	
			?>
				<div class="day">
					<span class="day-number<?php echo ($i == date('j')) ? ' today': ''; ?>"><?php echo $i; ?></span>
				</div>	
				<?php if ($i == date('j',strtotime('last thu of '.$now_dateTime->format("F"))) && $thurs_counter < 6) { ?>
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
			<?php if ($i == 5 && $fris_counter == 0) { 
			$fris_counter++;
			?>
			<div class="day dim-day">
				<span class="day-number"><?php echo date("j", strtotime('last fri of '.$month_before->format("F"))); ?></span>
			</div>	
			<?php } ?>
			<?php if (date("N",strtotime($now_dateTime->format("F")." ".$i."S" ) ) == 5) { 
			$fris_counter++;	
			?>
				<div class="day">
					<span class="day-number<?php echo ($i == date('j')) ? ' today': ''; ?>"><?php echo $i; ?></span>
					<div class="events">
					<?php if (in_array_r($i, $calendar_meetings)) { 
						$k = in_array_key($i, $calendar_meetings);
						?>
						<div class="label label-info block">
							<?php echo get_the_title($calendar_meetings[$k][0]); ?>
						</div>
						<?php } ?>
						<?php if (in_array_r($i, $calendar_reminders)) { 
						$k = in_array_key($i,$calendar_reminders);
						?>
						<div class="label label-primary block">
							<?php echo get_the_title($calendar_reminders[$k][0]); ?>
						</div>
						<?php } ?>
					</div>
				</div>	
				<?php if ($i == date('j',strtotime('last fri of '.$now_dateTime->format("F"))) && $fris_counter < 6) { ?>
				<div class="day dim-day">
				<span class="day-number"><?php echo date("j", strtotime('first fri of '.$next_month->format("F"))); ?></span>
				</div>	
				<?php } ?>
			<?php } ?>

			<?php } ?>
		</div>	
		<div class="day-col wk-end pull-left">
			<div class="day-label">Sat</div>
			<?php for ($i = 1; $i <= $month_end->format("j"); $i++) {?>
			<?php if ($i == 6 && $sats_counter == 0) { 
			$sats_counter++;	
			?>
			<div class="day dim-day">
				<span class="day-number"><?php echo date("j", strtotime('last sat of '.$month_before->format("F"))); ?></span>
			</div>	
			<?php } ?>
			<?php if (date("N",strtotime($now_dateTime->format("F")." ".$i."S" ) ) == 6) { 
			$sats_counter++;	
			?>
				<div class="day">
					<span class="day-number<?php echo ($i == date('j')) ? ' today': ''; ?>"><?php echo $i; ?></span>
				</div>	
				<?php if ($i == date('j',strtotime('last sat of '.$now_dateTime->format("F"))) && $sats_counter < 6) { ?>
				<div class="day dim-day">
				<span class="day-number<?php echo ($i == date('j')) ? ' today': ''; ?>"><?php echo date("j", strtotime('first sat of '.$next_month->format("F"))); ?></span>
				</div>	
				<?php } ?>
			<?php } ?>

			<?php } ?>
		</div>	
		<div class="day-col wk-end pull-left">
			<div class="day-label">Sun</div>
			<?php for ($i = 1; $i <= $month_end->format("j"); $i++) {?>
			<?php if ($i == 7 && $suns_counter == 0) { 
			$suns_counter++;	
			?>
			<div class="day dim-day">
				<span class="day-number"><?php echo date("j", strtotime('last sun of '.$month_before->format("F"))); ?></span>
			</div>	
			<?php } ?>
			<?php if (date("N",strtotime($now_dateTime->format("F")." ".$i."S" ) ) == 7) {
			$suns_counter++;	
			?>
				<div class="day">
					<span class="day-number<?php echo ($i == date('j')) ? ' today': ''; ?>"><?php echo $i; ?></span>
				</div>
				<?php if ($i == date('j',strtotime('last sun of '.$now_dateTime->format("F"))) && $suns_counter < 6) { ?>
				<div class="day dim-day">
				<span class="day-number"><?php echo date("j", strtotime('first sun of '.$next_month->format("F"))); ?></span>
				</div>	
				<?php } ?>	
			<?php } ?>
			<?php } ?>
		</div>			
</div>