<?php if ( isset($_GET['holidayid']) && $_GET['action'] == "confirm_holiday") {
	
	$cur_url = explode("?", $_SERVER['REQUEST_URI']);
	$holiday_id = $_GET['holidayid'];
	$holiday = get_post($holiday_id);
	$start_date = strtotime( get_field('holiday_start_date', $holiday_id));
	$end_date = strtotime(get_field('holiday_end_date', $holiday_id));
	$numdays = get_field('number_of_days', $holiday_id);
	$booked_by = get_user_by('id', $holiday->post_author);
	
	//echo '<pre>';print_r(date("Ymd"));echo '</pre>';
	
	/* SET POST META */
	if ( $end_date > strtotime("now") && !in_array_r($current_user->ID, $partners) && $current_user->ID != $hb_admin['ID']) {
	//include (STYLESHEETPATH . '/_/inc/holiday-request/notifications/add-holiday-email.php');
	}

?>

<div class="alert alert-success text-center">

	<h4>Holiday Request</h4>

	<?php if ( $end_date > strtotime("now") && !in_array_r($current_user->ID, $partners) && $current_user->ID != $hb_admin['ID']) { ?>
	Your holiday request has been sent to<br><strong>Office Administration</strong> for approval.<br>
	You will receive an email when your request has been approved.<br><br>
	<?php } else { ?>
	Your holiday booking has been added successfully.<br><br>
	<?php } ?>
	
	<strong class="caps">Holiday details:</strong><br>
	<p>
		<span class="bold">Date:</span> 
		<?php echo date( 'D jS F Y', $start_date ); ?>
		<?php if (date("H", $start_date) != "00") { ?>
		<?php echo ' at '. date( 'g:ia',  $start_date); ?>
		<?php } ?>
		<?php if (date("Ymd", $start_date) == date("Ymd", $end_date) && date("H", $end_date) != "00") { ?>
		<?php echo ' - '.date( 'g:ia',  $end_date); ?>
		<?php } ?>
		<br>
	
		<?php if (date("Ymd", $end_date) > date("Ymd", $start_date)) { ?>
		<span class="bold">Last day:</span> 
		<?php echo date( 'D jS F Y', $end_date ); ?>
		
		<?php if (date("H", $end_date) != "00") { ?>
		<?php echo ' at '. date( 'g:ia',  $end_date); ?>
		<?php } ?>
		
		<br>
		<?php } ?>
		<span class="bold">Number of days:</span>  <?php echo $numdays; ?><br>
	</p>
	<br>
	
	<div class="action-btns">

		<a href="<?php echo get_option('home'); ?><?php echo $cur_url[0]; ?>" class="btn btn-success btn-block"><i class="fa fa-check fa-lg"></i>Continue</a>
		
	</div>
	
</div>

<?php }  ?>