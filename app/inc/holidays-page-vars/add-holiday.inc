<?php 
if (isset($_POST['add-holiday']) || isset($_POST['update-holiday'])) {
	global $add_holiday_errors;
	global $current_user;
	global $user_holidays_raw;
	global $user_holidays;
	global $timeZone;
	global $current_year;
	
	//debug($_POST);	
	$booked_date = new DateTime($_POST['date-booked'], new DateTimeZone($timeZone));
	$date_from = new DateTime($_POST['date-from'], new DateTimeZone($timeZone));
	$date_to = new DateTime($_POST['date-to'], new DateTimeZone($timeZone));
	$date_from_length = $_POST['date-from-length'];
	$date_to_length = $_POST['date-to-length'];
	$days_remaining = $_POST['days-remaining'];
	$holiday_id =  $_POST['holiday-id'];
	
	$total_no_days = 1;
	
	if ($date_from > $date_to) {
	$add_holiday_errors['date-error-from'] = '<h4 class="caps">Dates mismatch!</h4><p>The <b>Last day</b> date is before the <b>First day</b> date.</p>';	
	}
	
	if ($date_to->format('Ymd') > $date_from->format('Ymd') && empty($add_holiday_errors)) {
		$interval = $date_from->diff($date_to);
		$days = $interval->days;
		$period = new DatePeriod($date_from, new DateInterval('P1D'), $date_to);
		foreach($period as $dt) {
		    $curr = $dt->format('w');
		    $y = $dt->format('Y');
		    
		    if ($y > $current_year && !array_key_exists('date-next-year', $add_holiday_errors) ) {
			$add_holiday_errors['date-next-year'] = '<h4 class="caps">The <b>last day</b> is next year.</h4><p>Please add this to next years holidays.</p>';	  
		    }
		
		    // substract if Saturday or Sunday
		    if ($curr != 6 && $curr != 0) {
		        $total_no_days++;
		    }
		}	
	}
	
	if (($date_from_length == 'am' || $date_from_length == 'pm') && $date_to > $date_from) {
	$total_no_days = $total_no_days - 0.5;	
	}
	
	if (($date_to_length == 'am' || $date_to_length == 'pm') && $date_to > $date_from) {
	$total_no_days = $total_no_days - 0.5;	
	}
	
	if (($date_to_length == 'am' && $date_from_length == 'am') || ($date_to_length == 'pm' && $date_from_length == 'pm') && $date_from == $date_to) {
	$total_no_days = $total_no_days - 0.5;	
	}
	
	if (empty($add_holiday_errors)) {
	
		$holiday_details = array(
		'holiday-id' => $holiday_id,
		'date-booked' => $booked_date->format('Ymd'), 
		'date-from' => $date_from->format('Ymd'), 
		'date-from-length' => $date_from_length, 
		'date-to' => $date_to->format('Ymd'),
		'date-to-length' => $date_to_length,
		'no-days' => $total_no_days
		);
		
		//debug($holiday_details);
		
		if (isset($_POST['update-holiday'])) {
			
			foreach ($user_holidays as $k => $uh) {
				if ($uh['holiday-id'] == $holiday_id) {
				$user_holidays[$k] = $holiday_details;
				}
			}
			
			$holidays_updated = update_user_meta($current_user->ID, 'holidays_'.$current_year, serialize($user_holidays), $user_holidays_raw); 
			$user_holidays_raw = get_user_meta($current_user->ID, 'holidays_'.$current_year, true);
			$user_holidays = unserialize($user_holidays_raw);
			
			wp_redirect( "?holiday-updated=1" );
			exit;
			
		}
		
		if (isset($_POST['add-holiday'])) {
			if ($_POST['approved'] == 'no') {
			$holiday_details['approved'] = "pending";
			$holidays_added = update_user_meta($current_user->ID, 'holidays_'.$current_year, serialize($user_holidays), $user_holidays_raw); 
			$user_holidays_raw = get_user_meta($current_user->ID, 'holidays_'.$current_year, true);
				
			} else {
			$holiday_details['approved'] = "yes";
			$user_holidays[] = $holiday_details;
			$holidays_added = update_user_meta($current_user->ID, 'holidays_'.$current_year, serialize($user_holidays), $user_holidays_raw); 
			$user_holidays_raw = get_user_meta($current_user->ID, 'holidays_'.$current_year, true);
			$user_holidays = unserialize($user_holidays_raw);
			
			wp_redirect( "?holiday-added=1" );
			exit;
		
			}
		}
				
	}

} 
?>