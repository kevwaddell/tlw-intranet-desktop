<?php if (isset($_GET['meetingid']) && $_GET['request'] == "edit_meeting") { 
$meeting = get_post($_GET['meetingid']);
$description = get_field('meeting_description', $meeting->ID);
$rooms_args = array('hide_empty' => false);
$rooms = get_terms('tlw_rooms_tax', $rooms_args);
$current_room = wp_get_post_terms( $meeting->ID, 'tlw_rooms_tax');
$date_raw = get_field('meeting_date', $meeting->ID);
$date_convert = strtotime($date_raw);
$start_raw = get_field('start_time', $meeting->ID);
$start_split = explode(":", date('H:i', $start_raw));
$end_raw = get_field('end_time', $meeting->ID);
$end_split = explode(":", date('H:i', $end_raw));
//echo '<pre>';print_r($end_split);echo '</pre>';
?>

<div class="alert alert-info">
	
<h4><i class="fa fa-pencil-square"></i> Edit Booking</h4>

<?php include (STYLESHEETPATH . '/_/inc/meeting-rooms/notifications/edit-form.php'); ?>

</div>

<div class="rule"></div>

<?php }  ?>
