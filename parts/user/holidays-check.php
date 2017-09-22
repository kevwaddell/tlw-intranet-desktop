<?php 
/* 
Check to see how many holidays 
a user has for current year 
*/

$holidays_check_args = array(
'post_type' => 'tlw_holiday',
'posts_per_page' => -1,
'post_status'	=> 'publish',
'author'	=> $curauth->ID,
'meta_query'	=> array(
		
		'relation' => 'AND',
		array(
			'key' => 'holiday_start_date',
			'value' => $start_of_year,
			'compare' => '>'
		),
		array(
			'key' => 'holiday_end_date',
			'value' => $end_of_year,
			'compare' => '<'
		)
	)
);

$holidays_check = get_posts($holidays_check_args);
$holidays_used = 0;
$holidays_booked = 0;

/* 
Loop through holidays and check
the amount of days used
*/
if (count($holidays_check) > 0) {

	foreach ($holidays_check as $holiday) {
	$start = get_field('holiday_start_date', $holiday->ID);
	$start_ts = strtotime($start);
	$end = get_field('holiday_end_date', $holiday->ID);
	$end_ts = strtotime($end);
	$numdays = get_field('number_of_days', $holiday->ID);
		
		if ($end_ts < $today) {
		$holidays_used += $numdays;	
		}
		
		if ($start_ts > $today) {
		$holidays_booked += $numdays;	
		}
		
	}
	
	
}
$holidays_check = get_posts($holidays_check_args);

/* 
Add the total of used and booked days together
-----
Add the total user holidays, extra days and
carried over days together
*/
$total_holidays_added = ($holidays_used + $holidays_booked);
$total_holidays = ($user_total_holidays + $extra_days) + $user_crossover_holidays;

/* 
Check to see if total holidays is greater
that database user holidays.
If not update total holidays in database
*/
if ($total_holidays > $user_total_holidays) {
update_user_meta( $curauth->ID, 'total_holidays', $total_holidays, $user_total_holidays);
$user_total_holidays = get_the_author_meta( "total_holidays", $curauth->ID );		
}

/* 
Check to see if total holidays added is not equal to 
number of holidays in the database.

If not update number of holidays in the database
*/
if ($total_holidays_added != $total_holidays) {
update_user_meta( $curauth->ID, 'number_of_holidays', ($total_holidays - $total_holidays_added), $user_holidays);	
$user_holidays = get_the_author_meta( "number_of_holidays", $curauth->ID );
}


$holidays_left = ($user_total_holidays - $total_holidays_added);

//echo '<pre>';print_r($holidays_left);echo '</pre>';

/* NEXT YEARS HOLIDAYS */
$xty_holidays_check_args = array(
'post_type' => 'tlw_holiday',
'posts_per_page' => -1,
'post_status'	=> 'publish',
'author'	=> $curauth->ID,
'meta_query'	=> array(
		
		'relation' => 'AND',
		array(
			'key' => 'holiday_start_date',
			'value' => $end_of_year,
			'compare' => '>'
		),
		array(
			'key' => 'holiday_end_date',
			'value' => $end_of_nxt_year,
			'compare' => '<'
		)
	)
);

$xty_holidays_check = get_posts($xty_holidays_check_args);
$xty_holidays_booked = 0;

if (count($xty_holidays_check) > 0) {

	foreach ($xty_holidays_check as $xt_holiday) {
	$start = get_field('holiday_start_date', $xt_holiday->ID);
	$end = get_field('holiday_end_date', $xt_holiday->ID);
	$numdays = get_field('number_of_days', $xt_holiday->ID);
		
	$xty_holidays_booked += $numdays;	
	
	}
}

/*
echo '<pre>';
print_r($xty_holidays_booked);
echo '</pre>';
*/
 ?>