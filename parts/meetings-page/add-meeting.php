<?php
global $current_user;
global $locations;	
global $all_users;
global $add_meeting_errors;
global $room;
//echo '<pre class="debug">';print_r($all_users);echo '</pre>';
?>
<?php if (array_key_exists ('booked' , $add_meeting_errors )) { ?>
<div class="alert alert-danger alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<p><i class="fa fa-check-circle"></i> The meeting room <span class="bold"><?php echo $room->name; ?></span> is already booked at <span class="bold"><?php echo $_REQUEST['start-time'] ?></span> on <span class="bold"><?php echo $_REQUEST['meeting-date']; ?></span>.</p>	
</div>		
<?php } ?>
<form action="<?php the_permalink(); ?>" method="post">
<table class="table table-striped">
	<thead>
		<tr>
			<th width="200" class="text-right"><i class="fa fa-calendar-plus-o fa-4x"></i></th>
			<th><h1>Add meeting</h1></th>
		</tr>
	</thead>
	<tbody>
		<tr<?php echo (array_key_exists ('location' , $add_meeting_errors )) ? ' class="danger"':''; ?>>
			<td class="text-right<?php echo (array_key_exists ('location' , $add_meeting_errors )) ? ' text-danger':''; ?>"><label for="location-id">Location</label></td>
			<td>
				<div class="form-group<?php echo (array_key_exists ('location' , $add_meeting_errors )) ? ' has-error':''; ?>">
				<select name="location-id" class="selectpicker" data-width="50%" title="Choose a location">
					<?php foreach ($locations as $location) { ?>
					<option value="<?php echo $location->term_id; ?>"<?php echo ($_REQUEST['location-id'] == $location->term_id ) ? ' selected':''; ?>><?php echo $location->name; ?></option>
					<?php } ?>
				</select>
				<?php echo (array_key_exists ('location' , $add_meeting_errors )) ? $add_meeting_errors['location']:''; ?>
				</div>
			</td>
		</tr>
		<tr<?php echo (array_key_exists ('meeting-title' , $add_meeting_errors )) ? ' class="danger"':''; ?>>
			<td class="text-right<?php echo (array_key_exists ('meeting-title' , $add_meeting_errors )) ? ' text-danger':''; ?>"><label for="meeting-title">* Meeting title</label></td>
			<td>
				<div class="form-group<?php echo (array_key_exists ('meeting-title' , $add_meeting_errors )) ? ' has-error':''; ?>">
					<input type="text" class="form-control" name="meeting-title"  placeholder="Enter a meeting title" value="<?php echo (isset($_REQUEST['meeting-title'])) ? $_REQUEST['meeting-title']:''; ?>">
					<?php echo (array_key_exists ('meeting-title' , $add_meeting_errors )) ? $add_meeting_errors['meeting-title']:''; ?>
				</div>
			</td>
		</tr>
		<tr>
			<td class="text-right vtop"><label for="meeting-description">Meeting description</label></td>
			<td>
				<div class="form-group">
					<textarea class="form-control" rows="3" name="meeting-description" placeholder="Enter a meeting description"><?php echo (isset($_REQUEST['meeting-description'])) ? $_REQUEST['meeting-description']:''; ?></textarea>
				</div>
			</td>
		</tr>
		<tr<?php echo (array_key_exists ('meeting-date' , $add_meeting_errors )) ? ' class="danger"':''; ?>>
			<td class="text-right<?php echo (array_key_exists ('meeting-date' , $add_meeting_errors )) ? ' text-danger':''; ?>"><label for="meeting-date">* Date</label></td>
			<td>
				<div class="form-group<?php echo (array_key_exists ('meeting-date' , $add_meeting_errors )) ? ' has-error':''; ?>">
					<div class='input-group date' id='meeting-datepicker'>
						<input type="text" class="form-control" name="meeting-date" placeholder="Click icon to select a date" value="<?php echo (isset($_REQUEST['meeting-date'])) ? $_REQUEST['meeting-date']:''; ?>" />
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
						<input type="text" class="form-control" name="start-time" placeholder="Click icon to select a time" value="<?php echo (isset($_REQUEST['start-time'])) ? $_REQUEST['start-time']:''; ?>" />
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
						<input type="text" class="form-control" name="end-time" placeholder="Click icon to select a time" value="<?php echo (isset($_REQUEST['end-time'])) ? $_REQUEST['end-time']:''; ?>" />
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
				<button type="submit" class="btn btn-default caps" name="add-meeting">Check availability <i class="fa fa-check"></i></button>
				<a href="<?php the_permalink(); ?>" class="btn btn-default caps">Cancel <i class="fa fa-times"></i></a>
			</td>
		</tr>
	</tbody>
</table>
</form>