<?php 
$form_url = explode("?", $_SERVER['REQUEST_URI']);
//echo '<pre>';print_r($_GET);echo '</pre>';
?>

<form action="<?php echo get_option('home'); ?><?php echo $form_url[0]; ?>" method="post" class="meeting-form" id="add_meeting_form">
	
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
			<option value="<?php echo $u->ID; ?>"<?php echo ($_REQUEST['userid'] == $u->ID) ? ' selected="selected"':''; ?>> <?php echo $u->data->display_name; ?></option>
		<?php } ?>
		</select>
	</div>
	
	<?php } else { ?>
	
	<input type="hidden" name="userid" id="userid" value="<?php echo $_GET['userid']; ?>">	
		
	<?php } ?>
	
	<div class="form-group">
		<div class="input-group">
			<span class="input-group-addon required" style="width: 150px;">Meeting description</span>
			<input type="text" id="meeting_description" name="description" class="form-control" placeholder="Enter a meeting description" value="<?php echo (isset($_POST['description'])) ? $_POST['description']:""; ?>">
			<span class="input-group-addon"><i class="fa fa-info-circle"></i></span>
		</div>
		<p class="help-block">e.g (Weekly team meeting).</p>
	</div>
	
	<div class="form-group">
		<div class="input-group">
			<div class="input-group-btn required">
		        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" style="width: 150px;">Room <span class="caret"></span></button>
		        <ul class="dropdown-menu" id="meeting-room-select" role="menu">
		        <?php foreach ($rooms as $room) { ?>
		        	<li><a href="#" id="room-<?php echo $room->term_id; ?>"><?php echo $room->name; ?></a></li>
		        <?php } ?>
		        </ul>
			</div><!-- /btn-group -->
	       <input type="text" class="form-control" name="meeting_room_name" id="meeting_room_name" placeholder="Choose a meeting room" value="<?php echo (isset($_POST['meeting_room_name'])) ?  stripslashes($_POST['meeting_room_name']):""; ?>" readonly>
	       <span class="input-group-addon"><i class="fa fa-cube"></i></span>
		</div>
		<input type="hidden" name="meeting_room" id="meeting_room" value="0">
	</div>
	
	<div class="form-group">
	<div class="input-group">
		<span class="input-group-addon required" style="width: 150px;">Date</span>
		<input type="text" id="meeting_date" name="meeting_date" class="form-control date-picker" placeholder="Choose a date" value="<?php echo (isset($_POST['meeting_date'])) ? $_POST['meeting_date']:""; ?>">
		<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
	</div>
	</div>
	
	<div class="form-group">
		<div class="row">
			<div class="col-xs-6">
				
				<div class="input-group">
					<div class="input-group-btn">
						<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" style="width: 150px;">Start hour <span class="caret"></span></button>
						<ul class="dropdown-menu" id="start-meeting-hr-select" role="menu">
						<?php for($h = 9 ; $h <= 17; $h++) { ?>
		       				<li><a href="#"><?php echo sprintf('%02d', $h); ?></a></li>
			   			<?php } ?>
			   			</ul>
			   		</div><!-- /btn-group -->
			   		<input type="text" class="form-control" name="start_hrs" id="start_hrs" value="<?php echo (isset($_POST['start_hrs'])) ?  $_POST['start_hrs']:"09"; ?>" readonly>
			   		<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
				</div>
				
			</div>
			
			<div class="col-xs-6">
				
				<div class="input-group">
					<div class="input-group-btn">
						<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" style="width: 150px;">Start mins <span class="caret"></span></button>
						<ul class="dropdown-menu" id="start-meeting-min-select" role="menu">
						<?php for($m = 0 ; $m <= 55; $m++) { ?>
							<?php if(($m % 15) == 0) { ?>
		       				<li><a href="#"><?php echo sprintf('%02d', $m); ?></a></li>
		       				<?php } ?>
			   			<?php } ?>
			   			</ul>
			   		</div><!-- /btn-group -->
			   		<input type="text" class="form-control" name="start_mins" id="start_mins" value="<?php echo (isset($_POST['start_mins'])) ?  $_POST['start_mins']:"00"; ?>" readonly>
			   		<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
				</div>
			
			</div>
		</div>
	</div>
	
	<div class="form-group">
		<div class="row">
			<div class="col-xs-6">
				
				<div class="input-group">
					<div class="input-group-btn">
						<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" style="width: 150px;">End hour <span class="caret"></span></button>
						<ul class="dropdown-menu" id="end-meeting-hr-select" role="menu">
						<?php for($h = 9 ; $h <= 17; $h++) { ?>
		       				<li><a href="#"><?php echo sprintf('%02d', $h); ?></a></li>
			   			<?php } ?>
			   			</ul>
			   		</div><!-- /btn-group -->
			   		<input type="text" class="form-control" name="end_hrs" id="end_hrs" value="<?php echo (isset($_POST['end_hrs'])) ?  $_POST['end_hrs']:"09"; ?>" readonly>
			   		<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
				</div>
				
			</div>
			
			<div class="col-xs-6">
				
				<div class="input-group">
					<div class="input-group-btn">
						<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" style="width: 150px;">End mins <span class="caret"></span></button>
						<ul class="dropdown-menu" id="end-meeting-min-select" role="menu">
						<?php for($m = 0 ; $m <= 55; $m++) { ?>
							<?php if(($m % 15) == 0) { ?>
		       				<li><a href="#"><?php echo sprintf('%02d', $m); ?></a></li>
		       				<?php } ?>
			   			<?php } ?>
			   			</ul>
			   		</div><!-- /btn-group -->
			   		<input type="text" class="form-control" name="end_mins" id="end_mins" value="<?php echo (isset($_POST['end_mins'])) ?  $_POST['end_mins']:"00"; ?>" readonly>
			   		<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
				</div>
			
			</div>
		</div>
	</div>
	
	<div class="action-btns">
		<div class="row">
			<div class="col-xs-6">
				<?php wp_nonce_field( 'post_nonce', 'post_nonce_field' ); ?>
				<input type="submit" value="Send request" name="add_meeting" class="btn btn-info btn-block">
			</div>
			<div class="col-xs-6">
			<a href="<?php echo get_permalink($send_id); ?>" class="btn btn-info btn-block cancel-btn" title="Cancel">Cancel</a>
			</div>
		</div>
	</div>
		
</form>