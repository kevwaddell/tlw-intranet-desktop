<?php
global $add_contact_errors;
global $users_groups;
?>

<form action="<?php the_permalink(); ?>" method="post">
	<table class="table table-striped">
		<thead>
			<tr>
				<th width="170"><i class="fa fa-user-circle fa-4x"></i></th>
				<th><h1>Add contact</h1></th>
			</tr>
		</thead>
		<tbody>
			<tr<?php echo (array_key_exists ('group-id' , $add_contact_errors )) ? ' class="danger"':''; ?>>
				<td class="bold text-right<?php echo (array_key_exists ('group-id' , $add_contact_errors )) ? ' text-danger':''; ?>"><span class="text-danger">*</span> Contact group</td>
				<td>
					<div class="form-group<?php echo (array_key_exists ('group-id' , $add_contact_errors )) ? ' has-error':''; ?>">
					<select name="group-id" class="selectpicker">
						<option value="0">Choose a contact group</option>
						<?php foreach ($users_groups as $group) { ?>
						<option value="<?php echo $group[0]; ?>"<?php echo ($_REQUEST['group-id'] == $group[0] ) ? ' selected':''; ?>><?php echo $group[1]; ?></option>
						<?php } ?>
					</select>
					<?php echo (array_key_exists ('group-id' , $add_contact_errors )) ? $add_contact_errors['group-id']:''; ?>
					</div>
				</td>
			</tr>
			<tr<?php echo (array_key_exists ('fname' , $add_contact_errors )) ? ' class="danger"':''; ?>>
				<td class="bold text-right<?php echo (array_key_exists ('fname' , $add_contact_errors )) ? ' text-danger':''; ?>"><span class="text-danger">*</span> First name</td>
				<td>
					 <div class="form-group<?php echo (array_key_exists ('fname' , $add_contact_errors )) ? ' has-error':''; ?>">
					<input type="text" class="form-control input-lg" name="fname" value="<?php echo (isset($_REQUEST['fname'])) ? $_REQUEST['fname']:''; ?>">
					<?php echo (array_key_exists ('fname' , $add_contact_errors )) ? $add_contact_errors['fname']:''; ?>
					 </div>
				</td>
			</tr>
			<tr>
				<td class="bold text-right">Last name</td>
				<td>
					<div class="form-group">
						<input type="text" class="form-control input-lg" name="lname" value="<?php echo (isset($_REQUEST['lname'])) ? $_REQUEST['lname']:''; ?>">
					</div>
				</td>
			</tr>
			<tr>
				<td class="bold text-right">Email</td>
				<td>
					<div class="form-group">
						<input type="email" name="email" class="form-control input-lg" value="<?php echo (isset($_REQUEST['email'])) ? $_REQUEST['email']:''; ?>">
					</div>
				</td>
			</tr>
			<tr>
				<td class="bold text-right">Company</td>
				<td>
					 <div class="form-group"><input type="text" class="form-control input-lg" name="company" value="<?php echo (isset($_REQUEST['company'])) ? $_REQUEST['company']:''; ?>"></div>
				</td>
			</tr>
			<tr>
				<td class="bold text-right">Telephone</td>
				<td> <div class="form-group"><input type="text" class="form-control input-lg" placeholder="(000) 000 000 000" name="tel" value="<?php echo (isset($_REQUEST['tel'])) ? $_REQUEST['tel']:''; ?>"></div></td>
			</tr>
			<tr>
				<td class="bold text-right">Mobile</td>
				<td> <div class="form-group"><input type="text" class="form-control input-lg" placeholder="077 789 678 77" name="mobile" value="<?php echo (isset($_REQUEST['mobile'])) ? $_REQUEST['mobile']:''; ?>"></div></td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input type="hidden" name="private-id" value="<?php echo rand(1000, 9999); ?>">
					<button type="submit" class="btn btn-default caps" name="add-contact">Add Contact <i class="fa fa-plus"></i></button>
					<a href="<?php the_permalink(); ?><?php echo (isset($_REQUEST['private'])) ? '?private='.$_REQUEST['private']:''; ?>" class="btn btn-default caps">Cancel <i class="fa fa-times"></i></a>
				</td>
			</tr>
		</tbody>
	</table>
</form>
