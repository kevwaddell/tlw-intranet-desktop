<?php if ( isset($_GET['admin_request']) || isset($_GET['holiday_approval']) ) { 
$holiday = get_post($_GET['holidayid']);
$booked_by = get_user_by('id', $holiday->post_author);
$start_date = strtotime(get_field('holiday_start_date', $holiday->ID));
$end_date = strtotime(get_field('holiday_end_date', $holiday->ID));
$number_of_days = get_field('number_of_days', $holiday->ID);
?>

<div class="admin-requests">

<?php if (is_user_logged_in()) { ?>
	
	<?php include (STYLESHEETPATH . '/_/inc/admin/notifications/admin-holiday-request.php'); ?>
	
	<?php include (STYLESHEETPATH . '/_/inc/admin/notifications/admin-holiday-approval.php'); ?>
	
<?php } else { ?>
	
	<div class="alert alert-danger text-center">
		<strong>Please login to approve holiday requests <a href="#log-in-alert" data-toggle="modal" class="btn btn-default btn-danger"><i class="fa fa-lock"></i> Login</a></strong>
	</div>	
	
<?php } ?>

</div>

<?php } ?>