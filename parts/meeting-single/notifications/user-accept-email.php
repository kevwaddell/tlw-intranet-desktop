<!-- ACCEPTANCE NOTIFICATION -->
<?php  
$subject = "TLW Solicitors meeting attendance accepted from ".$from_name;
$message = "<h3>This is a meeting acceptance notification from <font style=\"color: red;\">".$from_name."</font>.</h3>";
$message .= "<strong>".$user_meta['first_name'][0]."</strong> will be available to attend the <strong>'". $description ."'</strong> meeting<br>";
$message .= "on <strong>".  date('D jS F Y', $date_convert) ."</strong> at <strong>".  date('H:i', $start_time) ."</strong> - <strong>". date('H:i', $end_time). "</strong>.";
$headers = "From: $from_name <$from_email>";

function wps_set_content_type(){ return "text/html"; }
	
add_filter( 'wp_mail_content_type','wps_set_content_type' );

if ($_SERVER['REMOTE_ADDR'] != '127.0.0.1') {
wp_mail( $booked_by->data->user_email, $subject, $message, $headers );
} else {
wp_mail( "kwaddelltlw@icloud.com", $subject, $message, $headers );
}

remove_filter( 'wp_mail_content_type', 'set_html_content_type' );
?>
