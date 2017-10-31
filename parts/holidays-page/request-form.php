<?php
global $number_of_holidays;	
global $now_dateTime;
?>
<div class="request-form">
	<form action="<?php the_permalink(); ?>" method="post">
	<table class="table table-striped">
		<thead>
			<tr>
				<th colspan="4"><h2><i class="fa fa-calendar-plus-o"></i> Add or request a holiday</h2></th>
			</tr>
		</thead>
		</thead>
		<tbody>
			<tr>
				<th>Date booked</th>
				<th>First day</th>
				<th>Last day</th>
				<th width="15%">Approval needed</th>
			</tr>	
			<tr>
				<td>
					<div class="input-group date holiday-datepicker" id="h-date-bookded-datepicker">
						<input type="text" class="form-control input-sm" name="date-booked" value="<?php echo (isset($_POST['date-booked'])) ? $_POST['date-booked']: $now_dateTime->format('l jS F, Y'); ?>">
						<span class="input-group-addon"><span class="fa fa-calendar"></span></span>
					</div>
				</td>
				<td>
					<div class="input-group date holiday-datepicker" id="h-date-from-datepicker">
						<input type="text" class="form-control input-sm" name="date-from" value="<?php echo (isset($_POST['date-from'])) ? $_POST['date-from']:''; ?>">
						<span class="input-group-addon"><span class="fa fa-calendar"></span></span>
					</div>
					<div class="form-group text-center">
						<label class="radio-inline">
							<input type="radio" name="date-from-length" <?php echo ($_POST['date-from-length'] == 'full') ? 'checked="checked" ':''; ?><?php echo (!isset($_POST['date-from-length'])) ? 'checked="checked" ':''; ?>value="full"> Full day
						</label>
						<label class="radio-inline">
							<input type="radio" name="date-from-length" <?php echo ($_POST['date-from-length'] == 'half') ? 'checked="checked" ':''; ?>value="half"> Half day
						</label>						
					</div>
				</td>
				<td>
					<div class="input-group date holiday-datepicker" id="h-date-to-datepicker">
						<input type="text" class="form-control input-sm" name="date-to" value="<?php echo (isset($_POST['date-to'])) ? $_POST['date-to']:''; ?>">
						<span class="input-group-addon"><span class="fa fa-calendar"></span></span>
					</div>
					<div class="form-group text-center">
						<label class="radio-inline">
							<input type="radio" name="date-to-length" <?php echo ($_POST['date-to-length'] == 'full') ? 'checked="checked" ':''; ?><?php echo (!isset($_POST['date-to-length'])) ? 'checked="checked" ':''; ?>value="full"> Full day
						</label>
						<label class="radio-inline">
							<input type="radio" name="date-to-length" <?php echo ($_POST['date-to-length'] == 'half') ? 'checked="checked" ':''; ?>value="half"> Half day
						</label>						
					</div>
				</td>
				<td>
					<input id="approval-toggle" type="checkbox" data-toggle="toggle" data-onstyle="success" data-width="100%" data-size="small" data-on="Yes" data-off="No" name="approval" <?php echo (isset($_POST['approval'])) ? 'checked="checked" ':''; ?>value="yes">
				</td>
			</tr>
		</tbody>
	</table>
	<br>	
	<input type="hidden" class="form-control input-sm" name="days-remaining" value="<?php echo $number_of_holidays; ?>">
	<div class="row">
		<div class="col-xs-6">
	<button type="submit" class="btn btn-default btn-block caps" name="add-holiday">Submit <i class="fa fa-plus"></i></button>
		</div>
		<div class="col-xs-6">
			<a href="<?php get_permalink() ?>" class="btn btn-default btn-block caps">Cancel <i class="fa fa-times"></i></a>
		</div>
	</div>
</form>
</div>