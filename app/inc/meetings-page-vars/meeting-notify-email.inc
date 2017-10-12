<?php 
$timeZone = 'Europe/London';
$now_time = new DateTime(null, new DateTimeZone($timeZone));
$meeting_approval_pg = get_page_by_path("meetings/meeting-approval");

$meeting = get_post($_REQUEST['meeting-id']);
$locations = wp_get_post_terms( $_REQUEST['meeting-id'], 'tlw_rooms_tax');
$meeting_description = get_field('meeting_description', $meeting->ID);
$meeting_date = get_field('meeting_date', $meeting->ID);
$start_time = get_field('start_time', $meeting->ID);
$end_time = get_field('end_time', $meeting->ID);
$booked_by = $meeting->post_author;
$fname = get_user_meta( $booked_by, 'first_name', true );
$lname = get_user_meta( $booked_by, 'last_name', true );
$m_user = get_user_by( 'id', $_REQUEST['user-id'] );
$to_email = $m_user->data->user_email;
$user_fname = get_user_meta( $_REQUEST['user-id'], 'first_name', true );
$user_lname = get_user_meta( $_REQUEST['user-id'], 'last_name', true );

$from = get_user_by( 'id', $booked_by );
$from_email = $from->data->user_email;

$subject = "Meeting attendance request from $fname $lname";
$message = "<h3><font style=\"color: red;\">$fname $lname</font> has requested you attend a meeting.</h3>";
$message .= "<br>";
$message .= "<table width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"10\"><tbody><thead>";
$message .= "<tr><th colspan=\"2\" style=\"background-color: #999;\">MEETING DETAILS</th></tr></thead>";
$message .= "<tbody><tr><td style=\"background-color: #CCC;\">Meeting room:</td><td style=\"background-color: #EEE;\"><strong>".  $locations[0]->name ."</strong></td></tr>";
$message .= "<tr><td style=\"background-color: #CCC;\">Meeting title:</td><td style=\"background-color: #EEE;\"><strong>". get_the_title( $meeting->ID ) ."</strong></td></tr>";
$message .= "<tr><td style=\"background-color: #CCC;\">Meeting description:</td><td style=\"background-color: #EEE;\"><strong>". $meeting_description ."</strong></td></tr>";
$message .= "<tr><td style=\"background-color: #CCC;\">Date:</td><td style=\"background-color: #EEE;\"><strong>".  date('D jS F Y', strtotime($meeting_date)) ."</strong></td></tr>";
$message .= "<tr><td style=\"background-color: #CCC;\">Time:</td><td style=\"background-color: #EEE;\"><strong>".  $start_time ." - ".$end_time. "</strong></td></tr></tbody>";
$message .= "<tfoot><tr><td style=\"background-color: #CCC;\">Requested on:</td><td style=\"background-color: #EEE;\"><strong>". $now_time->format('D jS F Y @ H:i') . "</strong></td></tr>";
$message .= "<tr><td style=\"background-color: #CCC;\">Booked by:</td><td style=\"background-color: #EEE;\"><strong>". $fname ." ". $lname . "</strong></td></tr></tfoot>";
$message .= "</table><br><br>";
$message .= "Please use the link below to view meeting details and accept or reject the booking request.<br><br>";
$message .= "<a href=\"".get_permalink($meeting_approval_pg->ID)."?meeting-actions=attendee-approval&meeting-id=".$meeting->ID."&user-id=".$_REQUEST['user-id']."\">View request >></a><br><br>";
$headers = array();
$headers[] = "Content-Type: text/html; charset=UTF-8";
$headers[] = "From: $fname $lname <$from_email>";
$headers[] = "Reply-To: $fname $lname <$from_email>";

if ($_SERVER[SERVER_ADMIN] == "home-laptop@localhost") {
$live = false;
} else {
$live = true;	
}

debug($message);


if ($live) {
$notify_email_sent = wp_mail( "kwaddell@tlwsolicitors.co.uk", $subject, $message, $headers );	
} else {
$notify_email_sent = wp_mail( "kwaddelltlw@icloud.com", $subject, $message, $headers );	
}
//$booking_email_sent = true;
?>