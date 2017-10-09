<?php  
global $locations;
if (isset($_REQUEST['location-id'])) {
$location_id = $_REQUEST['location-id'];
$meetings_args = array(
'post_type'	=> 'tlw_meeting',
'posts_per_page' => -1,
'orderby' => 'date',
'date_query' => array ( array('after'  => date('d/m/Y', strtotime("Yesterday")) ) ),
'tax_query' => array(
		array(
			'taxonomy' => 'tlw_rooms_tax',
			'field'    => 'term_id',
			'terms'    => $location_id,
		),
	),

);
if ($_REQUEST['location-id'] == 0) {
unset($meetings_args['tax_query']);
	if ($_REQUEST['meeting-year'] == date("Y")) {
	$meetings_args['date_query'] = array( array('after' => date('d/m/Y', strtotime("january ".$_REQUEST['meeting-year'])) ), array('before' => date('d/m/Y', strtotime("Today")) ));	
	} else {
	$meetings_args['date_query'] = array( array('year' => $_REQUEST['meeting-year']));	
	}
}
$meetings = get_posts($meetings_args);
$meeting_months = array();
foreach ($meetings as $m) {

$month = date('F', strtotime(get_field( 'meeting_date', $m->ID )));
	if (!in_array($month, $meeting_months)) {
	$meeting_months[] = $month;
	}
}
//echo '<pre class="debug">';print_r($meeting_months);echo '</pre>';
if ($_REQUEST['location-id'] != 0) {
$location = get_term( $_REQUEST['location-id']);	
//echo '<pre class="debug">';print_r($location);echo '</pre>';
}	
?>
<?php if (!empty($meetings)) { ?>
<div class="meetings">
<?php foreach ($meeting_months as $mm) { ?>
	<div class="list-label"><?php echo $mm; ?></div>
	
	<?php foreach ($meetings as $meeting) { ?>
	<?php
	$meeting_title = $meeting->post_title;
	$meeting_date = strtotime( get_field( 'meeting_date', $meeting->ID ) );
	?>
	<?php if (date("F", $meeting_date) == $mm) { ?>
	<div id="meeting-id-<?php echo $meeting->ID; ?>" class="list-item<?php echo($_REQUEST['meeting-id'] == $meeting->ID) ? ' active':''; ?>">
		<a href="?meeting-id=<?php echo $meeting->ID; ?>&location-id=<?php echo $_REQUEST['location-id'] ?>&meeting-year=<?php echo date("Y", strtotime( get_field( 'meeting_date', $meeting->ID ) )); ?>">
			<span class="date"><?php echo date('D jS M Y', $meeting_date); ?></span>
			<span class="title"><?php echo get_the_title( $meeting->ID ); ?></span>
		</a>
	</div>
	<?php } ?>
	
	<?php } ?>
	
<?php } ?>
</div>
<?php } else { ?>
<div class="no-name-message text-center">
	<i class="fa fa-calendar-times-o fa-4x block sb-icon"></i>
	<?php if ($_REQUEST['location-id'] == 0) { ?>
	<p>There are no meetings in<span><?php echo $_REQUEST['meeting-year']; ?></span></p>
	<?php } else { ?>
	<p>There are no meetings booked for<span><?php echo $location->name; ?></span></p>
	<a href="?meeting-actions=add-meeting&location-id=<?php echo $_REQUEST['location-id']; ?>" id="add-meeting" class="btn btn-default btn-block caps"><i class="fa fa-plus-circle pull-left"></i> Add meeting</a>
	<?php } ?>
</div>
<?php } ?>
<?php } ?>