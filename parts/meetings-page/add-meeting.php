<?php
global $locations;	
?>
<table class="table table-striped">
	<thead>
		<tr>
			<th width="200" class="text-right"><i class="fa fa-calendar-plus-o fa-4x"></i></th>
			<th><h1>Add Meeting</h1></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="text-right">Meeting location/type</td>
			<td>
				<select name="group-id" class="selectpicker">
						<option value="0">Choose a contact group</option>
						<?php foreach ($locations as $location) { ?>
						<option value="<?php echo $location->term_id; ?>"<?php echo ($_REQUEST['location-id'] == $location->term_id ) ? ' selected':''; ?>><?php echo $location->name; ?></option>
						<?php } ?>
					[</select>
			</td>
		</tr>
		<tr>
			<td class="text-right">Meeting title</td>
			<td></td>
		</tr>
		<tr>
			<td class="text-right vtop">Meeting description</td>
			<td></td>
		</tr>
		<tr>
			<td class="text-right">Date</td>
			<td></td>
		</tr>
		<tr>
			<td class="text-right">Start time</td>
			<td></td>
		</tr>
		<tr>
			<td class="text-right">End time</td>
			<td></td>
		</tr>
		<tr>
			<td class="text-right">Internal attendees</td>
			<td></td>
		</tr>
		<tr>
			<td class="text-right">External attendees</td>
			<td></td>
		</tr>
	</tbody>
</table>