<?php if (isset($_GET['meetingid']) && $_GET['action'] == "delete_meeting") { 

$page_url = explode("?", $_SERVER['REQUEST_URI']);

$meeting = get_post($_GET['meetingid']);
$room = wp_get_post_terms( $meeting->ID, 'tlw_rooms_tax');
$description = get_field('meeting_description', $meeting->ID);

	if ($meeting->post_status == 'draft') {
		wp_delete_post( $meeting->ID, true );
	} 

?>

<div class="alert alert-success text-center">
	
	<h4><i class="fa fa-check-circle"></i> Success</h4>
	
	Booking of <strong><?php echo $room[0]->name; ?></strong> for <strong><?php echo $description; ?></strong> meeting has been deleted.</strong><br><br>

	<div class="action-btns">
		<a href="<?php echo $page_url[0]; ?>" class="btn btn-success btn-block">Continue</a>
	</div>
</div>

<div class="rule"></div>

<?php }  ?>
