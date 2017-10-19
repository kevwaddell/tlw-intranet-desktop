<?php 
global $your_meetings;	
?>
<?php if (!empty($your_meetings)) { ?>
<div class="meetings">
	<?php foreach ($your_meetings as $meeting) { 
	$meeting_date = get_field('meeting_date', $meeting->ID);
	$meeting_month = date('m', strtotime($meeting_date));
	$meeting_year = date('Y', strtotime($meeting_date));	
	?>
		<?php if ($meeting_month == $_REQUEST['meeting-month'] && $meeting_year ==$_REQUEST['meeting-year']) { ?>
		<div id="meeting-id-<?php echo $meeting->ID; ?>" class="list-item<?php echo($_REQUEST['meeting-id'] == $meeting->ID) ? ' active':''; ?>">
			<a href="?meeting-id=<?php echo $meeting->ID; ?>&meeting-month=<?php echo $meeting_month; ?>&meeting-year=<?php echo $meeting_year; ?>">
			<span class="date"><?php echo date('l jS', strtotime($meeting_date)); ?></span>
			<span class="title"><?php echo get_the_title( $meeting->ID ); ?></span>
			</a>
		</div>
		<?php } ?>
	<?php } ?>
</div>
<?php } else { ?>

<?php } ?>