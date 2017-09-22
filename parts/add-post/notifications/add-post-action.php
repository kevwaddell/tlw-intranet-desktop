<?php if (isset($_POST['userid'])) { 

$errors = array();
$title = trim($_POST['title']);
$content = trim($_POST['addpost']);
$user_id = $_POST['userid'];
$cat = $_POST['cat'];
$tags = explode(", ", $_POST['post_tags']);
$httpref = $_POST['httpref'];

	if ($title == "") {
	$errors[] = array('error_type' => 'title', 'message' => 'You have not entered a title');	
	}
	
	if ($content == "") {
	$errors[] =  array('error_type' => 'content', 'message' => 'You have not entered any article content');
	}
	
	if ($cat == "0") {
	$errors[] = array('error_type' => 'cat', 'message' => 'You have not chosen an article category');
	}
	
//echo '<pre>';print_r($errors);echo '</pre>';	

	if (count($errors) == 0) {
	
	$post_args = array();
	
	if ( isset($_POST['postid']) ) {
	
	//echo '<pre>';print_r($_POST);echo '</pre>';
	
	$old_post = get_post($_POST['postid']);	
	$post_id = $old_post->ID;
	$old_cats = get_the_category($old_post->ID);
	$old_tags = wp_get_post_terms($old_post->ID, 'post_tag', array("fields" => "names") );
	$post_args['ID'] = $post_id;
	
	
		if  ( strcmp( wp_strip_all_tags($title), $old_post->post_title) !== 0 ) {
		$post_args['post_name']	= sanitize_title($title);	
		$post_args['post_title'] = wp_strip_all_tags($title);
		}
		
		if (strcmp($content, $old_post->post_content) !== 0 ) {
		$post_args['post_content'] = $content;	
		}
		
		if ($old_cats[0]->term_id != $cat) {
		$post_args['post_category'] = array($cat);	
		}
		
		if ( count( array_diff($tags, $old_tags) ) > 0 ) {
		$post_args['tags_input'] = $tags;
		}
		
		/*
echo '<pre>';
		print_r($old_post->post_content);
		echo '<br><br><br><br>';
		print_r($content);
		echo '</pre>';
*/
	
		wp_update_post($post_args);
		
	} else {
		$post_args['post_author']= $user_id;
		$post_args['post_type']= 'post';
		$post_args['post_status']= 'pending';
		$post_args['post_content']= $content;
		$post_args['post_name']	= sanitize_title($title);
		$post_args['post_title'] = wp_strip_all_tags($title);
		$post_args['post_category'] = array($cat);
		
		if (!empty($tags)) {
		$post_args['tags_input'] = $tags;	
		}
		
		$post_id = wp_insert_post($post_args);
		
	}	
	
}

?>

<?php if (count($errors) == 0) { ?>
		
	<div class="alert alert-success">
		<strong>Your article is ready to be sent for review.</strong><br>
		Use the links below to confirm or change you article.<br><br>
	
		<div class="action-btns">
			<div class="row">
				<div class="col-xs-6">
					<a href="<?php the_permalink(); ?>?action=confirm&postid=<?php echo $post_id; ?>&httpref=<?php echo $httpref; ?>" class="btn btn-success btn-block btn-action"><i class="fa fa-check fa-lg"></i>Confirm</a>
				</div>
				<div class="col-xs-6">
					<button class="btn btn-info btn-block close-btn no-arrow"><i class="fa fa-pencil fa-lg"></i>Edit article</button>
				</div>
			</div>
	
		</div>
	
	</div>
	
<?php } else { ?>
	
	<div class="alert alert-danger">
		
		<h4>Errors !</h4>
	
		<ul>
			<?php foreach ($errors as $error) { ?>
			<li><?php echo $error['message']; ?>.</li>
			<?php } ?>
		</ul>
		<br>
		<div class="action-btns">

			<button class="btn btn-danger btn-block close-btn no-arrow"><i class="fa fa-times fa-lg"></i>Close</button>
	
		</div>
	
	</div>
	
<?php } ?>

<?php } ?>