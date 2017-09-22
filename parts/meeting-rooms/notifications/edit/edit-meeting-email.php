<?php
$default_tz = date_default_timezone_get();
date_default_timezone_set('Europe/London'); 
$now = strtotime("now");

$from_name = $current_user->data->display_name;
$from_email = $current_user->data->user_email;

if ($_SERVER['REMOTE_ADDR'] != '127.0.0.1') {

$send_to = 	$rb_admin['user_email'];
} else {
$send_to = 	"kwaddelltlw@icloud.com";
}

$to = $send_to;
$subject = "Room Booking for ".$description." meeting has been changed.";
$message = "<h3>This message is a notification that a room booking has been changed.</h3>";
$message .= "<br>";
$message .= "<table width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"10\"><tbody><thead>";
$message .= "<tr><th colspan=\"2\" style=\"background-color: #999;\">MEETING DETAILS</th></tr></thead>";
$message .= "<tbody><tr><td width=\"20%\" style=\"background-color: #CCC;\">Meeting description:</td><td style=\"background-color: #EEE;\"><strong>". $description ."</strong></td></tr>";
$message .= "<tr><td style=\"background-color: #CCC;\">Meeting room:</td><td style=\"background-color: #EEE;\"><strong>".  $room[0]->name ."</strong></td></tr>";
$message .= "<tr><td style=\"background-color: #CCC;\">Date:</td><td style=\"background-color: #EEE;\"><strong>".  date('D jS F Y', $date_convert) ."</strong></td></tr>";
$message .= "<tr><td style=\"background-color: #CCC;\">Time:</td><td style=\"background-color: #EEE;\"><strong>".  $meeting_start ." - ". $meeting_end. "</strong></td></tr></tbody>";
$message .= "<tfoot><tr><td style=\"background-color: #CCC;\">Changed on:</td><td style=\"background-color: #EEE;\"><strong>".  date('D jS F Y', $now) ." at ". date('H:i', $now) . "</strong></td></tr>";
$message .= "<tr><td style=\"background-color: #CCC;\">Changed by:</td><td style=\"background-color: #EEE;\"><strong>". $from_name . "</strong></td></tr></tfoot>";
$message .= "</table><br><br>";
$message .= "Please use the link below to view meeting details and accept or reject the meeting update.<br><br>";		
$message .= "<a href=\"".get_permalink($meetings->ID)."?admin_request=booking_request&meetingid=".$meeting->ID."\">View request >></a><br><br>";
$headers = "From: $from_name <$from_email>";

//echo '<pre>';print_r( $message );echo '</pre>';
date_default_timezone_set($default_tz); 

function wps_set_content_type(){
	return "text/html";
	}
add_filter( 'wp_mail_content_type','wps_set_content_type' );

wp_mail( $to, $subject, $message, $headers );

remove_filter( 'wp_mail_content_type', 'set_html_content_type' );
?>