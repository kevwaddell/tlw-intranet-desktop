<?php //echo '<pre>';print_r($_POST);echo '</pre>'; ?>

<?php if ( isset($_POST['add_holiday']) ) { 
	
	/* VARS */
	$user_id = $_POST['userid'];
	$current_user = get_user_by('id', $user_id);
	$numdays = 0;
	$totaldays = 0;
	$day_amount = $_POST['day_amount'];
	$hol_start_date_raw = trim($_POST['holiday_start_date']);
	$start_year = date("Y", strtotime($hol_start_date_raw));
	$bank_hols = calculateBankHolidays(date("Y"));
	//echo '<pre>';print_r( $s_date );echo '</pre>';
	//$addDay = 86400;
	//echo '<pre>';print_r($_POST);echo '</pre>';
	
	/* ERRORS CHECK */
	if ( $hol_start_date_raw == "") {
	$errors[] = "Please select a start date.";
	} else {
	$s_date = new DateTime($hol_start_date_raw);	
	}
	
	$get_start_holidays_args = array(
	'post_type' => 'tlw_holiday',
	'author'	=> $user_id,
	'meta_key'	=> 'holiday_start_date',
	'meta_value' => $s_date->getTimestamp(),
	);
	
	$get_start_holidays = get_posts($get_start_holidays_args);
	
	if (!empty($get_start_holidays)) {
	$errors[] = "You already have this start day booked.";	
	}
	
	if ($day_amount == 'single') {
		$e_date = new DateTime($hol_start_date_raw);
		
		$numdays = 1;
	
		if (isset($_POST['start_half_day'])) {
		$day_time = $_POST['day_time'];
			
			if ($day_time == 'am') {
			$s_date->modify('9:00am');	
			$e_date->modify('1:30pm');	
			}
			
			if ($day_time == 'pm') {
			$s_date->modify('12:30pm');		
			$e_date->modify('5:00pm');	
			}
			
			$numdays = 0.5;
		}
		
	
	}
	
	if ($day_amount == 'multiple') {
	
		$hol_end_date_raw = trim($_POST['holiday_end_date']);
		
		if ( $hol_end_date_raw == "") {
		$errors[] = "Please select an end date.";
		} else {
		$e_date = new DateTime($hol_end_date_raw);	
		}
		
		$get_end_holidays_args = array(
		'post_type' => 'tlw_holiday',
		'author'	=> $user_id,
		'meta_key'	=> 'holiday_end_date',
		'meta_value' => $e_date->getTimestamp(),
		);
		
		$get_end_holidays = get_posts($get_end_holidays_args);
		
		if (!empty($get_end_holidays)) {
		$errors[] = "You already have this last day booked.";	
		}
		
		
		if (count($errors) == 0) {
		$s_ts = $s_date->getTimestamp();
		$datediff = $e_date->diff($s_date);
		$addDay = 86400;
	
		/* Count number of days */
		for ($i = 0; $i <= $datediff->days; $i++) {
			$numdays++;
			$totaldays++;
		}
		
		/* Check if it a day is a weekend */
		for($d = 0; $d < $totaldays; $d++){

		    // get what day it is next day
		    $day = date('w', $s_ts);
		    $dayDate = date('Y-m-d', $s_ts);
		
		    // if it's Saturday or Sunday get $i-1
		    if($day == 0 || $day == 6) {
		        $numdays--;
		    }
		    
		    if(in_array($dayDate, $bank_hols)) {
		        $numdays--;
		    }
		    
			$s_ts = $s_ts+$addDay;
	     
		}
		
		if (isset($_POST['start_half_day'])) {
			
			$s_date->modify('1:30pm');	
						
			$numdays -= 0.5;	
		}
		
		if (isset($_POST['end_half_day'])) {
			
			$e_date->modify('1:30pm');	
			
			$numdays -= 0.5;	
		}
		
		}
	
	}
	
	/* IF NO ERRORS ADD POST */
	if ( count($errors) == 0 ) {
	
		$post_title = $current_user->data->display_name;
		
		$post_args = array(
		'post_name' => sanitize_title($post_title. ' ' .$s_date->getTimestamp(). ' '.$e_date->getTimestamp()),
		'post_title' => $post_title,
		'post_status'   => 'pending',
		'post_author'   => $user_id,
		'post_type'     => 'tlw_holiday'
		);
		
		if ( $e_date->format( 'Ymd' ) < date('Ymd') ) {
		$user_holidays = get_the_author_meta( "number_of_holidays", $user_id );
		$post_args['post_status'] = 'publish';
		update_user_meta( $user_id, 'number_of_holidays', ($user_holidays - $numdays));	
		}
		
		//echo '<pre>';print_r($post_args);echo '</pre>';
		
		$h_id = wp_insert_post($post_args);
		
		
		
		/* SET META */
		update_post_meta($h_id, '_holiday_start_date', 'field_53c67357805e5'); 
		update_post_meta($h_id, 'holiday_start_date', $s_date->getTimestamp()); 
		update_post_meta($h_id, '_holiday_end_date', 'field_53c673b0805e6');  
		update_post_meta($h_id, 'holiday_end_date', $e_date->getTimestamp());  
		update_post_meta($h_id, '_number_of_days', 'field_53c673d9805e7');  
		update_post_meta($h_id, 'number_of_days', $numdays);  
	
	}
?>

<?php if (count($errors) == 0) { 
//echo '<pre>';print_r($cur_url);echo '</pre>';
?>

<div class="alert alert-success text-center">

	<h4>Holiday Request</h4>
	
	<strong>Please confirm your holiday details below</strong><br><br>
	<p>
		<span class="bold">Date:</span> 
		<?php echo $s_date->format( 'D jS F Y' ) ?>
		
		<?php if (isset($_POST['start_half_day'])) { ?>
		<?php echo ' at '.$s_date->format( 'g:ia' ); ?>
		<?php } ?>
		
		<?php if (isset($_POST['start_half_day']) && $_POST['day_amount'] == 'single') { ?>
		<?php echo ' - '.$e_date->format( 'g:ia' ); ?>
		<?php } ?>
		<br>
		<?php if ($day_amount == 'multiple') { ?>
		<span class="bold">Last day:</span> <?php echo $e_date->format( 'D jS F Y' ); ?><?php echo (isset($_POST['end_half_day'])) ? ' at '.$e_date->format( 'g:ia' ):'' ?><br>
		<?php } ?>
		
		<span class="bold">Number of days:</span>  <?php echo $numdays; ?><br>
	</p>
	<br>
	
	<div class="action-btns">
		<div class="row">
		<div class="col-xs-6">
			<a href="?action=confirm_holiday&holidayid=<?php echo $h_id; ?>" class="btn btn-success btn-block btn-action"><i class="fa fa-check fa-lg"></i>Confirm</a>
		</div>
		<div class="col-xs-6">
			<a href="?request=cancel_holiday&num_days=<?php echo $numdays; ?>&holidayid=<?php echo $h_id; ?>" class="btn btn-danger btn-block btn-action"><i class="fa fa-times fa-lg"></i>Cancel</a>
		</div>
	</div>
	
</div>

<?php } else { ?>

<div class="alert alert-info">
	
	<h4>Holiday request</h4>
	
	<div class="well well-sm errors">
	    <p>Errors!</p>
	   	<ul>
		<?php foreach ($errors as $error) { ?>
		<li><?php echo $error; ?></li>
		<?php } ?>
		</ul>
	</div>

	<?php include (STYLESHEETPATH . '/_/inc/holiday-request/notifications/add-form.php'); ?>
	
</div>

<?php } ?>
 
<?php }  ?>