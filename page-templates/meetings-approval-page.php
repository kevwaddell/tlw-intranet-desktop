<?php
/*
Template Name: Meetings approval page
*/
?>
<?php 
$meetings_page = get_page_by_path('meetings');
$ical_pg = get_page_by_path( 'meetings/single-ical-event');
if (!isset($_GET['meeting-actions'])) {
wp_redirect(get_permalink($meetings_page->ID));
} 
?>
<?php get_header(); ?>
<?php  
$pg_icon = get_field( 'icon');
$meeting = get_post($_REQUEST['meeting-id']);
$booked_by = $meeting->post_author;
$booked_by_fname = get_user_meta($booked_by, 'first_name', true);
$booked_by_lname = get_user_meta($booked_by, 'last_name', true);
$user_fname = get_user_meta( $_REQUEST['user-id'], 'first_name', true );
$locations = wp_get_post_terms( $meeting->ID, 'tlw_rooms_tax');
$current_location = $locations[0];
$meeting_description = get_field('meeting_description', $meeting->ID);
$meeting_date = strtotime(get_field( 'meeting_date', $meeting->ID ));
$start_time = get_field( 'start_time', $meeting->ID);
$end_time = get_field( 'end_time', $meeting->ID);
$attendees_staff = get_field('attendees_staff',  $_REQUEST['meeting-id']);

$contacts_pg = get_page_by_path('contacts');

if (isset($_POST['send-comment'])) {
	//debug($_POST);
	$attendee_removed = false;
	$comment = trim($_POST['meeting-comment']);
	$meeting_title = get_the_title( $_REQUEST['meeting-id'] );
	$user_lname = get_user_meta( $_REQUEST['user-id'], 'last_name', true );
	$m_user = get_user_by( 'id', $_REQUEST['user-id'] );
	$from_email = $m_user->data->user_email;
	
	foreach ($attendees_staff as $k => $staff) {
		if ($staff['attendee']['ID'] == $_REQUEST['user-id']) {
			unset($attendees_staff[$k]);
		}	
	}
	
	$attendee_staff_key = acf_get_field_key('attendees_staff', $_REQUEST['meeting-id']);
	
	update_field( $attendee_staff_key, $attendees_staff, $_REQUEST['meeting-id'] );
	$attendee_removed = true;
	
	if ($attendee_removed) {
	$subject = "Meeting attendance request";
	$message = "<div style=\"text-align: center;\">";
	$message .= "<h1 style=\"font-size:25px; line-height: 30px;\">Sorry <font style=\"color: red;\">$booked_by_fname</font> I can not attend your meeting</h1>";
	$message .= "<p style=\"font-size:16px; line-height: 20px;\"><font style=\"color: red; font-weight: bold;\">$user_fname $user_lname</font> can not attend the meeting<br><font style=\"color: red; font-weight: bold;\">$meeting_title</font> on<br><font style=\"color: red; font-weight: bold;\">".date('l - jS F - Y', $meeting_date)."</font> at <font style=\"color: red; font-weight: bold;\">".$start_time."</font></p>";
	$message .= "</div>";
	if (!empty($comment)) {
	$message .= "<div style=\"padding: 10px 20px 10px 20px; border: 1px solid black;\">";
	$message .= "<p style=\"font-size:16px; line-height: 20px;\"><strong>Brief reason/description: </strong><br>$comment</p>";
	$message .= "</div>";
	}
	$headers = array();
	$headers[] = "Content-Type: text/html; charset=UTF-8";
	$headers[] = "From: $user_fname $user_lname <$from_email>";
	$headers[] = "Reply-To: $user_fname $user_lname <$from_email>";
	
	//debug($message);
	if ($_SERVER[SERVER_ADMIN] == "home-laptop@localhost") {
	$reject_email_sent = wp_mail( "kevwaddell@mac.com", $subject, $message, $headers );	
	} else {
	$reject_email_sent = wp_mail( "kwaddell@tlwsolicitors.co.uk", $subject, $message, $headers );	
	}
	
	}
}
if ($_REQUEST['status'] == 'accepted') {
	//debug($_POST);
	$status_updated = false;
	$meeting_title = get_the_title( $_REQUEST['meeting-id'] );
	$user_lname = get_user_meta( $_REQUEST['user-id'], 'last_name', true );
	$m_user = get_user_by( 'id', $_REQUEST['user-id'] );
	$from_email = $m_user->data->user_email;
	
	foreach ($attendees_staff as $k => $staff) {
		if ($staff['attendee']['ID'] == $_REQUEST['user-id']) {
		$attendees_staff[$k]['status'] = $_REQUEST['status'];	
		}	
	}
	
	$attendee_staff_key = acf_get_field_key('attendees_staff', $_REQUEST['meeting-id']);
	
	update_field( $attendee_staff_key, $attendees_staff, $_REQUEST['meeting-id'] );
	$status_updated = true;
	//debug($status_updated);
	if ($status_updated) {	
	$subject = "Meeting attendance request";
	$message = "<div style=\"text-align: center;\">";
	$message .= "<h1 style=\"font-size:25px; line-height: 30px;\">Your request has been <font style=\"color: red;\"><strong>accepted</strong></font></h1>";
	$message .= "<p style=\"font-size:16px; line-height: 20px;\"><font style=\"color: red;\"><strong>$user_fname $user_lname</strong></font> has accepted your invitation to attend the meeting<br>
	<font style=\"color: red;\"><strong>$meeting_title</strong></font> on <font style=\"color: red;\"><strong>".date('l - jS F - Y', $meeting_date)."</strong></font> at <font style=\"color: red;\"><strong>".$start_time."</strong></font></p>";
	$message .= "</div>";
	$headers = array();
	$headers[] = "Content-Type: text/html; charset=UTF-8";
	$headers[] = "From: $user_fname $user_lname <$from_email>";
	$headers[] = "Reply-To: $user_fname $user_lname <$from_email>";
	//$accept_email_sent = true;
	
	//debug($message);
		if ($_SERVER[SERVER_ADMIN] == "home-laptop@localhost") {
			$accepted_email_sent = wp_mail( "kevwaddell@mac.com", $subject, $message, $headers );
		} else {
			$accepted_email_sent = wp_mail( "webmaster@tlwsolicitors.co.uk", $subject, $message, $headers );	
		}	
	}
}
//debug($meeting);	
?>
<?php if ( have_posts() ): while ( have_posts() ) : the_post(); ?>	

	<article <?php post_class('no-sbs'); ?>>
		<div class="container">
			<div class="row">
				<div class="col-xs-8 col-xs-offset-2">
				<div class="text-center">
				<i class="meeting-icon fa <?php echo $pg_icon; ?> fa-4x"></i>	
				<h1>Meeting approval</h1>
				<?php if (isset($_REQUEST['status']) || isset($_POST['send-comment'])) { ?>
				
				<?php if ($accepted_email_sent) { ?>
				<div class="alert alert-success">
					<h3>Thank you <?php echo $user_fname; ?></h3>
					<p>A notification has been sent to <span class="bold"><?php echo $booked_by_fname; ?> <?php echo $booked_by_lname; ?></span>.</p>
					<p>Please add the meeting to your calendar using the <span class="bold">Add to calendar</span> button.</p>
				</div>	
				<?php } ?>
				
				<?php if ($_REQUEST['status'] == 'reject') { ?>
				<div class="alert alert-info">
					<h3><?php echo $user_fname; ?> you have rejected the request</h3>
					<p>Please can you give a brief description of why you can not attend the meeting.</p>
				</div>	
				<?php } ?>
				<?php if ($reject_email_sent) { ?>
				<div class="alert alert-success">
					<h3>Thank you <?php echo $user_fname; ?></h3>
					<p>A notification has been sent to <span class="bold"><?php echo $booked_by_fname; ?> <?php echo $booked_by_lname; ?></span>.</p>
				</div>	
				<?php } ?>
				<?php } else { ?>
				<h2 class="col-red-mid">Hello <?php echo $user_fname; ?></h2>			
				<div class="alert alert-info"><?php the_content(); ?></div>
				<?php } ?>
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
						<?php if ($accepted_email_sent) { ?>
						<tr>
							<td class="bold text-right">Reminder</td>
							<td><a href="<?php echo get_permalink( $ical_pg->ID ); ?>?meeting-id=<?php echo $_REQUEST['meeting-id']; ?>" target="_blank" class="btn btn-info"><i class="fa fa-calendar-plus-o"></i> Add to calendar</a></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>	
				<?php if (isset($_REQUEST['status']) || isset($_POST['send-comment'])) { ?>
					<?php if ($accepted_email_sent || $reject_email_sent) { ?>
					<a href="<?php echo get_permalink( $meetings_page->ID); ?>?meeting-id=<?php echo $_REQUEST['meeting-id']; ?><?php echo (isset($_REQUEST['meeting-day'])) ? '&meeting-day='.$_REQUEST['meeting-day']:'' ?><?php echo (isset($_REQUEST['meeting-day-to'])) ? '&meeting-day-to='.$_REQUEST['meeting-day-to']:'' ?>" class="btn btn-success btn-block btn-lg caps"><i class="fa fa-check fa-lg pull-left"></i> Continue</a>
					<?php } ?>
					<?php if ($_REQUEST['status'] == 'reject') { ?>
					<form action="<?php the_permalink(); ?>?meeting-actions=meeting-approval<?php echo (isset($_REQUEST['meeting-day'])) ? '&meeting-day='.$_REQUEST['meeting-day']:'' ?><?php echo (isset($_REQUEST['meeting-day-to'])) ? '&meeting-day-to='.$_REQUEST['meeting-day-to']:'' ?>" method="post">
						<div class="form-group">
							<label>Comments</label>	
							<textarea name="meeting-comment" class="form-control" rows="5"></textarea>
							<input type="hidden" name="user-id" value="<?php echo $_REQUEST['user-id']; ?>">
							<input type="hidden" name="meeting-id" value="<?php echo $_REQUEST['meeting-id']; ?>">
						</div>
						<button type="submit" class="btn btn-primary btn-lg caps" name="send-comment"><i class="fa fa-comment"></i> Send comments</button>
					</form>
					<?php } ?>
				<?php } else { ?>
				<table class="table">
					<tbody>
						<tr>
							<td width="50%">
								<a href="?meeting-actions=meeting-approval&status=accepted&meeting-id=<?php echo $_REQUEST['meeting-id']; ?>&user-id=<?php echo $_REQUEST['user-id']; ?><?php echo (isset($_REQUEST['meeting-day'])) ? '&meeting-day='.$_REQUEST['meeting-day']:'' ?><?php echo (isset($_REQUEST['meeting-day-to'])) ? '&meeting-day-to='.$_REQUEST['meeting-day-to']:'' ?>" class="btn btn-success btn-block btn-lg caps"><i class="fa fa-check fa-lg pull-left"></i>Accept</a>
							</td>
							<td>
								<a href="?meeting-actions=meeting-approval&status=reject&meeting-id=<?php echo $_REQUEST['meeting-id']; ?>&user-id=<?php echo $_REQUEST['user-id']; ?><?php echo (isset($_REQUEST['meeting-day'])) ? '&meeting-day='.$_REQUEST['meeting-day']:'' ?><?php echo (isset($_REQUEST['meeting-day-to'])) ? '&meeting-day-to='.$_REQUEST['meeting-day-to']:'' ?>" class="btn btn-danger btn-block btn-lg caps"><i class="fa fa-times fa-lg pull-left"></i>Reject</a>
							</td>
						</tr>
					</tbody> 
				</table>
				<?php } ?>
				</div>
			</div>
		</div>
	</article>
		
<?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>
