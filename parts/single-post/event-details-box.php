<?php
$event_date_raw = get_field('event_date');
$event_date = date("l jS F, Y", strtotime($event_date_raw ));
$event_time = get_field('event_time');
$event_time_end = get_field('event_time_end');
$location = get_field('location');
?>
<div class="details-box">
	<h3><i class="fa fa-info-circle"></i>Event details</h3>
	
	<?php if ($event_date) { ?>
	<div class="details-row">
		<div class="row">
			<div class="col-xs-3"><span class="info-label">Event date:</span></div>
			<div class="col-xs-9"><span class="info-details"><?php echo $event_date; ?></span></div>
		</div>
	</div>
	<?php } ?>
	
	<?php if ($event_time ) { ?>
	<div class="details-row">
		<div class="row">
			<div class="col-xs-3"><span class="info-label">Event time:</span></div>
			<div class="col-xs-9"><span class="info-details"><?php echo $event_time; ?><?php echo ($event_time_end) ? ' - '.$event_time_end:''; ?></span></div>
		</div>
	</div>
	<?php } ?>
	
	<?php if ($location) { ?>
	<div class="details-row">
		<div class="row">
			<div class="col-xs-3"><span class="info-label">Location:</span></div>
			<div class="col-xs-9"><span class="info-details"><?php echo $location; ?></span></div>
		</div>
	</div>
	<?php } ?>
	
</div>