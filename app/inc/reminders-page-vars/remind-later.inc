<?php
global $current_user;
global $timeZone;
//debug($reminders_completed);
if ( isset($_POST['status-later'])) {
	$reminder_id = $_POST['status-later'];
	$reminder = get_post($reminder_id);
	$dateTime = new DateTime("+1 hour", new DateTimeZone($timeZone));
	$dt_ts = $dateTime->getTimestamp();
	$remind_later_key = acf_get_field_key('remind_later',  $reminder_id);
	$remind_later_updated = update_field($remind_later_key, date('Y-m-d G:i:s', $dt_ts), $reminder_id);
}
?>