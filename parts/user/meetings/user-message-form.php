<?php
$page_url = explode("?", $_SERVER['REQUEST_URI']);

?>
<form action="<?php echo $page_url[0]; ?>" method="post" class="message-form post-form" id="message_form">
	<div class="form-group">
		<input type="text" id="title" name="subject" class="form-control input-lg" placeholder="Subject" value="">
	</div>
	
	<div class="form-group">
		<?php 
		$editor_css = array( 'content_css' => get_stylesheet_directory_uri().'/_/css/custom-editor-style.css');
		$settings = array( 
		'media_buttons' => false,
		'teeny' => true,
		'tinymce' => $editor_css,
		'textarea_rows'	=> "10"
		);
		wp_editor( get_the_content(), "message", $settings ); 
		?>
	</div>
	
	<div class="action-btns col-red">
		<?php wp_nonce_field( 'post_nonce', 'post_nonce_field' ); ?>
		<input type="submit" name="send_user_message" value="Send Message" class="btn btn-info btn-block">
	</div>
	
</form>