<?php
$start_datediff = $now_date->diff($user_s_date);
/*
echo '<pre>';
print_r($start_datediff);
echo '<br>';
echo '<br>';
*/

if ($start_datediff->y == 1 && $start_datediff->invert == 1) {
$extra_year	= 1;
} else {
$extra_year	= $start_datediff->y;
$extra_days = $start_datediff->y;
}

$first_change_date = new DateTime($user_s_date->format('jS F Y')." 1 year");
$change_date = new DateTime($first_change_date->format('jS F Y')." +". ($extra_year) ." year");

if ($user_s_date->format('n') != 1) {
$first_change_date = $first_change_date->modify("00:00 01/01". $first_change_date->format('Y') . " +1 year");	
$change_date = $change_date->modify("00:00 01/01". $first_change_date->format('Y') ."+". ($extra_year) ." year");	
}

$change_datediff = $user_s_date->diff($change_date);
$datediff = $now_date->diff($change_date);

if ($datediff->invert == 1) {
		
	if ( $extra_days != $change_datediff->y && ($user_allocated_holidays + $extra_days) < 28 ) {
	$update_extra = update_user_meta( $curauth->ID, 'extra_holidays', $change_datediff->y, $extra_days);
	$extra_days = get_the_author_meta('extra_holidays', $curauth->ID);
	$extra_year = $extra_days;
	}
		
	$change_date = $change_date->modify("00:00 01/01". $user_s_date->format('Y') ."+". ($extra_year) ." year");
	
	if ($user_s_date->format('n') != 1) {
	$change_date = $change_date->modify("00:00 01/01". $user_s_date->format('Y') ."+". ($extra_year+1) ." year");
	}
		
}

if (($user_allocated_holidays + $extra_days) > 28) {
$change_extra_days = ($user_allocated_holidays + $extra_days) - $user_allocated_holidays;
$update_extra = update_user_meta( $curauth->ID, 'extra_holidays', $change_extra_days, $extra_days);
$extra_days = get_the_author_meta('extra_holidays', $curauth->ID);	
}
 ?>