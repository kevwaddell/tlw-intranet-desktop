<?php
/*
Template Name: Calendar page
*/
?>
<?php
if (isset($_REQUEST['calendar-view'])) {
$current_view = $_REQUEST['calendar-view'];	
} else {
$current_view = 'month';	
}
if (isset($_REQUEST['month-actions'])) {
$current_month = $_REQUEST['month-actions'];	
} else {
$current_month = 'this-month';	
}
if (isset($_REQUEST['week-actions'])) {
$current_week = $_REQUEST['week-actions'];	
} else {
$current_week = 'this-week';	
}
if (isset($_REQUEST['day-actions'])) {
$current_day = $_REQUEST['day-actions'];	
} else {
$current_day = 'today';	
}
?>
<?php get_header(); ?>

<?php if ( have_posts() ): while ( have_posts() ) : the_post(); ?>	

<article id="<?php echo $post->post_name; ?>-page" <?php post_class('fl-wth'); ?>>
	<div class="entry">
		<div id="calendar-wrapper">
			<div class="calendar-inner">
				
				<?php  get_template_part( 'parts/calendar-page/calendar', 'views' ); ?>
				
			</div>
		</div>

	</div>				
</article>
		
<?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>
