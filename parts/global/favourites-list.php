<?php
$post_ids = array();
$meetings_ids = array();
/*
echo '<pre>';
print_r($favs);
echo '</pre>';
*/
foreach ($favs as $fav) {
	
	if ($fav['post_type'] == 'post') {
		if (!in_array($fav['post_id'], $post_ids)) {
			array_push($post_ids, $fav['post_id']);
		}	
	}
	
	if ($fav['post_type'] == 'tlw_meeting') {
		if (!in_array($fav['post_id'], $meetings_ids)) {
			array_push($meetings_ids, $fav['post_id']);
		}	
	}
}

if (!empty($post_ids)) {
	$fav_posts_args = array(
	'post_type'	=> 'post',
	'include'	=> 	$post_ids,
	'posts_per_page'	=> -1,
	'orderby'	=> 'date'
	);
	
	$fav_posts = get_posts($fav_posts_args);
}

if (!empty($meetings_ids)) {
$fav_meetings_args = array(
'post_type'	=> 'tlw_meeting',
'include'	=> 	$meetings_ids,
'posts_per_page'	=> -1,
'meta_key'	=> 'start_time',
'orderby' => 'meta_value_num'
);

$fav_meetings = get_posts($fav_meetings_args);
}

$news = array();
$events = array();
$announcments = array();

foreach ($fav_posts as $fav_post) {
	$cat = get_the_category($fav_post->ID);
	
	if ($cat[0]->slug == 'company-news'	|| $cat[0]->slug == 'office-news') {
	array_push($news, $fav_post);
	}
	
	if ($cat[0]->slug == 'events') {
	array_push($events, $fav_post);
	}
	
	if ($cat[0]->slug == 'announcements') {
	array_push($announcments, $fav_post);
	}
}
?>

<?php if (!empty($news)) { ?>
<button id="news-favs-btn" class="btn btn-default btn-block favs-btn"><i class="fa fa-rss"></i>News <span class="badge"><?php echo count($news); ?></span></button>

<div class="list-closed">

	<div id="user-favs-news-posts" class="user-favs-list">
		
		<div class="user-favs-list-outer">
		
			<div class="user-favs-list-wrap">
		
				<?php foreach ($news as $n) { 
				$cat = get_the_category($n->ID);	
				//echo '<pre>';print_r($cat);echo '</pre>';
				?>
				<div class="list-item"> 
					<a href="<?php echo get_permalink($n->ID); ?>" title="View article">
						<span class="title"><?php echo $n->post_title; ?></span>
						<span class="cat"><?php echo $cat[0]->name; ?></span>
						<span class="date"><?php echo get_the_date( get_option('date_format '), $n->ID ); ?></span>
					</a>
				</div>
				
				<?php } ?>
			
			</div>
		
		</div>
		
	</div>

</div>
<?php } ?>

<?php if (!empty($events)) { ?>
<button id="events-favs-btn" class="btn btn-default btn-block favs-btn"><i class="fa fa-calendar"></i>Events <span class="badge"><?php echo count($events); ?></span></button>

<div class="list-closed">

	<div id="user-favs-events-posts" class="user-favs-list">
	
		<div class="user-favs-list-outer">
			
			<div class="user-favs-list-wrap">
		
				<?php foreach ($events as $e) { 
				$event_date_raw = get_field('event_date', $e->ID);
				$event_date = date(get_option('date_format '), strtotime($event_date_raw ));
				$event_time = get_field('event_time', $e->ID);
				$event_time_end = get_field('event_time_end', $e->ID);	
				?>
				<div class="list-item"> 
					<a href="<?php echo get_permalink($e->ID); ?>" title="View article">
						<span class="title"><?php echo $e->post_title; ?></span>
						<span class="date"><?php echo $event_date; ?>: <?php echo $event_time; ?> - <?php echo $event_time_end; ?></span>
					</a>
				</div>
				
				<?php } ?>
			
			</div>
			
		</div>
	
	</div>

</div>
<?php } ?>

<?php if (!empty($announcments)) { ?>
<button id="announcments-favs-btn" class="btn btn-default btn-block favs-btn"><i class="fa fa-bullhorn"></i>Announcments <span class="badge"><?php echo count($announcments); ?></span></button>

<div class="list-closed">

	<div id="user-favs-announcments-posts" class="user-favs-list">
	
		<div class="user-favs-list-outer">
		
			<div class="user-favs-list-wrap">
		
				<?php foreach ($announcments as $a) { ?>
				<div class="list-item"> 
					<a href="<?php echo get_permalink($a->ID); ?>" title="View article">
						<span class="title"><?php echo $a->post_title; ?></span>
						<span class="date"><?php echo get_the_date( get_option('date_format '), $a->ID ); ?></span>
					</a>
				</div>
				
				<?php } ?>
			
			</div>
			
		</div>
	
	</div>
	
</div>
<?php } ?>

<?php if ($fav_meetings) { ?>
<button id="meetings-favs-btn" class="btn btn-default btn-block favs-btn"><i class="fa fa-clock-o"></i>Meetings <span class="badge"><?php echo count($fav_meetings); ?></span></button>

<div class="list-closed">

	<div id="user-favs-meetings-posts" class="user-favs-list">
		
		<div class="user-favs-list-outer">
		
			<div class="user-favs-list-wrap">
		
				<?php foreach ($fav_meetings as $m) { 
				$meeting_date_raw = get_field('meeting_date', $m->ID);
				$meeting_date = date(get_option('date_format '), strtotime($meeting_date_raw));
				$meeting_time = get_field('start_time', $m->ID);
				$meeting_time_end = get_field('end_time', $m->ID);	
				$room = wp_get_post_terms( $m->ID, 'tlw_rooms_tax');		
				?>
				<div class="list-item"> 
					<a href="<?php echo get_permalink($m->ID); ?>" title="View article">
						<span class="title"><?php echo $m->post_title; ?></span>
						<span class="cat"><?php echo $room[0]->name;?></span>
						<span class="date"><?php echo $meeting_date; ?>: <?php echo date('H:i', $meeting_time); ?> - <?php echo date('H:i', $meeting_time_end); ?></span>
					</a>
				</div>
				
				<?php } ?>
			
			</div>
			
		</div>
	
	</div>
	
</div>
<?php } ?>
<?php
/*
echo '<pre>';
print_r($fav_meetings);
echo '</pre>';
*/
?>