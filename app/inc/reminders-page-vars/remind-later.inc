<?php
global $current_user;
global $timeZone;
//debug($reminders_completed);
if ( isset($_POST['status-later'])) {
	$reminder_id = $_POST['status-later'];
	$reminder = get_post($reminder_id);
	$dateTime = new DateTime("now + 1 hour", new DateTimeZone($timeZone));
	$dt_ts = strtotime($dateTime->format('Y-m-d G:i:s'));
	$remind_later_key = acf_get_field_key('remind_later',  $reminder_id);
	$remind_later_updated = update_field($remind_later_key, $dt_ts, $reminder_id);
}
?>