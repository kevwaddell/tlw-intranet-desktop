<?php
/*
Template Name: Holidays page
*/
?>
<?php
$timeZone = 'Europe/London';
global $current_user;
$add_holiday_errors = array();
$number_of_holidays = get_user_meta($current_user->ID, 'number_of_days', true);
$days_remaining = $number_of_holidays;
$user_holidays_raw = get_user_meta($current_user->ID, 'holidays_'.date('Y'), true);

if (empty($user_holdays_raw)) {
$user_holidays = array();
add_user_meta($current_user->ID, 'holidays_'.date('Y'), serialize($user_holidays), true);	
$user_holidays_raw = get_user_meta($current_user->ID, 'holidays_'.date('Y'), true);	
}	

$user_holidays = unserialize($user_holidays_raw);
$now_dateTime = new DateTime("now", new DateTimeZone($timeZone));

//debug($number_of_days);

include (STYLESHEETPATH . '/app/inc/holidays-page-vars/add-holiday.inc');
if (!empty($user_holidays)) {
	foreach ($user_holidays as $u_hol) {
	$days_remaining = $days_remaining - $u_hol['no-days'];
	}			
}
?>

<?php get_header(); ?>
	
<?php if ( have_posts() ): while ( have_posts() ) : the_post(); ?>	
	
	<article id="<?php echo $post->post_name; ?>-page" <?php post_class('fl-wth'); ?>>
		<div class="entry no-side-pad">
			<div class="container">
				<?php if (empty($user_holidays) && date('n') >= 6) { ?>
				<div class="alert alert-info text-center">
					<h3>Keep your holidays upto date!</h3>
					<p>You have no holidays added for <?php echo date("Y"); ?>.<br>
					Please add any previously approved holidays.</p>
				</div>
				<?php } ?>
				
			<?php get_template_part( 'parts/holidays-page/holiday', 'alerts' ); ?>
			
			<?php get_template_part( 'parts/holidays-page/request', 'form' ); ?>
			
			<?php get_template_part( 'parts/holidays-page/holidays', 'list' ); ?>
			
			</div>
		</div>
	</article>
		
<?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>