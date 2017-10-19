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
?>
<div class="alerts-pop animated fadeIn">
<?php if ( $booking_email_sent ) { 
global $room;	
?>
<div class="alert alert-success" role="alert">
	<h3>Meeting room <span class="bold"><?php echo $room->name; ?></span> has been booked</h3>
	<p>You can now add attendees.</p>	
	<a href="?meeting-id=<?php echo $meeting_added; ?><?php echo (isset($_REQUEST['meeting-day'])) ? '&meeting-day='.$_REQUEST['meeting-day']:'' ?><?php echo (isset($_REQUEST['meeting-day-to'])) ? '&meeting-day-to='.$_REQUEST['meeting-day-to']:'' ?>" class="btn btn-success btn-block">Continue <i class="fa fa-check pull-right"></i></a>
</div>
<?php } ?>
<?php if ( $attendees_added ) { ?>
<div class="alert alert-success" role="alert">
	<p>Attendees added successfully.</p>	
	<a href="?meeting-id=<?php echo $_REQUEST['meeting-id'] ?><?php echo (isset($_REQUEST['meeting-day'])) ? '&meeting-day='.$_REQUEST['meeting-day']:'' ?><?php echo (isset($_REQUEST['meeting-day-to'])) ? '&meeting-day-to='.$_REQUEST['meeting-day-to']:'' ?>" class="btn btn-success btn-block">Continue <i class="fa fa-check pull-right"></i></a>
</div>
<?php } ?>
<?php if (  $attendee_removed ) { ?>
<div class="alert alert-success" role="alert">
	<p>Attendee has been removed successfully.</p>	
	<a href="?meeting-id=<?php echo $_REQUEST['meeting-id'] ?><?php echo (isset($_REQUEST['meeting-day'])) ? '&meeting-day='.$_REQUEST['meeting-day']:'' ?><?php echo (isset($_REQUEST['meeting-day-to'])) ? '&meeting-day-to='.$_REQUEST['meeting-day-to']:'' ?>" class="btn btn-success btn-block">Continue <i class="fa fa-check pull-right"></i></a>
</div>
<?php } ?>
<?php if ( $attendee_updated ) { ?>
<div class="alert alert-success" role="alert">
	<p>Attendee has been updated successfully.</p>	
	<a href="?meeting-id=<?php echo $_REQUEST['meeting-id'] ?><?php echo (isset($_REQUEST['meeting-day'])) ? '&meeting-day='.$_REQUEST['meeting-day']:'' ?><?php echo (isset($_REQUEST['meeting-day-to'])) ? '&meeting-day-to='.$_REQUEST['meeting-day-to']:'' ?>" class="btn btn-success btn-block">Continue <i class="fa fa-check pull-right"></i></a>
</div>
<?php } ?>
<?php if ( $notify_email_sent ) { 
global $user_fname;
global $user_lname;
?>
<div class="alert alert-success" role="alert">
	<h3><?php echo $user_fname; ?> <?php echo $user_lname; ?></h3>
	<p>Has been notified of meeting.</p>	
	<a href="?meeting-id=<?php echo $_REQUEST['meeting-id'] ?><?php echo (isset($_REQUEST['meeting-day'])) ? '&meeting-day='.$_REQUEST['meeting-day']:'' ?><?php echo (isset($_REQUEST['meeting-day-to'])) ? '&meeting-day-to='.$_REQUEST['meeting-day-to']:'' ?>" class="btn btn-success btn-block">Continue <i class="fa fa-check pull-right"></i></a>
</div>
<?php } ?>
<?php if ($meeting_canceled) { 
global $meeting;
global $notify_user_emails;
?>
<div class="alert alert-success" role="alert">
	<h3><span class="bold"><?php echo get_the_title( $meeting->ID ); ?></span> meeting has been canceled.</h3>	
	<?php if (!empty($notify_user_emails)) { ?>
	<ul>
		<?php foreach ($notify_user_emails as $ue) { 
		$n_user = get_user_by_email( $ue );
		?>
		<li><strong><?php echo $n_user->display_name; ?></strong> has been notified.</li>
		<?php } ?>	
	</ul>	
	<?php } ?>
	<a href="<?php echo (isset($_REQUEST['meeting-day'])) ? '?meeting-day='.$_REQUEST['meeting-day']:'' ?><?php echo (isset($_REQUEST['meeting-day-to'])) ? '&meeting-day-to='.$_REQUEST['meeting-day-to']:'' ?>" class="btn btn-success btn-block">Continue <i class="fa fa-check pull-right"></i></a>
</div>
<?php } ?>

<?php if ( $meeting_updated ) { ?>
<div class="alert alert-success" role="alert">
	<p>Meeting updated successfully.</p>	
	<a href="?meeting-id=<?php echo $_REQUEST['meeting-id'] ?><?php echo (isset($_REQUEST['meeting-day'])) ? '&meeting-day='.$_REQUEST['meeting-day']:'' ?><?php echo (isset($_REQUEST['meeting-day-to'])) ? '&meeting-day-to='.$_REQUEST['meeting-day-to']:'' ?>" class="btn btn-success btn-block">Continue <i class="fa fa-check pull-right"></i></a>
</div>
<?php } ?>

<?php if ( $meeting_deleted ) { ?>
<div class="alert alert-success" role="alert">
	<p><i class="fa fa-check-circle"></i> Meeting has been deleted successfully.</p>	
	<a href="<?php echo (isset($_REQUEST['meeting-day'])) ? '?meeting-day='.$_REQUEST['meeting-day']:'' ?><?php echo (isset($_REQUEST['meeting-day-to'])) ? '&meeting-day-to='.$_REQUEST['meeting-day-to']:'' ?>" class="btn btn-success btn-block">Continue <i class="fa fa-check pull-right"></i></a>
</div>
<?php } ?>
</div>