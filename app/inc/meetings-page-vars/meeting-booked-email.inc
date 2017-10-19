<?php 
$timeZone = 'Europe/London';
$now_time = new DateTime(null, new DateTimeZone($timeZone));
$meetings_pg = get_page_by_path("meetings");
global $show_alert;
global $meeting_added;
global $location_id;
global $meeting_title;
global $meeting_description;
global $meeting_date;
global $start_time;
global $end_time;
global $booked_by;
global $room;

$from = get_user_by( 'id', 1 );
$fname = get_user_meta( 1, 'first_name', true );
$lname = get_user_meta( 1, 'last_name', true );
$from_email = $from->data->user_email;
$to = get_user_by( 'id', $booked_by );
$to_email = $to->data->user_email;

$request_params = "";
if (isset($_REQUEST['meeting-day'])) {
$request_params .= '&meeting-day='.$_REQUEST['meeting-day'];	
}
if (isset($_REQUEST['meeting-day-to'])) {
$request_params .= '&meeting-day-to='.$_REQUEST['meeting-day-to'];	
}

$subject = "Meeting room booking";
$message = "<h1 style=\"font-size:25px; line-height: 30px;\"><font style=\"color: red;\">".$room->name."</font> has been booked.</h1>";
$message .= "<table width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"10\"><tbody><thead>";
$message .= "<tr><th colspan=\"2\" style=\"background-color: #999;\">MEETING DETAILS</th></tr></thead>";
$message .= "<tbody><tr><td style=\"background-color: #CCC;\">Meeting title:</td><td style=\"background-color: #EEE;\"><strong>". $meeting_title ."</strong></td></tr>";
if (!empty($meeting_description)) {
$message .= "<tr><td style=\"background-color: #CCC;\">Meeting description:</td><td style=\"background-color: #EEE;\"><strong>". $meeting_description ."</strong></td></tr>";			
}
$message .= "<tr><td style=\"background-color: #CCC;\">Meeting Date/time:</td><td style=\"background-color: #EEE;\"><strong>".  date('D jS F Y', strtotime($meeting_date)) ." @ ".$start_time ." - ".$end_time."</strong></td></tr></tbody>";
$message .= "<tfoot><tr><td style=\"background-color: #CCC;\">Requested date/time:</td><td style=\"background-color: #EEE;\"><strong>". $now_time->format('D jS F Y @ H:i')  . "</strong></td></tr></tfoot>";
$message .= "</table><br><br>";
$message .= "Please use the link below to view your meeting details.<br><br>";
$message .= "<a href=\"".get_permalink($meetings_pg->ID)."?meeting-id=".$meeting_added.$request_params."\" target=\"_blank\" style=\"display: block; text-align: center; text-transform: uppercase; text-decoration: none; padding: 10px; background-color: red; color: white; \">View request >></a><br><br>";
$headers = array();
$headers[] = "Content-Type: text/html; charset=UTF-8";
$headers[] = "From: $fname $lname <$from_email>";
$headers[] = "Reply-To: $fname $lname <$from_email>";

//debug($message);
$booking_email_sent = wp_mail("kwaddell@tlwsolicitors.co.uk", $subject, $message, $headers );
$show_alert = true;
//debug($booking_email_sent);
//$booking_email_sent = true;
?>