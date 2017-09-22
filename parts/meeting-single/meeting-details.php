<div class="meeting-details">
	<div class="meeting-details-wrap">
	
	<?php if (isset($_GET['request']) && $_GET['request'] == "edit_meeting") { 
	$rooms_args = array('hide_empty' => false);
	$rooms = get_terms('tlw_rooms_tax', $rooms_args);	
	$start_split = explode(":", date('H:i', $start_time));
	$end_split = explode(":", date('H:i', $end_time));
	?>
	
	<form action="<?php echo get_permalink($meetings->ID); ?>" method="post" id="edit_meeting_form">
		
		<input type="hidden" name="meetingid" id="meetingid" value="<?php the_ID(); ?>">
		
		<div class="row">
			<div class="col-xs-3">
				<div class="info-label">Room:</div> 
			</div>
			<div class="col-xs-9">
				<div class="form-group">
					<select class="form-control" id="meeting_room" name="meeting_room">
	
						<?php foreach ($rooms as $r) { ?>
								<option value="<?php echo $r->term_id; ?>"<?php echo ($room[0]->term_id == $r->term_id) ? " selected":""; ?>><?php echo $r->name; ?></option>
						<?php } ?>
	
					</select>
				</div>
			</div>
			
			<div class="col-xs-3">
				<div class="info-label">Date:</div> 
			</div>
			<div class="col-xs-9">
				<div class="form-group">
					<input type="text" id="meeting_date" name="meeting_date" class="form-control date-picker" value="<?php echo date('D j F, Y', $date_convert);?>">
				</div>
			</div>
			
			<div class="col-xs-3">
				<div class="info-label">Time:</div> 
			</div>
			<div class="col-xs-9">
				<div class="form-group form-inline">
					<label>Start:</label>
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
					<label for="start_hrs">End:</label>
					<select class="form-control" id="end_hrs" name="end_hrs">
					<?php for($h = 8 ; $h <= 16; $h++) { ?>
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
			</div>
	
		</div>
		
		<div class="action-btns">
			<div class="row">
				<div class="col-xs-6">
					<input type="submit" value="Update meeting" class="btn btn-success btn-block">
				</div>
				<div class="col-xs-6">
				<a href="<?php the_permalink(); ?>" class="btn btn-danger btn-block" title="Cancel">Cancel</a>
				</div>
			</div>
		</div>
		
	</form>

	<?php } else {  ?>
	
		<div class="row">
			<div class="col-xs-3">
				<div class="info-label">Description:</div> 
			</div>
			<div class="col-xs-9">
				<div class="text"><?php echo $description; ?></div>	
			</div>
		</div>
		<div class="row">
			<div class="col-xs-3">
				<div class="info-label">Room:</div> 
			</div>
			<div class="col-xs-9">
				<div class="text"><a href="<?php echo get_term_link( $room[0]->term_id, $room[0]->taxonomy );?>"><?php echo $room[0]->name;?></a></div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-3">
				<div class="info-label">Date:</div> 
			</div>
			<div class="col-xs-9">
				<div class="text"><span class="booked-date"><?php echo date('D jS F Y', $date_convert);?></span></div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-3">
				<div class="info-label">Time:</div> 
			</div>
			<div class="col-xs-9">
				<div class="text"><pan class="time"><?php echo gmdate('H:i', $start_time);?> - <?php echo gmdate('H:i', $end_time);?></span></div>
			</div>
		</div>
		<div class="row">	
			<div class="col-xs-3">
				<div class="info-label">Booked By:</div> 
			</div>
			<div class="col-xs-9">
				<div class="text"><a href="<?php echo get_author_posts_url($booked_by->data->ID);?>"><?php echo $booked_by->data->display_name; ?></a></div>
			</div>
	
		</div>
	
	<?php } ?>
		
	</div>
</div>
