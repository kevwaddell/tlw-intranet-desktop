<?php if (isset($_GET['meetingid']) && $_GET['action'] == "approve") { 
$page_url = explode("?", $_SERVER['REQUEST_URI']);


$meeting = get_post($_GET['meetingid']);
$room = wp_get_post_terms( $meeting->ID, 'tlw_rooms_tax');
$booked_by = get_user_by('id', $meeting->post_author);
$meeting_date_raw = get_field('meeting_date', $meeting->ID);
$meeting_date = date('l jS F, Y', strtotime($meeting_date_raw));
$start_time = get_field('start_time', $meeting->ID);
$end_time = get_field('end_time', $meeting->ID);


	if ($meeting->post_status == 'pending' || $meeting->post_status == 'draft') {
		 
		if ($start_time > $today_start) {
		include (STYLESHEETPATH . '/_/inc/meeting-rooms/notifications/approve-meeting-email.php');
		}
				
		 $meeting_args = array(
		 'ID'           => $meeting->ID,
		 'post_status'	=> 'publish'
		 );
		 
		 wp_update_post( $meeting_args );
		 
		 add_post_meta($meeting->ID, 'attendees_staff', '0', true);
		 add_post_meta($meeting->ID, '_attendees_staff', 'field_539877b3fecd7', true);
		 add_post_meta($meeting->ID, 'attendees_clients', '0', true);
		 add_post_meta($meeting->ID, '_attendees_clients', 'field_539878dcfecd9', true);

	} 

?>

<div class="alert alert-success text-center">
	
	<h4><i class="fa fa-check-circle"></i> Success</h4>

	<strong><?php echo $room[0]->name; ?></strong> meeting room has been booked<br>for <strong><?php echo $booked_by->data->display_name; ?></strong>.<br><br>

	<div class="action-btns">
		<a href="<?php echo $page_url[0]; ?>" class="btn btn-success btn-block">Continue</a>
	</div>
	
</div>

<?php }  ?>
