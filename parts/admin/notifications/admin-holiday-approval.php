<?php if (isset($_GET['holiday_approval'])) { 
$holiday = get_post($_GET['holidayid']);
$holiday_args = array(
'ID' => $holiday->ID
);
?>

<?php if ($_GET['holiday_approval'] == "yes") { 
$holiday_args['post_status'] = 'publish';
$numdays = $_GET['num_days'];
$user_holidays = get_the_author_meta( "number_of_holidays", $holiday->post_author );
update_user_meta( $holiday->post_author, 'number_of_holidays', ($user_holidays - $numdays));	
//include (STYLESHEETPATH . '/_/inc/admin/notifications/admin-holiday-approval-email.php');
?>
	
<div class="alert alert-success text-center" style="margin-bottom: 10px;">
	<h4>Holiday request has been approved.</h4>
	<strong><?php echo $booked_by->data->display_name; ?></strong> has been notified.
	<br><br>

	<div class="action-btns">

		<a href="<?php the_permalink();?>" class="btn btn-success btn-block">Continue</a>
				
	</div>

</div>

<?php } ?>

<?php if ($_GET['holiday_approval'] == "no") { 
$holiday_args['post_status'] = 'draft';	
//include (STYLESHEETPATH . '/_/inc/admin/notifications/admin-holiday-reject-email.php');
?>

<div class="alert alert-danger text-center" style="margin-bottom: 10px;">

	<h4>Holiday request has been rejected.</h4>
	<strong><?php echo $booked_by->data->display_name; ?></strong> has been notified.
	<br><br>

	<div class="action-btns">

		<a href="<?php the_permalink();?>" class="btn btn-danger btn-block">Continue</a>
				
	</div>

</div>

<?php } ?>

<?php 

wp_update_post( $holiday_args );	

} ?>