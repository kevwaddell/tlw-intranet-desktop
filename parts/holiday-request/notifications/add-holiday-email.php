<?php 
$default_tz = date_default_timezone_get();
date_default_timezone_set('Europe/London'); 
$now = strtotime("now");
$holiday_request_pg = get_page_by_title("Holiday Requests");

//echo '<pre>';print_r($holiday);echo '</pre>';

$holiday_start_date_convert = strtotime(get_field('holiday_start_date', $holiday->ID));
$holiday_end_date_convert = strtotime(get_field('holiday_end_date', $holiday->ID));
$number_of_days = get_field('number_of_days', $holiday->ID);

$from_name = $booked_by->data->display_name;
$from_email = $booked_by->data->user_email;

$subject = 'Holiday booking request from '.$from_name;
$message = '<h3><font style="color: red;">'.$from_name.'</font> has requested a holiday to be approved.</h3>';
$message .= '<br>';
$message .= '<table width="100%" border="0" cellspacing="2" cellpadding="10"><tbody><thead>';
$message .= '<tr><th colspan="2" style="background-color: #999;">HOLIDAY DETAILS</th></tr></thead>';
$message .= '<tbody><tr><td style="background-color: #CCC;">Date:</td><td style="background-color: #EEE;"><strong>';
$message .=  date('D jS F Y', $holiday_start_date_convert);
if (date("H", $holiday_start_date_convert) != "00") { 
$message .= ' at '. date( 'g:ia',  $holiday_start_date_convert);
}
if (date("Ymd", $holiday_start_date_convert) == date("Ymd", $holiday_end_date_convert) && date("H", $holiday_end_date_convert) != "00") {
$message .= ' - '.date( 'g:ia',  $holiday_end_date_convert);
}
$message .= '</strong></td></tr>';
if ( date( "Ymd", $holiday_end_date_convert) > date( "Ymd",  $holiday_start_date_convert) ) {
$message .= '<tr><td style="background-color: #CCC;">Last day:</td><td style="background-color: #EEE;"><strong>';
$message .= date('D jS F Y', $holiday_end_date_convert);
if (date("H", $holiday_end_date_convert) != "00") {
$message .=' at '. date( 'g:ia',  $holiday_end_date_convert);
}
$message .= '</strong></td></tr>';
}
$message .= '<tr><td style="background-color: #CCC;">Number of days:</td><td style="background-color: #EEE;"><strong>'. $number_of_days . '</strong></td></tr></tbody>';
$message .= '<tfoot><tr><td style="background-color: #CCC;">Requested on:</td><td style="background-color: #EEE;"><strong>'. date('D jS F Y', $now) .' at '. date('H:i', $now)  . '</strong></td></tr>';
$message .= '<tr><td style="background-color: #CCC;">Requested by:</td><td style="background-color: #EEE;"><strong>'. $from_name . '</strong></td></tr></tfoot>';
$message .= '</table><br><br>';
$message .= 'Please use the link below to view holiday request details and accept or reject the request.<br><br>';
$message .= '<a href="'. get_permalink($holiday_request_pg->ID) .'?admin_request=holiday_request&holidayid='.$holiday->ID.'">View request >></a><br><br>';
$headers = 'From:' .$from_name. '<' .$from_email. '>';

//echo '<pre>';print_r($message);echo '</pre>';

function wps_set_content_type(){return "text/html";}

add_filter( 'wp_mail_content_type','wps_set_content_type' );

if ($_SERVER['REMOTE_ADDR'] != '127.0.0.1') {
	wp_mail( $hb_admin['user_email'], $subject, $message, $headers );
} else {
	wp_mail( "kwaddelltlw@icloud.com", $subject, $message, $headers );
}

remove_filter( 'wp_mail_content_type', 'set_html_content_type' );

date_default_timezone_set($default_tz); 
?>