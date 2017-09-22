<?php if (isset($_GET['meetingid']) && $_GET['request'] == "delete_meeting") { 

$page_url = explode("?", $_SERVER['REQUEST_URI']);

$meeting = get_post($_GET['meetingid']);
$room = wp_get_post_terms( $meeting->ID, 'tlw_rooms_tax');
$description = get_field('meeting_description', $meeting->ID);
?>

<div class="alert alert-warning text-center">
	
	<h4><i class="fa fa-warning"></i> Confirm</h4>
	
	Are you sure you want to delete booking of <strong><?php echo $room[0]->name; ?></strong> for <strong><?php echo $description; ?></strong> meeting.<br><br>

	<div class="row">
		<div class="col-xs-6">
			<a href="?action=delete_meeting&meetingid=<?php echo $_GET['meetingid'];?>" class="btn btn-danger btn-block btn-action"><i class="fa fa-check fa-lg"></i> Yes</a>
		</div>
		<div class="col-xs-6">
			<a href="<?php echo $page_url[0]; ?>" class="btn btn-danger btn-block cancel-btn"><i class="fa fa-times fa-lg"></i> No</a>
		</div>
	</div>

</div>

<div class="rule"></div>

<?php }  ?>
