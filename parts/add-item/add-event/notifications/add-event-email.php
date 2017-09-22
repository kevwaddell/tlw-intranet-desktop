<?php 
$default_tz = date_default_timezone_get();
date_default_timezone_set('Europe/London'); 
$now = strtotime("now");

$from_name = $added_by->data->display_name;
$from_email = $added_by->data->user_email;

$subject = "TLW intranet article submission from $from_name";
$message = "<h3><font style=\"color: red;\">$from_name</font> has submitted an article for review.</h3>";
$message .= "<br>";
$message .= "<table width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"10\"><tbody><thead>";
$message .= "<tr><th colspan=\"2\" style=\"background-color: #999;\">ARTICLE DETAILS</th></tr></thead>";
$message .= "<tbody><tr><td style=\"background-color: #CCC;\" width=\"20%\">Title:</td><td style=\"background-color: #EEE;\"><strong>".  $new_post->post_title ."</strong></td></tr>";
$message .= "<tr><td style=\"background-color: #CCC;\">Category:</td><td style=\"background-color: #EEE;\"><strong>". $cats[0]->name ."</strong></td></tr>";
$message .= "<tr><td style=\"background-color: #CCC;\">Tags:</td><td style=\"background-color: #EEE;\"><strong>".  $tags ."</strong></td></tr>";
$message .= "<tr><td style=\"background-color: #CCC;\" valign=\"top\">Content:</td><td style=\"background-color: #EEE;\"><strong>".  $email_content . "</strong></td></tr></tbody>";
$message .= "<tfoot><tr><td style=\"background-color: #CCC;\">Requested on:</td><td style=\"background-color: #EEE;\"><strong>". date('D jS F Y', $now) ." at ". date('H:i', $now)  . "</strong></td></tr>";
$message .= "<tr><td style=\"background-color: #CCC;\">Added by:</td><td style=\"background-color: #EEE;\"><strong>". $from_name . "</strong></td></tr></tfoot>";
$message .= "</table><br><br>";
$message .= "Please use the link below to view article details and edit, publish or delete the article.<br><br>";
$message .= "<a href=\"".$edit_post_link."\">View article details >></a><br><br>";
$headers = "From: $from_name <$from_email>";

//echo '<pre>';print_r( $edit_post_link  );echo '</pre>';

function wps_set_content_type(){return "text/html";}

add_filter( 'wp_mail_content_type','wps_set_content_type' );

wp_mail( $to, $subject, $message, $headers );

if ($_SERVER['REMOTE_ADDR'] != '127.0.0.1') {
wp_mail( $rb_admin['user_email'], $subject, $message, $headers );
} else {
wp_mail( "kevwaddell@mac.com", $subject, $message, $headers );
}

remove_filter( 'wp_mail_content_type', 'set_html_content_type' );

date_default_timezone_set($default_tz); 
?>