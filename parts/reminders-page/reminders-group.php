<?php  
global $current_group;	
global $reminder_groups;
global $reminders_completed;
global $reminder_added;
$current_completed = array();
$exclude_completed = array();

if (!empty($reminders_completed)) {
	foreach ($reminders_completed as $k => $comp) { 
		
		if ($comp['group-id'] == $current_group) {
		$current_completed[] = $reminders_completed[$k];
		$exclude_completed[] = $comp['reminder-id'];
		}
	}
}

$group_key = in_array_key($current_group, $reminder_groups);
$group_title = $reminder_groups[$group_key]['title'];
$group_id = $reminder_groups[$group_key]['group-id'];
$group_color = $reminder_groups[$group_key]['color'];

$reminders_args = array(
	'posts_per_page' => -1,
	'post_type' => 'tlw_reminder',
	'meta_key' => 'reminder_date',
	'orderby' => 'meta_value_num',
	'order'	=> 'ASC',
	'meta_query'	=> array(
		array(
		'key'	=> 'reminder_group'	,
		'value'	=> $group_id
		)
	)
);

if (!empty($exclude_completed)) {
$reminders_args['exclude'] = $exclude_completed;
$completed_reminders_args = array(
	'posts_per_page' => -1,
	'post_type' => 'tlw_reminder',
	'meta_key' => 'reminder_date',
	'orderby' => 'meta_value_num',
	'include'	=> $exclude_completed
	);	
$completed_reminders = get_posts($completed_reminders_args);
}

$reminders = get_posts($reminders_args);
//debug($reminders);
?>

<div id="reminder-group-wrapper" class="group-col-<?php echo (empty($group_color)) ? 'red':$group_color;  ?>">
	<header class="reminder-header over-hide">
		<h1><?php echo $group_title; ?></h1>
		<a href="?reminder-actions=options">Options</a>
	</header>
	<div class="reminders-list">
		<div class="completed-list">
			<div class="list-header over-hide">
				<div class="header-btn pull-left">
				<?php if (!empty($current_completed)) { ?>
				<button id="show-completed" class="btn btn-default"><i class="fa fa-arrow-right fa-lg"></i></button>
				<?php } ?>
				</div>
				<div class="counter-label in-block"><?php echo count($current_completed); ?> Completed</div>
				<?php if (!empty($current_completed)) { ?>
				<div class="header-link pull-right">
					<a href="?reminder-actions=clear-completed&group-id=<?php echo $group_id; ?>">Clear Completed</a>	
				</div>		
				<?php } ?>
			</div>
			<?php if (!empty($completed_reminders)) { ?>
			<div class="reminders completed">
				<form action="<?php the_permalink(); ?>" method="post">
				<?php foreach ($completed_reminders as $item) { ?>
					<?php  
					$reminder_date = get_field('reminder_date', $item->ID);	
					$rem_time = get_field('reminder_time', $item->ID);	
					$reminder_priority = get_field('reminder_priority', $item->ID);	
					$rem_date = date('D jS Y', strtotime($reminder_date));
					//echo '<pre>';print_r($reminder_date);echo '</pre>';
					if ( date('Ymd') == $reminder_date ) {
					$rem_date = "Today";	
					}	
					switch($reminder_priority){
					case  "low": $priority = "! ";
					break;
					case  "med": $priority = "!! ";
					break;
					case  "high": $priority = "!!! ";
					break;
					default: $priority = "";
					}
					?>
					<div class="reminder">
					<div class="reminder-inner">
						<div class="change-status in-block">
							<input name="change-status" value="<?php echo $item->ID; ?>" checked="checked" type="checkbox" onchange="this.form.submit()">	
						</div>
						<div class="details">
							<h3><span><?php echo $priority; ?></span><?php echo get_the_title($item->ID); ?></h3>
							<time class="text-uppercase"><?php echo $rem_date; ?> @ <?php echo $rem_time; ?></time>
						</div>
					</div>
				</div>
				<?php } ?>
				<input type="hidden" name="group-id" value="<?php echo $group_id; ?>">
				<input type="submit" name="uncomplete-reminder" style="display:none;">
				</form>
			</div>
			<?php } ?>
		</div>
		<div class="reminders">
			
			<?php if (!empty($reminders)) { ?>
			<form action="<?php the_permalink(); ?>?group-id=<?php echo $current_group; ?>" method="post">
				<?php foreach ($reminders as $item) { ?>
				<?php  
				$reminder_date = get_field('reminder_date', $item->ID);	
				$rem_time = get_field('reminder_time', $item->ID);	
				$reminder_priority = get_field('reminder_priority', $item->ID);	
				$reminder_notes = get_field('reminder_notes', $item->ID);
				$reminder_repeat = get_field('reminder_repeat', $item->ID);	
				$rem_date = date('D jS Y', strtotime($reminder_date));
				//echo '<pre>';print_r($item->ID);echo '</pre>';
				if ( date('Ymd') == $reminder_date ) {
				$rem_date = "Today";	
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
				<div class="reminder<?php echo ($_GET['reminder-actions'] == 'edit-reminder' && $_GET['reminder-id'] == $item->ID || ($_GET['reminder-actions'] == 'add-reminder' && $item->ID == $reminder_added)) ? ' editing':''; ?>">
					<div class="reminder-inner">
						<div class="change-status in-block">
							<input name="status" value="<?php echo $item->ID; ?>" type="checkbox" onchange="this.form.submit()">	
						</div>
						<div class="details">
							<h3><span><?php echo $priority_label; ?></span><?php echo get_the_title($item->ID); ?></h3>
							<time class="text-uppercase"><?php echo $rem_date; ?> @ <?php echo $rem_time; ?></time>
						</div>
						<div class="details-link">
							<a href="#" class="view-reminder-details">Details</a>
							<a href="?reminder-actions=edit-reminder&group-id=<?php echo $group_id; ?>&reminder-id=<?php echo $item->ID; ?>">Edit</a>
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
					
					<?php if (($_GET['reminder-actions'] == 'edit-reminder' && $_GET['reminder-id'] == $item->ID) || ($_GET['reminder-actions'] == 'add-reminder' && $item->ID == $reminder_added)) { ?>
					<div class="edit-reminder">
						<div class="form-group form-left">
							<input name="reminder-title" value="<?php echo get_the_title($item->ID); ?>" class="form-control input-sm" autofocus>
						</div>
						<div class="form-group form-mid">
							<div class="input-group date" id="reminder-datepicker">
								<input type="text" class="form-control input-sm" name="reminder-date" value="<?php echo date('l jS F, Y', strtotime($reminder_date)); ?>">
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
						<?php if (!empty($reminder_groups)) { ?>
						<div class="form-group form-right">
							<select name="change-group" class="sml-selectpicker show-tick" data-width="100%" title="Move reminder">
								<?php foreach ($reminder_groups as $rg) { ?>
								<option value="<?php echo $rg['group-id']; ?>"<?php echo ($rg['group-id'] == $group_id ) ? ' selected':''; ?>><?php echo $rg['title']; ?></option>
								<?php } ?>
							</select>
						</div>
						<?php } ?>
						<div class="form-group">
							<textarea name="reminder-notes" class="form-control" rows="3"><?php echo wp_strip_all_tags($reminder_notes); ?></textarea>	
						</div>
						
						<input type="hidden" name="orig-title" value="<?php echo get_the_title($item->ID); ?>">
						<input type="hidden" name="orig-date" value="<?php echo $reminder_date; ?>">
						<input type="hidden" name="orig-time" value="<?php echo $rem_time; ?>">
						<input type="hidden" name="orig-priority" value="<?php echo $reminder_priority; ?>">
						<input type="hidden" name="orig-repeat" value="<?php echo $reminder_repeat; ?>">
						<input type="hidden" name="orig-notes" value="<?php echo $reminder_notes; ?>">
						<input type="hidden" name="orig-group" value="<?php echo $group_id; ?>">
						<input type="hidden" name="reminder-id" value="<?php echo $item->ID; ?>">
						<div class="form-group clear">
							<button type="submit" name="update-reminder" class="btn btn-default btn-sm" value="update-<?php echo $item->ID; ?>">Update</button>
							<a href="?group-id=<?php echo $current_group; ?>" class="btn btn-default btn-sm">Cancel</a>
						</div>
					</div>
					<?php } ?>
				</div>
				<?php } ?>	
				<input type="hidden" name="group-id" value="<?php echo $group_id; ?>">
				<input type="submit" name="update-reminder" style="display:none;">
			</form>	
			<?php } ?>
			
		</div>
		<div class="reminder-footer">
			<a href="?reminder-actions=add-reminder&group-id=<?php echo $current_group; ?>&counter=<?php echo count($reminders) + count($exclude_completed); ?>" class="btn btn-default">New item <i class="fa fa-plus"></i></a>
		</div>
	</div>
</div>