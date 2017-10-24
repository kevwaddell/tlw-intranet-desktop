<?php
global $reminder_groups;
global $current_group;	
$group_key = in_array_key($current_group, $reminder_groups);
$group_title = $reminder_groups[$group_key]['title'];
?>
<div class="alert" role="alert">
	<h3><i class="fa fa-warning fa-lg col-red"></i> Delete<strong>"<?php echo $group_title; ?>"</strong>?</h3>	
	<p>All reminders will be deleted. You cannot undo this action.</p>
	<div class="alert-actions text-left">
		<a href="?reminder-actions=delete-group&group-id=<?php echo $current_group; ?>" class="btn no-rounded no-border bold">Delete List <i class="fa fa-check pull-right"></i></a>
		<a href="?group-id=<?php echo $current_group; ?>" class="btn no-rounded no-border pull-right">Cancel <i class="fa fa-times pull-right"></i></a>
	</div>
</div>