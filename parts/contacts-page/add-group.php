<?php
global $add_group_errors;
?>

<form action="<?php the_permalink() ?>" method="get">
	<table class="table table-striped">
		<thead>
			<tr>
				<th width="20%"><i class="fa fa-address-book fa-4x"></i></th>
				<th><h1>Add contact group</h1></th>
			</tr>
		</thead>
		<tbody>
			<tr<?php echo (array_key_exists ('new-private' , $add_group_errors )) ? ' class="danger"':''; ?>>
				<td class="bold text-right<?php echo (array_key_exists ('new-private' , $add_group_errors )) ? ' text-danger':''; ?>" width="20%"><span class="text-danger">*</span> Contact group</td>
				<td>
					<div class="form-group<?php echo (array_key_exists ('new-private' , $add_group_errors )) ? ' has-error':''; ?>">
					<input type="text" class="form-control input-lg" name="new-private" value="<?php echo (isset($_GET['new-private'])) ? $_GET['new-private']:''; ?>">
					<?php echo (array_key_exists ('new-private' , $add_group_errors )) ? $add_group_errors['new-private']:''; ?>
					</div>
				</td>
			</tr>
			<tr>
				<td></td>
				<td><button type="submit" class="btn btn-default btn-lg caps" name="add-group" value="new-group">Add Group <i class="fa fa-plus"></i></button></td>
			</tr>
		</tbody>
	</table>
</form>
