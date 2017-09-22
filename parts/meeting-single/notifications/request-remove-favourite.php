<?php if ( isset($_GET['request']) && $_GET['request'] == 'remove_from_favs') {  
$postid = $_GET['postid'];
$type = $_GET['type'];
?>

<div class="alert alert-success text-center">
	
Are you sure want to remove<br><strong><?php echo $post->post_title; ?></strong><br>from your favourites.<br><br>
	
<div class="action-btns">
		
	<div class="row">
		<div class="col-xs-6">
				<a href="?action=remove_from_favs&postid=<?php echo $postid;?>" class="btn btn-success btn-block"><i class="fa fa-check fa-lg"></i> Yes</a>
			</div>
			<div class="col-xs-6">
				<a href="<?php the_permalink(); ?>" class="btn btn-danger btn-block"><i class="fa fa-times fa-lg"></i> No</a>
			</div>
		</div>
	</div>

</div>

<?php } ?>