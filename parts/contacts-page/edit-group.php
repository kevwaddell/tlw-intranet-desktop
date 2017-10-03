<?php
global $edit_group_errors;
global $users_groups;
$group_title_raw = $users_groups[in_array_key($_REQUEST['group-id'], $users_groups)]['1'];
$group_title = strtolower($group_title_raw);
//echo '<pre>';print_r( in_array_key($_REQUEST['group-id'], $users_groups) );echo '</pre>';
?>

<form action="<?php the_permalink() ?>" method="post">
	<table class="table table-striped">
		<thead>
			<tr>
				<th width="170"><i class="fa fa-address-book fa-4x pull-right"></i></th>
				<th><h1>Edit contact group</h1></th>
			</tr>
		</thead>
		<tbody>
			<tr<?php echo (array_key_exists ('group-title' , $edit_group_errors )) ? ' class="danger"':''; ?>>
				<td class="bold text-right<?php echo (array_key_exists ('group-title' , $edit_group_errors )) ? ' text-danger':''; ?>"><span class="text-danger">*</span> Contact group</td>
				<td>
					<div class="form-group<?php echo (array_key_exists ('group-title' , $edit_group_errors )) ? ' has-error':''; ?>">
					<input type="text" class="form-control input-lg" name="group-title" value="<?php echo (isset($_REQUEST['group-title'])) ? $_REQUEST['group-title']:ucfirst($group_title); ?>">
					<?php echo (array_key_exists ('group-title' , $edit_group_errors )) ? $edit_group_errors['private']:''; ?>
					</div>
				</td>
			</tr>
			<tr>
				<td><input type="hidden" name="group-id" value="<?php echo $_REQUEST['group-id']; ?>"></td>
				<td>
					<button type="submit" class="btn btn-default caps" name="edit-group">Update Group <i class="fa fa-save"></i></button>
					<a href="<?php the_permalink(); ?>?group-id=<?php echo $_REQUEST['group-id']; ?>" class="btn btn-default caps">Cancel <i class="fa fa-times"></i></a>
				</td>
			</tr>
		</tbody>
	</table>
</form>
