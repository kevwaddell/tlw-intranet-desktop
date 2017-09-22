<?php if ( isset($_POST['send_user_message']) ) { 
//echo '<pre>';print_r($_POST);echo '</pre>';
$_POST = stripslashes_deep( $_POST );	
$http_ref = $_POST['_wp_http_referer'];

include (STYLESHEETPATH . '/_/inc/user/notifications/user-message-email.php');

?>
<?php if ($email_sent) { ?>
<div class="alert alert-success text-center">
	
	<h4><i class="fa fa-send"></i> Success</h4>
	
	<strong>Your message has been sent successfully.</strong><br><br>
	
	<div class="action-btns">
		<a href="<?php echo $http_ref; ?>" class="btn btn-success btn-block">Continue</a>
	</div>
	
</div>
<?php } else { ?>
<div class="alert alert-danger text-center">
	
	<h4><i class="fa fa-warning"></i> Error</h4>
	
	<strong>There was a problem send ing your message.</strong><br><br>
	
	<form action="<?php echo $http_ref; ?>" method="post">
		
	<input type="hidden" name="to_email" value="<?php echo $to_email; ?>">
	<input type="hidden" name="from_email" value="<?php echo $from_email; ?>">
	<input type="hidden" name="from_name" value="<?php echo $from_name; ?>">
	<input type="hidden" name="subject" value="<?php echo $email_subject; ?>">
	<input type="hidden" name="message" value="<?php echo $email_content ; ?>">
	<?php wp_nonce_field( 'post_nonce', 'try_again_nonce_field' ); ?>
		
	<div class="action-btns">
		<input type="submit" name="retry_user_message" value="Try again" class="btn btn-danger btn-block">
	</div>
	
	</form>
	
</div>
<?php } ?>

<?php }  ?>