<?php
global $current_user;
global $meeting_added;
global $add_attendee_errors;
global $attendees_added;
global $current_attendees_staff;
global $current_attendees_clients;

$id = $_REQUEST['meeting-id'];
if ($meeting_added) {
$id = $meeting_added;	
}
$current_meeting = get_post($id);
$locations = wp_get_post_terms( $current_meeting->ID, 'tlw_rooms_tax');
$current_location = $locations[0];	
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
?>

<?php if ($_GET['meeting-actions'] != 'add-attendees' && empty($add_attendee_errors)) { ?>
<?php 
$timeZone = 'Europe/London';
$mdate_time = new DateTime(get_field( 'meeting_date', $current_meeting->ID )." ". $start_time, new DateTimeZone($timeZone));
$now_time = new DateTime(null, new DateTimeZone($timeZone));
$meeting_date_time = $mdate_time->getTimestamp();
$now = $now_time->getTimestamp();
//debug(date('l - jS F - Y G:i', $meeting_date_time).'<br>'.date('l - jS F - Y G:i', $now) );
?>
<table class="table table-striped">
	<thead>
		<tr>
			<th width="200" class="text-right"><i class="meeting-icon fa fa-calendar-plus-o"></i></th>
			<th>
				<h1><?php echo get_the_title( $current_meeting->ID ); ?></h1>
			</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="bold text-right">Booked by</td>
			<td><a href="<?php echo get_permalink($contacts_pg->ID); ?>?id=<?php echo $booked_by; ?>&contacts=team#contact-id-<?php echo $booked_by; ?>"><?php echo $booked_by_fname; ?> <?php echo $booked_by_lname; ?></a></td>
		</tr>
		<tr>
			<td class="bold text-right">Location</td>
			<td><?php echo $current_location->name; ?></td>
		</tr>
		<?php if (!empty($meeting_description)) { ?>
		<tr>
			<td class="bold text-right">Description</td>
			<td><?php echo $meeting_description; ?></td>
		</tr>			
		<?php } ?>
		<tr>
			<td class="bold text-right">Date</td>
			<td><?php echo date('l - jS F - Y', $meeting_date); ?></td>
		</tr>
		<tr>
			<td class="bold text-right">Time</td>
			<td><?php echo $start_time; ?> - <?php echo $end_time; ?></td>
		</tr>
		<?php if (!empty($current_attendees_staff)) { ?>
		<tr>
			<td class="bold text-right">Internal attendees</td>
			<td>
				<div class="label label-success">Accepted <i class="fa fa-check fa-lg pull-right"></i> </div>
				<div class="label label-info">Pending <i class="fa fa-clock-o fa-lg pull-right"></i></div>
			</td>
		</tr>
		<?php foreach ($current_attendees_staff as $staff) { 
				$att_id = $staff['attendee']['ID'];
				$att_fname = get_user_meta( $att_id, "first_name", true );
				$att_lname = get_user_meta( $att_id, "last_name", true );
				$status = $staff['status'];
				?>
		<?php if ($status != 'rejected') { ?>	
		<tr class="<?php echo ($status == 'accepted') ? 'success': 'info'; ?>">
			<td>
				<?php if ($status == 'accepted') { ?>
				<i class="fa fa-check fa-2x pull-right text-success"></i>
				<?php } else { ?>
				<i class="fa fa-clock-o fa-2x pull-right text-info"></i>
				<?php } ?>	
			</td>
			<td>
				<a href="<?php echo get_permalink($contacts_pg->ID); ?>?id=<?php echo $att_id; ?>&contacts=team#contact-id-<?php echo $id; ?>" class="attendee <?php echo ($status == 'accepted') ? 'text-success': 'text-info'; ?>">
					<span class="name"><?php echo $att_fname; ?> <?php echo $att_lname; ?></span>
				</a>
				<?php if ($current_user->ID == $booked_by && $meeting_date_time > $now && $status == 'pending') { ?>
				<a href="?meeting-actions=notify-user&user-id=<?php echo $att_id; ?>&meeting-id=<?php echo $current_meeting->ID; ?><?php echo (isset($_REQUEST['meeting-day'])) ? '&meeting-day='.$_REQUEST['meeting-day']:'' ?><?php echo (isset($_REQUEST['meeting-day-to'])) ? '&meeting-day-to='.$_REQUEST['meeting-day-to']:'' ?>" class="notify-btn btn btn-default">Notify <?php echo $att_fname; ?> <i class="fa fa-envelope"></i></a>
				<a href="?meeting-actions=remove-attendee&user-id=<?php echo $att_id; ?>&meeting-id=<?php echo $current_meeting->ID; ?><?php echo (isset($_REQUEST['meeting-day'])) ? '&meeting-day='.$_REQUEST['meeting-day']:'' ?><?php echo (isset($_REQUEST['meeting-day-to'])) ? '&meeting-day-to='.$_REQUEST['meeting-day-to']:'' ?>" class="btn btn-default"><i class="fa fa-trash"></i></a>
				<?php } ?>
				<?php if ($current_user->ID == $att_id && $meeting_date_time <= $now && $status == 'pending') { ?>
				<a href="?meeting-actions=user-status&status=accept&meeting-id=<?php echo $current_meeting->ID; ?><?php echo (isset($_REQUEST['meeting-day'])) ? '&meeting-day='.$_REQUEST['meeting-day']:'' ?><?php echo (isset($_REQUEST['meeting-day-to'])) ? '&meeting-day-to='.$_REQUEST['meeting-day-to']:'' ?>" class="notify-btn btn btn-success">Accept <i class="fa fa-check"></i></a>
				<a href="?meeting-actions=user-status&status=rejected&meeting-id=<?php echo $current_meeting->ID; ?><?php echo (isset($_REQUEST['meeting-day'])) ? '&meeting-day='.$_REQUEST['meeting-day']:'' ?><?php echo (isset($_REQUEST['meeting-day-to'])) ? '&meeting-day-to='.$_REQUEST['meeting-day-to']:'' ?>" class="notify-btn btn btn-danger">Reject <i class="fa fa-times"></i></a>
				<?php } ?>
			</td>
		</tr>
		<?php } ?>
		<?php } ?>
		
		<?php } ?>
		<?php if (!empty($current_attendees_clients)) { ?>
		<tr>
			<td class="bold text-right">External attendees</td>
			<td>
			<?php foreach ($current_attendees_clients as $client) { ?>	
				<span class="name"><?php echo $client['attendee_client']; ?></span><br>
			<?php } ?>
			</td>
		</tr>			
		<?php } ?>
		<?php if ($current_user->ID == $booked_by && $meeting_date_time > $now) { ?>
		<tr>
			<td></td>
			<td>
				<a href="?meeting-actions=add-attendees&meeting-id=<?php echo $current_meeting->ID; ?><?php echo (isset($_REQUEST['meeting-day'])) ? '&meeting-day='.$_REQUEST['meeting-day']:'' ?><?php echo (isset($_REQUEST['meeting-day-to'])) ? '&meeting-day-to='.$_REQUEST['meeting-day-to']:'' ?>" class="btn btn-default caps"><i class="fa fa-plus"></i> Add attendees</a>
				<a href="?meeting-actions=edit-meeting&meeting-id=<?php echo $current_meeting->ID; ?><?php echo (isset($_REQUEST['meeting-day'])) ? '&meeting-day='.$_REQUEST['meeting-day']:'' ?><?php echo (isset($_REQUEST['meeting-day-to'])) ? '&meeting-day-to='.$_REQUEST['meeting-day-to']:'' ?>" class="btn btn-default caps"><i class="fa fa-pencil"></i> Change meeting</a>
				<a href="?meeting-actions=cancel-meeting&meeting-id=<?php echo $current_meeting->ID; ?><?php echo (isset($_REQUEST['meeting-day'])) ? '&meeting-day='.$_REQUEST['meeting-day']:'' ?><?php echo (isset($_REQUEST['meeting-day-to'])) ? '&meeting-day-to='.$_REQUEST['meeting-day-to']:'' ?>" class="btn btn-default caps"><i class="fa fa-times"></i> Cancel meeting</a>
			</td>
		</tr>
		<?php } ?>
		<?php if ( current_user_can( 'administrator') && $meeting_date_time < $now) { ?>
		<tr>
			<td></td>
			<td>
				<a href="?meeting-actions=delete-meeting&meeting-id=<?php echo $current_meeting->ID; ?><?php echo (isset($_REQUEST['meeting-day'])) ? '&meeting-day='.$_REQUEST['meeting-day']:'' ?><?php echo (isset($_REQUEST['meeting-day-to'])) ? '&meeting-day-to='.$_REQUEST['meeting-day-to']:'' ?>" class="btn btn-default caps"><i class="fa fa-trash"></i> Delete meeting</a>
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