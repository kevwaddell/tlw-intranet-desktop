<?php
global $current_user;
$default_tz = date_default_timezone_get();
date_default_timezone_set('Europe/London'); 
$now = strtotime('now');
$today = date('Ymd', strtotime('today'));
$today_end = strtotime("today 18:00");

$all_count = 0;
$room_count = 0;
$meetings_count = 0;
$holiday_count = 0;

$user_meetings_args = array(
'post_status'	=> 'publish',
'post_type'	=> 'tlw_meeting',
'posts_per_page'	=> -1,
'meta_query'	=> array(
	'relation' => 'AND',
		array(
			'key' => 'start_time',
			'value' => $now,
			'compare' => '>',
			'type' => 'NUMERIC'
		),
		array(
			'key' => 'end_time',
			'value' => $today_end,
			'compare' => '<',
			'type' => 'NUMERIC'
		)
	)
);
$user_meetings = get_posts($user_meetings_args);

if (!empty($user_meetings)) {
	foreach ($user_meetings as $user_meeting) {
	$staff_attendees = get_field('attendees_staff', $user_meeting->ID);
		
		foreach ($staff_attendees as $staff_attendee) {
			if ($staff_attendee[attendee_staff][ID] == $current_user->ID && ($staff_attendee[status] == 'pending' || $staff_attendee[status] == 'approved') ) {
			$meetings_count++;
			}
		}
		
	}
}

//echo '<pre>';print_r(date('F j Y H:i', $now));echo '</pre>';

$user_room_args = array(
'post_status'	=> 'pending',
'post_type'	=> 'tlw_meeting',
'posts_per_page'	=> -1,
'author'	=> $current_user->ID,
'meta_query'	=> array(
	array(
		'key' => 'start_time',
		'value' => $now,
		'compare' => '>',
		'type' => 'NUMERIC'
	)
)
);
$user_rooms = get_posts($user_room_args);

if ($meetings_count > 0) {
$all_count += $meetings_count;
}

if (count($user_rooms) > 0) {
$room_count = count($user_rooms);
$all_count += $room_count;
}

//echo '<pre>';print_r($user_meetings);echo '</pre>';
date_default_timezone_set($default_tz);
 ?>

<?php if ($all_count > 0) { ?>

<div class="notifications">
	<button><i class="fa fa-angle-down fa-lg pull-left"></i>Notifications<span class="badge pull-right"><?php echo $all_count; ?></span></button>
	
	<div class="messages messages-hidden">
		<?php if ($meetings_count > 0) { ?>
		<a href="<?php echo get_author_posts_url( $current_user->ID, $current_user->user_nicename); ?>?view=today">Meetings<span class="badge pull-right"><?php echo $meetings_count; ?></span></a>
		<?php } ?>
		
		<?php if ($room_count > 0) { ?>
		<a href="<?php echo get_author_posts_url( $current_user->ID, $current_user->user_nicename); ?>?sortby=pending">Room bookings<span class="badge pull-right"><?php echo $room_count; ?></span></a>
		<?php } ?>
		
	</div>
</div>

<?php } ?>

