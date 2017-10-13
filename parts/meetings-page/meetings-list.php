<?php  
global $locations;
global $meeting_added;
$meetings_args = array(
	'post_type'	=> 'tlw_meeting',
	'posts_per_page' => -1,
	'meta_key'	=> 'meeting_date',
	'orderby' => 'meta_value_num'
);
if (isset($_REQUEST['meeting-day']) ) {
	$meetings_args['order'] = 'ASC';
	
	if (isset($_REQUEST['meeting-day-to'])) {
	$meetings_args['meta_query'] = array( 'value' => array($_REQUEST['meeting-day'], $_REQUEST['meeting-day-to']) , 'compare' => 'BETWEEN' );
	} else {
	$meetings_args['meta_query'] = array(  'value' => $_REQUEST['meeting-day'], 'compare'	=> '=' );	
	}
}

if (isset($_REQUEST['meeting-year']) ) {
//$meetings_args['meta_query'] = array( array( 'key' => 'meeting_year', 'value'	=> $_REQUEST['meeting-year']), array('key'	=> 'meeting_date') );
$meetings_args['order'] = 'ASC';
$meetings_args['meta_query'] = array( 'value' => array(date('Ymd', strtotime("first day of January ". $_REQUEST['meeting-year']) ), date('Ymd', strtotime("last day of December ". $_REQUEST['meeting-year']) )), 'compare' => 'BETWEEN' );
/*
$meetings_args['meta_key'] = 'meeting_year';
$meetings_args['meta_value'] = $_REQUEST['meeting-year'];
*/
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
?>
<?php if (!empty($meetings)) { ?>

<div class="meetings">
<?php if ( isset($_REQUEST['meeting-year']) ) { ?>
<?php foreach ($meeting_months as $mm) { ?>
	<div class="list-label"><?php echo $mm; ?></div>
	
	<?php foreach ($meetings as $meeting) { ?>
	<?php
	$meeting_title = $meeting->post_title;
	$meeting_date = get_field( 'meeting_date', $meeting->ID );
	?>
	<?php if (date("F", strtotime($meeting_date)) == $mm) { ?>
	<div id="meeting-id-<?php echo $meeting->ID; ?>" class="list-item<?php echo($_REQUEST['meeting-id'] == $meeting->ID) ? ' active':''; ?>">
		<a href="?meeting-id=<?php echo $meeting->ID; ?>&meeting-year=<?php echo date("Y", strtotime( $meeting_date ) ); ?>">
			<span class="date"><?php echo date('l jS', strtotime($meeting_date)); ?></span>
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
	$m_id = $_REQUEST['meeting-id'];
	if ($meeting_added) {
	$m_id = $meeting_added;	
	}
	//debug($locations[0]);
	?>
	<div id="meeting-id-<?php echo $meeting->ID; ?>" class="list-item<?php echo($m_id == $meeting->ID) ? ' active':''; ?>">
		<a href="?meeting-id=<?php echo $meeting->ID; ?>&meeting-day=<?php echo $_REQUEST['meeting-day']; ?><?php echo ( isset($_REQUEST['meeting-day-to']) ) ? '&meeting-day-to='.$_REQUEST['meeting-day-to']:''; ?>">
			<span class="date"><?php echo date('l jS M', $meeting_date); ?></span>
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
	<p>There are no meetings booked <?php echo (isset($_REQUEST['meeting-day-to'])) ? 'from':'for';?><span><?php echo date('jS F', strtotime($_REQUEST['meeting-day'])); ?></span><?php echo (isset($_REQUEST['meeting-day-to'])) ? ' to <span>'.date('jS F', strtotime($_REQUEST['meeting-day-to'])).'</span>':''; ?></p>
	<a href="?meeting-actions=add-meeting<?php echo (isset($_REQUEST['meeting-day'])) ? '&meeting-day='.$_REQUEST['meeting-day']:'' ?><?php echo (isset($_REQUEST['meeting-day-to'])) ? '&meeting-day-to='.$_REQUEST['meeting-day-to']:'' ?>" id="add-meeting" class="btn btn-default btn-block caps"><i class="fa fa-plus-circle pull-left"></i> Book a room</a>
	<?php } ?>
</div>
<?php } ?>