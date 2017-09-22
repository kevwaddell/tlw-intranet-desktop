<?php if (isset($_GET['meetingid']) && $_GET['action'] == "notify_cancel_meeting") { 
$page_url = explode("?", $_SERVER['REQUEST_URI']);

$meeting = get_post($_GET['meetingid']);
$staff_attendees = get_field('attendees_staff', $meeting->ID);
$room = wp_get_post_terms( $meeting->ID, 'tlw_rooms_tax');
$description = get_field('meeting_description', $meeting->ID);
$meeting_date_raw = get_field('meeting_date', $meeting->ID);
$meeting_date_convert = strtotime($meeting_date_raw);
$start_time = get_field('start_time', $meeting->ID);
$end_time = get_field('end_time', $meeting->ID);
$to_arr = array();
//echo '<pre>';print_r($staff_attendees);echo '</pre>';

foreach ($staff_attendees as $key => $attendee) {
	if (!in_array($attendee[attendee_staff][user_email], $to_arr)) {
		
		array_push($to_arr, $attendee[attendee_staff][user_email]);
	}
	
	if ($attendee[status] == 'accepted') {
	update_post_meta($meeting->ID, 'attendees_staff_'.$key.'_status','pending', $attendee[status]);	
	}
	
}

include (STYLESHEETPATH . '/_/inc/meeting-rooms/notifications/notify-attendees-cancel-email.php');

//echo '<pre>';print_r($to);echo '</pre>';

?>
<div class="alert alert-success text-center">
	
	<h4><i class="fa fa-check-circle"></i> Success</h4>

	<strong>The following attendees have been notified:</strong><br><br>
	
	<ul class="list-unstyled">
		<?php foreach ($staff_attendees as $attendee) { ?>
		<li><?php echo $attendee[attendee_staff][display_name]; ?></li>
		<?php } ?>
	</ul>
	<br>
	
	<div class="action-btns">
		
		<a href="<?php echo $page_url[0]; ?>" class="btn btn-success btn-block">Continue</a>
		
	</div>
</div>

<?php }  ?>