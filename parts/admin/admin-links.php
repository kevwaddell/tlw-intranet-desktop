<?php 
$add_new_user = admin_url('user-new.php');
$all_users = admin_url('users.php');

$add_new_page = admin_url('post-new.php?post_type=page');
$all_pages = admin_url('edit.php?post_type=page');

$add_new_post = admin_url('post-new.php?post_type=post');
$all_posts = admin_url('edit.php');

$dashboard = admin_url('index.php');
$dashboard_updates = admin_url('update-core.php');

$upload_media = admin_url('media-new.php');
$all_media = admin_url('upload.php');

$menus = admin_url('nav-menus.php');
$background = admin_url('themes.php?page=custom-background');
//echo '<pre>';print_r($add_new_user);echo '</pre>';

?>
<div class="row">
	<div class="col-xs-6">
		<h3 class="block-header"><i class="fa fa-group fa-lg"></i>Users</h3>
		<div class="action-btns col-red">
			<a href="<?php echo $add_new_user; ?>" class="btn btn-default btn-block" target="_blank"><i class="fa fa-plus"></i>Add a new user</a>
			<a href="<?php echo $all_users; ?>" class="btn btn-default btn-block" target="_blank"><i class="fa fa-eye"></i>View all users</a>
		</div>
		
		<h3 class="block-header"><i class="fa fa-file fa-lg"></i>Pages</h3>
		<div class="action-btns col-red">
			<a href="<?php echo $add_new_page; ?>" class="btn btn-default btn-block" target="_blank"><i class="fa fa-plus"></i>Add a new page</a>
			<a href="<?php echo $all_pages; ?>" class="btn btn-default btn-block" target="_blank"><i class="fa fa-eye"></i>All pages</a>
		</div>
		
		<h3 class="block-header"><i class="fa fa-rss fa-lg"></i>News</h3>
		<div class="action-btns col-red">
			<a href="<?php echo $add_new_post; ?>" class="btn btn-default btn-block" target="_blank"><i class="fa fa-plus"></i>Add a new article</a>
			<a href="<?php echo $all_posts; ?>" class="btn btn-default btn-block" target="_blank"><i class="fa fa-eye"></i>All news articles</a>
		</div>
	</div>
	
	<div class="col-xs-6">
		<h3 class="block-header"><i class="fa fa-dashboard fa-lg"></i>Dashboard</h3>
		<div class="action-btns col-red">
			<a href="<?php echo $dashboard; ?>" class="btn btn-default btn-block" target="_blank"><i class="fa fa-home"></i>Admin home</a>
			<a href="<?php echo $dashboard_updates; ?>" class="btn btn-default btn-block" target="_blank"><i class="fa fa-eye"></i>Updates</a>
		</div>


		<h3 class="block-header"><i class="fa fa-camera fa-lg"></i>Media</h3>
		<div class="action-btns col-red">
			<a href="<?php echo $upload_media; ?>" class="btn btn-default btn-block" target="_blank"><i class="fa fa-upload"></i>Upload media</a>
			<a href="<?php echo $all_media; ?>" class="btn btn-default btn-block" target="_blank"><i class="fa fa-eye"></i>View all media</a>
		</div>
		
		<h3 class="block-header"><i class="fa fa-paint-brush fa-lg"></i>Appearance</h3>
		<div class="action-btns col-red">
			<a href="<?php echo $menus; ?>" class="btn btn-default btn-block" target="_blank"><i class="fa fa-navicon"></i>Menus</a>
			<a href="<?php echo $background; ?>" class="btn btn-default btn-block" target="_blank"><i class="fa fa-image"></i>Background</a>
		</div>
		
	</div>
</div>