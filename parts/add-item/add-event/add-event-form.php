<?php
if (isset($_GET['catid'])) {
$cat_id = $_GET['catid'];
} else {
$cat = get_category_by_slug( 'events' );	
$cat_id = $cat->term_id;
}
//echo '<pre>';print_r($cat);echo '</pre>';
?>
<div class="form">
	<div class="form-wrap">
	
		<form action="<?php the_permalink(); ?>" method="post" style="margin-bottom: 20px;" class="post-form" id="add_post_form">
		
			<input type="hidden" name="userid" value="<?php echo get_current_user_id(); ?>">
			<input type="hidden" name="httpref" value="<?php echo $return_url; ?>">
			<input type="hidden" name="cat" value="<?php echo $cat_id; ?>">
			
			<?php if ( $post_id ) { ?>
			<input type="hidden" name="postid" value="<?php echo $post_id; ?>">
			<?php } ?>
		
			
			<div class="form-group">
				<input type="text" id="title" name="title" class="form-control input-lg" placeholder="Enter event name" value="<?php echo ($_POST['title']) ? $_POST['title']:'' ;?>">
			</div>
			
			<div class="form-group">
				<input type="text" id="event_date" name="event_date" class="form-control input-lg date-picker" placeholder="Choose a date" value="<?php echo ($_POST['event_date']) ? $_POST['event_date']:'' ;?>">
			</div>
			
			<div class="form-group">
				<div class="row">
					<div class="col-xs-6">
						
						<div class="input-group">
							<div class="input-group-btn">
								<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" style="width: 150px;">Start hour <span class="caret"></span></button>
								<ul class="dropdown-menu" id="start-hr-select" role="menu">
								<?php for($h = 0 ; $h <= 23; $h++) { ?>
				       				<li><a href="#"><?php echo sprintf('%02d', $h); ?></a></li>
					   			<?php } ?>
					   			</ul>
					   		</div><!-- /btn-group -->
					   		<input type="text" class="form-control" name="start_hrs" id="start_hrs" value="<?php echo (isset($_POST['start_hrs'])) ?  $_POST['start_hrs']:"00"; ?>" readonly>
					   		<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
						</div>
						
					</div>
					
					<div class="col-xs-6">
						
						<div class="input-group">
							<div class="input-group-btn">
								<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" style="width: 150px;">Start mins <span class="caret"></span></button>
								<ul class="dropdown-menu" id="start-min-select" role="menu">
								<?php for($m = 0 ; $m <= 55; $m++) { ?>
									<?php if(($m % 5) == 0) { ?>
				       				<li><a href="#"><?php echo sprintf('%02d', $m); ?></a></li>
				       				<?php } ?>
					   			<?php } ?>
					   			</ul>
					   		</div><!-- /btn-group -->
					   		<input type="text" class="form-control" name="start_mins" id="start_mins" value="<?php echo (isset($_POST['start_mins'])) ?  $_POST['start_mins']:"00"; ?>" readonly>
					   		<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
						</div>
					
					</div>
				</div>
			</div>
			
				<div class="form-group">
					<div class="row">
						<div class="col-xs-6">
							
							<div class="input-group">
								<div class="input-group-btn">
									<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" style="width: 150px;">End hour <span class="caret"></span></button>
									<ul class="dropdown-menu" id="end-hr-select" role="menu">
									<?php for($h = 0 ; $h <= 23; $h++) { ?>
					       				<li><a href="#"><?php echo sprintf('%02d', $h); ?></a></li>
						   			<?php } ?>
						   			</ul>
						   		</div><!-- /btn-group -->
						   		<input type="text" class="form-control" name="end_hrs" id="end_hrs" value="<?php echo (isset($_POST['end_hrs'])) ?  $_POST['end_hrs']:"00"; ?>" readonly>
						   		<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
							</div>
							
						</div>
						
						<div class="col-xs-6">
							
							<div class="input-group">
								<div class="input-group-btn">
									<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" style="width: 150px;">End mins <span class="caret"></span></button>
									<ul class="dropdown-menu" id="end-min-select" role="menu">
									<?php for($m = 0 ; $m <= 55; $m++) { ?>
										<?php if(($m % 5) == 0) { ?>
					       				<li><a href="#"><?php echo sprintf('%02d', $m); ?></a></li>
					       				<?php } ?>
						   			<?php } ?>
						   			</ul>
						   		</div><!-- /btn-group -->
						   		<input type="text" class="form-control" name="end_mins" id="end_mins" value="<?php echo (isset($_POST['end_mins'])) ?  $_POST['end_mins']:"00"; ?>" readonly>
						   		<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
							</div>
						
						</div>
					</div>
				</div>

			
			<div class="form-group">
				<input type="text" id="location" name="location" class="form-control input-lg" placeholder="Enter location" value="<?php echo ($_POST['location']) ? $_POST['location']:'' ;?>">
			</div>
			
			<div class="form-group">
				<?php 
				if ($_POST['addpost']) {
				$content = $_POST['addpost'];	
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
					
			<div class="action-btns col-red">
				<div class="row">
					<div class="col-xs-6">
						<?php wp_nonce_field( 'post_nonce', 'post_nonce_field' ); ?>
						<?php if ( $post_id ) { ?>
						<input type="submit" name="add-event" value="Change Event" class="btn btn-info btn-block">
						<?php } else {?>
						<input type="submit" name="add-event" value="Submit Event" class="btn btn-info btn-block">
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