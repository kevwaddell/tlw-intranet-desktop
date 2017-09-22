<?php if ($total_int > 0 || $total_ext > 0 ) { ?>

<div class="data-list-key">
	<div class="status-key">
		<strong>Status:</strong> 
		<span class="pending">Pending</span>
		<span class="accepted">Accepted</span>
		<span class="rejected">Unavailable</span>
	</div>
	
	<div class="actions-key">

		<?php if (is_user_logged_in()) { ?>
		<span class="actions"><i class="fa fa-cogs"></i> Actions</span>
		<?php } ?>
		<span class="status"><i class="fa fa-info-circle"></i> Status</span>
		
	</div>

</div>

<?php } ?>