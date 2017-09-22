<?php if (isset($_POST['add-event'])) { 
$_POST = stripslashes_deep( $_POST );
$errors = array();
$title = trim($_POST['title']);
$content = trim($_POST['addpost']);
$date = trim($_POST['event_date']);
$location = trim($_POST['location']);
$user_id = $_POST['userid'];
$cat = $_POST['cat'];
$httpref = $_POST['httpref'];

	if ($title == "") {
	$errors[] = array('error_type' => 'title', 'message' => 'You have not entered a title');	
	}
	
	if ($date == "") {
	$errors[] =  array('error_type' => 'date', 'message' => 'You have not chosen an event date');
	} else {
	$event_date = date("Ymd", strtotime($date));
	$start_time = strtotime($date." at ".$_POST['start_hrs'].":".$_POST['start_mins'] );
	$end_time = strtotime($date." at ".$_POST['end_hrs'].":".$_POST['end_mins'] );
	}
	
	if ($location == "") {
	$errors[] =  array('error_type' => 'location', 'message' => 'You did not enter an event location');
	}
	
	if ($content == "") {
	$errors[] =  array('error_type' => 'content', 'message' => 'You have not entered any event content');
	}

	if (count($errors) == 0) {
	
	$post_args = array();
	
	if ( isset($_POST['postid']) ) {
	
	$old_post = get_post($_POST['postid']);	
	$post_id = $old_post->ID;
	$post_args['ID'] = $post_id;
	
	
		if  ( strcmp( wp_strip_all_tags($title), $old_post->post_title) !== 0 ) {
		$post_args['post_name']	= sanitize_title($title);	
		$post_args['post_title'] = wp_strip_all_tags($title);
		}
		
		if (strcmp($content, $old_post->post_content) !== 0 ) {
		$post_args['post_content'] = $content;	
		}
	
		wp_update_post($post_args);
		
		update_post_meta($post_id, 'event_date', $event_date); 
		update_post_meta($post_id, 'event_time', $start_time);
		update_post_meta($post_id, 'event_time_end', $end_time);
		update_post_meta($post_id, 'location', $location);
		
	} else {
	
		$post_args['post_author']= $user_id;
		$post_args['post_type']= 'post';
		$post_args['post_status']= 'pending';
		$post_args['post_content']= $content;
		$post_args['post_name']	= sanitize_title($title);
		$post_args['post_title'] = wp_strip_all_tags($title);
		$post_args['post_category'] = array($cat);
		
		$post_id = wp_insert_post($post_args);
		
		update_post_meta($post_id, '_event_date', 'field_53d66da430dcb'); 
		update_post_meta($post_id, 'event_date', $event_date); 
		update_post_meta($post_id, '_event_time', 'field_53d66de130dcc');
		update_post_meta($post_id, 'event_time', $start_time);
		update_post_meta($post_id, '_event_time_end', 'field_53d66eebee215');
		update_post_meta($post_id, 'event_time_end', $end_time);
		update_post_meta($post_id, '_location', 'field_53d66e3930dcd');
		update_post_meta($post_id, 'location', $location);
		
	}	
	
}

?>

<?php if (count($errors) == 0) { ?>
		
	<div class="alert alert-success text-center">
		
		<h4><i class="fa fa-check-circle"></i> Success</h4>
		
		<strong>Your event is ready to be sent for review.</strong><br>
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
		
		<h4><i class="fa fa-warning"></i> Errors!</h4>
	
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