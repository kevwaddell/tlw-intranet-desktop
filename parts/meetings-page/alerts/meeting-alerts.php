<?php
global $notify_email_sent;
global $booking_email_sent;
global $notify_emails_sent;
global $attendees_added;
global $meeting_updated;
global $attendee_removed;
global $attendee_updated;
global $room;
?>
<?php if ( $booking_email_sent ) { ?>
<div class="alert alert-success alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<p><i class="fa fa-check-circle"></i> Meeting room <span class="bold"><?php echo $room->name; ?></span> has been booked. You can now add attendees.</p>	
</div>
<?php } ?>
<?php if ( $attendees_added ) { ?>
<div class="alert alert-success alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<p><i class="fa fa-check-circle"></i> Attendees added successfully.</p>	
</div>
<?php } ?>
<?php if (  $attendee_removed ) { ?>
<div class="alert alert-success alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<p><i class="fa fa-check-circle"></i> Attendee has been removed successfully.</p>	
</div>
<?php } ?>
<?php if ( $attendee_updated ) { ?>
<div class="alert alert-success alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<p><i class="fa fa-check-circle"></i> Attendee has been updated successfully.</p>	
</div>
<?php } ?>
<?php if ( $notify_email_sent ) { 
global $user_fname;
global $user_lname;
?>
<div class="alert alert-success alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<p><i class="fa fa-check-circle"></i> <span class="bold"><?php echo $user_fname; ?> <?php echo $user_lname; ?></span> has been notified of meeting.</p>	
</div>
<?php } ?>
<?php if ($meeting_canceled) { 
global $meeting;
global $notify_user_emails;
?>
<div class="alert alert-success alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<p><i class="fa fa-check-circle"></i> <span class="bold"><?php echo get_the_title( $meeting->ID ); ?></span> meeting has canceled.</p>	
	<?php if (!empty($notify_user_emails)) { 
		echo '<pre>';
	?>
		<?php foreach ($notify_user_emails as $ue) { 
		$n_user = get_user_by_email( $ue );
		?>
		<?php print_r($n_user); ?>
		<?php } ?>		
	<?php 
		echo '</pre>';
		} ?>
</div>
<?php } ?>

<?php if ( $meeting_updated ) { ?>
<div class="alert alert-success alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<p><i class="fa fa-check-circle"></i> Meeting updated successfully.</p>	
</div>
<?php } ?>