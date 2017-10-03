<?php
global $group_added;
global $group_updated;
global $group_deleted;
global $contact_updated;
global $contact_deleted;	
global $contact_added;
?>
<?php if ($group_added) { ?>
<div class="alert alert-success alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<p><i class="fa fa-check-circle"></i> Group added successfully</p>	
</div>
<?php } ?>
<?php if ($group_updated) { ?>
<div class="alert alert-success alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<p><i class="fa fa-check-circle"></i> Group updated successfully</p>	
</div>
<?php } ?>
<?php if ($group_deleted) { ?>
<div class="alert alert-success alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<p><i class="fa fa-check-circle"></i> Your contact group has been deleted.</p>
</div>
<?php } ?>	
<?php if ($contact_added) { ?>
<div class="alert alert-success alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<p><i class="fa fa-check-circle"></i> Contact added successfully</p>	
</div>
<?php } ?>
<?php if ($contact_updated) { ?>
<div class="alert alert-success alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<p><i class="fa fa-check-circle"></i> Contact updated successfully</p>	
</div>
<?php } ?>
<?php if ($contact_deleted) { ?>
<div class="alert alert-success alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<p><i class="fa fa-check-circle"></i> Your contact has been deleted.</p>
</div>
<?php } ?>
