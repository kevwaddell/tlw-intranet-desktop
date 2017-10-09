<?php
$current_meeting = get_post( $_REQUEST['meeting-id']);
$id = $current_meeting->ID; 	
$meeting_description = get_field('meeting_description', $id);
$meeting_date = strtotime(get_field( 'meeting_date', $id ));
$start_time = get_field( 'start_time', $id);
$end_time = get_field( 'end_time', $id);
$attendees_staff = get_field( 'attendees_staff', $id );
$attendees_clients = get_field('attendees_clients', $id);
$contacts_pg = get_page_by_path( 'contacts' );
//echo '<pre>';print_r($attendees_staff);echo '</pre>';
?>
<table class="table table-striped">
	<thead>
		<tr>
			<th width="200" class="text-right"><i class="meeting-icon fa fa-calendar-plus-o"></i></th>
			<th><h1><?php echo get_the_title( $id ); ?></h1></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="bold text-right">Description</td>
			<td><?php echo $meeting_description; ?></td>
		</tr>
		<tr>
			<td class="bold text-right">Date</td>
			<td><?php echo date('l - jS F - Y', $meeting_date); ?></td>
		</tr>
		<tr>
			<td class="bold text-right">Start time</td>
			<td><?php echo $start_time; ?></td>
		</tr>
		<tr>
			<td class="bold text-right">End time</td>
			<td>
				<?php echo $end_time; ?>
			</td>
		</tr>
		<?php if ($attendees_staff) { ?>
		<tr>
			<td class="bold text-right">Internal attendees</td>
			<td>
				<?php foreach ($attendees_staff as $staff) { 
				$id = $staff['attendee_staff']['ID'];
				$status = $staff['status'];
				?>	
					<?php if ($status != 'rejected') { ?>
					<a href="<?php echo get_permalink($contacts_pg->ID); ?>?id=<?php echo $id; ?>&contacts=team#contact-id-<?php echo $id; ?>" class="attendee">
						<span class="name"><?php echo $staff['attendee_staff']['display_name']; ?></span>
						<div class="label label-<?php echo ($status == 'accepted') ? 'success':'warning'; ?>">
						<?php if ($status == 'accepted') { ?>
						<i class="fa fa-check fleft"></i> Accepted
						<?php } else { ?>
						<i class="fa fa-clock-o fleft"></i> Pending
						<?php } ?>	
						</div>
					</a><br>
					<?php } ?>
				<?php } ?>
			</td>
		</tr>
		<?php } ?>
		<?php if (!empty($attendees_clients)) { ?>
		<tr>
			<td class="bold text-right">External attendees</td>
			<td>
			<?php foreach ($attendees_clients as $client) { ?>	
				<span class="name"><?php echo $client['attendee_client']; ?></span><br>
			<?php } ?>
			</td>
		</tr>			
		<?php } ?>
	</tbody>
</table>