<?php  
global $current_group;	
global $reminder_groups;
global $reminders_completed;
$current_completed = array();

if (!empty($reminders_completed)) {
	foreach ($reminders_completed as $k => $comp) { 
		
		if ($comp['group-id'] == $current_group) {
		$current_completed[] = $reminders_completed[$k];
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
	'meta_query'	=> array(
		array(
		'key'	=> 'reminder_group'	,
		'value'	=> $group_id
		)
	)
);

$reminders = get_posts($reminders_args);
//debug($reminders);
?>

<div id="reminder-group-wrapper" class="group-col-<?php echo (empty($group_color)) ? 'red':$group_color;  ?>">
	<header class="reminder-header over-hide">
		<h1 class="pull-left"><?php echo $group_title; ?></h1>
		<a href="?reminder-actions=options" class="pull-right">Options</a>
	</header>
	<div class="reminders-list">
		<div class="completed-list closed">
			<div class="list-header over-hide">
				<?php if (!empty($current_completed)) { ?>
				<button id="show-completed" class="btn btn-default pull-left"><i class="fa fa-arrow-right fa-2x"></i></button>
				<?php } ?>
				<div class="counter-label"><?php echo count($current_completed); ?> Completed</div>
				<?php if (!empty($current_completed)) { ?>
				<a href="?reminder-actions=clear-completed&group-id=scheduled" class="pull-right">Clear Completed</a>			
				<?php } ?>
			</div>
			<?php if (count($reminders_completed) > 0) { ?>
			<div class="reminders">
				
			</div>
			<?php } ?>
		</div>
		<div class="reminders">
			
			<?php if (!empty($reminders)) { ?>
			<form action="<?php the_permalink(); ?>" method="post">
				<?php foreach ($reminders as $item) { ?>
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
					<div class="change-status in-block">
						<input name="status[]" value="<?php echo $item->ID; ?>" type="checkbox" onchange="this.form.submit()">	
					</div>
					<div class="details in-block">
						<h3><span><?php echo $priority; ?></span><?php echo get_the_title($item->ID); ?></h3>
						<time class="text-uppercase"><?php echo $rem_date; ?> @ <?php echo $rem_time; ?></time>
					</div>
					<div class="details-link pull-right">
						<a href="">Details</a>
					</div>
					<div class="hidden-info hidden">
					
					</div>
				</div>
				<?php } ?>	
				<input type="hidden" name="group-id" value="<?php echo $group_id; ?>">
				<input type="submit" name="update-status" value="" style="display:none;">
			</form>	
			<?php } ?>
			
			<?php if ($_GET['reminder-actions'] == 'add-reminder') { 
			$timeZone = 'Europe/London';
			$now = time();
			$now_time = new DateTime(date(DATE_ATOM, $now + ((3600*2) - $now % 3600)), new DateTimeZone($timeZone));
			//debug($now_time);
			?>
				<form action="<?php the_permalink(); ?>" method="post">
					<div class="form-group">
						<input name="reminder-title" value="" class="form-control" autofocus>
					</div>
					<input type="hidden" name="reminder-date" value="<?php echo $now_time->format('Ymd'); ?>">
					<input type="hidden" name="reminder-time" value="<?php echo $now_time->format('G:i'); ?>">
					<input type="hidden" name="group-id" value="<?php echo $group_id; ?>">
					<input type="submit" name="add-reminder" value="" style="display:none;">
				</form>		
			<?php } ?>
			
		</div>
		<div class="reminder-footer">
			<a href="?reminder-actions=add-reminder&group-id=<?php echo $current_group; ?>" class="btn btn-default">New item <i class="fa fa-plus"></i></a>
		</div>
	</div>
</div>