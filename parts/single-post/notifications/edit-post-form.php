<form action="<?php the_permalink(); ?>" method="post" style="margin-bottom: 20px;" class="post-form" id="edit_post_form">

	<input type="hidden" name="postid" id="postid" value="<?php echo get_the_ID(); ?>">
	
	<div class="form-group" style="padding-top: 10px;">
		<input type="text" id="title" name="title" class="form-control input-lg" placeholder="Enter a title" value="<?php echo get_the_title() ;?>">
	</div>
	
	<div class="form-group">
		<?php 
		$editor_css = array( 'content_css' => get_stylesheet_directory_uri().'/_/css/custom-editor-style.css');
		$settings = array( 
		'media_buttons' => false,
		'teeny' => true,
		'tinymce' => $editor_css
		);
		wp_editor( get_the_content(), "editpost", $settings ); 
		?>
	</div>
	
	<div class="form-group clearfix">
		<label for="cat" class="col-xs-2 control-label">Category:</label>
		 <div class="col-xs-10">
		<?php wp_dropdown_categories( 'selected='.$cat[0]->term_id.'&taxonomy=category&hide_empty=0&exclude=0&class=form-control' ); ?>
		</div>
	</div>
	
	<div class="form-group clearfix" style="margin-bottom: 20px;">
		<label for="post_tags" class="col-xs-2 control-label">Tags:</label>
		 <div class="col-xs-10">
			 <input type="text" class="form-control" value="<?php echo $tags; ?>" name="post_tags" id="post_tags" />
			 <span class="help-block">Additional Keywords (comma separated)</span>
		</div>
	</div>
			
	<div class="action-btns col-red">
		<div class="row">
			<div class="col-xs-6">
				<?php wp_nonce_field( 'post_nonce', 'post_nonce_field' ); ?>
				<input type="submit" value="Update Post" class="btn btn-info btn-block">
			</div>
			<div class="col-xs-6">
				<a href="<?php the_permalink(); ?>" class="btn btn-info btn-block cancel-btn" title="Cancel">Cancel</a>
			</div>
		</div>
	</div>
		
</form>