<?php 
$default_tz = date_default_timezone_get();
date_default_timezone_set('Europe/London'); 
$now = strtotime("now");
$meetings_pg = get_page_by_path("meetings/meeting-approval");

global $meeting_added;
global $location_id;
global $meeting_title;
global $meeting_description;
global $meeting_date;
global $start_time;
global $end_time;
global $booked_by;
global $room;

$from = get_user_by( 'id', $booked_by );

$from_name = $from->data->display_name;
$from_email = $from->data->user_email;

$subject = "Meeting room booking request from $from_name";
$message = "<h3><font style=\"color: red;\">$from_name</font> has requested a meeting room.</h3>";
$message .= "<br>";
$message .= "<table width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"10\"><tbody><thead>";
$message .= "<tr><th colspan=\"2\" style=\"background-color: #999;\">MEETING DETAILS</th></tr></thead>";
$message .= "<tbody><tr><td style=\"background-color: #CCC;\">Meeting room:</td><td style=\"background-color: #EEE;\"><strong>".  $room->name ."</strong></td></tr>";
$message .= "<tr><td style=\"background-color: #CCC;\">Meeting title:</td><td style=\"background-color: #EEE;\"><strong>". $meeting_title ."</strong></td></tr>";
$message .= "<tr><td style=\"background-color: #CCC;\">Date:</td><td style=\"background-color: #EEE;\"><strong>".  date('D jS F Y', strtotime($meeting_date)) ."</strong></td></tr>";
$message .= "<tr><td style=\"background-color: #CCC;\">Time:</td><td style=\"background-color: #EEE;\"><strong>".  $start_time ." - ".$end_time. "</strong></td></tr></tbody>";
$message .= "<tfoot><tr><td style=\"background-color: #CCC;\">Requested on:</td><td style=\"background-color: #EEE;\"><strong>". date('D jS F Y', $now) ." at ". date('H:i', $now)  . "</strong></td></tr>";
$message .= "<tr><td style=\"background-color: #CCC;\">Booked by:</td><td style=\"background-color: #EEE;\"><strong>". $from_name . "</strong></td></tr></tfoot>";
$message .= "</table><br><br>";
$message .= "Please use the link below to view meeting details and accept or reject the booking request.<br><br>";
$message .= "<a href=\"".get_permalink($meetings_pg->ID)."?booking-approval=booking-approval&meeting-id=".$meeting_added."\">View request >></a><br><br>";
$headers = "From: $from_name <$from_email>";

debug($message);

function wps_set_content_type(){
return "text/html";
}

add_filter( 'wp_mail_content_type','wps_set_content_type' );

$booking_email_sent = ( "kevwaddell@mac.com", $subject, $message, $headers );
//$booking_email_sent = true;

remove_filter( 'wp_mail_content_type', 'set_html_content_type' );

date_default_timezone_set($default_tz); 
?>