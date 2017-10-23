<?php
global $current_user;
global $timeZone;
//debug($reminders_completed);
if ( isset($_POST['status-later'])) {
	//debug($_POST);
	$rem_id = $_POST['status-later'];
	$reminder = get_post($rem_id);
	$dateTime = new DateTime("+1 hour", new DateTimeZone($timeZone));
	$rem_later = $dateTime->format('Y-m-d G:i:s');
	$remind_later_key = acf_get_field_key('remind_later',  $rem_id);
	$remind_later_updated = update_field($remind_later_key, $rem_later, $rem_id);
	//debug($remind_later_key);
}
?>