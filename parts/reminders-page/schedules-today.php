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
	'order'	=> 'ASC'
);
$reminders = get_posts($reminders_args);
$schedules_today = array();
$today = new DateTime("today", new DateTimeZone($timeZone));
foreach ($reminders as $rem) {
$reminder_date = get_field('reminder_date', $rem->ID);	
	if (date('Ymd', strtotime($reminder_date)) == $today->format('Ymd')) {
	$schedules_today[] = $rem->ID;	
	}
}
//debug($reminders);
?>
<?php if (!empty($schedules_today)) { ?>
<?php foreach ($schedules_today as $st) { ?>
<?php  
$rem = get_post($st);	
$rem_group = get_field('reminder_group', $rem->ID);	
$rem_group_title = "";
$rem_date = get_field('reminder_date', $rem->ID);
$rem_time = get_field('reminder_time', $rem->ID);	
$reminder_priority = get_field('reminder_priority', $rem->ID);	
$reminder_notes = get_field('reminder_notes', $rem->ID);
$reminder_repeat = get_field('reminder_repeat', $rem->ID);	
foreach($reminder_groups as $rg) {
	if ($rg['group-id'] == $rem_group){
	$rem_group_title = $rg['title'];
	}
}
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
					<time class="text-uppercase">@ <?php echo date('H:i a', strtotime($rem_time)); ?></time>
					<?php if (!empty($rem_group_title)) { ?>
					<span class="group-title text-uppercase"> | <?php echo $rem_group_title; ?></span>			
					<?php } ?>
				</div>
				<div class="details-link">
					<a href="#" class="view-reminder-details">Details</a>
					<a href="?reminder-actions=edit-reminder&group-id=scheduled&reminder-id=<?php echo $rem->ID; ?>">Edit</a>
				</div>
			</div>
		<div class="reminder-full-details">
			<div class="full-details-inner">
				<div class="reminder-info text-center">Priority: <strong><?php echo $priority; ?></strong>&nbsp;&nbsp;|&nbsp;&nbsp;Repeat: <strong><?php echo $repeat; ?></strong></div>
				<?php if (!empty($reminder_notes)) { ?>
				<div class="notes text-center"><?php echo $reminder_notes; ?></div>
				<?php } ?>
			</div>
		</div>
		<?php if (($_GET['reminder-actions'] == 'edit-reminder' || $_GET['reminder-added']) && $_GET['reminder-id'] == $rem->ID) { ?>
		<div class="edit-reminder">
			<div class="form-group form-left">
				<input name="reminder-title" value="<?php echo get_the_title($rem->ID); ?>" class="form-control input-sm" autofocus>
			</div>
			<div class="form-group form-mid">
				<div class="input-group date" id="reminder-datepicker">
					<input type="text" class="form-control input-sm" name="reminder-date" value="<?php echo date('l jS F, Y', strtotime($rem_date)); ?>">
					<span class="input-group-addon"><span class="fa fa-calendar"></span></span>
				</div>
			</div>
			<div class="form-group form-right">
				<div class='input-group date' id='reminder-timepicker'>
					<input type="text" class="form-control input-sm" name="reminder-time" value="<?php echo $rem_time; ?>" />
					<span class="input-group-addon"><span class="fa fa-clock-o"></span></span>
				</div>
			</div>
			<div class="form-group form-left">
				<select name="reminder-priority" class="sml-selectpicker show-tick" data-width="100%" title="Reminder priority">
					<option value="none"<?php echo ($reminder_priority == 'none' ) ? ' selected':''; ?>>No priority</option>
					<option value="low"<?php echo ($reminder_priority == 'low' ) ? ' selected':''; ?>>! Low priority</option>
					<option value="med"<?php echo ($reminder_priority == 'med' ) ? ' selected':''; ?>>!! Medium priority</option>
					<option value="high"<?php echo ($reminder_priority == 'high' ) ? ' selected':''; ?>>!!! High priority</option>
				</select>
			</div>
			<div class="form-group form-mid">
				<select name="reminder-repeat" class="sml-selectpicker show-tick" data-width="100%" title="Reminder priority">
					<option value="never"<?php echo ($reminder_repeat == 'never' ) ? ' selected':''; ?>>Never repeat</option>
					<option value="day"<?php echo ($reminder_repeat == 'day' ) ? ' selected':''; ?>>Every day</option>
					<option value="week"<?php echo ($reminder_repeat == 'week' ) ? ' selected':''; ?>>Every week</option>
					<option value="weeks"<?php echo ($reminder_repeat == 'weeks' ) ? ' selected':''; ?>>Every 2 weeks</option>
					<option value="month"<?php echo ($reminder_repeat == 'month' ) ? ' selected':''; ?>>Every month</option>
					<option value="year"<?php echo ($reminder_repeat == 'year' ) ? ' selected':''; ?>>Every year</option>
				</select>
			</div>
			
			<div class="form-group form-right">
				<select name="change-group" class="sml-selectpicker show-tick" data-width="100%" title="Move reminder">
					<option value="scheduled"<?php echo ($rem_group == 'scheduled') ? ' selected':''; ?>>Scheduled</option>
					<?php if (!empty($reminder_groups)) { ?>
					<?php foreach ($reminder_groups as $rg) { ?>
					<option value="<?php echo $rg['group-id']; ?>"<?php echo ($rg['group-id'] == $rem_group ) ? ' selected':''; ?>><?php echo $rg['title']; ?></option>
					<?php } ?>
					<?php } ?>
				</select>
			</div>

			<div class="form-group">
				<textarea name="reminder-notes" class="form-control" rows="3"><?php echo wp_strip_all_tags($reminder_notes); ?></textarea>	
			</div>
			
			<input type="hidden" name="orig-title" value="<?php echo get_the_title($rem->ID); ?>">
			<input type="hidden" name="orig-date" value="<?php echo $rem_date; ?>">
			<input type="hidden" name="orig-time" value="<?php echo $rem_time; ?>">
			<input type="hidden" name="orig-priority" value="<?php echo $reminder_priority; ?>">
			<input type="hidden" name="orig-repeat" value="<?php echo $reminder_repeat; ?>">
			<input type="hidden" name="orig-notes" value="<?php echo $reminder_notes; ?>">
			<input type="hidden" name="orig-group" value="<?php echo $rem_group; ?>">
			<input type="hidden" name="reminder-id" value="<?php echo $rem->ID; ?>">
			<div class="form-group clear">
				<button type="submit" name="update-reminder" class="btn btn-default btn-sm" value="update-<?php echo $item->ID; ?>">Update</button>
				<a href="?group-id=scheduled" class="btn btn-default btn-sm">Cancel</a>
			</div>
		</div>
		<?php } ?>
	</div>
</form>
<?php } ?>
<?php } ?>
<div class="reminder-footer">
	<a href="?reminder-actions=add-reminder&group-id=scheduled" class="btn btn-default">New item <i class="fa fa-plus"></i></a>
</div>