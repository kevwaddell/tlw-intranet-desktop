<?php
global $current_user;
global $locations;	
global $all_users;
global $add_attendee_errors;
//echo '<pre class="debug">';print_r($all_users);echo '</pre>';
?>
<form action="<?php the_permalink(); ?><?php echo (isset($_REQUEST['meeting-day'])) ? '?meeting-day='.$_REQUEST['meeting-day']:'' ?><?php echo (isset($_REQUEST['meeting-day-to'])) ? '&meeting-day-to='.$_REQUEST['meeting-day-to']:'' ?>" method="post">
	<table class="table table-striped">
	<thead>
		<tr>
			<th width="200" class="text-right"><i class="fa fa-user-plus fa-4x"></i></th>
			<th><h1>Add attendees</h1></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="text-right"><label>Internal staff</label></td>
			<td><small>*Staff members will be notified of the meeting.</small></td>
		</tr>
		<tr>
			<td class="text-right"><button class="add-staff-btn btn btn-default text-center"><i class="fa fa-plus fa-lg"></i></button></td>
			<td>
				<div class="form-group">
					<select name="attendees-staff[]" class="selectpicker" data-width="100%" title="Choose a staff member">
					<?php foreach ($all_users as $user) { 
					$fname = get_user_meta( $user->ID, "first_name", true );
					$lname = get_user_meta( $user->ID, "last_name", true );
					?>
					<option value="<?php echo $user->ID; ?>"><?php echo $fname; ?> <?php echo $lname; ?></option>
					<?php } ?>
					</select>
				</div>
			</td>
		</tr>
		<tr>
			<td class="text-right"><label>External visitors</label></td>
			<td><small>*Enter the visitors full name.</small></td>
		</tr>
		<tr>
			<td class="text-right">
				<button class="add-client-btn btn btn-default text-center"><i class="fa fa-plus fa-lg"></i></button>
			</td>
			<td>
				<div class="form-group">
					<input type="text" class="form-control" name="attendees-clients[]" placeholder="Enter full name" value="" />
				</div>
			</td>
		</tr>
		<tr>
			<td></td>
			<td colspan="2">
				<input type="hidden" name="meeting-id" value="<?php echo $_REQUEST['meeting-id'] ?>">
				<button type="submit" class="btn btn-default caps" name="add-attendees">Add attendees <i class="fa fa-check"></i></button>
				<a href="<?php the_permalink(); ?>?meeting-id=<?php echo $_REQUEST['meeting-id']; ?><?php echo (isset($_REQUEST['meeting-day'])) ? '&meeting-day='.$_REQUEST['meeting-day']:'' ?><?php echo (isset($_REQUEST['meeting-day-to'])) ? '&meeting-day-to='.$_REQUEST['meeting-day-to']:'' ?>" class="btn btn-default caps">Cancel <i class="fa fa-times"></i></a>
			</td>
		</tr>
	</tbody>
</table>
</form>