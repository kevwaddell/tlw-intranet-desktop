<?php if ( $_GET['request'] == 'remove_from_favs') {  
$page_url = explode("?", $_SERVER['REQUEST_URI']);

$fav_post = get_post($_GET['postid']);

$postid = $fav_post->ID;
$type = $fav_post->post_type;
?>

<div class="alert alert-success text-center">

	<h4><i class="fa fa-check-circle fa-lg"></i> Confirm</h4>
	
	Are you sure want to remove<br><strong><?php echo $fav_post->post_title; ?></strong><br>from your favourites.<br><br>
	
	<div class="action-btns">
		
		<div class="row">
			<div class="col-xs-6">
				<a href="?action=remove_from_favs&postid=<?php echo $postid;?>" class="btn btn-success btn-block"><i class="fa fa-check fa-lg"></i> Yes</a>
			</div>
			<div class="col-xs-6">
				<a href="<?php echo $page_url[0]; ?>" class="btn btn-danger btn-block"><i class="fa fa-times fa-lg"></i> No</a>
			</div>
		</div>
	</div>

</div>

<?php } ?>