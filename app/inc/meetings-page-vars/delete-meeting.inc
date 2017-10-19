<?php
if ($_GET['meeting-actions'] == 'delete-meeting') {
global $show_alert;
global $meeting_deleted;
$m_id = $_GET['meeting-id'];
	if (wp_trash_post($m_id)) {
	$meeting_deleted = true;
	$show_alert = true;	
	}
}
?>