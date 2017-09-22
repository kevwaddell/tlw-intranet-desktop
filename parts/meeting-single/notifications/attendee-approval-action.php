<?php if (is_user_logged_in()) { 
global $current_user;
$user = get_user_by('id', $_GET['user']);	
?>

	<?php if ($current_user->ID == $_GET['user']) { ?>
	
	<div class="alert alert-warning text-center">
	
	<h4><i class="fa fa-check-circle"></i> Confirm</h4>
		
	Please complete your attendee request using the buttons below.<br><br>
	
	<div class="action-btns">
		<div class="row">
			<div class="col-xs-6">
				<a href="<?php the_permalink(); ?>?action=attendee_accept&user_key=<?php echo $_GET['user_key']; ?>&user=<?php echo $_GET['user']; ?>" class="btn btn-success btn-block accept"><i class="fa fa-check fa-lg"></i>Accept invite</a>
			</div>
			
			<div class="col-xs-6">
				<a href="<?php the_permalink(); ?>?action=attendee_reject&user_key=<?php echo $_GET['user_key']; ?>&user=<?php echo $_GET['user']; ?>" class="btn btn-danger btn-block reject"><i class="fa fa-times fa-lg"></i>Reject invite</a>
			</div>
		</div>
	</div>
	
	</div>
	
	<?php } else { 
	
	wp_redirect( get_permalink(get_the_ID()) );
	exit;
	
	 } ?>

<?php } else { ?>

	<div class="alert alert-danger text-center">
	<strong>Please login to complete your request <a href="#log-in-alert" data-toggle="modal" class="btn btn-default btn-danger">Login</a></strong>
	</div>

<?php } ?>
