<?php  
global $rooms;
if (isset($_REQUEST['room-id'])) {
$room_id = $_REQUEST['room-id'];
$meetings_args = array(
'post_type'	=> 'tlw_meeting',
'posts_per_page' => -1,
'orderby' => 'date',
'tax_query' => array(
		array(
			'taxonomy' => 'tlw_rooms_tax',
			'field'    => 'term_id',
			'terms'    => $room_id,
		),
	),
);
$meetings = get_posts($meetings_args);
//echo '<pre class="debug">';print_r($meetings);echo '</pre>';
?>
<?php foreach ($meetings as $meeting) { 
	$meeting_title = $meeting->post_title;
	$meeting_date = strtotime(get_field( 'meeting_date', $meeting->ID ));
?>
	<div id="meeting-id-<?php echo $meeting->ID; ?>" class="meeting-list-item<?php echo($meeting->ID == $_GET['meeting_id']) ? ' meeting-active':''; ?>">
		<a href="?meeting-id=<?php echo $meeting->ID; ?>&room-id=<?php echo $_GET['room-id'] ?>">
			<span class="date"><?php echo date('D jS M Y', $meeting_date); ?></span>
			<span class="title"><?php echo get_the_title( $meeting->ID ); ?></span>
		</a>
	</div>
<?php } ?>

<?php } ?>