<?php if (isset($_POST['meetingid']) ) { 
$meeting = get_post($_POST['meetingid']);
$current_user = get_user_by('id', $current_user_ID);

$page_url = explode("?", $_SERVER['REQUEST_URI']);

/* POST VARS */
$meeting_room = $_POST['meeting_room'];
$meeting_date_raw = $_POST['meeting_date'];
$meeting_date_convert = strtotime($meeting_date_raw);
$meeting_date = date('Ymd', $meeting_date_convert);
$start_hrs = $_POST['start_hrs'];
$start_mins = $_POST['start_mins'];
$meeting_start = $start_hrs.":".$start_mins;
$end_hrs = $_POST['end_hrs'];
$end_mins = $_POST['end_mins'];
$meeting_end = $end_hrs.":".$end_mins;

/* ORIGINAL MEETING VARS */
$room = wp_get_post_terms( $meeting->ID, 'tlw_rooms_tax');
$description = get_field('meeting_description', $meeting->ID);
$date_raw = get_field('meeting_date', $meeting->ID);
$date_convert = strtotime($date_raw);
$date = date('Ymd', $date_convert);
$start_time = date('H:i', get_field('start_time', $meeting->ID));
$end_time = date('H:i', get_field('end_time', $meeting->ID));

$changes = array('meeting_room' => $room[0]->name, 'meeting_date' => date('D jS F Y', $date_convert), 'start_time' => date('H:i',get_field('start_time', $meeting->ID)), 'end_time' => date('H:i', get_field('end_time', $meeting->ID)) );
$no_changes = 0;

	$post_args = array(
	'ID' => $meeting->ID,
	'post_name' => sanitize_title($description.' '.$date),
	'post_title' => $description
	);
	
	if ($meeting_room != $room[0]->term_id) {
		$room = get_term( $meeting_room, 'tlw_rooms_tax');
		
		wp_set_post_terms( $meeting->ID, $meeting_room, 'tlw_rooms_tax', false );
		$changes['meeting_room'] = $room->name;
		$no_changes = 1;
	}
	
	if ($meeting_date != $date) {
		
		update_post_meta($meeting->ID, 'meeting_date', $meeting_date);
		
		$post_args['post_name'] = sanitize_title($description.' '.$meeting_date);
		
		$changes['meeting_date'] = date('D jS F Y', $meeting_date_convert);
		$no_changes = 1;
	}
	
	if ($meeting_start != $start_time) {
	
		$start_time_raw = strtotime($changes['meeting_date'].' '.$start_hrs.':'.$start_mins);
		
		update_post_meta($meeting->ID, 'start_time', $start_time_raw);
		
		$changes['start_time'] = date('H:i', $start_time_raw);
		$no_changes = 1;
	}
	
	if ($meeting_end != $end_time) {
	
		$end_time_raw = strtotime($changes['meeting_date'].' '.$end_hrs.':'.$end_mins);
		
		update_post_meta($meeting->ID, 'end_time', $end_time_raw);
		
		$changes['end_time'] = date('H:i', $end_time_raw);
		$no_changes = 1;
	}
	
	if ($meeting->post_status == 'publish' && $no_changes == 1) {
	
		$post_args['post_status'] = 'pending';
	}
	
	if ($meeting->post_status == 'draft' && $no_changes == 1) {
	
		$post_args['post_status'] = 'pending';
	}
	
	wp_update_post( $post_args );
	
	if ($no_changes == 1) {
	
	include (STYLESHEETPATH . '/_/inc/meeting-rooms/notifications/edit-meeting-email.php');
	
	}


//echo '<pre>';print_r($changes);echo '</pre>';
?>


<a name="meeting-updated" id="meeting-updated"></a>
<?php if ($no_changes == 1) { ?>
<div class="alert alert-success">
	
	<h4><i class="fa fa-check-circle"></i> Success</h4>

	<p>The meeting has been updated and <strong>Office Administration</strong> has been notified.<br>
	You will receive an email when your request has been approved.</p><br>
	
	<p><strong class="caps">Meeting details:</strong></p>
	<p>
		<span class="bold">Description:</span> <?php echo $description; ?><br>
		<span class="bold">Room:</span> <?php echo $changes['meeting_room']; ?><br>
		<span class="bold">Date:</span>  <?php echo $changes['meeting_date']; ?><br>
		<span class="bold">Time:</span>  <?php echo $changes['start_time']; ?> - <?php echo $changes['end_time']; ?>
	</p><br>
	
	<div class="action-btns">
		<a href="<?php echo $page_url[0]; ?>" class="btn btn-success btn-block">Continue</a>
	</div>

</div>

<?php } else { ?>
<div class="alert alert-warning text-center">
	
	<h4><i class="fa fa-warning"></i> Warning</h4>

	You did not make any changes to <strong>'<?php echo $description; ?>'</strong> meeting.<br><br>
	
	<div class="action-btns">
		<a href="<?php echo $page_url[0]; ?>" class="btn btn-danger btn-block">Continue</a>
	</div>
	
</div>
<?php } ?>

<div class="rule"></div>

<?php }  ?>
