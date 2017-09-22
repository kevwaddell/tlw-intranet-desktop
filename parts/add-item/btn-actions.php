<div class="post-actions<?php echo (!empty($color)) ? " col-".$color:""; ?>">

	<?php if (!empty($post->post_content)) { ?>
	<button id="show-info" class="btn<?php echo (isset($_GET['request']) || isset($_GET['action']) || $_SERVER['REQUEST_METHOD'] === 'POST') ? "":" disabled"; ?>" title="Help"><span>Help</span><i class="fa fa-life-ring fa-lg"></i></button>
	<?php } ?>
		
	<button class="btn" title="View video" data-toggle="modal" data-target="#help-video"><span>Help video</span><i class="fa fa-video-camera fa-lg"></i></button>
		
</div>