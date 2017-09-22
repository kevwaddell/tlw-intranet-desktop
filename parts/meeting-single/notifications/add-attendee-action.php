<?php if ( $_POST['add_attendee'] ) { 
//echo '<pre>';print_r($_POST);echo '</pre>';	
	
?>

<?php 
$errors = array();

if ($_POST['attendee_type'] == "0") {
$errors[] = "Please choose an external or internal attendee.";		
} else {
$errors = array();	
}

//echo '<pre>';print_r($errors);echo '</pre>';

if ( $_POST['attendee_type'] == "internal" && empty($errors) ) { 
		
		if ( $_POST['staff_member'] == 0 ) {
		$errors[] = "You did not select an internal attendee.";
		}
		
		$meta_key = "attendees_staff_".$_POST['staff_key']."_attendee_staff";
		$meta_value = $_POST['staff_member'];
		
		$status_meta_key = "attendees_staff_".$_POST['staff_key']."_status";
		
		if ($start_time > $now) {
			$status_value = "pending";
		} else {
			$status_value = "accepted";	
		}
		
		$field_meta_key = "_attendees_staff_".$_POST['staff_key']."_attendee_staff";
		$field_meta_value = $_POST['staff_field_key'];
		
		$status_field_meta_key = "_attendees_staff_".$_POST['staff_key']."_status";
		$status_field_meta_value = $_POST['status_field_key'];
		
		$attendees_staff_total = $_POST['staff_key']+1;
		
		add_post_meta(get_the_ID(), $meta_key, $meta_value, true);
		add_post_meta(get_the_ID(), $field_meta_key, $field_meta_value, true);
		add_post_meta(get_the_ID(), $status_meta_key, $status_value, true);
		add_post_meta(get_the_ID(), $status_field_meta_key, $status_field_meta_value, true);
		update_post_meta(get_the_ID(), 'attendees_staff', $attendees_staff_total);
		
		$user = get_user_by('id', $meta_value);
		$user_meta = get_user_meta($meta_value);
		
}	

if ( $_POST['attendee_type'] == "external" && empty($errors) ) { 
	
		if (trim($_POST['external_name']) == "") { 
		$errors[] = "You did not enter an attendee name.";
		}
			
		if (empty($errors)) {
		
			$ext_key = "attendees_clients_".$_POST['client_key']."_attendee_client";
			$ext_value = trim($_POST['external_name']);
		
			$field_ext_key = "_attendees_clients_".$_POST['client_key']."_attendee_client";
			$field_ext_value = $_POST['client_field_key'];
			$attendees_ext_total = $_POST['client_key']+1;
		
			add_post_meta(get_the_ID(), $ext_key, $ext_value, true);
			add_post_meta(get_the_ID(), $field_ext_key, $field_ext_value, true);
			update_post_meta(get_the_ID(), 'attendees_clients', $attendees_ext_total);	
		} 
}
?>

	<?php if (empty($errors) && $_POST['attendee_type'] == "internal") { ?>

	<div class="alert alert-success text-center">
		
		<h4><i class="fa fa-check-circle"></i> Success</h4>
		
		<strong><?php echo $user->data->display_name; ?></strong> has been added to Internal attendees.<br> 
		
		<?php if ($start_time > $now) { ?>
		You may now notify <strong><?php echo $user_meta['first_name'][0]; ?></strong> of the meeting.<br><br>
		<?php } else { ?>
		<br>
		<?php } ?>
		
		<div class="action-btns">
			
			<?php if ($start_time > $now) { ?>
			<div class="row">
				<div class="col-xs-6">
					<a href="?action=notify_attendee&user_key=<?php echo $_POST['staff_key']; ?>&user=<?php echo $_POST['staff_member']; ?>" class="btn btn-success btn-block notify btn-action"><i class="fa fa-bullhorn fa-lg"></i> Notify now</a>
				</div>
				<div class="col-xs-6">
					<a href="<?php the_permalink(); ?>" class="btn btn-success btn-block"><i class="fa fa-clock-o fa-lg"></i> Notify later</a>
				</div>
			</div>
			<?php } else { ?>
			
				<a href="<?php the_permalink(); ?>" class="btn btn-success btn-block">Continue</a>
				
			<?php } ?>
			
		</div>
	
	</div>	

	<?php } ?>

	<?php if ( empty($errors) && $_POST['attendee_type'] == "external" ) { ?>
		
	<div class="alert alert-success text-center">
		
		<h4><i class="fa fa-check-circle"></i> Success</h4>
		
		<strong><?php echo $ext_value; ?></strong> has been added to External attendees.<br><br>
		
		<div class="action-btns">
			<a href="<?php the_permalink(); ?>" class="btn btn-success btn-block">Continue</a>
		</div>
		
	</div>
		
	<?php } ?>

	<?php if ( !empty($errors) ) { ?>
		
	<div class="alert alert-danger text-center">
	
	<h4><i class="fa fa-plus-circle"></i> Add Attendee</h4>
	
	<div class="well well-sm errors">
	    <p>Errors!</p>
		<ul>
		<?php foreach ($errors as $error) { ?>
		<li><?php echo $error; ?></li>
		<?php } ?>
		</ul>
	</div>
	
	<?php include (STYLESHEETPATH . '/_/inc/meeting-single/notifications/add-attendee-form.php'); ?>

	</div>
		
	<?php } ?>

<?php } ?>