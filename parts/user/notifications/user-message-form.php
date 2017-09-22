<?php
$page_url = explode("?", $_SERVER['REQUEST_URI']);
//echo '<pre>';print_r($current_user->data->user_email);echo '</pre>';
?>

<?php include (STYLESHEETPATH . '/_/inc/user/notifications/user-message-confirm.php'); ?>
<?php include (STYLESHEETPATH . '/_/inc/user/notifications/user-message-send.php'); ?>

<?php if (!isset($_POST['confirm_user_message']) && empty($errors) || isset($_POST['change_user_message']) || isset($_POST['retry_user_message'])) { ?>

<form action="<?php echo $page_url[0]; ?>" method="post" class="message-form post-form" id="message_form">
	
	<input type="hidden" name="to_email" value="<?php echo $curauth->data->user_email; ?>">
	
	<?php if (is_user_logged_in()) { ?>
	<input type="hidden" name="from_email" value="<?php echo $current_user->data->user_email; ?>">
	<input type="hidden" name="from_name" value="<?php echo $current_user->data->display_name; ?>">
	<?php } else { ?>
	<div class="form-group">
		<input type="email" id="title" name="from_email" class="form-control input-lg" placeholder="Enter your email address" value="<?php echo ( isset($_POST['confirm_user_message']) || isset($_POST['change_user_message']) || isset($_POST['retry_user_message'])) ? $_POST['from_email']:'';?>">
	</div>
	<input type="hidden" name="from_name" value="<?php bloginfo('name'); ?> <?php bloginfo('description'); ?>">
	<?php } ?>
	
	<div class="form-group">
		<input type="text" id="title" name="subject" class="form-control input-lg" placeholder="Subject" value="<?php echo ( isset($_POST['confirm_user_message']) || isset($_POST['change_user_message']) || isset($_POST['retry_user_message'])) ? $_POST['subject']:'';?>">
	</div>
	
	<div class="form-group">
		<?php 
		$editor_css = array( 'content_css' => get_stylesheet_directory_uri().'/_/css/custom-editor-style.css');
		if ( current_user_can("administrator") ) {
		$quicktags = true;	
		} else {
		$quicktags = false;		
		}
		if ($_POST['message'] && isset($_POST['confirm_user_message']) || isset($_POST['change_user_message']) || isset($_POST['retry_user_message'])) {
		$message = $_POST['message'];	
		} else {
		$message = "";	
		}
		$settings = array( 
		'quicktags'	=> $quicktags,
		'media_buttons' => false,
		'teeny' => true,
		'tinymce' => $editor_css,
		'textarea_rows'	=> "10"
		);
		wp_editor( $message, "message", $settings ); 
		?>
	</div>
	
	<div class="action-btns col-red">
		<?php wp_nonce_field( 'post_nonce', 'confirm_nonce_field' ); ?>
		<input type="submit" name="confirm_user_message" value="Send Message" class="btn btn-info btn-block">
	</div>
	
</form>

<?php } ?>