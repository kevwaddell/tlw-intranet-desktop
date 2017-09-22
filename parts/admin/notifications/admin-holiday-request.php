<?php if (isset($_GET['admin_request'])) { ?>
	
<div class="alert alert-success text-center" style="margin-bottom: 10px;">

	<h4>Do you want to approve the holiday request for:</h4>
	<strong><?php echo $booked_by->data->display_name; ?></strong><br>
	Date: <strong>
	<?php echo date('D jS F Y', $start_date); ?>
	
	<?php if (date("H", $start_date) != "00") { ?>
	<?php echo ' at '. date( 'g:ia',  $start_date); ?>
	<?php } ?>
	
	<?php if (date("Ymd", $start_date) == date("Ymd", $end_date) && date("H", $end_date) != "00") { ?>
	<?php echo ' - '.date( 'g:ia',  $end_date); ?>
	<?php } ?>
	</strong><br>
	
	<?php if (date("Ymd", $end_date) > date("Ymd", $start_date)) { ?>
	Last day: <strong>
	<?php echo date('D jS F Y', $end_date ); ?>
	
	<?php if (date("H", $end_date) != "00") { ?>
	<?php echo ' at '. date( 'g:ia', $end_date); ?>
	<?php } ?>
	</strong><br>
	<?php } ?>

	Number of days: <strong><?php echo $number_of_days; ?></strong>
	<br><br>

	<div class="action-btns">

		<div class="row">
			<div class="col-xs-6">
				<a href="?holiday_approval=yes&num_days=<?php echo $number_of_days; ?>&holidayid=<?php echo $holiday->ID;?>" class="btn btn-success btn-block"><i class="fa fa-check fa-lg"></i> Yes</a>
			</div>
			<div class="col-xs-6">
				<a href="?holiday_approval=no&holidayid=<?php echo $holiday->ID;?>" class="btn btn-danger btn-block"><i class="fa fa-times fa-lg"></i> No</a>
			</div>
		</div>
	
	</div>

</div>

<?php } ?>