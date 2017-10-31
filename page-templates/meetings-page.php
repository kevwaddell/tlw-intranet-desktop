<?php
/*
Template Name: Meetings page
*/
?>
<?php  
global $current_user;
$timeZone = 'Europe/London';
$locations = get_terms('tlw_rooms_tax', 'hide_empty=0');
$meeting_years = get_posts(array('posts_per_page' => -1, 'post_type' => 'tlw_meeting', 'meta_key' => 'meeting_year','orderby' => 'meta_value', 'order' => 'ASC')); 
$attending_meetings = array(); 
$your_meetings_args = array(
	'posts_per_page' => -1,
	'post_type' => 'tlw_meeting',
	'author' => $current_user->ID,
	'meta_key' => 'meeting_date',
	'orderby' => 'meta_value',
	'order' => 'ASC',
	'meta_compare' => '>=',
	'meta_value'	=> date('Ymd')
);
$your_meetings = get_posts($your_meetings_args); 
$all_meetings_args = array(
	'posts_per_page' => -1,
	'post_type' => 'tlw_meeting',
	'orderby' => 'meta_value',
	'meta_key' => 'meeting_date',
	'order' => 'ASC',
	'meta_compare' => '>=',
	'meta_value'	=> date('Ymd')
);
$all_meetings = get_posts($all_meetings_args); 
$archive_years = array();
$your_months = array();
foreach ($meeting_years as $y) {
$meeting_year = get_field('meeting_year', $y->ID);	
	if (!in_array($meeting_year, $archive_years)) {
	$archive_years[] = $meeting_year;	
	}
}
foreach ($all_meetings as $k => $am) {
$att_staff = get_field('attendees_staff', $am->ID);	
	if (!empty($att_staff)) {
		foreach ($att_staff as $sk => $staff) {
			if ($staff['attendee']['ID'] == $current_user->ID && !in_array($am, $your_meetings)) {
			$your_meetings[] = $am;	
			}
		}
	}
}
foreach ($your_meetings as $ym) {
$meeting_date = get_field('meeting_date', $ym->ID);	
//debug(get_the_title( $ym->ID ));	
	$meeting_month = date("F", strtotime($meeting_date) );
	$meeting_year = date("Y", strtotime($meeting_date) );
	if (!in_array(array($meeting_month, $meeting_year), $your_months)) {
	$your_months[] = array($meeting_month, $meeting_year);	
	}
}
$add_meeting_errors = array();
$add_attendee_errors = array();
$edit_meeting_errors = array();
$meeting_updated = false;
$attendees_added = false;
$meeting_canceled = false;
$attendee_removed = false;
$attendee_updated = false;
$meeting_deleted = false;
$show_alert = false;

if ($current_user->ID == 1) {
$excluded_users = array(60, 69, $current_user->ID);	
} else {
$excluded_users = array(1, 60, 69, $current_user->ID);	
}

$users_args = array(
'exclude'	=> $excluded_users,
'meta_key' => 'last_name',
'orderby'	=> 'meta_value'
);
$all_users = get_users($users_args);
//echo '<pre class="debug">';print_r($first_meeting_post);echo '</pre>';

include (STYLESHEETPATH . '/app/inc/meetings-page-vars/add-meeting.inc');
include (STYLESHEETPATH . '/app/inc/meetings-page-vars/edit-meeting.inc');
include (STYLESHEETPATH . '/app/inc/meetings-page-vars/cancel-meeting.inc');
include (STYLESHEETPATH . '/app/inc/meetings-page-vars/delete-meeting.inc');
include (STYLESHEETPATH . '/app/inc/meetings-page-vars/add-attendees.inc');
include (STYLESHEETPATH . '/app/inc/meetings-page-vars/update-attendee.inc');
include (STYLESHEETPATH . '/app/inc/meetings-page-vars/remove-attendee.inc');
include (STYLESHEETPATH . '/app/inc/meetings-page-vars/add-reminder.inc');

if ($meeting_added) {
include (STYLESHEETPATH . '/app/inc/meetings-page-vars/meeting-booked-email.inc');	
}
if ($_REQUEST['meeting-actions'] == 'notify-user') {
include (STYLESHEETPATH . '/app/inc/meetings-page-vars/meeting-notify-email.inc');	
}
//debug($your_months);
//$show_alert = true;
//$meeting_deleted = true;
?>

<?php get_header(); ?>

<article <?php post_class('page'); ?>>
	<div class="entry">
		<?php if ( $show_alert) { ?>
			<?php  get_template_part( 'parts/meetings-page/alerts/meeting', 'alerts' ); ?>
		<?php } ?>
		<?php if ( isset($_REQUEST['meeting-id']) || $meeting_added || $attendees_added ) { ?>
			<?php  get_template_part( 'parts/meetings-page/meetings', 'info' ); ?>
		<?php } ?>
		<?php if ( isset($_GET['meeting-actions']) || isset($_POST['add-meeting']) || isset($_POST['edit-meeting'])) { ?>
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
			<a href="?meeting-day=<?php echo date('Ymd', strtotime("first day of this month")); ?>&meeting-day-to=<?php echo date('Ymd', strtotime("last day of this month")); ?>" class="lg-link<?php echo ($_REQUEST['meeting-day-to'] == date('Ymd', strtotime("last day of this month"))) ? ' active':'' ?>">This month</a>
			<a href="?meeting-day=<?php echo date('Ymd', strtotime("first day of next month")); ?>&meeting-day-to=<?php echo date('Ymd', strtotime("last day of next month")); ?>" class="lg-link<?php echo ($_REQUEST['meeting-day'] == date('Ymd', strtotime("first day of next month"))) ? ' active':'' ?>">Next month</a>
		  
		  <?php if (!empty($your_months)) { ?>
		  <h3>Your Meetings</h3>
		  	<?php foreach ($your_months as $m) { 
			$dt_month = new DateTime($m[0]." ".$m[1], new DateTimeZone($timeZone));
		  	?>
		  	<a href="?meeting-month=<?php echo $dt_month->format('m'); ?>&meeting-year=<?php echo $dt_month->format('Y'); ?>" class="<?php echo ($_REQUEST['meeting-month'] == $dt_month->format('m')) ? ' active':'' ?>"><?php echo $dt_month->format('F'); ?></a>
		  	<?php } ?>		
		  <?php } ?>
		  
		   <h3>Meetings archive</h3>
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
		<?php  if ( isset($_REQUEST['meeting-day']) || isset($_REQUEST['meeting-year']) && !isset($_REQUEST['meeting-month'])) { ?>
		<?php get_template_part( 'parts/meetings-page/meetings', 'list' ); ?>
		<?php } ?>	
		
		<?php  if ( isset($_REQUEST['meeting-month']) && isset($_REQUEST['meeting-year'])) { ?>
		<?php get_template_part( 'parts/meetings-page/your', 'meetings' ); ?>
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
