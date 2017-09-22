<?php get_header(); ?>

<?php if ( have_posts() ): while ( have_posts() ) : the_post(); ?>	

<?php include (STYLESHEETPATH . '/_/inc/meeting-single/meeting-vars.php'); ?>
	
		<article <?php post_class('page'); ?>>
			<h1 class="block-header<?php echo (!empty($color)) ? " col-".$color:""; ?>"><?php if (!empty($icon)) {  echo '<i class="fa '.$icon.' fa-lg"></i>'; }?>Meeting details</h1>
			
			<div class="action-btns<?php echo (!empty($color)) ? " col-".$color:""; ?>">
				<div class="row">
					<div class="col-xs-6">
						<a href="<?php echo get_permalink($meetings->ID); ?>" class="btn btn-default btn-block no-arrow"><i class="fa fa-angle-double-left fa-lg"></i>Back to <?php echo $meetings->post_title; ?></a>		
					</div>	
					<div class="col-xs-6">
						<a href="<?php echo get_permalink($ical_page->ID); ?>?meetingid=<?php echo get_the_ID(); ?>" class="btn btn-default btn-block"><i class="fa fa-calendar fa-lg"></i>Add to calendar</a>
					</div>
				</div>	
			</div>
			
			<div class="rule"></div>
			
			<div class="row">
				<div class="col-xs-11">
			
					<?php include (STYLESHEETPATH . '/_/inc/meeting-single/meeting-details.php'); ?>	
					
				</div>
				
				<div class="col-xs-1">
					<?php include (STYLESHEETPATH . '/_/inc/meeting-single/user-actions.php'); ?>	
				</div>
			
			</div>

			<div class="rule"></div>
			
			<!-- EXTERNAL REQUEST ALERTS -->
			<?php if (isset($_GET['user_request']) && $_GET['user_request'] == "user_approval") { ?>
	
			<?php include (STYLESHEETPATH . '/_/inc/meeting-single/notifications/external-alerts.php'); ?>
	
			<div class="rule"></div>

			<?php } ?>

			
			<!-- REQUEST AND ACTION ALERTS -->
			<div class="alerts">
				<?php include (STYLESHEETPATH . '/_/inc/meeting-single/notifications/alerts.php'); ?>
			</div>
			
			<section id="attendees-section" class="page-section">
			
				<div class="lists-wrap">
				
				<?php include (STYLESHEETPATH . '/_/inc/meeting-single/data-list-vars.php'); ?>

					<h3 class="section-header"><i class="fa fa-group fa-lg"></i> Attendees</h3>
					
					<!-- DATA KEY -->
					<?php include (STYLESHEETPATH . '/_/inc/meeting-single/data-list-key.php'); ?>	
					
					<?php if ( $total_int > 0 || $total_ext > 0 ) { ?>
					<?php include (STYLESHEETPATH . '/_/inc/meeting-single/internal-attendees.php'); ?>	
				
					<?php include (STYLESHEETPATH . '/_/inc/meeting-single/external-attendees.php'); ?>	
					<?php } else { ?>
					<div class="well text-center">
						There are no attendees at the moment.
					</div>	
					<?php } ?>
				
				</div>
				
			</section>
			
			<div class="rule"></div>
			
			<?php include (STYLESHEETPATH . '/_/inc/meeting-single/btn-actions.php'); ?>	

		</article>
		
<?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>
