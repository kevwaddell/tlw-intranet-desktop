<?php if ( isset($_POST['confirm_user_message']) ) { 
//echo '<pre>';print_r($_POST);echo '</pre>';
$_POST = stripslashes_deep( $_POST );
$to_email = trim($_POST['to_email']);
$from_email = trim($_POST['from_email']);
$from_name = $_POST['from_name'];
$subject = trim($_POST['subject']);
$message = trim( apply_filters('the_content',$_POST['message'] ) );
$http_ref = $_POST['_wp_http_referer'];

if ($nickname != $user_name) {
$message_to = $nickname;
} else {
$message_to = $firstname;	
}

$errors = array();

/*
echo '<pre>';
print_r($curauth);
echo '<br>';
echo '<br>';
echo '<br>';
print_r($user_meta);
echo '</pre>';
*/
?>

<?php if (empty($errors)) { ?>

<div class="well well-lg">
	
	<strong class="caps">Message details:</strong><br>
		<span class="bold">To:</span> <?php echo $to_email; ?><br>
		<?php if (isset($_POST['from_name'])) { ?>
		<span class="bold">From:</span> <?php echo $from_name; ?> - [ <?php echo $from_email; ?> ]<br>
		<?php } else { ?>
		<span class="bold">From:</span> <?php echo $from_email; ?><br>
		<?php } ?>
		<span class="bold">Subject:</span>  <?php echo $subject; ?><br><br>
		<span class="bold">Your Message:</span><br><br>
		<p>Hi <?php echo $message_to ; ?></p>
		
		<?php echo $message ; ?>	
		<br>
		<p><strong>Message sent by <?php echo $from_name ; ?></strong></p>
		<br>
	
	<form action="<?php echo $http_ref; ?>" method="post">
		
	<input type="hidden" name="to_email" value="<?php echo $to_email; ?>">
	<input type="hidden" name="from_email" value="<?php echo $from_email; ?>">
	<input type="hidden" name="from_name" value="<?php echo $from_name; ?>">
	<input type="hidden" name="subject" value="<?php echo $subject; ?>">
	<input type="hidden" name="message" value="<?php echo urlencode($message); ?>">
	<?php wp_nonce_field( 'post_nonce', 'send_nonce_field' ); ?>
		
	<div class="action-btns col-gray">
		<div class="row">
			<div class="col-xs-4">
				<input type="submit" name="send_user_message" value="Send Message" class="btn btn-info btn-block">
			</div>
			<div class="col-xs-4">
				<input type="submit" name="change_user_message" value="Change Message" class="btn btn-info btn-block">
			</div>
			<div class="col-xs-4">
				<a href="<?php echo $http_ref; ?>" class="btn btn-default btn-block no-arrow">Cancel</a>
			</div>
		</div>
	</div>
	
	</form>
	
</div>

<?php } ?>

<?php }  ?>

