<?php if (isset($_GET['meetingid']) && $_GET['action'] == "reject_meeting") { 

$page_url = explode("?", $_SERVER['REQUEST_URI']);

$meeting = get_post($_GET['meetingid']);
$room = wp_get_post_terms( $meeting->ID, 'tlw_rooms_tax');
$booked_by = get_user_by('id', $meeting->post_author);
$meeting_date_raw = get_field('meeting_date', $meeting->ID);
$meeting_date = date('l jS F, Y', strtotime($meeting_date_raw));
$start_time = get_field('start_time', $meeting->ID);
//$start = date('g:ia', $start_time);
$end_time = get_field('end_time', $meeting->ID);
//$end = date('g:ia', $end_time);
//echo '<pre>';print_r($booked_by->data->user_email);echo '</pre>';

	if ($meeting->post_status == 'pending') {
	
		 $meeting_args = array(
		 'ID'           => $meeting->ID,
		 'post_status'	=> 'draft'
		 );
		 
		 wp_update_post( $meeting_args );
		 
		include (STYLESHEETPATH . '/_/inc/meeting-rooms/notifications/reject-meeting-email.php');
	} 

?>

<div class="alert alert-success text-center">
	
	<h4><i class="fa fa-check-circle"></i> Success</h4>
	
	Booking for <strong><?php echo $room[0]->name; ?></strong> meeting room has been rejected and<br><strong><?php echo $booked_by->data->display_name; ?></strong> has been notified.</strong><br><br>
	<div class="action-btns">
		<a href="<?php echo $page_url[0]; ?>" class="btn btn-success btn-block">Continue</a>
	</div>
</div>

<div class="rule"></div>

<?php }  ?>
