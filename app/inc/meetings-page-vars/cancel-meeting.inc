<?php
if ($_GET['meeting-actions'] == 'cancel-meeting') {
$m_id = $_GET['meeting-id'];
$attendees_staff_orig = get_field( 'attendees_staff', $m_id );
$notify_user_emails = array();
$meeting_canceled = false;
$show_alert = false;

	if (!empty($attendees_staff_orig)) {
		foreach($attendees_staff_orig as $k => $as) {
			if ($as['status'] == 'pending') {
			$notify_user_emails[] = $as['attendee']['user_email'];	
			}
		}
	}
	
	if (!empty($notify_user_emails)) {	
		$timeZone = 'Europe/London';
		$now_time = new DateTime(null, new DateTimeZone($timeZone));
		$show_alert = false;
		$meeting = get_post($m_id);
		$locations = wp_get_post_terms( $m_id, 'tlw_rooms_tax');
		$meeting_description = get_field('meeting_description', $m_id);
		$meeting_date = get_field('meeting_date', $m_id);
		$start_time = get_field('start_time', $m_id);
		$end_time = get_field('end_time', $m_id);
		$booked_by = $meeting->post_author;
		$fname = get_user_meta( $booked_by, 'first_name', true );
		$lname = get_user_meta( $booked_by, 'last_name', true );
		
		$from = get_user_by( 'id', $booked_by );
		$from_email = $from->data->user_email;
		
		$subject =  "TLW Meeting cancelation";
		$message = "<h1 style=\"font-size:25px; line-height: 30px;text-align: center;\"><font style=\"color: red;\">$fname $lname</font><br>has canceled the meeting<br><font style=\"color: red;\">". get_the_title( $meeting->ID )."</font></h1>";
		$message .= "<table width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"10\"><tbody><thead>";
		$message .= "<tr><th colspan=\"2\" style=\"background-color: #999;\">CANCELATION DETAILS</th></tr></thead>";
		$message .= "<tbody><tr><td style=\"background-color: #CCC;\">Meeting room:</td><td style=\"background-color: #EEE;\"><strong>".  $locations[0]->name ."</strong></td></tr>";
		if (!empty($meeting_description)) {
		$message .= "<tr><td style=\"background-color: #CCC;\">Meeting description:</td><td style=\"background-color: #EEE;\"><strong>". $meeting_description ."</strong></td></tr>";			
		}
		$message .= "<tr><td style=\"background-color: #CCC;\">Meeting Date/time:</td><td style=\"background-color: #EEE;\"><strong>".  date('D jS F Y', strtotime($meeting_date)) ." @ ".$start_time ." - ".$end_time."</strong></td></tr></tbody>";
		$message .= "<tfoot><tr><td style=\"background-color: #CCC;\">Canceled at:</td><td style=\"background-color: #EEE;\"><strong>". $now_time->format('D jS F Y @ H:i') . "</strong></td></tr>";
		$message .= "<tr><td style=\"background-color: #CCC;\">Canceled by:</td><td style=\"background-color: #EEE;\"><strong>". $fname ." ". $lname . "</strong></td></tr></tfoot>";
		$message .= "</table>";
		$headers = array();
		$headers[] = "Content-Type: text/html; charset=UTF-8";
		$headers[] = "From: $fname $lname <$from_email>";
		$headers[] = "Reply-To: $fname $lname <$from_email>";
		
		$notify_test_emails = array('kwaddell@tlwsolicitors.co.uk', 'webmaster@tlwsolicitors.co.uk');
		
		$notify_emails_sent = wp_mail( $notify_test_emails, $subject, $message, $headers );	
	}	
	
	//$meeting_canceled = true;
	//$show_alert = true;
	
	//debug($show_alert);
	
	
}	
?>