<?php
/*
Template Name: Meetings page
*/
?>

<?php get_header(); ?>

<?php 
$current_user_ID = get_current_user_id();
$meetings = get_page_by_title('Meetings');
$calendar = get_page_by_title('Calendar');
$meetings_page_content_raw = $meetings->post_content;
$meetings_page_content = apply_filters('the_content', $meetings_page_content_raw );
$icon = get_field('icon', $meetings->ID);
$color = get_field('col', $meetings->ID);
$today = date('Ymd');
$today_start = strtotime("Today 08:00");
$today_end = strtotime("Today 18:00");
$rooms = get_terms('tlw_rooms_tax', 'hide_empty=0');
$rb_admin = get_field('rb_admin', 'options');
$ical_page = get_page_by_title("Cal feed");
$ical_page_split_url = explode('http://', get_permalink($ical_page->ID));
/*
echo '<pre>';
print_r($today_start."<br>");
print_r(date("D jS F Y H:i", $today_start)."<br><br>");
echo '</pre>';
*/
//echo '<pre>';print_r($rb_admin['user_email']);echo '</pre>';
?>


<article <?php post_class('page'); ?>>
	
	<?php if ( have_posts() ): while ( have_posts() ) : the_post(); ?>	
	
	<h1 class="block-header<?php echo (!empty($color)) ? " col-".$color:""; ?>"><?php if (!empty($icon)) {  echo '<i class="fa '.$icon.' fa-lg"></i>'; }?><?php echo $meetings->post_title; ?></h1>
	
	<?php get_template_part( 'parts/meeting-rooms/banner', 'imgs' ); ?>

	<?php if (!empty($meetings_page_content)) { ?>
	<?php echo $meetings_page_content ; ?>
	<?php } ?>
	
	<?php endwhile; ?>
	<?php endif; ?>

	<div class="rule"></div>
	
	<?php include (STYLESHEETPATH . '/_/inc/meeting-rooms/btn-actions.php'); ?>								
						
	<div class="rule"></div>
	
	<?php if (isset($_GET['admin_request']) && $_GET['admin_request'] == "booking_request") { ?>
	
	<?php get_template_part( 'parts/admin/notifications/meeting', 'request' ); ?>
	
	<div class="rule"></div>

	<?php } ?>
	
	<!-- REQUEST AND ACTION ALERTS -->
	<div class="alerts">
		<?php get_template_part( 'parts/meeting-rooms/notifications/all', 'alerts' ); ?>
	</div>
	
	<section class="page-section">
		<div class="lists-wrap">
			
			<?php get_template_part( 'parts/meeting-rooms/list', 'query' ); ?>
			<!-- MEETINGS SECTION -->
			<?php get_template_part( 'parts/meeting-rooms/meeting', 'list' ); ?>
			<!-- MEETINGS SECTION END -->
			
			</div>
	</section>
	
	

</article>

<?php get_footer(); ?>
