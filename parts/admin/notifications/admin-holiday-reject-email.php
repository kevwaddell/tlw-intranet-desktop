<?php 
$default_tz = date_default_timezone_get();
date_default_timezone_set('Europe/London'); 
$now = strtotime("now");
$holiday_request_pg = get_page_by_title("Holiday Requests");
$booked_by = get_user_by('id', $holiday->post_author);

//echo '<pre>';print_r($holiday);echo '</pre>';

$holiday_start_date_convert = strtotime(get_field('holiday_start_date', $holiday->ID));
$holiday_end_date_convert = strtotime(get_field('holiday_end_date', $holiday->ID));
$number_of_days = get_field('number_of_days', $holiday->ID);

$from_name = $hb_admin['display_name'];
$from_email = $hb_admin['user_email'];

$subject = 'Holiday booking rejected';
$message = '<h3><font style="color: red;">'.$from_name.'</font> has rejected your holiday request.</h3>';
$message .= 'Please contact <a href="mailto:'.$hb_admin['user_email'].'">'.$hb_admin['dispaly_name'].'</a> for more details on your rejected request.<br><br>';
$headers = 'From:' .$from_name. '<' .$from_email. '>';

//echo '<pre>';print_r($message);echo '</pre>';

function wps_set_content_type(){return "text/html";}

add_filter( 'wp_mail_content_type','wps_set_content_type' );

if ($_SERVER['REMOTE_ADDR'] != '127.0.0.1') {
	wp_mail( $booked_by->data->user_email, $subject, $message, $headers );
} else {
	wp_mail( "kevwaddell@mac.com", $subject, $message, $headers );
}

remove_filter( 'wp_mail_content_type', 'set_html_content_type' );

date_default_timezone_set($default_tz); 
?>