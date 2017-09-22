<?php
/*
Template Name: Holiday request page
*/
?>

<?php get_header(); ?>

<?php if ( have_posts() ): while ( have_posts() ) : the_post(); ?>	

<?php 
$calendar = get_page_by_title("Holidays Calendar");
$current_user_ID = get_current_user_id();
$icon = get_field('icon', $meetings->ID);
$color = get_field('col', $meetings->ID);
$rb_admin = get_field('rb_admin', 'options');
$hb_admin = get_field('hb_admin', 'options');
$ical_page = get_page_by_title("Holidays Cal Feed");
$ical_page_split_url = explode('http://', get_permalink($ical_page->ID));
//echo '<pre>';print_r($hb_admin['ID']);echo '</pre>';
?>	
		<article <?php post_class(); ?>>
			<h1 class="block-header<?php echo (!empty($color)) ? " col-".$color:" col-gray"; ?>"><?php if (!empty($icon)) {  echo '<i class="fa '.$icon.' fa-lg"></i>'; }?><?php the_title(); ?></h1>
			
			<?php include (STYLESHEETPATH . '/_/inc/holiday-request/banner-imgs.php'); ?>
			
			<?php the_content(); ?>
			
			<div class="rule"></div>
			
			<!-- ACTION BUTTONS -->
			<?php include (STYLESHEETPATH . '/_/inc/holiday-request/action-btns.php'); ?>
						
			<div class="rule"></div>
			<!-- ADMIN ALERTS -->
			<?php include (STYLESHEETPATH . '/_/inc/admin/notifications/holiday-alerts.php'); ?>
			
			<!-- REQUEST AND ACTION ALERTS -->
			<div class="alerts">
			<?php include (STYLESHEETPATH . '/_/inc/holiday-request/notifications/alerts.php'); ?>				
			</div>
			
			<section class="page-section">
				<div class="lists-wrap">
					
					<?php include (STYLESHEETPATH . '/_/inc/holiday-request/data-list-query.php'); ?>
					
					<?php if ( !isset($_GET['admin_request']) ) { ?>
					
					<?php if ( $current_user_ID == $hb_admin['ID'] || current_user_can("administrator") ) { ?>
					<!-- PENDING HOLIDAYS -->
					<?php include (STYLESHEETPATH . '/_/inc/holiday-request/pending-holidays-list.php'); ?>
					<!-- PENDING HOLIDAYS END -->
					<?php } ?>
					
					<?php } ?>
					
					<!-- OUT OF OFFICE SECTION -->
					<?php include (STYLESHEETPATH . '/_/inc/holiday-request/out-of-office-list.php'); ?>
					<!-- OUT OF OFFICE SECTION END -->
					
				</div>
			</section>


		</article>
		
<?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>
