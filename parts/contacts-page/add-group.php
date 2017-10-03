<?php
global $add_group_errors;
?>

<form action="<?php the_permalink() ?>" method="post">
	<table class="table table-striped">
		<thead>
			<tr>
				<th width="170"><i class="fa fa-address-book fa-4x pull-right"></i></th>
				<th><h1>Add contact group</h1></th>
			</tr>
		</thead>
		<tbody>
			<tr<?php echo (array_key_exists ('group-title' , $add_group_errors )) ? ' class="danger"':''; ?>>
				<td class="bold text-right<?php echo (array_key_exists ('group-title' , $add_group_errors )) ? ' text-danger':''; ?>"><span class="text-danger">*</span> Contact group</td>
				<td>
					<div class="form-group<?php echo (array_key_exists ('group-title' , $add_group_errors )) ? ' has-error':''; ?>">
					<input type="text" class="form-control input-lg" name="group-title" value="<?php echo (isset($_REQUEST['group-title'])) ? $_REQUEST['group-title']:''; ?>">
					<?php echo (array_key_exists ('group-title' , $add_group_errors )) ? $add_group_errors['private']:''; ?>
					</div>
				</td>
			</tr>
			<tr>
				<td><input type="hidden" name="group-id" value="<?php echo rand(100, 999); ?>"></td>
				<td>
					<button type="submit" class="btn btn-default caps" name="add-group">Add Group <i class="fa fa-plus"></i></button>
					<a href="<?php the_permalink(); ?>" class="btn btn-default caps">Cancel <i class="fa fa-times"></i></a>
				</td>
			</tr>
		</tbody>
	</table>
</form>
