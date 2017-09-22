<?php if (isset($_GET['userid']) && $_GET['request'] == "room_booking") { 
$user_id = get_user_by('id', $_GET['userid']);
$todays_date_raw = strtotime("now");
//echo '<pre>';print_r($todays_date_raw);echo '</pre>';
?>
<div class="alert alert-info">

<h4><i class="fa fa-clock-o"></i> Booking request</h4>

<?php include (STYLESHEETPATH . '/_/inc/meeting-rooms/notifications/add-form.php'); ?>

</div>

<?php }  ?>
