<?php
global $notify_email_sent;
global $booking_email_sent;
global $notify_emails_sent;
global $attendees_added;
global $meeting_added;
global $meeting_updated;
global $attendee_removed;
global $attendee_updated;
global $meeting_canceled;
global $meeting_deleted;
global $reminder_added;
global $add_reminder_error;
?>
<div class="alerts-pop animated fadeIn">
<?php if ( $booking_email_sent ) { 
global $room;	
?>
<div class="alert text-center" role="alert">
	<h3><i class="fa fa-calendar-check-o"></i> Meeting room <span class="bold"><?php echo $room->name; ?></span> has been booked</h3>
	<p>You can now add attendees.</p>	
	<a href="?meeting-id=<?php echo $meeting_added; ?><?php echo (isset($_REQUEST['meeting-day'])) ? '&meeting-day='.$_REQUEST['meeting-day']:'' ?><?php echo (isset($_REQUEST['meeting-day-to'])) ? '&meeting-day-to='.$_REQUEST['meeting-day-to']:'' ?><?php echo (isset($_REQUEST['meeting-month'])) ? '&meeting-month='.$_REQUEST['meeting-month']:'' ?><?php echo (isset($_REQUEST['meeting-year'])) ? '&meeting-year='.$_REQUEST['meeting-year']:'' ?>" class="btn btn-success btn-block">Continue <i class="fa fa-check pull-right"></i></a>
</div>
<?php } ?>
<?php if ( $attendees_added ) { ?>
<div class="alert text-center" role="alert">
	<h3><i class="fa fa-user-plus"></i> Attendees added successfully</h3>	
	<a href="?meeting-id=<?php echo $_REQUEST['meeting-id'] ?><?php echo (isset($_REQUEST['meeting-day'])) ? '&meeting-day='.$_REQUEST['meeting-day']:'' ?><?php echo (isset($_REQUEST['meeting-day-to'])) ? '&meeting-day-to='.$_REQUEST['meeting-day-to']:'' ?><?php echo (isset($_REQUEST['meeting-month'])) ? '&meeting-month='.$_REQUEST['meeting-month']:'' ?><?php echo (isset($_REQUEST['meeting-year'])) ? '&meeting-year='.$_REQUEST['meeting-year']:'' ?>" class="btn btn-success btn-block">Continue <i class="fa fa-check pull-right"></i></a>
</div>
<?php } ?>
<?php if ( $attendee_removed ) { ?>
<div class="alert text-center" role="alert">
	<h3><i class="fa fa-user-times"></i> Attendee has been removed successfully</h3>	
	<a href="?meeting-id=<?php echo $_REQUEST['meeting-id'] ?><?php echo (isset($_REQUEST['meeting-day'])) ? '&meeting-day='.$_REQUEST['meeting-day']:'' ?><?php echo (isset($_REQUEST['meeting-day-to'])) ? '&meeting-day-to='.$_REQUEST['meeting-day-to']:'' ?><?php echo (isset($_REQUEST['meeting-month'])) ? '&meeting-month='.$_REQUEST['meeting-month']:'' ?><?php echo (isset($_REQUEST['meeting-year'])) ? '&meeting-year='.$_REQUEST['meeting-year']:'' ?>" class="btn btn-success btn-block">Continue <i class="fa fa-check pull-right"></i></a>
</div>
<?php } ?>
<?php if ( $attendee_updated ) { ?>
<div class="alert text-center" role="alert">
	<h3><i class="fa fa-check-circle"></i> Attendee has been updated successfully</h3>	
	<a href="?meeting-id=<?php echo $_REQUEST['meeting-id'] ?><?php echo (isset($_REQUEST['meeting-day'])) ? '&meeting-day='.$_REQUEST['meeting-day']:'' ?><?php echo (isset($_REQUEST['meeting-day-to'])) ? '&meeting-day-to='.$_REQUEST['meeting-day-to']:'' ?><?php echo (isset($_REQUEST['meeting-month'])) ? '&meeting-month='.$_REQUEST['meeting-month']:'' ?><?php echo (isset($_REQUEST['meeting-year'])) ? '&meeting-year='.$_REQUEST['meeting-year']:'' ?>" class="btn btn-success btn-block">Continue <i class="fa fa-check pull-right"></i></a>
</div>
<?php } ?>
<?php if ( $notify_email_sent ) { 
global $user_fname;
global $user_lname;
?>
<div class="alert" role="alert">
	<h3><i class="fa fa-user"></i> <?php echo $user_fname; ?> <?php echo $user_lname; ?></h3>
	<p>Has been notified of meeting.</p>	
	<a href="?meeting-id=<?php echo $_REQUEST['meeting-id'] ?><?php echo (isset($_REQUEST['meeting-day'])) ? '&meeting-day='.$_REQUEST['meeting-day']:'' ?><?php echo (isset($_REQUEST['meeting-day-to'])) ? '&meeting-day-to='.$_REQUEST['meeting-day-to']:'' ?><?php echo (isset($_REQUEST['meeting-month'])) ? '&meeting-month='.$_REQUEST['meeting-month']:'' ?><?php echo (isset($_REQUEST['meeting-year'])) ? '&meeting-year='.$_REQUEST['meeting-year']:'' ?>" class="btn btn-success btn-block">Continue <i class="fa fa-check pull-right"></i></a>
</div>
<?php } ?>
<?php if ($meeting_canceled) { 
global $meeting;
global $notify_user_emails;
?>
<div class="alert" role="alert">
	<h3><i class="fa fa-calendar-times-o"></i> <span class="bold"><?php echo get_the_title( $meeting->ID ); ?></span> meeting has been canceled.</h3>	
	<?php if (!empty($notify_user_emails)) { ?>
	<ul>
		<?php foreach ($notify_user_emails as $ue) { 
		$n_user = get_user_by_email( $ue );
		?>
		<li><strong><?php echo $n_user->display_name; ?></strong> has been notified.</li>
		<?php } ?>	
	</ul>	
	<?php } ?>
	<a href="<?php echo (isset($_REQUEST['meeting-day'])) ? '?meeting-day='.$_REQUEST['meeting-day']:'' ?><?php echo (isset($_REQUEST['meeting-day-to'])) ? '&meeting-day-to='.$_REQUEST['meeting-day-to']:'' ?><?php echo (isset($_REQUEST['meeting-month'])) ? '&meeting-month='.$_REQUEST['meeting-month']:'' ?><?php echo (isset($_REQUEST['meeting-year'])) ? '&meeting-year='.$_REQUEST['meeting-year']:'' ?>" class="btn btn-success btn-block">Continue <i class="fa fa-check pull-right"></i></a>
</div>
<?php } ?>

<?php if ( $meeting_updated ) { ?>
<div class="alert text-center" role="alert">
	<h3><i class="fa fa-calendar-check-o"></i> Meeting updated successfully</h3>	
	<a href="?meeting-id=<?php echo $_REQUEST['meeting-id'] ?><?php echo (isset($_REQUEST['meeting-day'])) ? '&meeting-day='.$_REQUEST['meeting-day']:'' ?><?php echo (isset($_REQUEST['meeting-day-to'])) ? '&meeting-day-to='.$_REQUEST['meeting-day-to']:'' ?><?php echo (isset($_REQUEST['meeting-month'])) ? '&meeting-month='.$_REQUEST['meeting-month']:'' ?><?php echo (isset($_REQUEST['meeting-year'])) ? '&meeting-year='.$_REQUEST['meeting-year']:'' ?>" class="btn btn-success btn-block">Continue <i class="fa fa-check pull-right"></i></a>
</div>
<?php } ?>

<?php if ( $meeting_deleted ) { ?>
<div class="alert text-center" role="alert">
	<h3><i class="fa fa-calendar-times-o"></i> Meeting has been deleted successfully</h3>	
	<a href="<?php echo (isset($_REQUEST['meeting-day'])) ? '?meeting-day='.$_REQUEST['meeting-day']:'' ?><?php echo (isset($_REQUEST['meeting-day-to'])) ? '&meeting-day-to='.$_REQUEST['meeting-day-to']:'' ?>" class="btn btn-success btn-block">Continue <i class="fa fa-check pull-right"></i></a>
</div>
<?php } ?>
<?php if ( $reminder_added ) { 
$meeting = get_post($_REQUEST['meeting-id']);
?>
<div class="alert text-center" role="alert">
	<h3><i class="fa fa-bell col-red"></i> Reminder added</h3>
	<p>The meeting <span class="bold"><?php echo get_the_title( $meeting->ID ); ?></span> was added to your reminders successfully.</p>	
	<a href="?meeting-id=<?php echo $_REQUEST['meeting-id'] ?><?php echo (isset($_REQUEST['meeting-day'])) ? '&meeting-day='.$_REQUEST['meeting-day']:'' ?><?php echo (isset($_REQUEST['meeting-day-to'])) ? '&meeting-day-to='.$_REQUEST['meeting-day-to']:'' ?><?php echo (isset($_REQUEST['meeting-month'])) ? '&meeting-month='.$_REQUEST['meeting-month']:'' ?><?php echo (isset($_REQUEST['meeting-year'])) ? '&meeting-year='.$_REQUEST['meeting-year']:'' ?>" class="btn btn-success btn-block">Continue <i class="fa fa-check pull-right"></i></a>
</div>
<?php } ?>
<?php if ( $add_reminder_error ) { ?>
<div class="alert text-center" role="alert">
	<h3><i class="fa fa-bell-slash col-red"></i> Reminder not created</h3>
	<p>There is a reminder already set for this meeting.</p>	
	<a href="?meeting-id=<?php echo $_REQUEST['meeting-id'] ?><?php echo (isset($_REQUEST['meeting-day'])) ? '&meeting-day='.$_REQUEST['meeting-day']:'' ?><?php echo (isset($_REQUEST['meeting-day-to'])) ? '&meeting-day-to='.$_REQUEST['meeting-day-to']:'' ?><?php echo (isset($_REQUEST['meeting-month'])) ? '&meeting-month='.$_REQUEST['meeting-month']:'' ?><?php echo (isset($_REQUEST['meeting-year'])) ? '&meeting-year='.$_REQUEST['meeting-year']:'' ?>" class="btn btn-success btn-block">Continue <i class="fa fa-check pull-right"></i></a>
</div>
<?php } ?>
</div>