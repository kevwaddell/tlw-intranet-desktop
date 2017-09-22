<?php 
$default_tz = date_default_timezone_get();
date_default_timezone_set('Europe/London'); 
$now = strtotime("now");
$meetings = get_page_by_title("Meetings");

$from_name = $booked_by->data->display_name;
$from_email = $booked_by->data->user_email;

$subject = "Meeting room booking request from $from_name";
$message = "<h3><font style=\"color: red;\">$from_name</font> has requested a meeting room.</h3>";
$message .= "<br>";
$message .= "<table width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"10\"><tbody><thead>";
$message .= "<tr><th colspan=\"2\" style=\"background-color: #999;\">MEETING DETAILS</th></tr></thead>";
$message .= "<tbody><tr><td style=\"background-color: #CCC;\">Meeting room:</td><td style=\"background-color: #EEE;\"><strong>".  $room[0]->name ."</strong></td></tr>";
$message .= "<tr><td style=\"background-color: #CCC;\">Description:</td><td style=\"background-color: #EEE;\"><strong>". $description ."</strong></td></tr>";
$message .= "<tr><td style=\"background-color: #CCC;\">Date:</td><td style=\"background-color: #EEE;\"><strong>".  date('D jS F Y', $meeting_date_convert) ."</strong></td></tr>";
$message .= "<tr><td style=\"background-color: #CCC;\">Time:</td><td style=\"background-color: #EEE;\"><strong>".  gmdate('H:i', $start_time) ." - ". gmdate('H:i', $end_time). "</strong></td></tr></tbody>";
$message .= "<tfoot><tr><td style=\"background-color: #CCC;\">Requested on:</td><td style=\"background-color: #EEE;\"><strong>". date('D jS F Y', $now) ." at ". date('H:i', $now)  . "</strong></td></tr>";
$message .= "<tr><td style=\"background-color: #CCC;\">Booked by:</td><td style=\"background-color: #EEE;\"><strong>". $from_name . "</strong></td></tr></tfoot>";
$message .= "</table><br><br>";
$message .= "Please use the link below to view meeting details and accept or reject the booking request.<br><br>";
$message .= "<a href=\"".get_permalink($meetings->ID)."?admin_request=booking_request&meetingid=".$meeting_id."\">View request >></a><br><br>";
$headers = "From: $from_name <$from_email>";

//echo '<pre>';print_r($message);echo '</pre>';

function wps_set_content_type(){
	return "text/html";
	}
add_filter( 'wp_mail_content_type','wps_set_content_type' );

if ($_SERVER['REMOTE_ADDR'] != '127.0.0.1') {
wp_mail( $rb_admin['user_email'], $subject, $message, $headers );
} else {
wp_mail( "kevwaddell@mac.com", $subject, $message, $headers );
}

remove_filter( 'wp_mail_content_type', 'set_html_content_type' );

date_default_timezone_set($default_tz); 
?>