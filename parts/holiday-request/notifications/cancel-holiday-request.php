<?php if ( isset($_GET['holidayid']) && $_GET['request'] == "cancel_holiday") {
	
	$cur_url = explode("?", $_SERVER['REQUEST_URI']);
	$holiday_id = $_GET['holidayid'];
	$numdays = $_GET['num_days'];
?>
<div class="alert alert-danger text-center">
	Are you sure you want to cancel your holiday booking.<br><br>
	<div class="action-btns">
		<div class="row">
			<div class="col-xs-6">
			
				<a href="?action=cancel_holiday&num_days=<?php echo $numdays; ?>&holidayid=<?php echo $holiday_id; ?>" class="btn btn-success btn-block btn-action"><i class="fa fa-check fa-lg"></i>Yes</a>
			</div>
			<div class="col-xs-6">
			
				<a href="<?php echo get_option('home'); ?><?php echo $cur_url[0]; ?>" class="btn btn-danger btn-block"><i class="fa fa-times fa-lg"></i>No</a>
			</div>
		</div>	
	</div>
	
</div>
<?php }  ?>
