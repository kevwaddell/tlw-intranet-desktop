<?php 
//array_push($excluded_staff, 1);
$excluded_staff = array(1);

if ($rb_admin['ID'] == '60') {
array_push($excluded_staff, $rb_admin['ID']);	
}

$all_users 	= get_users();	

foreach($all_users as $au) {
	if (empty($au->roles)) {
	//print_r($u->ID);echo '<br>';
	array_push($excluded_staff, $au->ID);
	}
}

$users_args = array(
'exclude'	=> $excluded_staff
);
$users 	= get_users($users_args);	

$staff_field_key = "field_53987829fecd8";
$status_field_key = "field_5399ae2a892eb";
$staff_attendees_total = $total_int;	
	
$client_field_key = "field_539878dcfecd9";
$client_attendees_total = $total_ext;
?>

<!--
<?php echo ($_POST['staff_member'] == $user->data->ID) ? ' selected':''; ?>
<?php echo ($_POST['attendee_type'] == "internal") ? ' external':''; ?>
<?php echo ($_POST['attendee_type'] == "internal") ? ' selected':''; ?>
-->

<form action="<?php the_permalink(); ?>" method="post" id="add_attendee_form">
	
	<div class="form-group">
	
		<select class="form-control selectpicker" id="attendee_type" name="attendee_type">
			<option value="0">Choose the type of attendee</option>
			<option value="internal"<?php echo ($_POST['attendee_type'] == "internal") ? ' selected':''; ?>>Internal</option>
			<option value="external"<?php echo ($_POST['attendee_type'] == "external") ? ' selected':''; ?>>External</option>
		</select>
		<span class="help-block">Choose either internal staff or external client.</span>
		
	</div>
	
	<div id="internal_attendee" class="form-group<?php echo (isset($_POST['attendee_type']) && $_POST['attendee_type'] != "0") ? '':' hidden'; ?>">
			
		<input type="hidden" value="<?php echo $staff_attendees_total; ?>" name="staff_key">
		<input type="hidden" value="<?php echo $staff_field_key; ?>" name="staff_field_key">
		<input type="hidden" value="<?php echo $status_field_key; ?>" name="status_field_key">
	
		<select class="form-control selectpicker" id="staff_member" name="staff_member">
			
			<option value="0">Choose staff member</option>
			
			<?php foreach ($users as $user) { ?>
			<option value="<?php echo $user->data->ID; ?>"<?php echo ($_POST['staff_member'] == $user->data->ID) ? ' selected':''; ?>><?php echo $user->data->display_name; ?></option>
			<?php } ?>
		</select>
		<span class="help-block">Choose an internal staff member.</span>
		
	</div>
	
	<div id="external_attendee" class="form-group hidden">
		
		<input type="hidden" value="<?php echo $client_attendees_total; ?>" name="client_key">
		<input type="hidden" value="<?php echo $client_field_key; ?>" name="client_field_key">
		
		<input type="text" class="form-control" placeholder="Full name" id="external_name" name="external_name">
		<span class="help-block">Enter the name of the attendee.</span>
		
	</div>
	
	<div class="action-btns">
		<div class="row">
		
			<div class="col-xs-6">
				<?php wp_nonce_field( 'post_nonce', 'post_nonce_field' ); ?>
				<input type="submit" id="submit-attendee" name="add_attendee" value="Add Attendee" class="btn btn-info btn-block">
			
			</div>
			
			<div class="col-xs-6">
	
				<button class="btn btn-info btn-block close-btn"><i class="fa fa-times fa-lrg"></i>Cancel</button>
			
			</div>
	
		</div>
	
	</div>

</form>