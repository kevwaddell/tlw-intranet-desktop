<?php
$form_url = explode("?", $_SERVER['REQUEST_URI']);
//echo '<pre>';print_r(explode("?", $_SERVER['REQUEST_URI']));echo '</pre>';
//echo '<pre>';print_r($_REQUEST);echo '</pre>';
 ?>

<form action="<?php echo get_option('home'); ?><?php echo $form_url[0]; ?>" method="post" class="holiday-form" id="add_holiday_form">

	
	<small class="required">Required</small>
	
	<?php if (current_user_can("administrator") ) { 
	$users = get_users();
	?>
	
	<div class="form-group">
		<select name="userid" class="form-control">
			<option value="0">Select a user</option>
		<?php foreach ($users as $u) { 
		//echo '<pre>';print_r($u);echo '</pre>';
		?>
			<option value="<?php echo $u->ID; ?>"<?php echo ( $_REQUEST['userid'] == $u->ID ) ? ' selected="selected"':''; ?>> <?php echo $u->data->display_name; ?></option>
		<?php } ?>
		</select>
	</div>
	
	<?php } else { ?>
	
	<input type="hidden" name="userid" id="userid" value="<?php echo $_GET['userid']; ?>">	
		
	<?php } ?>
	
	<div class="form-group">
		<div class="input-group">
			<span class="input-group-addon required" style="width: 110px;"><i class="fa fa-calendar"></i> Date*</span>
			<input type="text" id="holiday_start_date" name="holiday_start_date" class="form-control date-picker" placeholder="Choose a date" value="<?php echo (isset($_POST['holiday_start_date'])) ? $_POST['holiday_start_date']:""; ?>">
			<span class="input-group-addon"><input type="checkbox" name="start_half_day" value="y"<?php echo ($_POST['start_half_day'] == 'y') ? ' checked="checked"':''; ?>> Half day</span>
		</div>
	</div>
	
	<div class="form-group form-inline">
		<label style="width: 140px;">Number of days: </label>
		<input type="radio" name="day_amount" id="day_amount_single" style="margin-left: 10px;" value="single"<?php echo (!isset($_POST['day_amount']) || $_POST['day_amount'] == 'single') ? ' checked="checked"':''; ?>> Single 
		<input type="radio" name="day_amount" id="day_amount_multiple" style="margin-left: 10px;" value="multiple"<?php echo ($_POST['day_amount'] == 'multiple') ? ' checked="checked"':''; ?>> Multiple
	</div>
	
	<div class="form-group form-inline<?php echo (isset($_POST['start_half_day'])) ? '':' hidden'; ?>">
		<label style="width: 140px;">AM/PM: </label>
		<input type="radio" name="day_time" id="day_time_am" style="margin-left: 10px;" value="am"<?php echo (!isset($_POST['day_time']) || $_POST['day_time'] == 'am') ? ' checked="checked"':''; ?>> Morning (AM)
		<input type="radio" name="day_time" id="day_time_pm" style="margin-left: 10px;" value="pm"<?php echo ($_POST['day_time'] == 'pm') ? ' checked="checked"':''; ?>> Afternoon (PM)
	</div>

	<div class="form-group <?php echo ($_POST['day_amount'] == 'multiple') ? '':' hidden'; ?>">
		<div class="input-group">
			<span class="input-group-addon required" style="width: 110px;"><i class="fa fa-calendar"></i> Last Day*</span>
			<input type="text" id="holiday_end_date" name="holiday_end_date" class="form-control date-picker" placeholder="Choose a date" value="<?php echo (isset($_POST['holiday_end_date'])) ? $_POST['holiday_end_date']:""; ?>">
			<span class="input-group-addon"><input type="checkbox" name="end_half_day" value="y"<?php echo ($_POST['end_half_day'] == 'y') ? ' checked="checked"':''; ?>> Half day</span>
		</div>
	</div>

			
	<div class="action-btns">
		<div class="row">
			<div class="col-xs-6">
				<input type="submit" value="Add Holiday" name="add_holiday" class="btn btn-info btn-block">
			</div>
			<div class="col-xs-6">
			<a href="<?php echo get_option('home'); ?><?php echo $form_url[0]; ?>" class="btn btn-info btn-block cancel-btn" title="Cancel">Cancel</a>
			</div>
		</div>
	</div>
		
</form>