<?php 
if ( isset($_POST['postid']) ) {  

$edit_post = get_post($_POST['postid']);
$edit_cat = get_the_category($_POST['postid']);
$edit_tags = wp_get_post_terms($_POST['postid'], 'post_tag', array("fields" => "names") );
$new_tags = explode(", ", $_POST['post_tags']);
/*

echo '<pre>';
print_r($edit_tags);
echo '<br>';
echo '<br>';
print_r(array_diff($new_tags, $edit_tags));
echo '<br>';
echo '<br>';
print_r($new_tags);
echo '</pre>';	
*/

$edit_post_args = array(
'ID'	=> $_POST['postid']
);

	if ($edit_post->post_title != $_POST['title']) {
	$edit_post_args['post_title'] = wp_strip_all_tags($_POST['title']);	
	$edit_post_args['post_name'] = sanitize_title($_POST['title']);
	}	
	
	if ($edit_post->post_content != $_POST['editpost']) {
	$edit_post_args['post_content'] = $_POST['editpost'];	
	}
	
	if ($edit_cat[0]->term_id != $_POST['cat']) {
	//wp_set_post_categories( $_POST['postid'], array($_POST['cat']) );
	$edit_post_args['post_category'] = array($_POST['cat']);	
	}
	
	if (count(array_diff($new_tags, $edit_tags)) > 0) {
	//wp_set_post_terms( $_POST['postid'], $new_tags, 'post_tag' );
	$edit_post_args['tags_input'] = $new_tags;
	}
	
	if ( current_user_can("administrator") || current_user_can("editor") ) {
	$edit_post_args['post_status']	= 'publish';
	$redirect = get_permalink($_POST['postid'])."?action=post_updated";	
	
	} else {
	$edit_post_args['post_status'] = 'pending';	
	$redirect = get_category_link( $_POST['cat'] )."?action=post_updated&postid=".$_POST['postid'];
	
	}
	
	wp_update_post( $edit_post_args );
	
	wp_redirect( $redirect );
	
}		
?>