<?php
$current_meeting = get_post( $_REQUEST['meeting-id']);
$id = $current_meeting->ID; 	
$meeting_date = strtotime(get_field( 'meeting_date', $id ));
$start_time = get_field( 'start_time', $id);
$end_time = get_field( 'end_time', $id);
$attendees_staff = get_field( 'attendees_staff', $id );
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
				?>
					<a href="<?php echo get_permalink($contacts_pg->ID); ?>?id=<?php echo $id; ?>&contacts=team#contact-id-<?php echo $id; ?>"><?php echo $staff['attendee_staff']['display_name']; ?></a><br>
				<?php } ?>
			</td>
		</tr>
		<?php } ?>
		<?php if (!empty($extenal)) { ?>
		<tr>
			<td class="bold text-right">External attendees</td>
			<td></td>
		</tr>			
		<?php } ?>
	</tbody>
</table>