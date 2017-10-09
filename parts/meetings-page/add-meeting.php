<?php
global $current_user;
global $locations;	
global $all_users;
global $add_meeting_errors;
//echo '<pre class="debug">';print_r($all_users);echo '</pre>';
?>
<form action="<?php the_permalink(); ?>" method="post">
<table class="table table-striped">
	<thead>
		<tr>
			<th width="200" class="text-right"><i class="fa fa-calendar-plus-o fa-4x"></i></th>
			<th><h1>Book a meeting room</h1></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="text-right"><label for="location-id">Room</label></td>
			<td>
				<div class="form-group">
				<select name="location-id" class="selectpicker" data-width="50%" title="Choose a contact group">
					<?php foreach ($locations as $location) { ?>
					<option value="<?php echo $location->term_id; ?>"<?php echo ($_REQUEST['location-id'] == $location->term_id ) ? ' selected':''; ?>><?php echo $location->name; ?></option>
					<?php } ?>
				</select>
				</div>
			</td>
		</tr>
		<tr<?php echo (array_key_exists ('meeting-title' , $add_meeting_errors )) ? ' class="danger"':''; ?>>
			<td class="text-right<?php echo (array_key_exists ('meeting-title' , $add_meeting_errors )) ? ' text-danger':''; ?>"><label for="meeting-title">* Meeting title</label></td>
			<td>
				<div class="form-group<?php echo (array_key_exists ('meeting-title' , $add_meeting_errors )) ? ' has-error':''; ?>">
					<input type="text" class="form-control" name="meeting-title"  placeholder="Enter meeting title" value="<?php echo (isset($_REQUEST['meeting-title'])) ? $_REQUEST['meeting-title']:''; ?>">
					<?php echo (array_key_exists ('meeting-title' , $add_meeting_errors )) ? $add_meeting_errors['meeting-title']:''; ?>
				</div>
			</td>
		</tr>
		<tr>
			<td class="text-right vtop"><label for="meeting-description">Meeting description</label></td>
			<td>
				<div class="form-group">
					<textarea class="form-control" rows="3" name="meeting-description" placeholder="Enter meeting description"></textarea>
				</div>
			</td>
		</tr>
		<tr<?php echo (array_key_exists ('meeting-date' , $add_meeting_errors )) ? ' class="danger"':''; ?>>
			<td class="text-right<?php echo (array_key_exists ('meeting-date' , $add_meeting_errors )) ? ' text-danger':''; ?>"><label for="meeting-date">* Date</label></td>
			<td>
				<div class="form-group<?php echo (array_key_exists ('meeting-date' , $add_meeting_errors )) ? ' has-error':''; ?>">
					<div class='input-group date' id='meeting-datepicker'>
						<input type="text" class="form-control" name="meeting-date" placeholder="Click icon to select" value="<?php echo (isset($_REQUEST['meeting_date'])) ? $_REQUEST['meeting_date']:''; ?>" />
						<span class="input-group-addon"><span class="fa fa-calendar"></span></span>
					</div>
					<?php echo (array_key_exists ('meeting-date' , $add_meeting_errors )) ? $add_meeting_errors['meeting-date']:''; ?>
				</div>
			</td>
		</tr>
		<tr<?php echo (array_key_exists ('start-time' , $add_meeting_errors )) ? ' class="danger"':''; ?>>
			<td class="text-right<?php echo (array_key_exists ('start-time' , $add_meeting_errors )) ? ' text-danger':''; ?>"><label for="start-time">* Start time</label></td>
			<td>
				<div class="form-group<?php echo (array_key_exists ('start-time' , $add_meeting_errors )) ? ' has-error':''; ?>">
					<div class='input-group date' id='meeting-startpicker'>
						<input type="text" class="form-control" name="start-time" value="<?php echo (isset($_REQUEST['start_time'])) ? $_REQUEST['start_time']:''; ?>" />
						<span class="input-group-addon"><span class="fa fa-clock-o"></span></span>
					</div>
					<?php echo (array_key_exists ('start-time' , $add_meeting_errors )) ? $add_meeting_errors['start-time']:''; ?>
				</div>
			</td>
		</tr>
		<tr<?php echo (array_key_exists ('end-time' , $add_meeting_errors )) ? ' class="danger"':''; ?>>
			<td class="text-right<?php echo (array_key_exists ('end-time' , $add_meeting_errors )) ? ' text-danger':''; ?>"><label for="end-time">End time</label></td>
			<td>
				<div class="form-group<?php echo (array_key_exists ('end-time' , $add_meeting_errors )) ? ' has-error':''; ?>">
					<div class='input-group date' id='meeting-endpicker'>
						<input type="text" class="form-control" name="end-time" value="<?php echo (isset($_REQUEST['end_time'])) ? $_REQUEST['end_time']:''; ?>" />
						<span class="input-group-addon"><span class="fa fa-clock-o"></span></span>
					</div>
					<?php echo (array_key_exists ('end-time' , $add_meeting_errors )) ? $add_meeting_errors['end-time']:''; ?>
				</div>
			</td>
		</tr>
		<tr>
			<td></td>
			<td colspan="2">
				<input type="hidden" name="booked-by-id" value="<?php echo $current_user->ID ?>">
				<input type="hidden" name="meeting-approved" value="0">
				<button type="submit" class="btn btn-default caps" name="add-meeting">Send booking for approval <i class="fa fa-check"></i></button>
				<a href="<?php the_permalink(); ?><?php echo (isset($_REQUEST['location-id'])) ? '?location-id='.$_REQUEST['location-id']:''; ?>" class="btn btn-default caps">Cancel <i class="fa fa-times"></i></a>
			</td>
		</tr>
	</tbody>
</table>
</form>