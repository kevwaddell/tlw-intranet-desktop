<?php
/*
Template Name: Reminders page
*/
?>

<?php
global $current_user;
$timeZone = 'Europe/London';
$date_format = get_option('date_format');
$time_format = get_option('time_format');
$reminder_groups_raw = get_user_meta($current_user->ID, 'reminder_groups', true);	
$reminders_completed_raw = get_user_meta($current_user->ID, 'reminders_completed', true);

if (empty($reminder_groups_raw)) {
$reminder_groups = array();
add_user_meta($current_user->ID, 'reminder_groups', serialize($reminder_groups),true);	
$reminder_groups_raw = get_user_meta($current_user->ID, 'reminder_groups', true);	
}	

$reminder_groups = unserialize($reminder_groups_raw);

if (empty($reminders_completed_raw)) {
$reminders_completed = array();
add_user_meta($current_user->ID, 'reminders_completed', serialize($reminders_completed),true);	
$reminders_completed_raw = get_user_meta($current_user->ID, 'reminders_completed', true);	
}	

$reminders_completed = unserialize($reminders_completed_raw);

include (STYLESHEETPATH . '/app/inc/reminders-page-vars/add-group.inc');
include (STYLESHEETPATH . '/app/inc/reminders-page-vars/update-group.inc');
include (STYLESHEETPATH . '/app/inc/reminders-page-vars/delete-group.inc');
include (STYLESHEETPATH . '/app/inc/reminders-page-vars/add-reminder.inc');
include (STYLESHEETPATH . '/app/inc/reminders-page-vars/update-reminder.inc');
include (STYLESHEETPATH . '/app/inc/reminders-page-vars/delete-reminder.inc');
include (STYLESHEETPATH . '/app/inc/reminders-page-vars/remind-later.inc');
include (STYLESHEETPATH . '/app/inc/reminders-page-vars/clear-completed.inc');

if (isset($_REQUEST['group-id'])) {
$current_group = $_REQUEST['group-id'];		
} else {
$current_group = 'scheduled';		
}
?>
<?php get_header(); ?>
	
<?php if ( have_posts() ): while ( have_posts() ) : the_post(); ?>	
	
	<article id="<?php echo $post->post_name; ?>-page" <?php post_class('sb-wide'); ?>>
		<div class="entry">
			<?php  get_template_part( 'parts/reminders-page/reminders', 'info' ); ?>
		</div>
	</article>
	
	<aside class="scrollable sb-ex-wide">
		<div class="sb-inner">
			<ul class="reminder-types-list list-unstyled">
				<li<?php echo ($current_group == 'scheduled') ? ' class="active"': ''; ?>><a href="?group-id=scheduled"><i class="fa fa-clock-o fa-2x"></i> Scheduled</a></li>
				<li<?php echo ($current_group == 'meeting') ? ' class="active"': ''; ?>><a href="?group-id=meeting"><i class="fa fa-calendar-check-o fa-2x"></i> Meetings</a></li>
				<?php if (!empty($reminder_groups)) { ?>
				<?php foreach ($reminder_groups as $group) { ?>
				<li class="col-<?php echo $group['color']; ?><?php echo ($current_group == $group['group-id']) ? ' active': ''; ?>">
					<a href="?group-id=<?php echo $group['group-id']; ?>"><i class="fa fa-dot-circle-o fa-2x"></i> <?php echo $group['title']; ?></a>
				</li>
				<?php } ?>			
				<?php } ?>
			</ul>
		</div>
		<div class="sb-actions">
			<a href="?reminder-actions=add-group&group-id=<?php echo rand(1000,9999); ?>" class="btn btn-default btn-lg no-rounded pull-right" type="button">
				<i class="fa fa-plus fa-lg"></i>
			</a>
		</div>
	</aside>	
		
<?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>