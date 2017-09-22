<?php
if ($_SERVER['REMOTE_ADDR'] != '127.0.0.1') {
$send_to = $booked_by->data->user_email;
} else {
$send_to = "kevwaddell@mac.com";
}

$from_name = $rb_admin['display_name'];
$from_email = $rb_admin['user_email'];
  
//$to = $booked_by[user_email];
$subject = "Your room booking has been rejected";
$message = "<h3>This message is to notify you that your room booking request has been rejected.</h3>";
$message .= "This may be because the room is pre-booked.<br><br><a href=\"".get_permalink($meetings->ID)."\">Please try again</a>";
$headers = "From:". $from_name ." <". $from_email .">";

function wps_set_content_type(){
	return "text/html";
	}
add_filter( 'wp_mail_content_type','wps_set_content_type' );

if ($_SERVER['REMOTE_ADDR'] != '127.0.0.1') {
$send_to = ;
wp_mail( $booked_by->data->user_email, $subject, $message, $headers );
} else {
$send_to = ;
wp_mail( "kwaddelltlw@icloud.com", $subject, $message, $headers );
}

remove_filter( 'wp_mail_content_type', 'set_html_content_type' );

 ?>