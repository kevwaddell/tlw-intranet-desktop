<?php if ( isset($_GET['postid']) && $_GET['action'] == "confirm") {
$httpref = $httpref = $_GET['httpref'];
$postid = $_GET['postid'];

$new_post = get_post($postid);
$edit_post_link = get_home_url().'/wp-admin/post.php?post='.$postid.'&action=edit';

if (current_user_can("administrator") || current_user_can("editor")) {
//$tags = implode( ", ", wp_get_post_terms($new_post->ID, 'post_tag', array("fields" => "names") ) ) ;

$post_args = array(
'ID' => $postid,
'post_status' => 'publish'
);

//echo '<pre>';print_r($tags);echo '</pre>';

wp_update_post($post_args);

$confirm_message = "Your post has been published.";
		
} else {

$added_by = get_user_by('id', $new_post->post_author);
$email_content = apply_filters('the_content', $new_post->post_content );
$cats = get_the_category($new_post->ID);
$tags = implode( ", ", wp_get_post_terms($new_post->ID, 'post_tag', array("fields" => "names") ) ) ;

include (STYLESHEETPATH . '/_/inc/add-post/notifications/add-post-email.php');


$confirm_message = "<strong>Your article has been sent for approval.</strong><br>You will be notified by the intranet editor when you article has been published.";	
}

?>

<div class="alert alert-success">
	
	<p class="text-center"><?php echo $confirm_message; ?></p>
	<br>
	<div class="action-btns">
		<a href="<?php echo $httpref; ?>" class="btn btn-success btn-block"><i class="fa fa-check fa-lg"></i>Continue</a>
	</div>
	
</div>

<?php }  ?>