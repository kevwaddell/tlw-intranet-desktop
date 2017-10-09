<?php  
global $locations;
$meetings_args = array(
	'post_type'	=> 'tlw_meeting',
	'posts_per_page' => -1
);
if (isset($_REQUEST['meeting-day']) ) {
	$meetings_args['orderby'] = 'meta_value';
	$meetings_args['meta_key'] = 'meeting_date';
	
	if (isset($_REQUEST['meeting-day-to'])) {
	$meetings_args['meta_query'] = array( 'value' => array($_REQUEST['meeting-day'], $_REQUEST['meeting-day-to']) , 'compare' => 'BETWEEN' );
	} else {
	$meetings_args['meta_query'] = array(  'value' => $_REQUEST['meeting-day'], 'compare'	=> '=' );	
	}
}

if (isset($_REQUEST['meeting-year']) ) {
$meetings_args['orderby'] = 'date';	
$meetings_args['year'] = $_REQUEST['meeting-year'];
}

$meetings = get_posts($meetings_args);

//debug($meetings_args);

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
<?php if ( isset($_REQUEST['meeting-year']) ) { ?>
<?php foreach ($meeting_months as $mm) { ?>
	<div class="list-label"><?php echo $mm; ?></div>
	
	<?php foreach ($meetings as $meeting) { ?>
	<?php
	$meeting_title = $meeting->post_title;
	$meeting_date = strtotime( get_field( 'meeting_date', $meeting->ID ) );
	$locations = wp_get_post_terms( $meeting->ID, 'tlw_rooms_tax');
	$location_id = $locations[0]->term_id;
	//debug($locations[0]);
	?>
	<?php if (date("F", $meeting_date) == $mm) { ?>
	<div id="meeting-id-<?php echo $meeting->ID; ?>" class="list-item<?php echo($_REQUEST['meeting-id'] == $meeting->ID) ? ' active':''; ?>">
		<a href="?meeting-id=<?php echo $meeting->ID; ?>&meeting-year=<?php echo date("Y", strtotime( get_field( 'meeting_date', $meeting->ID ) )); ?>">
			<span class="date"><?php echo date('D jS M Y', $meeting_date); ?></span>
			<span class="title"><?php echo get_the_title( $meeting->ID ); ?></span>
		</a>
	</div>
	<?php } ?>
	
	<?php } ?>
	
	<?php } ?>
	
<?php } ?>
<?php if (isset($_REQUEST['meeting-day'])) { ?>
	
	<?php foreach ($meetings as $meeting) { ?>
	<?php
	$meeting_title = $meeting->post_title;
	$meeting_date = strtotime( get_field( 'meeting_date', $meeting->ID ) );
	//debug($locations[0]);
	?>
	<div id="meeting-id-<?php echo $meeting->ID; ?>" class="list-item<?php echo($_REQUEST['meeting-id'] == $meeting->ID) ? ' active':''; ?>">
		<a href="?meeting-id=<?php echo $meeting->ID; ?>&meeting-day=<?php echo $_REQUEST['meeting-day']; ?>">
			<span class="date"><?php echo date('D jS M Y', $meeting_date); ?></span>
			<span class="title"><?php echo get_the_title( $meeting->ID ); ?></span>
		</a>
	</div>
	<?php } ?>
	
<?php } ?>
</div>
<?php } else { ?>
<div class="no-name-message text-center">
	<i class="fa fa-calendar-times-o fa-4x block sb-icon"></i>
	<?php if (isset($_REQUEST['meeting-year'])) { ?>
	<p>There are no meetings in<span><?php echo $_REQUEST['meeting-year']; ?></span></p>
	<?php } else { ?>
	<p>There are no meetings booked for<span><?php echo strtotime($_REQUEST['meeting-day']); ?></span></p>
	<a href="?meeting-actions=add-meeting" id="add-meeting" class="btn btn-default btn-block caps"><i class="fa fa-plus-circle pull-left"></i> Book room</a>
	<?php } ?>
</div>
<?php } ?>