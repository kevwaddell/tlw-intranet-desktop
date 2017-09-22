<?php
$subject = "Your Room Booking has been canceled.";
$message = "<h3>This message is to notify you that your room booking has been canceled.</h3>";
$message .= "<br>";
$message .= "<table width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"10\"><tbody><thead>";
$message .= "<tr><th colspan=\"2\" style=\"background-color: #999;\">MEETING DETAILS</th></tr></thead>";
$message .= "<tbody><tr><td width=\"20%\" style=\"background-color: #CCC;\">Meeting description:</td><td style=\"background-color: #EEE;\"><strong>". $description ."</strong></td></tr>";
$message .= "<tr><td style=\"background-color: #CCC;\">Meeting room:</td><td style=\"background-color: #EEE;\"><strong>".  $room[0]->name ."</strong></td></tr>";
$message .= "<tr><td style=\"background-color: #CCC;\">Date:</td><td style=\"background-color: #EEE;\"><strong>".  date('D jS F Y', $meeting_date_convert) ."</strong></td></tr>";
$message .= "<tr><td style=\"background-color: #CCC;\">Time:</td><td style=\"background-color: #EEE;\"><strong>".  gmdate('H:i', $start_time) ." - ". gmdate('H:i', $end_time). "</strong></td></tr></tbody>";
$message .= "<tfoot><tr><td style=\"background-color: #CCC;\">Canceled on:</td><td style=\"background-color: #EEE;\"><strong>". date('D jS F Y', $now) ." at ". date('H:i', $now)  . "</strong></td></tr>";
$message .= "<tr><td style=\"background-color: #CCC;\">Canceled by:</td><td style=\"background-color: #EEE;\"><strong>". $from_name . "</strong></td></tr></tfoot>";
$message .= "</table><br><br>";
$headers = "From:". $admin_name . "<" .$admin_email. ">";

$am_subject = "Room booking cancelation.";
$am_message = "<h3>A room booking has been canceled.</h3>";
$am_message .= "<br>";
$am_message .= "<table width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"10\"><tbody><thead>";
$am_message .= "<tr><th colspan=\"2\" style=\"background-color: #999;\">MEETING DETAILS</th></tr></thead>";
$am_message .= "<tbody><tr><td width=\"20%\" style=\"background-color: #CCC;\">Meeting description:</td><td style=\"background-color: #EEE;\"><strong>". $description ."</strong></td></tr>";
$am_message .= "<tr><td style=\"background-color: #CCC;\">Meeting room:</td><td style=\"background-color: #EEE;\"><strong>".  $room[0]->name ."</strong></td></tr>";
$am_message .= "<tr><td style=\"background-color: #CCC;\">Date:</td><td style=\"background-color: #EEE;\"><strong>".  date('D jS F Y', $meeting_date_convert) ."</strong></td></tr>";
$am_message .= "<tr><td style=\"background-color: #CCC;\">Time:</td><td style=\"background-color: #EEE;\"><strong>".  gmdate('H:i', $start_time) ." - ". gmdate('H:i', $end_time). "</strong></td></tr></tbody>";
$am_message .= "<tfoot><tr><td style=\"background-color: #CCC;\">Canceled on:</td><td style=\"background-color: #EEE;\"><strong>". date('D jS F Y', $now) ." at ". date('H:i', $now)  . "</strong></td></tr>";
$am_message .= "<tr><td style=\"background-color: #CCC;\">Canceled by:</td><td style=\"background-color: #EEE;\"><strong>". $from_name . "</strong></td></tr></tfoot>";
$am_message .= "</table><br><br>";
$am_headers = "From:". $from_name . "<" .$from_email. ">";

//echo '<pre>';print_r($message);echo '</pre>';

function wps_set_content_type(){
	return "text/html";
	}
add_filter( 'wp_mail_content_type','wps_set_content_type' );

if ($_SERVER['REMOTE_ADDR'] != '127.0.0.1') {
	wp_mail( $booked_by->data->user_email, $subject, $message, $headers );
	wp_mail( $admin_email, $am_subject, $am_message, $am_headers );
} else {
	wp_mail( "kwaddelltlw@icloud.com", $subject, $message, $headers );
	wp_mail( "kevwaddell@mac.com", $am_subject, $am_message, $am_headers );
}

remove_filter( 'wp_mail_content_type', 'set_html_content_type' );
?>