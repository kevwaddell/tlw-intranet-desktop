<?php
global $timeZone;
global $reminder_groups;
global $current_user;
$reminders_args = array(
	'posts_per_page' => -1,
	'author'	=> $current_user->ID,
	'post_type' => 'tlw_reminder',
	'meta_key' => 'reminder_date',
	'orderby' => 'meta_value_num',
	'order'	=> 'ASC',
	'meta_query' => array(
		array(
		'key' => 'reminder_group',	
		'value'	=> 'meeting'
		)
	)
);
$reminders = get_posts($reminders_args);
$schedules_tomorrow = array();
$tomorrow = new DateTime("tomorrow", new DateTimeZone($timeZone));
foreach ($reminders as $rem) {
$reminder_date = get_field('reminder_date', $rem->ID);	
$rem_date = new DateTime($reminder_date, new DateTimeZone($timeZone));
	if ($rem_date->format('Ymd') == $tomorrow->format('Ymd')) {
	$schedules_tomorrow[] = $rem->ID;	
	}
}
?>
<?php if (!empty($schedules_tomorrow)) { ?>
<div class="reminder-label bold">Tomorrow</div>
<?php foreach ($schedules_tomorrow as $tom) { ?>
<?php  
$rem = get_post($tom);	
$rem_group = get_field('reminder_group', $rem->ID);	
$rem_group_title = "";
$rem_date = get_field('reminder_date', $rem->ID);
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
<form action="<?php the_permalink(); ?>?group-id=scheduled" method="post">
	<div class="reminder">
		<div class="reminder-inner">
			<div class="change-status in-block">
				<input name="status" value="<?php echo $rem->ID; ?>" type="checkbox" onchange="this.form.submit()">	
			</div>
			<div class="details">
				<h3><span><?php echo $priority_label; ?></span><?php echo get_the_title($rem->ID); ?></h3>
				<time class="text-uppercase">@ <?php echo date('g:i a', strtotime($rem_time)); ?></time>
			</div>
			<div class="details-link">
				<a href="#" class="view-reminder-details">Details</a>
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
