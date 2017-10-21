<?php
global $reminder_groups;
global $date_format;
global $time_format;
global $timeZone;
$reminders_args = array(
	'posts_per_page' => -1,
	'post_type' => 'tlw_reminder',
	'meta_key' => 'reminder_date',
	'orderby' => 'meta_value_num',
	'order'	=> 'ASC'
);
$reminders = get_posts($reminders_args);
//debug($reminders);
$schedules_today = array();
$schedules_tomorrow = array();
$schedules_later = array();
$today = new DateTime("today", new DateTimeZone($timeZone));
$tomorrow = new DateTime("tomorrow", new DateTimeZone($timeZone));
foreach ($reminders as $rem) {
$reminder_date = get_field('reminder_date', $rem->ID);	
	if (date('Ymd', strtotime($reminder_date)) == $today->format('Ymd')) {
	$schedules_today[] = $rem->ID;	
	}
	if (date('Ymd', strtotime($reminder_date)) == $tomorrow->format('Ymd')) {
	$schedules_tomorrow[] = $rem->ID;	
	}
	if (date('Ymd', strtotime($reminder_date)) > date('Ymd', strtotime("tomorrow"))) {
		if ( !in_array(date('l, F j, Y', strtotime($reminder_date)), $schedules_later) ) {
		$schedules_later[] = date('l, F j, Y', strtotime($reminder_date));	
		}
	}
}
debug($today->format('Ymd'));
?>

<div id="reminder-group-wrapper">
<h1>Scheduled</h1>
<div class="reminders">
	<div class="reminder-label bold">Today</div>
	<?php if (!empty($schedules_today)) { ?>
		<?php foreach ($schedules_today as $st) { ?>
		<?php  
		$rem = get_post($st);	
		$rem_group = get_field('reminder_group', $rem->ID);	
		$rem_date = get_field('reminder_date', $rem->ID);
		$rem_time = get_field('reminder_time', $rem->ID);	
		$reminder_priority = get_field('reminder_priority', $rem->ID);	
		$reminder_notes = get_field('reminder_notes', $rem->ID);
		$reminder_repeat = get_field('reminder_repeat', $rem->ID);	
		?>
		<form action="<?php the_permalink(); ?>?group-id=<?php echo $rem_group; ?>" method="post">
			<div class="reminder">
					<div class="reminder-inner">
						<div class="change-status in-block">
							<input name="status" value="<?php echo $rem->ID; ?>" type="checkbox" onchange="this.form.submit()">	
						</div>
						<div class="details">
							<h3><span><?php echo $priority_label; ?></span><?php echo get_the_title($rem->ID); ?></h3>
							<time class="text-uppercase"><?php echo $rem_time; ?></time>
						</div>
						<div class="details-link">
							<a href="#" class="view-reminder-details">Details</a>
							<a href="?reminder-actions=edit-reminder&group-id=<?php echo $rem_group; ?>&reminder-id=<?php echo $rem->ID; ?>">Edit</a>
						</div>
					</div>
					<div class="reminder-full-details">
						<div class="full-details-inner">
							<div class="reminder-info text-center">Priority:<strong><?php echo $priority; ?></strong>&nbsp;&nbsp;|&nbsp;&nbsp;Repeat:<strong><?php echo $repeat; ?></strong></div>
							<?php if (!empty($reminder_notes)) { ?>
							<div class="notes text-center"><?php echo $reminder_notes; ?></div>
							<?php } ?>
						</div>
					</div>
				</div>
		</form>
		<?php } ?>
	<?php } ?>
	<div class="reminder-footer">
		<a href="?reminder-actions=add-reminder&when=today" class="btn btn-default">New item <i class="fa fa-plus"></i></a>
	</div>
	<div class="reminder-label bold">Tomorrow</div>
	<?php if (!empty($schedules_tomorrow)) { ?>

	<?php } ?>
	<div class="reminder-footer">
		<a href="?reminder-actions=add-reminder&when=tomorrow" class="btn btn-default">New item <i class="fa fa-plus"></i></a>
	</div>
	<?php if (!empty($schedules_later)) { ?>

		<?php foreach ($schedules_later as $sl) { ?>
		<div class="reminder-label bold"><?php echo $sl; ?></div>
			<?php foreach ($reminders as $rem) { ?>
			<?php  
			$rem_date = get_field('reminder_date', $rem->ID);		
			?>
			<?php if ($rem_date == date('Ymd', strtotime($sl))) { ?>
			<?php  
			$rem_group = get_field('reminder_group', $rem->ID);	
			$rem_time = get_field('reminder_time', $rem->ID);	
			$reminder_priority = get_field('reminder_priority', $rem->ID);	
			$reminder_notes = get_field('reminder_notes', $rem->ID);
			$reminder_repeat = get_field('reminder_repeat', $rem->ID);	
			switch($reminder_priority){
				case  "low": 
				$priority_label = "! ";
				$priority = "Low";
				break;
				case  "med": 
				$priority_label = "!! ";
				$priority = "Medium";
				break;
				case  "high":
				$priority_label = "!!! ";
				$priority = "High";
				break;
				default: 
				$priority_label = "";
				$priority = "None";
				}
				switch($reminder_repeat){
				case  "day": $repeat = "Every day";
				break;
				case  "week": $repeat = "Every week";
				break;
				case  "weeks": $repeat = "Every 2 weeks";
				break;
				case  "month": $repeat = "Every month";
				break;
				case  "year": $repeat = "Every year";
				break;
				default: $repeat = "Never";
				}
			?>
			<form action="<?php the_permalink(); ?>?group-id=<?php echo $rem_group; ?>" method="post">
				<div class="reminder">
					<div class="reminder-inner">
						<div class="change-status in-block">
							<input name="status" value="<?php echo $rem->ID; ?>" type="checkbox" onchange="this.form.submit()">	
						</div>
						<div class="details">
							<h3><span><?php echo $priority_label; ?></span><?php echo get_the_title($rem->ID); ?></h3>
							<time class="text-uppercase"><?php echo $rem_time; ?></time>
						</div>
						<div class="details-link">
							<a href="#" class="view-reminder-details">Details</a>
							<a href="?reminder-actions=edit-reminder&group-id=<?php echo $rem_group; ?>&reminder-id=<?php echo $rem->ID; ?>">Edit</a>
						</div>
					</div>
					<div class="reminder-full-details">
						<div class="full-details-inner">
							<div class="reminder-info text-center">Priority:<strong><?php echo $priority; ?></strong>&nbsp;&nbsp;|&nbsp;&nbsp;Repeat:<strong><?php echo $repeat; ?></strong></div>
							<?php if (!empty($reminder_notes)) { ?>
							<div class="notes text-center"><?php echo $reminder_notes; ?></div>
							<?php } ?>
						</div>
					</div>
				</div>
			</form>
			<?php } ?>
			
			<?php } ?>
		<?php } ?>
	<?php } ?>
	<div class="reminder-footer">
		<a href="?reminder-actions=add-reminder" class="btn btn-default">New item <i class="fa fa-plus"></i></a>
	</div>
</div>
</div>