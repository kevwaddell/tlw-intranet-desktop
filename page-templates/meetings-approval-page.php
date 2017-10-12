<?php
/*
Template Name: Meetings approval page
*/
?>
<?php 
if (!isset($_GET['meeting-actions'])) {
$meetings_page = get_page_by_path('meetings');
wp_redirect(get_permalink($meetings_page->ID));
} 
?>

<?php get_header(); ?>
<?php  
$meeting = get_post($_GET['meeting-id']);
$booked_by = $meeting->post_author;
$booked_by_fname = get_user_meta($booked_by, 'first_name', true);
$booked_by_lname = get_user_meta($booked_by, 'last_name', true);
$locations = wp_get_post_terms( $meeting->ID, 'tlw_rooms_tax');
$current_location = $locations[0];
$meeting_description = get_field('meeting_description', $meeting->ID);
$meeting_date = strtotime(get_field( 'meeting_date', $meeting->ID ));
$start_time = get_field( 'start_time', $meeting->ID);
$end_time = get_field( 'end_time', $meeting->ID);

$contacts_pg = get_page_by_path('contacts');
//debug($meeting);	
?>
<?php if ( have_posts() ): while ( have_posts() ) : the_post(); ?>	

	<article <?php post_class('no-sbs'); ?>>
		<div class="container">
			<div class="row">
				<div class="col-xs-8 col-xs-offset-2">
				<div class="text-center">
				<i class="meeting-icon fa fa-calendar-plus-o fa-4x"></i>	
				<h1>Meeting approval</h1>
				<div class="alert alert-info"><?php the_content(); ?></div>
				</div>
				<div class="rule"></div>
				<table class="table table-striped">
					<tbody>
						<tr>
							<td class="bold text-right">Meeting</td>
							<td><?php echo get_the_title( $meeting->ID ); ?></td>
						</tr>
						<tr>
							<td class="bold text-right">Booked by</td>
							<td><a href="<?php echo get_permalink($contacts_pg->ID); ?>?id=<?php echo $booked_by; ?>&contacts=team#contact-id-<?php echo $booked_by; ?>"><?php echo $booked_by_fname; ?> <?php echo $booked_by_lname; ?></a></td>
						</tr>
						<tr>
							<td class="bold text-right">Location</td>
							<td><?php echo $current_location->name; ?></td>
						</tr>
						<?php if (!empty($meeting_description)) { ?>
						<tr>
							<td class="bold text-right">Description</td>
							<td><?php echo $meeting_description; ?></td>
						</tr>			
						<?php } ?>
						<tr>
							<td class="bold text-right">Date/time</td>
							<td><?php echo date('l - jS F - Y', $meeting_date); ?> @ <?php echo $start_time; ?> - <?php echo $end_time; ?></td>
						</tr>
					</tbody>
				</table>	
				<table class="table">
					<tbody>
						<tr>
							<td width="50%">
								<a href="?meeting-actions=meeting-approval&status=accept&meeting-id=<?php echo $_GET['meeting-id']; ?>&user-id=<?php echo $_GET['user-id']; ?>" class="btn btn-success btn-block btn-lg"><i class="fa fa-check fa-lg pull-left"></i>Accept</a>
							</td>
							<td>
								<a href="?meeting-actions=meeting-approval&status=reject&meeting-id=<?php echo $_GET['meeting-id']; ?>&user-id=<?php echo $_GET['user-id']; ?>" class="btn btn-danger btn-block btn-lg"><i class="fa fa-times fa-lg pull-left"></i>Reject</a>
							</td>
						</tr>
					</tbody> 
				</table>
				</div>
			</div>
		</div>
	</article>
		
<?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>
