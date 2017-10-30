<?php
/*
Template Name: Holidays page
*/
?>
<?php
$timeZone = 'Europe/London';
global $current_user;
$number_of_days = get_field('number_of_days', $current_user->ID);
$user_holidays_raw = get_user_meta($current_user->ID, 'holidays_'.date('Y'), true);

if (empty($user_holdays_raw)) {
$user_holidays = array();
add_user_meta($current_user->ID, 'holidays_'.date('Y'), serialize($user_holidays), true);	
$user_holidays_raw = get_user_meta($current_user->ID, 'holidays_'.date('Y'), true);	
}	

$user_holidays = unserialize($user_holidays_raw);
$now_dateTime = new DateTime("now", new DateTimeZone($timeZone));

debug($user_holidays);
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
				<div class="request-form">
				<form action="<?php the_permalink(); ?>" method="post">
					<table class="table table-striped">
						<thead>
							<tr>
								<th colspan="3"><h3>Add/request a holiday</h3></th>
							</tr>	
						</thead>
						<tbody>
							<tr>
								<th>Date booked</th>
								<th>From</th>
								<th>To</th>
							</tr>	
							<tr>
								<td>
									<div class="input-group date" id="h-date-bookded-datepicker">
										<input type="text" class="form-control input-sm" name="date-booked" value="<?php echo $now_dateTime->format('l jS F, Y'); ?>">
										<span class="input-group-addon"><span class="fa fa-calendar"></span></span>
									</div>
								</td>
								<td>
									<div class="input-group date" id="h-date-from-datepicker">
										<input type="text" class="form-control input-sm" name="date-from" value="<?php echo $now_dateTime->format('l jS F, Y'); ?>">
										<span class="input-group-addon"><span class="fa fa-calendar"></span></span>
									</div>
								</td>
								<td>
									<div class="input-group date" id="h-date-to-datepicker">
										<input type="text" class="form-control input-sm" name="date-to" value="<?php echo $now_dateTime->format('l jS F, Y'); ?>">
										<span class="input-group-addon"><span class="fa fa-calendar"></span></span>
									</div>
								</td>
							</tr>
							<tr>
								<th>No of days requested</th>
								<th>No of days remaining</th>
								<th>Approval needed</th>
							</tr>	
							<tr>
								<td></td>
								<td></td>
								<td>
									<div class="form-group">
										<input id="approval-toggle" type="checkbox" data-toggle="toggle" data-onstyle="success" data-width="100" data-size="mini" data-on="Yes" data-off="No" name="approval" value="yes">
									</div>
								</td>
							</tr>
						</tbody>
					</table>									
				</form>
				
				</div>
			</div>
		</div>
	</article>
		
<?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>