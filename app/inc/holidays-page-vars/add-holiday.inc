<?php 
if (isset($_POST['add-holiday'])) {
global $add_holiday_errors;
global $current_user;
global $user_holidays_raw;
global $user_holidays;
debug($_POST);	
$booked_date = date('Ymd', strtotime($_POST['date-booked']));
$date_from = date('Ymd', strtotime($_POST['date-from']));
$date_to = date('Ymd', strtotime($_POST['date-to']));
$date_from_length = $_POST['date-from-length'];
$date_to_length = $_POST['date-to-length'];
$days_remaining = $_POST['days-remaining'];

$total_no_days = 1;

if ($date_from > $date_to) {
$add_holiday_errors[] = array('date-error-from' => 'The from date is after the to date.');	
}

if ($date_to > $date_from) {
$total_no_days = ($date_to - $date_from) + $total_no_days;	
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
	'date-booked' => $booked_date, 
	'date-from' => $date_from, 
	'date-from-length' => $date_from_length, 
	'date-to' => $date_to,
	'date-to-length' => $date_to_length,
	'no-days' => $total_no_days,
	'approval'	=> 'pending'
	);
	
	if (isset($_POST['approval'])) {
		
	} else {
	$holiday_details['approval'] = "yes";
	$user_holidays[] = $holiday_details;
	$holidays_added = update_user_meta($current_user->ID, 'holidays_'.date('Y'), serialize($user_holidays), $user_holidays_raw); 
	$user_holidays_raw = get_user_meta($current_user->ID, 'holidays_'.date('Y'), true);
	$user_holidays = unserialize($user_holidays_raw);
	
	debug($user_holidays);
	}
			
}

} 

?>