<?php if (isset($_GET['request']) && $_GET['request'] == "cancel_meeting") { 
$room = wp_get_post_terms( get_the_ID(), 'tlw_rooms_tax');
$description = get_field('meeting_description');
?>

<div class="alert alert-warning text-center">
	
	<h4><i class="fa fa-warning"></i> Confirm</h4>
	
	Are you sure you want to cancel <strong><?php echo $description; ?></strong> meeting.<br><br>

	<div class="action-btns">
	
		<div class="row">
			<div class="col-xs-6">
				<a href="<?php echo get_permalink($meetings->ID); ?>?action=cancel_meeting&meetingid=<?php echo get_the_ID();?>" class="btn btn-danger btn-block"><i class="fa fa-check fa-lg"></i> Yes</a>
			</div>
			<div class="col-xs-6">
				<a href="<?php the_permalink(); ?>" class="btn btn-danger btn-block"><i class="fa fa-times fa-lg"></i> No</a>
			</div>
		</div>
		
	</div>

</div>

<div class="rule"></div>

<?php }  ?>