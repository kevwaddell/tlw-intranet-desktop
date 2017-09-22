<?php 
/*
Template Name: iCal Holiday template
*/
?>
<?php
header('Content-type: text/calendar; charset=utf-8');
header('Content-Disposition: inline; filename="holidays_ical_feed.ics"'); 
$eol = "\r\n";
function dateToCal($timestamp) {
	if (date('H', $timestamp) == 0) {
	return date('Ymd', $timestamp);
	} else {
	return date('Ymd\THi00', $timestamp);	
	}
}
function escapeString($string) {
  return preg_replace('/([\,;])/','\\\$1', $string);
}
?>
BEGIN:VCALENDAR<?php echo $eol; ?>
VERSION:2.0<?php echo $eol; ?>
PRODID:-//<?php bloginfo('name'); ?>//NONSGML v1.0//EN<?php echo $eol; ?>
CALSCALE:GREGORIAN<?php echo $eol; ?>
X-WR-CALNAME:<?php echo bloginfo('name')." - Holidays Calendar"; ?><?php echo $eol; ?>
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
<?php
$cal_args = array(
'post_type' => 'tlw_holiday',
'posts_per_page' => -1,
'post_status' => "publish",
'order'	=> 'ASC',
'meta_key'	=> 'holiday_start_date',
'orderby' => 'meta_value_num'
);
$cal_posts = query_posts($cal_args);
/*
$default_tz = date_default_timezone_get();
date_default_timezone_set(get_option('timezone_string')); 
*/
//echo '<pre>';print_r(get_option('timezone_string'));echo '</pre>';

foreach($cal_posts as $post) :
setup_postdata($post); 
$booked_by = get_user_by('id', $post->post_author);
$start = get_post_meta($post->ID, 'holiday_start_date', true);
$end = get_post_meta($post->ID, 'holiday_end_date', true);
$num_days = get_post_meta($post->ID, 'number_of_days', true);
$description = $post->post_title;
$room = wp_get_post_terms( $post->ID, 'tlw_rooms_tax');

//echo '<pre>';print_r (get_option('timezone_string') );echo '</pre>';
//echo '<pre>';print_r (date('Ymd\THi00', $end) );echo '</pre>';
?>
BEGIN:VEVENT<?php echo $eol; ?>
UID: <?php echo uniqid(); ?><?php echo $eol; ?>
SUMMARY:<?php echo escapeString($description); ?><?php echo $eol; ?>
DTSTART;TZID="Europe/London":<?php echo dateToCal($start); ?><?php echo $eol; ?>
DTEND;TZID="Europe/London":<?php echo (date('H', $end) == "00") ? dateToCal( strtotime( date('Ymd', $end). " +1 day" ) ): dateToCal( $end ); ?><?php echo $eol; ?>
CLASS:PRIVATE<?php echo $eol; ?>
END:VEVENT<?php echo $eol; ?>
<?php endforeach; ?>
END:VCALENDAR<?php echo $eol; ?>