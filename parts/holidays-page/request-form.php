<?php
global $add_holiday_errors;	
global $number_of_holidays;	
global $now_dateTime;
?>
<div class="request-form">
	
	<?php get_template_part( 'parts/holidays-page/form', 'errors' ); ?>
	
	<form action="<?php the_permalink(); ?>" method="post">
	<table class="table table-striped">
		<thead>
			<tr>
				<th colspan="4">
					<h2><?php if ($_REQUEST['holiday-actions'] == 'edit-holiday' || isset($_POST['update-holiday'])) { ?>
						<i class="fa fa-calendar-check-o"></i>
						Update holiday
						<?php } ?>
						<?php if ($_REQUEST['holiday-actions'] == 'add-holiday' || isset($_POST['add-holiday'])) { ?>
						<i class="fa fa-calendar-plus-o"></i> 
						Add holiday
						<?php } ?>
						<?php if ($_REQUEST['holiday-actions'] == 'request-holiday') { ?>
						<i class="fa fa-calendar-check-o"></i> 
						Request holiday 
						<?php } ?></h2>
					<small class="text-danger">*Please note: If you need to take 1 day or 1/2 a day please put the same date in 'First day' and 'Last day' fields<br>and choose either 'Full day' for 1 day or 'Half day' for 1/2 a day on both entries.</small>
				</th>
			</tr>
		</thead>
		</thead>
		<tbody>
			<tr>
				<th>Date booked</th>
				<th>First day</th>
				<th>Last day</th>
			</tr>	
			<tr>
				<td>
					<div class="input-group date holiday-datepicker" id="h-date-bookded-datepicker">
						<?php if ($_REQUEST['holiday-actions'] == 'edit-holiday') { ?>
						<input type="text" class="form-control input-sm" name="date-booked" value="<?php echo date('l jS F, Y', strtotime($_REQUEST['date-booked'])); ?>">
						<?php } else { ?>
						<input type="text" class="form-control input-sm" name="date-booked" value="<?php echo (isset($_POST['date-booked'])) ? $_POST['date-booked']: $now_dateTime->format('l jS F, Y'); ?>">
						<?php } ?>
						<span class="input-group-addon"><span class="fa fa-calendar"></span></span>
					</div>
				</td>
				<td>
					<div class="input-group date holiday-datepicker" id="h-date-from-datepicker">
						<?php if ($_REQUEST['holiday-actions'] == 'edit-holiday') { ?>
						<input type="text" class="form-control input-sm" name="date-from" value="<?php echo date('l jS F, Y', strtotime($_REQUEST['date-from'])); ?>">
						<?php } else { ?>
						<input type="text" class="form-control input-sm" name="date-from" value="<?php echo (isset($_POST['date-from'])) ? $_POST['date-from']:''; ?>">
						<?php } ?>
						<span class="input-group-addon"><span class="fa fa-calendar"></span></span>
					</div>
					<div class="form-group text-center">
						<label class="radio-inline">
							<input type="radio" name="date-from-length" <?php echo ($_REQUEST['date-from-length'] == 'full') ? 'checked="checked" ':''; ?><?php echo (!isset($_REQUEST['date-from-length'])) ? 'checked="checked" ':''; ?>value="full"> Full day
						</label>
						<label class="radio-inline">
							<input type="radio" name="date-from-length" <?php echo ($_REQUEST['date-from-length'] == 'am') ? 'checked="checked" ':''; ?>value="am"> AM
						</label>	
						<label class="radio-inline">
							<input type="radio" name="date-from-length" <?php echo ($_REQUEST['date-from-length'] == 'pm') ? 'checked="checked" ':''; ?>value="pm"> PM
						</label>					
					</div>
				</td>
				<td>
					<div class="input-group date holiday-datepicker" id="h-date-to-datepicker">
						<?php if ($_REQUEST['holiday-actions'] == 'edit-holiday') { ?>
						<input type="text" class="form-control input-sm" name="date-to" value="<?php echo date('l jS F, Y', strtotime($_REQUEST['date-to'])); ?>">
						<?php } else { ?>
						<input type="text" class="form-control input-sm" name="date-to" value="<?php echo (isset($_POST['date-to'])) ? $_POST['date-to']:''; ?>">
						<?php } ?>
						<span class="input-group-addon"><span class="fa fa-calendar"></span></span>
					</div>
					<div class="form-group text-center">
						<label class="radio-inline">
							<input type="radio" name="date-to-length" <?php echo ($_REQUEST['date-to-length'] == 'full') ? 'checked="checked" ':''; ?><?php echo (!isset($_REQUEST['date-to-length'])) ? 'checked="checked" ':''; ?>value="full"> Full day
						</label>
						<label class="radio-inline">
							<input type="radio" name="date-to-length" <?php echo ($_REQUEST['date-to-length'] == 'am') ? 'checked="checked" ':''; ?>value="am"> AM
						</label>	
						<label class="radio-inline">
							<input type="radio" name="date-to-length" <?php echo ($_REQUEST['date-to-length'] == 'pm') ? 'checked="checked" ':''; ?>value="pm"> PM
						</label>						
					</div>
				</td>
			</tr>
		</tbody>
	</table>
	<br>	
	<input type="hidden" name="days-remaining" value="<?php echo $number_of_holidays; ?>">
	<input type="hidden" name="approved" value="<?php echo ($_REQUEST['approved'] == 'yes') ? 'yes':'no'; ?>">
	<div class="row">
		<div class="col-xs-6">
		<?php if ($_REQUEST['holiday-actions'] == 'edit-holiday') { ?>
		<input type="hidden" name="holiday-id" value="<?php echo $_REQUEST['holiday-id']; ?>">
		<button type="submit" class="btn btn-default btn-block caps" name="update-holiday">Update <i class="fa fa-save"></i></button>
		<?php } else { ?>
		<input type="hidden" name="holiday-id" value="<?php echo rand(1000, 9999); ?>">
		<button type="submit" class="btn btn-default btn-block caps" name="add-holiday">Submit <i class="fa fa-plus"></i></button>
		<?php } ?>
		</div>
		<div class="col-xs-6">
			<a href="<?php get_permalink() ?>" class="btn btn-default btn-block caps">Cancel <i class="fa fa-times"></i></a>
		</div>
	</div>
</form>
</div>