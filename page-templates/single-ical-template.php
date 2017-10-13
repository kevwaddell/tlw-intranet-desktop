<?php 
/*
Template Name: Single iCal template
*/
?>
<?php

header('Content-type: text/calendar; charset=utf-8');
header('Content-Disposition: attachment; filename="meeting_ical.ics"'); 

$eol = "\r\n";
$meeting_id = $_GET['meeting-id'];
$meeting = get_post($meeting_id);
?>

BEGIN:VCALENDAR<?php echo $eol; ?>
VERSION:2.0<?php echo $eol; ?>
PRODID:-//<?php bloginfo('name'); ?>//NONSGML v1.0//EN<?php echo $eol; ?>
CALSCALE:GREGORIAN<?php echo $eol; ?>

<?php
$booked_by = get_user_by('id', $meeting->post_author);
$meeting_date = get_post_meta($meeting->ID, 'meeting_date', true);
$start_time = get_post_meta($meeting->ID, 'start_time', true);
$end_time = get_post_meta($meeting->ID, 'end_time', true);
$start = strtotime($meeting_date. " " .$start_time);
$end = strtotime($meeting_date. " " .$end_time);
$description = get_post_meta($meeting->ID, 'meeting_description', true);
$rooms = wp_get_post_terms( $meeting->ID, 'tlw_rooms_tax');
$url = get_permalink( $meeting_id );
function dateToCal($timestamp) {
  return date('Ymd\THi00', $timestamp);
}
function escapeString($string) {
  return preg_replace('/([\,;])/','\\\$1', $string);
}
//debug(dateToCal($start));
?>

BEGIN:VTIMEZONE<?php echo $eol; ?>
TZID:Europe/London<?php echo $eol; ?>
TZURL:http://tzurl.org/zoneinfo-outlook/Europe/London<?php echo $eol; ?>
X-LIC-LOCATION:Europe/London<?php echo $eol; ?>
BEGIN:DAYLIGHT<?php echo $eol; ?>
TZOFFSETFROM:+0000<?php echo $eol; ?>
TZOFFSETTO:+0100<?php echo $eol; ?>
TZNAME:BST<?php echo $eol; ?>
DTSTART:<?php echo dateToCal(strtotime("now")); ?><?php echo $eol; ?>
RRULE:FREQ=YEARLY;BYMONTH=3;BYDAY=-1SU<?php echo $eol; ?>
END:DAYLIGHT<?php echo $eol; ?>
BEGIN:STANDARD<?php echo $eol; ?>
TZOFFSETFROM:+0100<?php echo $eol; ?>
TZOFFSETTO:+0000<?php echo $eol; ?>
TZNAME:GMT<?php echo $eol; ?>
DTSTART:<?php echo dateToCal(strtotime("now +1hour")); ?><?php echo $eol; ?>
RRULE:FREQ=YEARLY;BYMONTH=10;BYDAY=-1SU<?php echo $eol; ?>
END:STANDARD<?php echo $eol; ?>
END:VTIMEZONE<?php echo $eol; ?>
BEGIN:VEVENT<?php echo $eol; ?>
UID: <?php echo uniqid(); ?><?php echo $eol; ?>
DTSTART;TZID="Europe/London":<?php echo dateToCal($start); ?><?php echo $eol; ?>
DTEND;TZID="Europe/London":<?php echo dateToCal($end); ?><?php echo $eol; ?>
SUMMARY:<?php echo escapeString(get_the_title($meeting_id)); ?><?php echo $eol; ?>
DESCRIPTION:<?php echo escapeString("Booked by ".$booked_by->data->display_name); ?><?php echo $eol; ?>
LOCATION:<?php echo escapeString($rooms[0]->name);  ?><?php echo $eol; ?>
CLASS:PRIVATE<?php echo $eol; ?>
END:VEVENT<?php echo $eol; ?>
END:VCALENDAR<?php echo $eol; ?>
