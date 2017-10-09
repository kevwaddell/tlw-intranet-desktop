<?php
/*
Template Name: Meetings page
*/
?>

<?php get_header(); ?>

<?php  
$locations = get_terms('tlw_rooms_tax', 'hide_empty=0');
$first_meeting_post = get_posts(array('posts_per_page' => 1, 'post_type' => 'tlw_meeting', 'orderby' => 'date', 'order' => 'ASC')); 
$add_meeting_errors = array();
$excluded_users = array(1, 60, 69);

$users_args = array(
'exclude'	=> $excluded_users,
'meta_key' => 'last_name',
'orderby'	=> 'meta_value'
);
$all_users = get_users($users_args);
//echo '<pre class="debug">';print_r($all_users);echo '</pre>';

include (STYLESHEETPATH . '/app/inc/meetings-page-vars/add-meeting.inc');
?>

<article <?php post_class('page'); ?>>
	<div class="entry">
		<?php if ( isset($_REQUEST['meeting-id']) ) { ?>
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
		<div class="locations">
		  <?php foreach ($locations as $location) { ?>
			<a href="?location-id=<?php echo $location->term_id; ?>" class="location-item<?php echo ($_REQUEST['location-id'] == $location->term_id) ? ' active':'' ?>"><?php echo $location->name; ?></a>
		  <?php } ?>
		  <?php if (strtotime($first_meeting_post[0]->post_date) < strtotime("Now")) { 
			$year_x = date("Y", strtotime($first_meeting_post[0]->post_date));
			$now_year = date("Y");
		  ?>
		   <h3>Meeting archives</h3>
		   <?php while ($now_year >= $year_x) { ?>
		   <a href="?location-id=0&meeting-year=<?php echo $now_year; ?>" class="location-item<?php echo ($_REQUEST['meeting-year'] == $now_year) ? ' active':'' ?>"><?php echo $now_year; ?></a>
		   <?php $now_year--; ?>
		   <?php } ?>
		   
		  <?php } ?>
		 </div>
	</div>
</aside>

<aside id="meetings-list" class="scrollable sb-right">
	<div class="sb-inner">
		<?php  if ( isset($_REQUEST['location-id']) ) { ?>
		<?php get_template_part( 'parts/meetings-page/meetings', 'list' ); ?>
		<?php } ?>		
		
		<?php if ( empty($_REQUEST)) { ?>
		<div class="no-name-message text-center">
			<i class="fa fa-group fa-4x block"></i>
			Select a location or year
		</div>
		<?php } ?>	

	</div>
	<div class="sb-actions">
		<div class="actions-inner">
		<?php if (isset($_REQUEST['location-id']) && $_REQUEST['location-id'] != 0) { ?>
			<a href="?meeting-actions=add-meeting<?php echo (isset($_REQUEST['location-id'])) ? '&location-id='.$_REQUEST['location-id']:''; ?>" class="btn btn-default btn-lg no-rounded pull-right" id="add-meeting"><i class="fa fa-plus fa-lg"></i><span class="sr-only">Book room</span></a>
			<?php } ?>	
		</div>
	</div>
</aside>

<?php get_footer(); ?>
