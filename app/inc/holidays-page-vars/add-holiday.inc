<?php 
if (isset($_POST['add-holiday'])) {
global $add_holiday_errors;
global $current_user;
global $user_holidays_raw;
global $user_holidays;
global $timeZone;
//debug($_POST);	
$booked_date = new DateTime($_POST['date-booked'], new DateTimeZone($timeZone));
$date_from = new DateTime($_POST['date-from'], new DateTimeZone($timeZone));
$date_to = new DateTime($_POST['date-to'], new DateTimeZone($timeZone));
$date_from_length = $_POST['date-from-length'];
$date_to_length = $_POST['date-to-length'];
$days_remaining = $_POST['days-remaining'];

$total_no_days = 1;

if ($date_from > $date_to) {
$add_holiday_errors[] = array('date-error-from' => 'The from date is after the to date.');	
}

if ($date_to->format('Ymd') > $date_from->format('Ymd')) {
	$interval = $date_from->diff($date_to);
	$days = $interval->days;
	$period = new DatePeriod($date_from, new DateInterval('P1D'), $date_to);
	foreach($period as $dt) {
	    $curr = $dt->format('w');
	
	    // substract if Saturday or Sunday
	    if ($curr != 6 && $curr != 0) {
	        $total_no_days++;
	    }
	}	
}

if ($date_from_length == 'half' && $date_to > $date_from) {
$total_no_days = $total_no_days - 0.5;	
}

if ($date_to_length == 'half' && $date_to > $date_from) {
$total_no_days = $total_no_days - 0.5;	
}

if ($date_to_length == 'half' && $date_from_length == 'half' && $date_from == $date_to) {
$total_no_days = $total_no_days - 0.5;	
}

if (empty($add_holiday_errors)) {

	$holiday_details = array(
	'date-booked' => $booked_date->format('Ymd'), 
	'date-from' => $date_from->format('Ymd'), 
	'date-from-length' => $date_from_length, 
	'date-to' => $date_to->format('Ymd'),
	'date-to-length' => $date_to_length,
	'no-days' => $total_no_days,
	'approval'	=> 'pending'
	);
	
	//debug($holiday_details);
	
	if (isset($_POST['approval'])) {
		
	} else {
	$holiday_details['approval'] = "yes";
	$user_holidays[] = $holiday_details;
	$holidays_added = update_user_meta($current_user->ID, 'holidays_'.date('Y'), serialize($user_holidays), $user_holidays_raw); 
	$user_holidays_raw = get_user_meta($current_user->ID, 'holidays_'.date('Y'), true);
	$user_holidays = unserialize($user_holidays_raw);
	
	wp_redirect( "?holiday-added=1" );
	exit;
	}
			
}

} 

?>