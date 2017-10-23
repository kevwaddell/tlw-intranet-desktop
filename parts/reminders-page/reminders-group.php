<?php  
global $current_group;	
global $reminder_groups;
global $reminders_completed;
global $reminder_added;
global $date_format;
global $time_format;
global $timeZone;
$current_completed = array();
$exclude_completed = array();

$now_dateTime = new DateTime("now", new DateTimeZone($timeZone));
//$ts = $now_dateTime->getTimestamp();
$now_ts = $now_dateTime->getTimestamp();

if (!empty($reminders_completed)) {
	foreach ($reminders_completed as $k => $comp) { 
	$reminder_repeat = get_field('reminder_repeat', $comp['reminder-id']);
		
		if ($comp['group-id'] == $current_group) {
		$current_completed[] = $reminders_completed[$k];
		}
		
		if ($reminder_repeat == 'never') {
		$exclude_completed[] = $comp['reminder-id'];	
		}
	}
}
//debug($current_completed);

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
}

$reminders = get_posts($reminders_args);
//debug($current_completed);
?>
<?php if ($_GET['reminder-actions'] == 'remove-group') { ?>
<div class="alerts-pop animated fadeIn">
	<?php  get_template_part( 'parts/reminders-page/delete', 'group-alert' ); ?>
</div>
<?php } ?>
<div id="reminder-group-wrapper" class="group-col-<?php echo (empty($group_color)) ? 'red':$group_color;  ?>">
	<header class="reminder-header over-hide">
		<h1><?php echo $group_title; ?></h1>
		<a href="#" id="group-options-btn">Options</a>
	</header>
	<div class="group-options<?php echo ($_GET['group-added']) ? ' options-open':' options-closed'; ?>">
		<form action="<?php the_permalink(); ?>?group-id=<?php echo $current_group; ?>" method="post">
			<div class="form-group">
				<input type="text" class="form-control input-lg" name="group-title" value="<?php echo $group_title; ?>" autofocus>
				<input type="hidden" name="group-id" value="<?php echo $group_id ?>">
			</div>
			<div class="form-group">
				<label for="group-col">List colour: </label>
				<input value="red" name="group-color[]" type="radio"<?php echo ($group_color == 'red') ? ' checked="checked"':''; ?> class="bg-red">
				<input value="purple" name="group-color[]" type="radio"<?php echo ($group_color == 'purple') ? ' checked="checked"':''; ?> class="bg-purple">
				<input value="green" name="group-color[]" type="radio"<?php echo ($group_color == 'green') ? ' checked="checked"':''; ?> class="bg-green">
				<input value="pink" name="group-color[]" type="radio"<?php echo ($group_color == 'pink') ? ' checked="checked"':''; ?> class="bg-pink">
				<input value="orange" name="group-color[]" type="radio"<?php echo ($group_color == 'orange') ? ' checked="checked"':''; ?> class="bg-orange">
				<input value="blue" name="group-color[]" type="radio"<?php echo ($group_color == 'blue') ? ' checked="checked"':''; ?> class="bg-blue">	
			</div>
			<div class="form-group option-actions">
				<a href="?reminder-actions=remove-group&group-id=<?php echo $current_group; ?>" class="btn btn-default btn-lg no-border no-rounded delete-group">Delete</a>
				<a href="?group-id=<?php echo $current_group; ?>" class="btn btn-default btn-lg no-border no-rounded pull-right">Cancel</a>
				<button type="submit" name="update-group" class="btn btn-default btn-lg no-border no-rounded pull-right">Done</button>
			</div>
		</form>
	</div>	
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
			<?php if (!empty($current_completed)) { ?>
			<div class="reminders completed">
				
				<?php foreach ($current_completed as $item) { ?>
					<?php 
					$rem_id = $item['reminder-id'];
					$reminder_date = $item['reminder-date'];	
					$reminder_group = $item['group-id'];
					$rem_time = get_field('reminder_time', $rem_id);	
					$reminder_priority = get_field('reminder_priority', $rem_id);	
					$rem_date = date('D jS M Y', strtotime($reminder_date));
					$comp_dateTime = new DateTime( date('Ymd G:i', $item['completed']), new DateTimeZone($timeZone));
					//echo '<pre>';print_r($comp_dateTime);echo '</pre>';
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
					<form action="<?php the_permalink(); ?>?group-id=<?php echo $current_group; ?>" method="post">
					<div class="reminder-inner">
						<div class="change-status in-block">
							<input value="<?php echo $item['reminder-id']; ?>" checked="checked" type="checkbox" onchange="this.form.submit()">	
						</div>
						<div class="details">
							<h3><span><?php echo $priority; ?></span><?php echo get_the_title($rem_id); ?></h3>
							<time class="text-uppercase"><?php echo $rem_date; ?> @ <?php echo $rem_time; ?></time>
							<time class="text-uppercase">&nbsp;&nbsp;|&nbsp;&nbsp;Completed on <?php echo $comp_dateTime->format("D jS M Y @".$time_format); ?></time>
						</div>
					</div>
					<input type="hidden" name="change-status" value="<?php echo $rem_id; ?>">
					<input type="hidden" name="reminder-date" value="<?php echo $reminder_date; ?>">
					<input type="hidden" name="group-id" value="<?php echo $reminder_group; ?>">
					<input type="submit" name="complete-rewind" style="display:none;">
					</form>
				</div>
				<?php } ?>
			</div>
			<?php } ?>
		</div>
		<div class="reminders">
			
			<?php if (!empty($reminders)) { ?>
				<?php foreach ($reminders as $item) { ?>
				<?php  
				$rem_group = get_field('reminder_group', $item->ID);	
				$reminder_date = get_field('reminder_date', $item->ID);	
				$rem_time = get_field('reminder_time', $item->ID);	
				$reminder_priority = get_field('reminder_priority', $item->ID);	
				$reminder_notes = get_field('reminder_notes', $item->ID);
				$reminder_repeat = get_field('reminder_repeat', $item->ID);	
				$rem_date = date('D jS M Y', strtotime($reminder_date));
				$rem_dateTime = new DateTime($reminder_date." ".$rem_time, new DateTimeZone($timeZone));
				//echo '<pre>';print_r($item->ID);echo '</pre>';
				if ( date('Ymd') == $rem_dateTime ) {
				$rem_date = "Today";	
				}	
				if ( $now_ts > $rem_dateTime->getTimestamp() ) {
				$rem_date = "";
				$interval = $rem_dateTime->diff($now_dateTime);	
				if ($interval->y != 0) {
				$y = ($interval->y > 1) ? 'Years':'Year';
				$rem_date .= $interval->format("%y $y ");	
				}
				if ($interval->m != 0) {
				$m = ($interval->m > 1) ? 'Months':'Month';
				$rem_date .= $interval->format("%m $m ");	
				}
				if ($interval->d != 0) {
				$d = ($interval->d > 1) ? 'Days':'Day';
				$rem_date .= $interval->format("%d $d ");		
				}
				if ($interval->h != 0) {
				$h = ($interval->h > 1) ? 'Hours':'Hour';
				$rem_date .= $interval->format("%h $h ");		
				}
				if ($interval->i != 0) {
				$rem_date .= $interval->format('and %i minutes ');		
				}
				$rem_date .= "ago";
				//echo '<pre>';print_r($interval);echo '</pre>';
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
				<div class="reminder<?php echo (($_GET['reminder-actions'] == 'edit-reminder' || $_GET['reminder-added']) && $_GET['reminder-id'] == $item->ID) ? ' editing':''; ?>">
					<form action="<?php the_permalink(); ?>?group-id=<?php echo $current_group; ?>" method="post">
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
					
					<?php if (($_GET['reminder-actions'] == 'edit-reminder' || $_GET['reminder-added']) && $_GET['reminder-id'] == $item->ID) { ?>
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
						
						<input type="hidden" name="orig-title" value="<?php echo get_the_title($item->ID); ?>">
						<input type="hidden" name="orig-date" value="<?php echo $reminder_date; ?>">
						<input type="hidden" name="orig-time" value="<?php echo $rem_time; ?>">
						<input type="hidden" name="orig-priority" value="<?php echo $reminder_priority; ?>">
						<input type="hidden" name="orig-repeat" value="<?php echo $reminder_repeat; ?>">
						<input type="hidden" name="orig-notes" value="<?php echo $reminder_notes; ?>">
						<input type="hidden" name="orig-group" value="<?php echo $rem_group; ?>">
						<input type="hidden" name="reminder-id" value="<?php echo $item->ID; ?>">
						<div class="form-group clear">
							<button type="submit" name="update-reminder" class="btn btn-default btn-sm" value="update-<?php echo $item->ID; ?>">Update</button>
							<a href="?group-id=<?php echo $rem_group; ?>" class="btn btn-default btn-sm">Cancel</a>
						</div>
					</div>
					<?php } ?>
					<input type="hidden" name="group-id" value="<?php echo $rem_group; ?>">
					<input type="submit" name="update-reminder" style="display:none;">
					</form>	
				</div>
				<?php } ?>	
			<?php } ?>
			
		</div>
		<div class="reminder-footer">
			<a href="?reminder-actions=add-reminder&group-id=<?php echo $current_group; ?>" class="btn btn-default">New item <i class="fa fa-plus"></i></a>
		</div>
	</div>
</div>