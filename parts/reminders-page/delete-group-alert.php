<?php
global $reminder_groups;
global $current_group;	
$group_key = in_array_key($current_group, $reminder_groups);
$group_title = $reminder_groups[$group_key]['title'];
?>
<div class="alert alert-danger" role="alert">
	<h3>Are you sure you want to delete<br><strong><?php echo $group_title; ?></strong></h3>	
	<p>This action will remove all reminders from this group</p>
	<div class="alert-actions">
		<a href="?reminder-actions=delete-group&group-id=<?php echo $current_group; ?>" class="btn btn-success">Yes <i class="fa fa-check pull-right"></i></a>
		<a href="?group-id=<?php echo $current_group; ?>" class="btn btn-danger">No <i class="fa fa-times pull-right"></i></a>
	</div>
</div>