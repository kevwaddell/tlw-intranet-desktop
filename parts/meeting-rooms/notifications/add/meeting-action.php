<?php if ( isset($_GET['meetingid']) && $_GET['action'] == "add_meeting") {

	$page_url = explode("?", $_SERVER['REQUEST_URI']);
	
	$meeting_id = $_GET['meetingid'];
	$meeting = get_post($meeting_id);
	$room = wp_get_post_terms($meeting_id,'tlw_rooms_tax');
	$description = get_field('meeting_description', $meeting_id);
	$meeting_date_convert = strtotime( get_field('meeting_date', $meeting_id) );
	$start_time = get_field('start_time', $meeting_id);
	$meeting_start = date('H:i', $start_time);
	$end_time = get_field('end_time', $meeting_id);
	$meeting_end = date('H:i', $end_time);
	$booked_by = get_user_by('id', $meeting->post_author);
	
	/* SET POST META */
	
	if ($meeting->post_status == 'pending') {
	
	include_once (STYLESHEETPATH . '/_/inc/meeting-rooms/notifications/add-meeting-email.php');
	
	}

?>

<div class="alert alert-success text-center">
	
	<h4><i class="fa fa-check-circle"></i> Success</h4>
	
	Your room booking request has been sent to<br><strong>Office Administration</strong> for approval.<br>
	You will receive an email when your request has been approved.<br><br>
	
	<strong class="caps">Meeting details:</strong><br>
	<p>
		<span class="bold">Description:</span> <?php echo $description; ?><br>
		<span class="bold">Room:</span> <?php echo $room[0]->name; ?><br>
		<span class="bold">Date:</span>  <?php echo date('D jS F Y', $meeting_date_convert); ?><br>
		<span class="bold">Time:</span>  <?php echo $meeting_start; ?> - <?php echo $meeting_end; ?>
	</p>
	<br>
	
	<div class="action-btns">

		<a href="<?php echo $page_url[0]; ?>" class="btn btn-success btn-block"><i class="fa fa-check fa-lg"></i>Continue</a>
		
	</div>
	
</div>

<?php }  ?>

<?php if ( isset($_GET['meetingid']) && $_GET['action'] == "cancel_add_meeting") {
	
	$meeting_id = $_GET['meetingid'];
	wp_delete_post( $meeting_id, true );
	
?>
<div class="alert alert-success text-center">
	
	<h4><i class="fa fa-check-circle"></i> Success</h4>
	
	Your room booking request has been canceled.<br><br>
	
	<div class="action-btns">

		<a href="<?php echo $page_url[0]; ?>" class="btn btn-danger btn-block"><i class="fa fa-check fa-lg"></i>Continue</a>
		
	</div>
	
</div>
<?php }  ?>
