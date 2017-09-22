<?php
$rb_admin = get_field('rb_admin', 'options');
$meetings = get_page_by_title('Meetings');
$calendar = get_page_by_title('Calendar');
$current_user_ID = get_current_user_id();
$booked_by = get_user_by('id', $post->post_author);	
$description = get_field('meeting_description');
$room = wp_get_post_terms( get_the_ID(), 'tlw_rooms_tax');	
$date_raw = get_field('meeting_date');
$date_convert = strtotime($date_raw);
$start_time = get_field('start_time');
$end_time = get_field('end_time');
$total_int = get_post_meta( get_the_ID(), 'attendees_staff', true );
$total_ext = get_post_meta( get_the_ID(), 'attendees_clients', true );
$staff_attendees = get_field('attendees_staff');
$excluded_staff = array();
$client_attendees = get_field('attendees_clients');
$default_tz = date_default_timezone_get();
date_default_timezone_set('Europe/London'); 
$now_local = localtime(time(), true);
$now = strtotime("today ".sprintf('%02d', $now_local[tm_hour]).":".sprintf('%02d', $now_local[tm_min]));
date_default_timezone_set($default_tz);
$icon = get_field('icon', $meetings->ID);
$color = get_field('col', $meetings->ID);
$today_time = time();
$ical_page = get_page_by_title("Single ical event");
$ical_page_split_url = explode('http://', get_permalink($ical_page->ID));
$user_favs = unserialize(get_user_meta($current_user->ID, 'user_favourites', true));

/*
echo '<pre>';
print_r($today_time."<br>");
print_r($start_time);
echo '</pre>';
*/

//echo '<pre>';print_r($staff_attendees);echo '</pre>';

if ( $total_int > 0 ) {
	
	foreach($staff_attendees as $staff_attendee) {
		
		if (!in_array($staff_attendee['attendee_staff']['ID'], $excluded_staff)) {
		array_push($excluded_staff, $staff_attendee['attendee_staff']['ID']);	
		}
	}
}
?>