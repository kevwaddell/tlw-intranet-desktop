<?php
global $booking_email_sent;
global $meeting_added;
global $room;
?>
<?php if ( $meeting_added ) { ?>
<div class="alert alert-success alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<p><i class="fa fa-check-circle"></i> Meeting room <span><?php echo $room->name; ?></span> has been booked. You can now add attendees.</p>	
</div>
<?php } ?>