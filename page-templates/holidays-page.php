<?php
/*
Template Name: Holidays page
*/
?>
<?php
$timeZone = 'Europe/London';
global $current_user;
$max_hols = 28;
$now_dateTime = new DateTime("now", new DateTimeZone($timeZone));
$current_year = $now_dateTime->format('Y');
$xmas_start = get_field( 'xmas_start_date', 'options' );
$xmas_end = get_field( 'xmas_end_date', 'options' );
$xmas_no_days = get_field( 'xmas_num_days', 'options' );
$add_holiday_errors = array();
if ($_REQUEST['holiday-actions'] == 'next-year') {
$current_year = $now_dateTime->add(new DateInterval('P1Y'))->format('Y');
}
$number_of_holidays = get_user_meta($current_user->ID, 'number_of_days', true);
$days_remaining = $number_of_holidays;
$user_holidays_raw = get_user_meta($current_user->ID, 'holidays_'.$current_year, true);
$user_holidays_nextY_raw = get_user_meta($current_user->ID,  'holidays_'.date('Y', strtotime('next year')), true);
$user_holidays_lastY_raw = get_user_meta($current_user->ID,  'holidays_'.date('Y', strtotime('last year')), true);

if (!empty($xmas_no_days) && date("Y", strtotime($xmas_start)) == $current_year) {
$days_remaining = $days_remaining - $xmas_no_days;	
}

if ($current_year > date('Y') && $number_of_holidays < $max_hols) {
$days_remaining = $days_remaining++;	
}

if (empty($user_holdays_raw)) {
$user_holidays = array();
add_user_meta($current_user->ID, 'holidays_'.date('Y'), serialize($user_holidays), true);	
$user_holidays_raw = get_user_meta($current_user->ID, 'holidays_'.date('Y'), true);	
}	

if (empty($user_holidays_nextY_raw)) {
$user_holidays_nextY = array();
add_user_meta($current_user->ID, 'holidays_'.date('Y', strtotime('next year')), serialize($user_holidays_nextY), true);	
$user_holidays_nextY_raw = get_user_meta($current_user->ID, 'holidays_'.date('Y', strtotime('next year')), true);	
}	

$user_holidays = unserialize($user_holidays_raw);

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
				
			<?php get_template_part( 'parts/holidays-page/holiday', 'alerts' ); ?>
			
			<?php if ($_REQUEST['holiday-actions'] == 'add-holiday' || $_REQUEST['holiday-actions'] == 'request-holiday' || $_REQUEST['holiday-actions'] == 'edit-holiday' || !empty($add_holiday_errors)) { ?>
			<?php get_template_part( 'parts/holidays-page/request', 'form' ); ?>
			<?php } ?>
			
			<?php get_template_part( 'parts/holidays-page/holiday', 'actions' ); ?>
			
			<?php get_template_part( 'parts/holidays-page/holidays', 'list' ); ?>
			
			</div>
		</div>
	</article>
		
<?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>