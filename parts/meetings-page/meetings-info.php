<?php
global $current_user;
global $meeting_added;
global $add_attendee_errors;
global $edit_meeting_errors;
global $attendees_added;
global $current_attendees_staff;
global $current_attendees_clients;
global $locations;	
global $meeting_updated;
global $meeting_deleted;
global $meeting_canceled;

$id = $_REQUEST['meeting-id'];
if ($meeting_added) {
$id = $meeting_added;	
}
$current_meeting = get_post($id);
$rooms = wp_get_post_terms( $current_meeting->ID, 'tlw_rooms_tax');
$current_location = $rooms[0];	
$booked_by = $current_meeting->post_author;	
$booked_by_fname = get_user_meta( $booked_by, 'first_name', true );
$booked_by_lname = get_user_meta( $booked_by, 'last_name', true );
$meeting_description = get_field('meeting_description', $current_meeting->ID);
$meeting_date = strtotime(get_field( 'meeting_date', $current_meeting->ID ));
$start_time = get_field( 'start_time', $current_meeting->ID);
$end_time = get_field( 'end_time', $current_meeting->ID);
$current_attendees_staff = get_field('attendees_staff', $current_meeting->ID);
$current_attendees_clients = get_field('attendees_clients', $current_meeting->ID);		
$contacts_pg = get_page_by_path( 'contacts' );
$ical_pg = get_page_by_path( 'meetings/single-ical-event');
?>

<?php if ($_GET['meeting-actions'] != 'add-attendees' && !$meeting_canceled && !$meeting_deleted && empty($add_attendee_errors)) { ?>
<?php 
$timeZone = 'Europe/London';
$mdate_time = new DateTime(get_field( 'meeting_date', $current_meeting->ID )." ". $start_time, new DateTimeZone($timeZone));
$now_time = new DateTime(null, new DateTimeZone($timeZone));
$meeting_date_time = $mdate_time->getTimestamp();
$now = $now_time->getTimestamp();
if ($meeting_date_time < $now && !empty($current_attendees_staff)) {
	foreach ($current_attendees_staff as $k => $cas) {
		if ($cas['status'] == 'pending') {
		unset($current_attendees_staff[$k]);
		}
	}
	
	$attendee_staff_key = acf_get_field_key('attendees_staff', $_REQUEST['meeting-id']);
	update_field( $attendee_staff_key, $current_attendees_staff, $_REQUEST['meeting-id'] );
}
//debug($current_user->ID." - ".$booked_by);
//debug($_SERVER[SERVER_ADMIN]);
?>
<?php if ($_GET['meeting-actions'] == 'edit-meeting') { ?>
	<form action="<?php the_permalink(); ?><?php echo (isset($_REQUEST['meeting-day'])) ? '?meeting-day='.$_REQUEST['meeting-day']:'' ?><?php echo (isset($_REQUEST['meeting-day-to'])) ? '&meeting-day-to='.$_REQUEST['meeting-day-to']:'' ?>" method="post">		
<?php } ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th width="200" class="text-right"><i class="meeting-icon fa fa-calendar-plus-o"></i></th>
			<th>
				<?php if ($_GET['meeting-actions'] == 'edit-meeting') { ?>
				<input type="text" class="input-title" name="meeting-title" value="<?php echo get_the_title( $current_meeting->ID ); ?>">
				<?php } else { ?>
				<?php if ($current_user->ID == $booked_by) { ?>
				<div class="label label-primary"><i class="fa fa-calendar-check-o"></i>Booked by you</div>		
				<?php } ?>
				<h1><?php echo get_the_title( $current_meeting->ID ); ?></h1>
				<?php } ?>
			</th>
		</tr>
	</thead>
	<tbody>
		<?php if ($_GET['meeting-actions'] != 'edit-meeting' &&  $current_user->ID != $booked_by) { ?>
		<tr>
			<td class="bold text-right">Booked by</td>
			<td><a href="<?php echo get_permalink($contacts_pg->ID); ?>?id=<?php echo $booked_by; ?>&contacts=team#contact-id-<?php echo $booked_by; ?>"><?php echo $booked_by_fname; ?> <?php echo $booked_by_lname; ?></a></td>
		</tr>
		<?php } ?>
		<tr>
			<td class="bold text-right">Location</td>
			<td>
				<?php if ($_GET['meeting-actions'] == 'edit-meeting') { ?>
				<div class="form-group<?php echo (array_key_exists ('location' ,  $edit_meeting_errors )) ? ' has-error':''; ?>">
				<select name="location-id" class="selectpicker" data-width="50%" title="Choose a location">
					<?php foreach ($locations as $location) { ?>
					<option value="<?php echo $location->term_id; ?>"<?php echo ($current_location->term_id == $location->term_id ) ? ' selected':''; ?>><?php echo $location->name; ?></option>
					<?php } ?>
				</select>
				<?php echo (array_key_exists ('location' ,  $edit_meeting_errors )) ?  $edit_meeting_errors['location']:''; ?>
				</div>
				<?php } else { ?>
				<?php echo $current_location->name; ?>
				<?php } ?>
			</td>
		</tr>
		<?php if (!empty($meeting_description)) { ?>
		<tr>
			<td class="bold text-right">Description</td>
			<td>
				<?php if ($_GET['meeting-actions'] == 'edit-meeting') { ?>
				<div class="form-group">
					<textarea class="form-control" rows="3" name="meeting-description" placeholder="Enter a meeting description"><?php echo $meeting_description; ?></textarea>
				</div>
				<?php } else { ?>
				<?php echo $meeting_description; ?>
				<?php } ?>
			</td>
		</tr>			
		<?php } ?>
		<tr>
			<td class="bold text-right">Date</td>
			<td>
				<?php if ($_GET['meeting-actions'] == 'edit-meeting') { ?>
				<div class="form-group<?php echo (array_key_exists ('meeting-date' , $edit_meeting_errors )) ? ' has-error':''; ?>">
					<div class='input-group date' id='meeting-datepicker'>
						<input type="text" class="form-control" name="meeting-date" placeholder="Click icon to select a date" value="<?php echo date('l jS F, Y', $meeting_date); ?>" />
						<span class="input-group-addon"><span class="fa fa-calendar"></span></span>
					</div>
					<?php echo (array_key_exists ('meeting-date' , $edit_meeting_errors )) ? $edit_meeting_errors['meeting-date']:''; ?>
				</div>
				<?php } else { ?>
				<?php echo date('l - jS F - Y', $meeting_date); ?>
				<?php } ?>
			</td>
		</tr>
		<?php if ($_GET['meeting-actions'] == 'edit-meeting') { ?>
		<tr>
			<td class="text-right"><label for="start-time">Start time</label></td>
			<td>
				<div class="form-group<?php echo (array_key_exists ('start-time' ,  $edit_meeting_errors )) ? ' has-error':''; ?>">
					<div class='input-group date' id='meeting-startpicker'>
						<input type="text" class="form-control" name="start-time" placeholder="Click icon to select a time" value="<?php echo $start_time; ?>" />
						<span class="input-group-addon"><span class="fa fa-clock-o"></span></span>
					</div>
					<?php echo (array_key_exists ('start-time' ,  $edit_meeting_errors )) ?  $edit_meeting_errors['start-time']:''; ?>
				</div>
			</td>
		</tr>
		<tr>
			<td class="text-right"><label for="end-time">End time</label></td>
			<td>
				<div class="form-group<?php echo (array_key_exists ('end-time' , $edit_meeting_errors )) ? ' has-error':''; ?>">
					<div class='input-group date' id='meeting-endpicker'>
						<input type="text" class="form-control" name="end-time" placeholder="Click icon to select a time" value="<?php echo $end_time; ?>" />
						<span class="input-group-addon"><span class="fa fa-clock-o"></span></span>
					</div>
					<?php echo (array_key_exists ('end-time' ,  $edit_meeting_errors )) ? $edit_meeting_errors['end-time']:''; ?>
				</div>
			</td>
		</tr>
		<?php } else { ?>
		<tr>
			<td class="bold text-right">Time</td>
			<td><?php echo $start_time; ?> - <?php echo $end_time; ?></td>
		</tr>
			<?php } ?>
		<?php if (!empty($current_attendees_staff) && $_GET['meeting-actions'] != 'edit-meeting') { ?>
		<tr>
			<td class="bold text-right">Internal attendees</td>
			<td>
				<div class="label label-success"><i class="fa fa-check fa-lg pull-left"></i> <?php echo ($meeting_date_time > $now) ? 'Accepted' : 'Attended' ?></div>
				<?php if ($meeting_date_time > $now) { ?>
				<div class="label label-info"><i class="fa fa-clock-o fa-lg pull-left"></i> Pending</div>
				<?php } ?>
			</td>
		</tr>
		<tr class="success">
			<td>
				<i class="fa fa-check fa-2x pull-right text-success"></i>
			</td>
			<td>
				<a href="<?php echo get_permalink($contacts_pg->ID); ?>?id=<?php echo $current_user->ID; ?>&contacts=team#contact-id-<?php echo $current_user->ID; ?>" class="attendee text-success">
					<span class="name"><?php echo $booked_by_fname; ?> <?php echo $booked_by_lname; ?></span>
				</a>
			</td>
		</tr>
		<?php foreach ($current_attendees_staff as $staff) { 
				$att_id = $staff['attendee']['ID'];
				$att_fname = get_user_meta( $att_id, "first_name", true );
				$att_lname = get_user_meta( $att_id, "last_name", true );
				$status = $staff['status'];
				?>
		<tr class="<?php echo ($status == 'accepted') ? 'success': 'info'; ?>">
			<td>
				<?php if ($status == 'accepted') { ?>

				<i class="fa fa-check fa-2x pull-right text-success"></i>
				<?php } else { ?>
				<i class="fa fa-clock-o fa-2x pull-right text-info"></i>
											
				<?php } ?>
			</td>
			<td>
				<a href="<?php echo get_permalink($contacts_pg->ID); ?>?id=<?php echo $att_id; ?>&contacts=team#contact-id-<?php echo $att_id; ?>" class="attendee <?php echo ($status == 'accepted') ? 'text-success': 'text-info'; ?>">
					<span class="name"><?php echo $att_fname; ?> <?php echo $att_lname; ?></span>
				</a>
				<?php if ($current_user->ID == $booked_by && $meeting_date_time > $now && $status == 'pending') { ?>
				<a href="?meeting-actions=notify-user&user-id=<?php echo $att_id; ?>&meeting-id=<?php echo $current_meeting->ID; ?><?php echo (isset($_REQUEST['meeting-day'])) ? '&meeting-day='.$_REQUEST['meeting-day']:'' ?><?php echo (isset($_REQUEST['meeting-day-to'])) ? '&meeting-day-to='.$_REQUEST['meeting-day-to']:'' ?>" class="notify-btn btn btn-primary">Notify <?php echo $att_fname; ?> <i class="fa fa-envelope"></i></a>
				<a href="?meeting-actions=remove-attendee&user-id=<?php echo $att_id; ?>&meeting-id=<?php echo $current_meeting->ID; ?><?php echo (isset($_REQUEST['meeting-day'])) ? '&meeting-day='.$_REQUEST['meeting-day']:'' ?><?php echo (isset($_REQUEST['meeting-day-to'])) ? '&meeting-day-to='.$_REQUEST['meeting-day-to']:'' ?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
				<?php } ?>
				<?php if ($current_user->ID == $att_id && $meeting_date_time > $now && $status == 'accepted') { ?>
				<a href="?meeting-actions=add-reminder&user-id=<?php echo $att_id; ?>&meeting-id=<?php echo $current_meeting->ID; ?><?php echo (isset($_REQUEST['meeting-month'])) ? '&meeting-month='.$_REQUEST['meeting-month']:'' ?><?php echo (isset($_REQUEST['meeting-year'])) ? '&meeting-year='.$_REQUEST['meeting-year']:'' ?><?php echo (isset($_REQUEST['meeting-day'])) ? '&meeting-day='.$_REQUEST['meeting-day']:'' ?><?php echo (isset($_REQUEST['meeting-day-to'])) ? '&meeting-day-to='.$_REQUEST['meeting-day-to']:'' ?>" class="btn btn-danger"><i class="fa fa-bell"></i></a>
				<a href="<?php echo get_permalink( $ical_pg->ID ); ?>?meeting-id=<?php echo $current_meeting->ID; ?>" class="btn btn-primary" target="_blank"><i class="fa fa-calendar-plus-o"></i></a>
				<?php } ?>
			</td>
		</tr>
		<?php } ?>
		
		<?php } ?>
		<?php if (!empty($current_attendees_clients) && $_GET['meeting-actions'] != 'edit-meeting') { ?>
		<tr>
			<td class="bold text-right">External attendees</td>
			<td></td>
		</tr>
		<?php foreach ($current_attendees_clients as $k => $client) { ?>
		<tr>
			<td></td>
			<?php if ($_GET['meeting-actions'] == 'edit-attendee' && $_GET['client-key'] == $k) { ?>
			<td>
				<form action="<?php the_permalink(); ?><?php echo (isset($_REQUEST['meeting-day'])) ? '?meeting-day='.$_REQUEST['meeting-day']:'' ?><?php echo (isset($_REQUEST['meeting-day-to'])) ? '&meeting-day-to='.$_REQUEST['meeting-day-to']:'' ?>" method="post" class="form-inline">
					<div class="form-group attendee-client-input">
						<input type="text" name="attendee-client" class="form-control" value="<?php echo $client['attendee_client']; ?>">
						<button type="submit" class="btn btn-success" name="update-attendee"><i class="fa fa-check"></i></button>
						<a href="<?php the_permalink(); ?>?meeting-id=<?php echo $current_meeting->ID; ?><?php echo (isset($_REQUEST['meeting-day'])) ? '&meeting-day='.$_REQUEST['meeting-day']:'' ?><?php echo (isset($_REQUEST['meeting-day-to'])) ? '&meeting-day-to='.$_REQUEST['meeting-day-to']:'' ?>" class="btn btn-warning caps"><i class="fa fa-times"></i></a>
						<input type="hidden" name="client-key" value="<?php echo $k; ?>">
						<input type="hidden" name="meeting-id" value="<?php echo $current_meeting->ID ?>">
					</div>
				</form>
			</td>
			<?php } else { ?>
			<td>	
				<span class="name"><?php echo $client['attendee_client']; ?></span>
				<?php if ($current_user->ID == $booked_by && $meeting_date_time > $now) { ?>
				<a href="?meeting-actions=edit-attendee&client-key=<?php echo $k; ?>&meeting-id=<?php echo $current_meeting->ID; ?><?php echo (isset($_REQUEST['meeting-day'])) ? '&meeting-day='.$_REQUEST['meeting-day']:'' ?><?php echo (isset($_REQUEST['meeting-day-to'])) ? '&meeting-day-to='.$_REQUEST['meeting-day-to']:'' ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
				<a href="?meeting-actions=remove-attendee&client-key=<?php echo $k; ?>&meeting-id=<?php echo $current_meeting->ID; ?><?php echo (isset($_REQUEST['meeting-day'])) ? '&meeting-day='.$_REQUEST['meeting-day']:'' ?><?php echo (isset($_REQUEST['meeting-day-to'])) ? '&meeting-day-to='.$_REQUEST['meeting-day-to']:'' ?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
				<?php } ?>
			</td>
			<?php } ?>
		</tr>	
		<?php } ?>		
		<?php } ?>
		
		<?php if ($_GET['meeting-actions'] == 'edit-meeting') { ?>
		<tr>
			<td></td>
			<td colspan="2">
				<input type="hidden" name="meeting-id" value="<?php echo $current_meeting->ID ?>">
				<input type="hidden" name="booked-by-id" value="<?php echo $current_meeting->post_author; ?>">
				<button type="submit" class="btn btn-default caps" name="edit-meeting">Update meeting details <i class="fa fa-check"></i></button>
				<a href="<?php the_permalink(); ?>?meeting-id=<?php echo $current_meeting->ID; ?><?php echo (isset($_REQUEST['meeting-day'])) ? '&meeting-day='.$_REQUEST['meeting-day']:'' ?><?php echo (isset($_REQUEST['meeting-day-to'])) ? '&meeting-day-to='.$_REQUEST['meeting-day-to']:'' ?>" class="btn btn-default caps">Cancel <i class="fa fa-times"></i></a>
			</td>
		</tr>
		<?php } ?>
		
		<?php if ($meeting_date_time > $now && $_GET['meeting-actions'] != 'edit-meeting') { ?>
		<tr>
			<td></td>
			<td>
				<div class="dropdown">
					<button class="btn btn-default dropdown-toggle" type="button" id="meeting-actions-menu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
	   				<span class="caps" style="padding-right: 10px;">User actions</span>
	   				<i class="fa fa-cogs"></i>
					</button>
					 <ul class="dropdown-menu" aria-labelledby="meeting-actions-menu">
					<?php if ($current_user->ID == $booked_by && $meeting_date_time > $now) { ?>
						<li><a href="?meeting-actions=add-attendees&meeting-id=<?php echo $current_meeting->ID; ?><?php echo (isset($_REQUEST['meeting-day'])) ? '&meeting-day='.$_REQUEST['meeting-day']:'' ?><?php echo (isset($_REQUEST['meeting-day-to'])) ? '&meeting-day-to='.$_REQUEST['meeting-day-to']:'' ?>"><i class="fa fa-plus"></i> Add attendees</a></li>
						<li><a href="?meeting-actions=edit-meeting&meeting-id=<?php echo $current_meeting->ID; ?><?php echo (isset($_REQUEST['meeting-day'])) ? '&meeting-day='.$_REQUEST['meeting-day']:'' ?><?php echo (isset($_REQUEST['meeting-day-to'])) ? '&meeting-day-to='.$_REQUEST['meeting-day-to']:'' ?>"><i class="fa fa-pencil"></i> Change meeting</a></li>
						<li><a href="?meeting-actions=cancel-meeting&meeting-id=<?php echo $current_meeting->ID; ?><?php echo (isset($_REQUEST['meeting-day'])) ? '&meeting-day='.$_REQUEST['meeting-day']:'' ?><?php echo (isset($_REQUEST['meeting-day-to'])) ? '&meeting-day-to='.$_REQUEST['meeting-day-to']:'' ?>"><i class="fa fa-times"></i> Cancel meeting</a></li>
						<li><a href="?meeting-actions=add-reminder&user-id=<?php echo $booked_by; ?>&meeting-id=<?php echo $current_meeting->ID; ?><?php echo (isset($_REQUEST['meeting-day'])) ? '&meeting-day='.$_REQUEST['meeting-day']:'' ?><?php echo (isset($_REQUEST['meeting-day-to'])) ? '&meeting-day-to='.$_REQUEST['meeting-day-to']:'' ?>"><i class="fa fa-bell"></i> Add reminder</a></li>
					<?php } ?>
						<li><a href="<?php echo get_permalink( $ical_pg->ID ); ?>?meeting-id=<?php echo $current_meeting->ID; ?>" target="_blank"><i class="fa fa-calendar-plus-o"></i> Add to calendar</a></li>
					 </ul>
				</div>
			</td>
		</tr>
		<?php } ?>
		<?php if ( current_user_can( 'administrator') && $meeting_date_time < $now) { ?>
		<tr>
			<td></td>
			<td>
				<a href="?meeting-actions=delete-meeting&meeting-id=<?php echo $current_meeting->ID; ?><?php echo (isset($_REQUEST['meeting-day'])) ? '&meeting-day='.$_REQUEST['meeting-day']:'' ?><?php echo (isset($_REQUEST['meeting-day-to'])) ? '&meeting-day-to='.$_REQUEST['meeting-day-to']:'' ?><?php echo (isset($_REQUEST['meeting-year'])) ? '&meeting-year='.$_REQUEST['meeting-year']:'' ?>" class="btn btn-default caps"><i class="fa fa-trash"></i> Delete meeting</a>
			</td>
		</tr>
		<?php } ?>
	</tbody>
</table>	
<?php//date_default_timezone_set($default_tz);  ?>	
<?php } ?>

<?php if ($_GET['meeting-actions'] == 'add-attendees' || !empty($add_attendee_errors)) { ?>
	<?php  get_template_part( 'parts/meetings-page/add', 'attendees' ); ?>
	<?php  //get_template_part( 'parts/meetings-page/add', 'attendees-acf' ); ?>
<?php } ?>

<?php if ($_GET['meeting-actions'] == 'edit-meeting') { ?>
	</form>		
<?php } ?>