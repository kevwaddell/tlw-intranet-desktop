<?php if (isset($_GET['meetingid']) && $_GET['action'] == "cancel_meeting") { 
$current_user = get_user_by('id', $current_user_ID);
$meeting = get_post($_GET['meetingid']);
$room = wp_get_post_terms( $meeting->ID, 'tlw_rooms_tax');
$booked_by = get_user_by('id', $meeting->post_author);
$description = get_field('meeting_description', $meeting->ID);
$meeting_date_raw = get_field('meeting_date', $meeting->ID);
$meeting_date_convert = strtotime($meeting_date_raw);
$start_time = get_field('start_time', $meeting->ID);
$end_time = get_field('end_time', $meeting->ID);
$admin_name = $rb_admin['display_name'];
$admin_email = $rb_admin['user_email'];

$from_name = $booked_by->data->display_name;
$from_email = $booked_by->data->user_email;

	if ($meeting->post_status == 'pending' || $meeting->post_status == 'publish') {
		$default_tz = date_default_timezone_get();
		date_default_timezone_set('Europe/London'); 
		$now = strtotime("now");
	
		$staff_attendees = get_post_meta($meeting->ID, 'attendees_staff', true);

		if ($start_time > $now) {
			
		include (STYLESHEETPATH . '/_/inc/meeting-rooms/notifications/cancel-meeting-email.php');
				
		}
		
		date_default_timezone_set($default_tz); 
		
		$meeting_args = array(
		 'ID'           => $meeting->ID,
		 'post_status'	=> 'draft'
		 );
		 
		 wp_update_post( $meeting_args );

	} 

?>

<div class="alert alert-success text-center">
	
	<h4><i class="fa fa-check-circle"></i> Confirm</h4>

	Booking of <strong><?php echo $room[0]->name; ?></strong> for <strong><?php echo $description; ?></strong> meeting has been canceled and <strong><?php echo $booked_by->data->display_name; ?></strong> has been notified.
	<?php if (!empty($staff_attendees) && $staff_attendees > 0) { ?>
	<br>There are <strong><?php echo $staff_attendees; ?></strong> attendees.
	<?php } ?>
	<br><br>
	
	<div class="action-btns">
		
		<?php if (!empty($staff_attendees) && $staff_attendees > 0) { ?>
		<a href="?action=notify_cancel_meeting&meetingid=<?php echo $meeting->ID; ?>" class="btn btn-success btn-block"><i class="fa fa-bullhorn fa-lg"></i> Notify attendees</a>
		<?php } else { 
		$page_url = explode("?", $_SERVER['REQUEST_URI']);	
		?>
		<a href="<?php echo $page_url[0]; ?>" class="btn btn-success btn-block">Continue</a>
		<?php } ?>
		
	</div>
</div>
<?php }  ?>