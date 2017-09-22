<?php
if (empty($user_crossover_holidays)) {
update_user_meta( $curauth->ID, 'crossover_holidays', '0');
$user_crossover_holidays = get_the_author_meta( "crossover_holidays", $curauth->ID );
}

if (empty($user_allocated_holidays)) {
update_user_meta( $curauth->ID, 'allocated_holidays', '20');
$user_allocated_holidays = get_the_author_meta( "allocated_holidays", $curauth->ID );
}

if (empty($user_total_holidays)) {
update_user_meta( $curauth->ID, 'total_holidays', $user_allocated_holidays);
$user_total_holidays = get_the_author_meta( "total_holidays", $curauth->ID );
}

if ($user_s_date->format('Y') == $now_date->format('Y') && $user_holidays == $user_allocated_holidays) {
$start_d = $user_s_date->format('j');
$start_m = $user_s_date->format('n');
if ($start_d < 4) {
$start_m = $start_m - 1;	
}
$val = ($user_allocated_holidays/12) * (12-$start_m);
update_user_meta( $curauth->ID, 'number_of_holidays', floorToFraction($val, 2));	
update_user_meta( $curauth->ID, 'total_holidays', floorToFraction($val, 2));
$user_holidays = get_the_author_meta( "number_of_holidays", $curauth->ID );
$user_total_holidays = get_the_author_meta( "total_holidays", $curauth->ID );
}


if ( $now_date->format('n') == 1 && $now_date->format('j') == 1) {

	if ( $now_date->format('Y') == ($user_s_date->format('Y') + 1) ) {
	update_user_meta( $curauth->ID, 'total_holidays', $user_allocated_holidays);
	$user_total_holidays = get_the_author_meta( "total_holidays", $curauth->ID );
	}

	if ($user_crossover_holidays > 0) {
	update_user_meta( $curauth->ID, 'crossover_holidays', 0);	
	}

	if ($user_holidays == 0) {
	update_user_meta( $curauth->ID, 'number_of_holidays', $user_allocated_holidays);	
	} else {
	update_user_meta( $curauth->ID, 'number_of_holidays', $user_allocated_holidays);	
		
		if ($user_holidays > 3) {
		update_user_meta( $curauth->ID, 'crossover_holidays', 3);		
		} else {
		update_user_meta( $curauth->ID, 'crossover_holidays', $user_holidays);	
		}
		
	}	
	
	$user_holidays = get_the_author_meta( "number_of_holidays", $curauth->ID );
	$user_crossover_holidays = get_the_author_meta( "crossover_holidays", $curauth->ID );
}

if (empty($extra_days)) {
update_user_meta( $curauth->ID, 'extra_holidays', '0');	
$extra_days = get_the_author_meta('extra_holidays', $curauth->ID);
}
 ?>