<?php if ( isset($_POST['add_meeting']) ) { 

$current_user = get_user_by('id', $_POST['userid']);
//echo '<pre>';print_r($_POST);echo '</pre>';

/* POST VARS */
$user_id = $_POST['userid'];
$description = trim($_POST['description']);
$meeting_room = $_POST['meeting_room'];
$meeting_date_raw = trim($_POST['meeting_date']);
$meeting_date_convert = strtotime($meeting_date_raw);
$meeting_date = date('Ymd', $meeting_date_convert);
$start_hrs = $_POST['start_hrs'];
$start_mins = $_POST['start_mins'];
$meeting_start = $start_hrs.":".$start_mins;
$start_time = strtotime( date('D jS F Y', $meeting_date_convert).' '.$meeting_start);
$end_hrs = $_POST['end_hrs'];
$end_mins = $_POST['end_mins'];
$meeting_end = $end_hrs.":".$end_mins;
$end_time = strtotime(date('D jS F Y', $meeting_date_convert).' '.$meeting_end); 

$errors = array();

if ( $description == "") {
$errors[] = "Please enter a meeting description.";
} 

if ( $meeting_room == 0) {
$errors[] = "Please choose a meeting room.";
} else {
$room = get_term_by('id', $meeting_room, 'tlw_rooms_tax');	
}

if ( $start_hrs == $end_hrs || $start_hrs > $end_hrs) {
$errors[] = "Please choose an end time.";
} 

if ( $meeting_date_raw == "") {
$errors[] = "Please choose a meeting date.";
} 

//echo '<pre>';print_r($errors);echo '</pre>';

if (count($errors) == 0) {
	
	$post_args = array(
	'post_name' => sanitize_title($description.' '.$meeting_date),
	'post_title' => wp_strip_all_tags($description),
	'post_status'   => 'pending',
	'post_author'   => $user_id,
	'post_type'     => 'tlw_meeting'
	);
	
	//echo '<pre>';print_r($post_args);echo '</pre>';
	
	$m_id = wp_insert_post($post_args);
	
	/* SET ROOM TAX */
	wp_set_post_terms( $m_id, array($meeting_room), 'tlw_rooms_tax');
	
	update_post_meta($m_id, '_meeting_description', 'field_5395d707861af'); 
	update_post_meta($m_id, 'meeting_description', $description); 
	update_post_meta($m_id, '_meeting_date', 'field_533be32c54fbc');  
	update_post_meta($m_id, 'meeting_date', $meeting_date);  
	update_post_meta($m_id, '_start_time', 'field_533be5353ffec');  
	update_post_meta($m_id, 'start_time', $start_time);  
	update_post_meta($m_id, '_end_time', 'field_533be5d13ffed'); 
	update_post_meta($m_id, 'end_time', $end_time); 
	
}

?>

<?php if (count($errors) == 0) { ?>

<div class="alert alert-success text-center">
	
	<h4><i class="fa fa-check-circle"></i> Confirm</h4>
	
	Please confirm your meeting details below.<br><br>
	
	<strong class="caps">Meeting details:</strong><br>
	<p>
		<span class="bold">Description:</span> <?php echo stripslashes($description); ?><br>
		<span class="bold">Room:</span> <?php echo $room->name; ?><br>
		<span class="bold">Date:</span>  <?php echo date('D jS F Y', $meeting_date_convert); ?><br>
		<span class="bold">Time:</span>  <?php echo $meeting_start; ?> - <?php echo $meeting_end; ?>
	</p>
	<br>
	
	<div class="action-btns">
		<div class="row">
		<div class="col-xs-6">
			<a href="?action=add_meeting&meetingid=<?php echo $m_id; ?>" class="btn btn-success btn-block btn-action"><i class="fa fa-check fa-lg"></i>Confirm</a>
		</div>
		<div class="col-xs-6">
			<a href="?action=cancel_add_meeting&meetingid=<?php echo $m_id; ?>" class="btn btn-danger btn-block btn-action"><i class="fa fa-times fa-lg"></i>Cancel</a>
		</div>
	</div>
	
</div>

<?php } else { ?>

<div class="alert alert-info">
	
	<h4><i class="fa fa-warning"></i> Booking request</h4>
	
	<div class="well well-sm errors">
	    <p>Errors!</p>
		<ul>
		<?php foreach ($errors as $error) { ?>
		<li><?php echo $error; ?></li>
		<?php } ?>
		</ul>
	</div>

	<?php include (STYLESHEETPATH . '/_/inc/meeting-rooms/notifications/add-form.php'); ?>
	
</div>
<?php } ?>



<?php }  ?>