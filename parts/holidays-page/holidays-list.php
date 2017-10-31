<?php
global $number_of_holidays;	
global $days_remaining;
global $user_holidays;
?>
<div class="holidays-list">
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th colspan="3" class="text-center">No of days holiday allocated: <span class="col-red lg-number"><?php echo $number_of_holidays; ?></span></th>
				<th colspan="3" class="text-center">No of days remaining for <?php echo date('Y'); ?>: <span class="col-red lg-number"><?php echo $days_remaining; ?></span></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<th width="8%" class="text-center">Approved</th>
				<th width="21%" class="text-center">Date booked</th>
				<th width="21%" class="text-center">First day</th>
				<th width="20%" class="text-center">Last day</th>
				<th width="7%" class="text-center">No days</th>
				<th class="text-center">Actions</th>
			</tr>
			<?php if (empty($user_holidays)) { ?>
			<tr>
				<td class="text-center"> - </td>
				<td class="text-center"> - </td>
				<td class="text-center"> - </td>
				<td class="text-center"> - </td>
				<td class="text-center"> - </td>
				<td></td>
			</tr>			
			<?php } else { ?>
			<?php foreach ($user_holidays as $uh) { 
			$date_booked = date("d/m/Y", strtotime($uh['date-booked']));
			$date_from = date("d/m/Y", strtotime($uh['date-from']));
			$date_from_length = $uh['date-from-length'];
			$date_to = date("d/m/Y", strtotime($uh['date-to']));
			$date_to_length = $uh['date-to-length'];
			$no_days = $uh['no-days'];
			?>
			<tr>
				<td class="text-center">
					<?php if ($uh['approval'] == 'yes') { ?>
						<i class="fa fa-check fa-2x text-success"></i>		
					<?php } ?>
					<?php if ($uh['approval'] == 'no') { ?>
						<i class="fa fa-times fa-2x text-danger"></i>		
					<?php } ?>
					<?php if ($uh['approval'] == 'pending') { ?>
						<i class="fa fa-refresh fa-2x text-warning"></i>		
					<?php } ?>
				</td>
				<td class="text-center"><?php echo $date_booked; ?></td>
				<td class="text-center"><?php echo $date_from; ?><?php echo ($date_from_length == 'half' && $no_days >= 1) ? ' @ 12:30pm':'' ?></td>
				<td class="text-center"><?php echo $date_to; ?><?php echo ($date_to_length == 'half' && $no_days >= 1) ? ' @ 1:30pm':'' ?></td>
				<td class="text-center"><?php echo $no_days; ?></td>
				<td class="text-center">
					<a href="?holiday-actions=edit-holiday" class="btn btn-default btn-sm"><i class="fa fa-pencil fa-lg"></i> Change</a>
					<a href="?holiday-actions=cancel-holiday" class="btn btn-default btn-sm"><i class="fa fa-times fa-lg"></i> Cancel</a>
					<?php if ($uh['approval'] == 'no') { ?>
					<a href="?holiday-actions=delete-holiday" class="btn btn-default btn-sm"><i class="fa fa-trash fa-lg"></i> Delete</a>		
					<?php } ?>
				</td>
			</tr>	
			<?php } ?>
			<?php } ?>
		</tbody>
	</table>
</div>