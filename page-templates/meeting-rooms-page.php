<?php
/*
Template Name: Meeting rooms page
*/
?>
<?php get_header(); ?>

<?php if ( have_posts() ): while ( have_posts() ) : the_post(); ?>		

	<?php
	$color = get_field('col');
	$icon = get_field('icon');
	$rooms = get_terms('tlw_rooms_tax');
	$meetings = get_page_by_title('Meetings');
	$rb_admin = get_field('rb_admin', 'options');
	//echo '<pre>';print_r($rooms);echo '</pre>';
	 ?>
			<article <?php post_class(); ?>>
				<h1 class="block-header<?php echo (!empty($color)) ? " col-".$color:""; ?>"><?php if (!empty($icon)) {  echo '<i class="fa '.$icon.' fa-lg"></i>'; }?><?php the_title(); ?></h1>
				<?php the_content(); ?>
				
				<div class="rule"></div>
				
				<div class="alerts alerts-off">
					<div class="alerts-wrap">
					<!-- NOTIFICATION ALERTS -->
					<?php include (STYLESHEETPATH . '/_/inc/meeting-rooms/notifications/add-meeting-request.php'); ?>
					<?php include (STYLESHEETPATH . '/_/inc/meeting-rooms/notifications/add-meeting-action.php'); ?>
					<?php include (STYLESHEETPATH . '/_/inc/meeting-rooms/notifications/add-meeting-approval.php'); ?>
					<!-- NOTIFICATION ALERTS -->
					</div>
				</div>
								
				<div class="action-btns<?php echo (!empty($color)) ? " col-".$color:""; ?>">
					<div class="row">
						<div class="col-xs-6">
						<?php if (is_user_logged_in()) { 
						$user_ID = get_current_user_id();	
						?>
						<a href="<?php the_permalink(); ?>?request=room_booking&userid=<?php echo $user_ID ; ?>" class="btn btn-default btn-block btn-action"><i class="fa fa-check fa-lg"></i>Book a meeting room</a>
						<?php } else { ?>
						<a href="#log-in-alert" class="btn btn-default btn-block" data-toggle="modal"><i class="fa fa-check fa-lg"></i>Book a meeting room</a>
						<?php } ?>
						</div>
						
						<div class="col-xs-6">
							<a href="<?php echo get_permalink($meetings->ID); ?>" class="btn btn-default btn-block"><i class="fa fa-calendar fa-lg"></i>View Meetings</a>
						</div>
					</div>
				</div>
				
				<div class="rule"></div>
				
				<section id="rooms-list" class="page-section">
					<h3 class="section-header"><i class="fa fa-info-circle fa-lg"></i>Room details</h3>
					
					<div class="row">
					
					<?php foreach ($rooms as $room) { 
						$capacity = get_field('capacity', $room->taxonomy.'_'.$room->term_id);
						$location = get_field('location', $room->taxonomy.'_'.$room->term_id);
					?>
					
						<div class="col-xs-4">
							<div class="room-details">
								<figure class="img"><img src="http://www.abbeyoffices.com/_images/assets/locations/image-gallery-full/Meeting-room_8.jpg" width="100%"></figure>
								<h4><?php echo $room->name; ?></h4>
								<div class="info">
									<p><span>Max Capacity:</span> <?php echo $capacity; ?></p>
									<p><span>Location:</span> <?php echo $location; ?></p>
								</div>
								<div class="txt"><?php echo $room->description; ?></div>
								
								<div class="feed-head">Today's availability</div>
								<div class="panel-feed">
									<div class="panel-feed-wrap">
									<ul class="list-unstyled">
										<li>
											<p class="time"><span>Time:</span> 09:00am - 10:30pm</p>	
											<p class="title"><span>Meeting:</span> Professional Negligence Team Meeting</p>
											<p class="name"><span>Booked by:</span> Sarah Spruce</p>
										</li>
										<li>
											<p class="time"><span>Time:</span> 11:00am - 12:30pm</p>	
											<p class="title"><span>Meeting:</span> Centre Team Meeting</p>
											<p class="name"><span>Booked by:</span> Peter Stephenson</p>
										</li>
										<li>
											<p class="time"><span>Time:</span> 01:00pm - 02:30pm</p>	
											<p class="title"><span>Meeting:</span> Marketing meeting</p>
											<p class="name"><span>Booked by:</span> Laura Brown</p>
										</li>
									</ul>
									</div>
								</div>
								
							</div>
						</div>
					
					<?php } ?>
					
					</div>
					
				</section>
				
			</article>
			
		
<?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>
