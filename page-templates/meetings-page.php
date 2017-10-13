<?php
/*
Template Name: Meetings page
*/
?>

<?php get_header(); ?>

<?php  
$locations = get_terms('tlw_rooms_tax', 'hide_empty=0');
$meeting_years = get_posts(array('posts_per_page' => -1, 'post_type' => 'tlw_meeting', 'meta_key' => 'meeting_year','orderby' => 'meta_value', 'order' => 'ASC')); 
$archive_years = array();
foreach ($meeting_years as $y) {
$meeting_year = get_field('meeting_year', $y->ID);	
	if (!in_array($meeting_year, $archive_years)) {
	$archive_years[] = $meeting_year;	
	}
}
$add_meeting_errors = array();
$add_attendee_errors = array();
$excluded_users = array(1, 60, 69);

$users_args = array(
'exclude'	=> $excluded_users,
'meta_key' => 'last_name',
'orderby'	=> 'meta_value'
);
$all_users = get_users($users_args);
//echo '<pre class="debug">';print_r($first_meeting_post);echo '</pre>';

include (STYLESHEETPATH . '/app/inc/meetings-page-vars/add-meeting.inc');
include (STYLESHEETPATH . '/app/inc/meetings-page-vars/cancel-meeting.inc');
include (STYLESHEETPATH . '/app/inc/meetings-page-vars/add-attendees.inc');

if ($meeting_added) {
include (STYLESHEETPATH . '/app/inc/meetings-page-vars/meeting-booked-email.inc');	
}
if ($_REQUEST['meeting-actions'] == 'notify-user') {
include (STYLESHEETPATH . '/app/inc/meetings-page-vars/meeting-notify-email.inc');	
}
?>

<article <?php post_class('page'); ?>>
	<div class="entry">
		<?php if ( $booking_email_sent || $meeting_canceled || $attendees_added || $notify_email_sent) { ?>
			<?php  get_template_part( 'parts/meetings-page/alerts/meeting', 'alerts' ); ?>
		<?php } ?>
		<?php if ( isset($_REQUEST['meeting-id']) || $meeting_added || $attendees_added) { ?>
			<?php  get_template_part( 'parts/meetings-page/meetings', 'info' ); ?>
		<?php } ?>
		<?php if ( isset($_GET['meeting-actions']) || isset($_POST['add-meeting'])) { ?>
			<?php if ($_GET['meeting-actions'] == 'add-meeting' || !empty($add_meeting_errors)) { ?>
			<?php  get_template_part( 'parts/meetings-page/add', 'meeting' ); ?>
			<?php } ?>
		<?php } ?>
	</div>
</article>

<aside id="rooms-list" class="scrollable sb-left">
	<div class="sb-inner">
		<div class="dates">
			<a href="?meeting-day=<?php echo date('Ymd'); ?>" class="lg-link<?php echo ($_REQUEST['meeting-day'] == date('Ymd') && !isset($_REQUEST['meeting-day-to'])) ? ' active':'' ?>">Today</a>
			<a href="?meeting-day=<?php echo date('Ymd'); ?>&meeting-day-to=<?php echo date('Ymd', strtotime("Friday this week")); ?>" class="lg-link<?php echo ($_REQUEST['meeting-day-to'] == date('Ymd', strtotime("Friday this week"))) ? ' active':'' ?>">This week</a>
			<a href="?meeting-day=<?php echo date('Ymd'); ?>&meeting-day-to=<?php echo date('Ymd', strtotime("last day of this month")); ?>" class="lg-link<?php echo ($_REQUEST['meeting-day-to'] == date('Ymd', strtotime("last day of this month"))) ? ' active':'' ?>">This month</a>
			<a href="?meeting-day=<?php echo date('Ymd', strtotime("first day of next month")); ?>&meeting-day-to=<?php echo date('Ymd', strtotime("last day of next month")); ?>" class="lg-link<?php echo ($_REQUEST['meeting-day'] == date('Ymd', strtotime("first day of next month"))) ? ' active':'' ?>">Next month</a>
		   <h3>Meeting archives</h3>
		   <?php 
			rsort($archive_years);
			foreach ($archive_years as $ay) { ?>
		   <a href="?meeting-year=<?php echo $ay; ?>"<?php echo ($_REQUEST['meeting-year'] == $ay) ? ' class="active"':'' ?>><?php echo $ay; ?></a>
		   <?php } ?>
		 </div>
	</div>
</aside>

<aside id="meetings-list" class="scrollable sb-right">
	<div class="sb-inner">
		<?php  if ( isset($_REQUEST['meeting-day']) || isset($_REQUEST['meeting-year'])) { ?>
		<?php get_template_part( 'parts/meetings-page/meetings', 'list' ); ?>
		<?php } ?>		
		
		<?php if ( empty($_REQUEST) ) { ?>
		<div class="no-name-message text-center">
			<i class="fa fa-calendar-check-o fa-4x block sb-icon"></i>
			<p class="caps">Select a date</p>
		</div>
		<?php } ?>	

	</div>
	<div class="sb-actions">
		<div class="actions-inner">
			<a href="?meeting-actions=add-meeting<?php echo (isset($_REQUEST['meeting-day'])) ? '&meeting-day='.$_REQUEST['meeting-day']:'' ?><?php echo (isset($_REQUEST['meeting-day-to'])) ? '&meeting-day-to='.$_REQUEST['meeting-day-to']:'' ?>" class="btn btn-default btn-lg no-rounded pull-right" id="add-meeting"><i class="fa fa-plus fa-lg"></i><span class="sr-only">Book room</span></a>	
		</div>
	</div>
</aside>

<?php get_footer(); ?>
