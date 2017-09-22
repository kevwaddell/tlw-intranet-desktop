<?php if (isset($_GET['meetingid']) && $_GET['request'] == "approve_meeting") { 

$page_url = explode("?", $_SERVER['REQUEST_URI']);


$meeting = get_post($_GET['meetingid']);
$room = wp_get_post_terms( $meeting->ID, 'tlw_rooms_tax');
$booked_by = get_user_by('id', $meeting->post_author);
$description = get_field('meeting_description', $meeting->ID);
$meeting_date_raw = get_field('meeting_date', $meeting->ID);
$meeting_date = date('l jS F, Y', strtotime($meeting_date_raw));
$start_time = get_field('start_time', $meeting->ID);
$end_time = get_field('end_time', $meeting->ID);
?>

<div class="alert alert-warning text-center">
	
	<h4><i class="fa fa-warning"></i> Confirm</h4>
	
	Do you want to approve booking of<br><strong><?php echo $room[0]->name; ?></strong> for <strong><?php echo $booked_by->data->display_name; ?></strong>.<br><br>

	<div class="action-btns">
	
		<div class="row">
			<div class="col-xs-6">
				<a href="?action=approve&meetingid=<?php echo $_GET['meetingid'];?>" class="btn btn-success btn-block"><i class="fa fa-check fa-lg"></i> Yes</a>
			</div>
			<div class="col-xs-6">
				<a href="<?php echo $page_url[0]; ?>" class="btn btn-danger btn-block"><i class="fa fa-times fa-lg"></i> No</a>
			</div>
		</div>
		
	</div>
	
</div>

<div class="rule"></div>

<?php }  ?>
