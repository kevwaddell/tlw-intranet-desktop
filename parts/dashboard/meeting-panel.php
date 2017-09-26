<?php
$today_start = strtotime("Today 08:00");
$today_end = strtotime("Today 18:00");
$args = array( 'hide_empty' => 0 );
$rooms = get_terms('tlw_rooms_tax', $args);
$meetings_pg = get_page_by_title('Meetings');
$ical_page = get_page_by_title("Cal feed");
$ical_page_split_url = explode('http://', get_permalink($ical_page->ID));
//echo '<pre>';print_r($rooms);echo '</pre>';
 ?>

<div class="panel-group panel-feeds" id="accordion" role="tablist" aria-multiselectable="true">
	
	<?php foreach ($rooms as $room) { 
	$meeting_args = array(
	'post_type' => 'tlw_meeting',
	'posts_per_page' => -1,
	'order'	=> 'ASC',
	'meta_key'	=> 'start_time',
	'orderby' => 'meta_value_num',
	'rooms'	=> $room->slug,
	'meta_query' => array(
		'relation' => 'AND',
		array(
			'key' => 'start_time',
			'value' => $today_start,
			'compare' => '>'
		),
		array(
			'key' => 'end_time',
			'value' => $today_end,
			'compare' => '<'
		)
	)	
	);
	
	$meetings = get_posts($meeting_args);	
	//echo '<pre>';print_r($meetings);echo '</pre>';	
	?>
	
	<div class="panel panel-default">
		
		<div class="panel-heading" role="tab" id="heading-<?php echo $room->slug; ?>">
			<h4 class="panel-title">
		        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#panel-<?php echo $room->slug; ?>" aria-expanded="false" aria-controls="panel-<?php echo $room->slug; ?>">
		          <?php echo $room->name; ?>
		        </a>
	      	</h4>
    	</div>
		
		<div id="panel-<?php echo $room->slug; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-<?php echo $room->slug; ?>">
		
		<div class="panel-body">
		<?php if (!empty($meetings)) { ?>
		
		<div class="panel-feed">
			<div class="panel-feed-wrap">
			
			<ul class="list-unstyled">
			
				<?php foreach ($meetings as $meeting) { 
				$description = get_field('meeting_description', $meeting->ID);
				$start_time = get_field('start_time', $meeting->ID);
				$end_time = get_field('end_time', $meeting->ID);
				$booked_by = get_user_by('id', $meeting->post_author);
				?>
				<li>
				<a href="<?php echo get_permalink($meeting->ID); ?>" class="View details">
					<span class="time"><strong>Time:</strong> <?php echo date('g:ia', $start_time);?> - <?php echo date('g:ia', $end_time);?></span>	
					<span class="title"><strong>Meeting:</strong> <?php echo $description; ?></span>
					<span class="name"><strong>Booked by:</strong> <?php echo $booked_by->data->display_name; ?></span>
				</a>
				</li>
				<?php } 
				$meetings = array();	
				?>
				
			</ul>
			
			</div>
		</div>
		
		<?php } else { ?>
		<div class="well text-center">
		<?php echo $room->name; ?> is available today.
		</div>
		<?php } ?>
		
		</div>
		
	</div>
	
	</div>
	
	<?php } ?>

</div>

<div class="panel-btns">
	<a href="<?php echo get_permalink($meetings_pg->ID); ?>" class="btn btn-default btn-block"><i class="fa fa-check fa-lg"></i>Book a meeting room</a>
	<a href="webcal://<?php echo $ical_page_split_url[1]; ?>" class="btn btn-default btn-block"><i class="fa fa-calendar fa-lg"></i>Download <?php echo $meetings_pg->post_title; ?> calendar</a>
</div>
