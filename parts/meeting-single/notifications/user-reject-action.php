<!-- REJECT NOTIFICATION -->
<?php if (isset($_GET['action']) && $_GET['action'] == 'attendee_reject') { 

$user = get_user_by('id', $_GET['user']);
$user_meta = get_user_meta($_GET['user']);
$from_name = $user->data->display_name;
$from_email = $user->data->user_email;
	
update_post_meta(get_the_ID(), "attendees_staff_".$_GET['user_key']."_status", "rejected");	

if ($start_time > $now ) {
include (STYLESHEETPATH . '/_/inc/meeting-single/notifications/user-reject-email.php');
}
?>
<?php if ($start_time > $now) { ?>
<div class="alert alert-danger text-center">
	
	<h4><i class="fa fa-bullhorn"></i> Notified</h4>
	
	<strong><?php echo $booked_by->data->display_name; ?></strong> has been notified that you are unavailable for the meeting.<br><br>
	
	<div class="action-btns">
	<a href="<?php the_permalink(); ?>" class="btn btn-danger btn-block">Continue</a>
	</div>
</div>
<?php } else { ?>
<div class="alert alert-sucess text-center">
	
	<h4><i class="fa fa-refresh"></i> Updated</h4>
	
	Thank you for updating your status <strong><?php echo $user_meta['first_name'][0]; ?></strong>.<br><br>
	
	<div class="action-btns">
	<a href="<?php the_permalink(); ?>" class="btn btn-success btn-block">Continue</a>
	</div>
</div>
<?php } ?>

<?php } ?>