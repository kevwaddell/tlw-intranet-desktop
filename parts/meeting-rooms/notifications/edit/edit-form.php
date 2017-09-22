<?php 
$form_url = explode("?", $_SERVER['REQUEST_URI']);
?>

<form action="<?php echo get_option('home'); ?><?php echo $form_url[0]; ?>" method="post" class="meeting-form" id="edit_meeting_form">

	<input type="hidden" name="meetingid" id="meetingid" value="<?php echo $meeting->ID; ?>">
	
	<div class="form-group">
		<label for="meeting_room">Room</label>
		<select class="form-control" id="meeting_room" name="meeting_room">
	
	<?php foreach ($rooms as $room) { ?>
			<option value="<?php echo $room->term_id; ?>"<?php echo ($current_room[0]->term_id == $room->term_id) ? " selected":""; ?>><?php echo $room->name; ?></option>
	<?php } ?>
	
		</select>
	</div>
	
	<div class="form-group">
	<label for="meeting_date">Date</label>
	<input type="text" id="meeting_date" name="meeting_date" class="form-control date-picker" value="<?php echo date('D j F, Y', $date_convert);?>">

	</div>
		
	<div class="form-group form-inline">
		<label for="meeting_room">Start time</label>
		<select class="form-control" id="start_hrs" name="start_hrs">
			<?php for($h = 8 ; $h <= 16; $h++) { ?>
			<option value="<?php echo sprintf('%02d', $h); ?>"<?php echo (sprintf('%02d', $h) == $start_split[0]) ? " selected":""; ?>><?php echo sprintf('%02d', $h); ?></option>
			<?php } ?>
		</select>
		<span>:</span>
		<select class="form-control" id="start_mins" name="start_mins">
			<?php for($m = 0 ; $m <= 55; $m++) { ?>
				<?php if(($m % 5) == 0) { ?>
			<option value="<?php echo sprintf('%02d', $m); ?>"<?php echo (sprintf('%02d', $m) == $start_split[1]) ? " selected":""; ?>><?php echo sprintf('%02d', $m); ?></option>
				<?php } ?>
			<?php } ?>
		</select>
		&nbsp;&nbsp;
		<label>End time</label>
		<select class="form-control" id="end_hrs" name="end_hrs">
			<?php for($h = 9 ; $h <= 17; $h++) { ?>
			<option value="<?php echo sprintf('%02d', $h); ?>"<?php echo (sprintf('%02d', $h) == $end_split[0]) ? " selected":""; ?>><?php echo sprintf('%02d', $h); ?></option>
			<?php } ?>
		</select>
		<span>:</span>
		<select class="form-control" id="end_mins" name="end_mins">
			<?php for($m = 0 ; $m <= 55; $m++) { ?>
				<?php if(($m % 5) == 0) { ?>
			<option value="<?php echo sprintf('%02d', $m); ?>"<?php echo (sprintf('%02d', $m) == $end_split[1]) ? " selected":""; ?>><?php echo sprintf('%02d', $m); ?></option>
				<?php } ?>
			<?php } ?>
		</select>
	</div>
	
	<div class="action-btns">
		<div class="row">
			<div class="col-xs-6">
				<?php wp_nonce_field( 'post_nonce', 'post_nonce_field' ); ?>
				<input type="submit" value="Update meeting" class="btn btn-info btn-block">
			</div>
			<div class="col-xs-6">
			<a href="<?php echo get_permalink($meetings->ID); ?>" class="btn btn-info btn-block cancel-btn" title="Cancel">Cancel</a>
			</div>
		</div>
	</div>
		
</form>