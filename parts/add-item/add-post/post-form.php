<div class="form">
	<div class="form-wrap">
	
		<form action="<?php the_permalink(); ?>" method="post" style="margin-bottom: 20px;" class="post-form" id="add_post_form">
		
			<input type="hidden" name="userid" value="<?php echo get_current_user_id(); ?>">
			<input type="hidden" name="httpref" value="<?php echo $return_url; ?>">
			
			<?php if ( $post_id ) { ?>
			<input type="hidden" name="postid" value="<?php echo $post_id; ?>">
			<?php } ?>
		
			
			<div class="form-group">
				<input type="text" id="title" name="title" class="form-control input-lg" placeholder="Enter a title" value="<?php echo ($_POST['title']) ? $_POST['title']:'' ;?>">
			</div>
			
			<div class="form-group">
				<?php 
				if ($_POST['addpost']) {
				$content = apply_filters('the_content', $_POST['addpost'] );	
				} else {
				$content = "";	
				}
				$editor_css = array( 'content_css' => get_stylesheet_directory_uri().'/_/css/custom-editor-style.css');
				$settings = array( 
				'media_buttons' => false,
				'teeny' => true,
				'tinymce' => $editor_css
				);
				wp_editor( $content, "addpost", $settings ); 
				?>
			</div>
			
			<div class="form-group clearfix<?php echo ($errors && in_array_r('cat', $errors)) ? ' has-error':'' ; ?>" style="margin-bottom: 10px;">
				<label for="cat" class="col-xs-2 control-label">Category:</label>
				 <div class="col-xs-10">
				<?php 
				
				if ($_POST['cat']) {
				$selected = $_POST['cat'];	
				} else if ( isset($_GET['catid']) ) {
				$selected = $_GET['catid'];	
				} else {
				$selected = 0;		
				}
				
				wp_dropdown_categories( 'taxonomy=category&hide_empty=0&exclude=1,15,12&class=form-control&show_option_all=Choose a category&selected='.$selected ); ?>
				</div>
			</div>
			
			<div class="form-group clearfix" style="margin-bottom: 20px;">
				<label for="post_tags" class="col-xs-2 control-label">Tags:</label>
				 <div class="col-xs-10">
					 <input type="text" class="form-control" value="" placeholder="e.g Keyword 1, Keyword 2, Keyword 3" name="post_tags" id="post_tags" />
					 <span class="help-block">Additional Keywords (comma separated)</span>
				</div>
			</div>
					
			<div class="action-btns col-red">
				<div class="row">
					<div class="col-xs-6">
						<?php wp_nonce_field( 'post_nonce', 'post_nonce_field' ); ?>
						<?php if ( $post_id ) { ?>
						<input type="submit" value="Change Article" class="btn btn-info btn-block">
						<?php } else {?>
						<input type="submit" value="Submit Article" class="btn btn-info btn-block">
						<?php } ?>
					</div>
					<div class="col-xs-6">
						<a href="<?php echo $return_url; ?>" class="btn btn-info btn-block" title="Cancel">Cancel</a>
					</div>
				</div>
			</div>
				
		</form>
		
	</div>
	
</div>