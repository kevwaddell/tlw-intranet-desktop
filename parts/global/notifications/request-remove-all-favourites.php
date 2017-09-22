<?php if ( $_GET['request'] == 'remove_all_favs') {  
$page_url = explode("?", $_SERVER['REQUEST_URI']);
$url = "?action=remove_all_favs";
$message = "";

if (isset($_GET['type'])) {
$url .= "&type=".$_GET['type'];	

if ($_GET['type'] == "tlw_meeting") {
$message = " for <strong>Meetings</strong>";	
}

}
if (isset($_GET['cat'])) {
$cat = get_category_by_slug( $_GET['cat'] );
$url .= "&cat=".$_GET['cat'];	
$message = " for <strong>".$cat->name."</strong>";
}
?>

<div class="alert alert-success text-center">
	
	<h4><i class="fa fa-check-circle fa-lg"></i> Success</h4>
	
	Are you sure want to remove all favourites<?php echo ($message != "") ? $message:''; ?>.<br><br>
	
	<div class="action-btns">
		
		<div class="row">
			<div class="col-xs-6">
				<a href="<?php echo $url;?>" class="btn btn-success btn-block"><i class="fa fa-check fa-lg"></i> Yes</a>
			</div>
			<div class="col-xs-6">
				<a href="<?php echo $page_url[0]; ?>" class="btn btn-danger btn-block"><i class="fa fa-times fa-lg"></i> No</a>
			</div>
		</div>
	</div>

</div>

<?php } ?>