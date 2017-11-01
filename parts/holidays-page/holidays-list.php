<?php
global $current_user;
global $number_of_holidays;	
global $days_remaining;
global $user_holidays;
global $xmas_no_days;
global $xmas_start;
global $xmas_end;
global $current_year;
$fname = get_user_meta( $current_user->ID, 'first_name', true );
$lname = get_user_meta( $current_user->ID, 'last_name', true );
?>
<div class="holidays-list">
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th colspan="3" class="text-center">Name: <span class="col-red"><?php echo $fname; ?> <?php echo $lname; ?></span></th>
				<th colspan="3" class="text-center">Year: <span class="col-red"><?php echo $current_year; ?></span></th>
			</tr>
			<tr>
				<th colspan="3" class="text-center">No of days holiday allocated: <span class="col-red lg-number"><?php echo $number_of_holidays; ?></span></th>
				<th colspan="3" class="text-center">No of days remaining: <span class="col-red lg-number"><?php echo $days_remaining; ?></span></th>
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
			<?php if (!empty($xmas_no_days) && date("Y", strtotime($xmas_start)) == $current_year) { ?>
			<tr>
				<td class="text-center" style="vertical-align: middle;"><i class="fa fa-check fa-lg text-success"></i></td>
				<td class="text-center caps">Xmas shutdown</td>
				<td class="text-center"><?php echo date("d/m/Y", strtotime($xmas_start)); ?></td>
				<td class="text-center"><?php echo date("d/m/Y", strtotime($xmas_end)); ?></td>
				<td class="text-center"><?php echo $xmas_no_days; ?></td>
				<td class="text-center" style="vertical-align: middle;"><?php echo wp_encode_emoji( 🍾🥂🍻🎄🎁🎅🏼); ?></td>
			</tr>	
			<?php } ?>
			<?php if (empty($user_holidays)) { ?>
			<tr>
				<td class="text-center"> - </td>
				<td class="text-center"> - </td>
				<td class="text-center"> - </td>
				<td class="text-center"> - </td>
				<td class="text-center"> - </td>
				<td></td>
			</tr>			
			<?php } else { 
			rsort($user_holidays);
			?>
			<?php foreach ($user_holidays as $uh) { 
			$date_booked = date("d/m/Y", strtotime($uh['date-booked']));
			$date_from = date("d/m/Y", strtotime($uh['date-from']));
			$date_from_length = $uh['date-from-length'];
			$date_to = date("d/m/Y", strtotime($uh['date-to']));
			$date_to_length = $uh['date-to-length'];
			$no_days = $uh['no-days'];
			$edit_params = '&holiday-id='.$uh['holiday-id'];
			$edit_params .= '&date-booked='.date("Ymd", strtotime($uh['date-booked']));
			$edit_params .= '&date-from='. date("Ymd", strtotime($uh['date-from']));
			$edit_params .= '&date-from-length='. $date_from_length;
			$edit_params .= '&date-to='. date("Ymd", strtotime($uh['date-to']));
			$edit_params .= '&date-to-length='. $date_to_length;
			$edit_params .= '&approved='. $uh['approved'];
			?>
			<tr>
				<td class="text-center" style="vertical-align: middle;">
					<?php if ($uh['approved'] == 'yes') { ?>
						<i class="fa fa-check fa-lg text-success"></i>		
					<?php } ?>
					<?php if ($uh['approved'] == 'no') { ?>
						<i class="fa fa-times fa-lg text-danger"></i>		
					<?php } ?>
					<?php if ($uh['approved'] == 'pending') { ?>
						<i class="fa fa-refresh fa-lg text-warning"></i>		
					<?php } ?>
				</td>
				<td class="text-center"><?php echo $date_booked; ?></td>
				<td class="text-center"><?php echo $date_from; ?><?php echo ($date_from_length == 'am') ? ' @ 9am - 12:30pm':'' ?><?php echo ($date_from_length == 'pm') ? ' @ 12:30pm':'' ?></td>
				<td class="text-center"><?php echo $date_to; ?><?php echo ($date_to_length == 'am') ? ' @ 1:30pm':'' ?><?php echo ($date_to_length == 'pm') ? ' @ 12:30pm':'' ?></td>
				<td class="text-center"><?php echo $no_days; ?></td>
				<td class="text-center">
					<a href="?holiday-actions=edit-holiday<?php echo $edit_params; ?>" class="btn btn-default btn-sm"><i class="fa fa-pencil fa-lg"></i> Change</a>
					<?php if (date('Ymd') < date("Ymd", strtotime($uh['date-from']))) { ?>
					<a href="?holiday-actions=cancel-holiday" class="btn btn-default btn-sm"><i class="fa fa-times fa-lg"></i> Cancel</a>
					<?php } ?>
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