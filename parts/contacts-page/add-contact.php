<?php
global $users_groups;	
global $add_contact_errors;
?>

<form action="<?php the_permalink(); ?>" method="get">
	<table class="table table-striped">
		<thead>
			<tr>
				<th width="30%"><i class="fa fa-user-circle fa-4x"></i></th>
				<th><h1>Add contact</h1></th>
			</tr>
		</thead>
		<tbody>
			<?php if (empty($users_groups)) { ?>
			<tr<?php echo (array_key_exists ('new-private' , $add_contact_errors )) ? ' class="danger"':''; ?>>
				<td class="bold text-right<?php echo (array_key_exists ('new-private' , $add_contact_errors )) ? ' text-danger':''; ?>"><span class="text-danger">*</span> Contact group</td>
				<td>
					<div class="form-group<?php echo (array_key_exists ('new-private' , $add_contact_errors )) ? ' has-error':''; ?>">
					<input type="text" class="form-control input-lg" name="new-private" value="<?php echo (isset($_GET['new-private'])) ? $_GET['new-private']:''; ?>">
					<?php echo (array_key_exists ('new-private' , $add_contact_errors )) ? $add_contact_errors['new-private']:''; ?>
					</div>
				</td>
			</tr>
			<?php } else { ?>
			<tr<?php echo (array_key_exists ('private' , $add_contact_errors )) ? ' class="danger"':''; ?>>
				<td class="bold text-right<?php echo (array_key_exists ('private' , $add_contact_errors )) ? ' text-danger':''; ?>"><span class="text-danger">*</span> Contact group</td>
				<td>
					<div class="form-group<?php echo (array_key_exists ('private' , $add_contact_errors )) ? ' has-error':''; ?>">
					<select name="private" class="selectpicker">
						<option value="0">Choose a contact group</option>
						<?php foreach ($users_groups as $group) { ?>
						<option value="<?php echo $group[0]; ?>"<?php echo (isset($GET['private']) && $_GET['private'] == $group[0] || $_GET['private'] == $group[1] ) ? ' selected':''; ?>><?php echo $group[0]; ?></option>
						<?php } ?>
					</select>
					<?php echo (array_key_exists ('private' , $add_contact_errors )) ? $add_contact_errors['private']:''; ?>
					</div>
				</td>
			</tr>
			<?php } ?>
			<tr<?php echo (array_key_exists ('fname' , $add_contact_errors )) ? ' class="danger"':''; ?>>
				<td class="bold text-right<?php echo (array_key_exists ('fname' , $add_contact_errors )) ? ' text-danger':''; ?>" width="20%"><span class="text-danger">*</span> First name</td>
				<td>
					 <div class="form-group<?php echo (array_key_exists ('fname' , $add_contact_errors )) ? ' has-error':''; ?>">
					<input type="text" class="form-control input-lg" name="fname" value="<?php echo (isset($_GET['fname'])) ? $_GET['fname']:''; ?>">
					<?php echo (array_key_exists ('fname' , $add_contact_errors )) ? $add_contact_errors['fname']:''; ?>
					 </div>
				</td>
			</tr>
			<tr>
				<td class="bold text-right" width="20%">Last name</td>
				<td>
					<div class="form-group">
						<input type="text" class="form-control input-lg" name="lname" value="<?php echo (isset($_POST['lname'])) ? $_POST['lname']:''; ?>">
					</div>
				</td>
			</tr>
			<tr>
				<td class="bold text-right">Email</td>
				<td>
					<div class="form-group">
						<input type="email" name="email" class="form-control input-lg" value="<?php echo (isset($_POST['email'])) ? $_POST['email']:''; ?>">
					</div>
				</td>
			</tr>
			<tr>
				<td class="bold text-right">Company</td>
				<td>
					 <div class="form-group"><input type="text" class="form-control input-lg" name="company" value="<?php echo (isset($_POST['company'])) ? $_POST['company']:''; ?>"></div>
				</td>
			</tr>
			<tr>
				<td class="bold text-right">Telephone</td>
				<td> <div class="form-group"><input type="text" class="form-control input-lg" placeholder="(000) 000 000 000" name="tel" value="<?php echo (isset($_POST['tel'])) ? $_POST['tel']:''; ?>"></div></td>
			</tr>
			<tr>
				<td class="bold text-right">Mobile</td>
				<td> <div class="form-group"><input type="text" class="form-control input-lg" placeholder="077 789 678 77" name="mobile" value="<?php echo (isset($_POST['mobile'])) ? $_POST['mobile']:''; ?>"></div></td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input type="hidden" name="private-id" value="<?php echo rand(100, 999); ?>">
					<button type="submit" class="btn btn-default btn-lg caps" name="add-contact" value="new-contact">Add Contact <i class="fa fa-plus"></i></button>
					<a href="<?php the_permalink(); ?><?php echo (isset($_GET['private'])) ? '?private='.$_GET['private']:''; ?>" class="btn btn-danger btn-lg">Cancel <i class="fa fa-times"></i></a>
				</td>
			</tr>
		</tbody>
	</table>
</form>
