<?php 
$home_url = get_option('home');
$add_article_pg = get_page_by_title('Add Article');

/* COMPANY NEWS POSTS */
$cn_cat_id = get_cat_ID( 'Company News' );
$comp_news_args = array(
	'posts_per_page'   => 3,
	'cat'  => $cn_cat_id
);

$comp_news = get_posts($comp_news_args);
$comp_news_feat_img = get_field('feat_img', 'category_'.$cn_cat_id);

/* OFFICE NEWS POSTS */
$on_cat_id = get_cat_ID( 'Office News' );
$office_news_args = array(
	'posts_per_page'   => 3,
	'cat'  => $on_cat_id
);

$office_news = get_posts($office_news_args);
$office_news_feat_img = get_field('feat_img', 'category_'.$on_cat_id);
//echo '<pre>';print_r($add_article_pg);echo '</pre>';


/* EVENTS POSTS */
$ev_cat_id = get_cat_ID( 'Events' );
$today = date('Ymd', strtotime("today"));	
$next_month = date('Ymd', strtotime("2 months"));	
$add_event_pg = get_page_by_title('Add Event');

$events_args = array(
	'posts_per_page'   => 3,
	'cate'  => $ev_cat_id,
	'meta_key'	=> 'event_date',
	'orderby'	=> 'meta_value_num',
	'order'		=> 'ASC',
	'meta_query' => array(
		'relation' => 'AND',
		array(
			'key' => 'event_date',
			'value' => $today,
			'compare' => '>',
			'type' => 'NUMERIC'
		),
		array(
			'key' => 'event_date',
			'value' => $next_month,
			'compare' => '<',
			'type' => 'NUMERIC'
		)
	)
);

$events = get_posts($events_args);
$events_feat_img = get_field('feat_img', 'category_'.$ev_cat_id);
//echo '<pre>';print_r($events);echo '</pre>';
?>

<div class="panel-articles">

	<ul class="nav nav-tabs">
	  <?php if ($comp_news) { ?>
	  <li class="active"><a href="#company-news" data-toggle="tab">Company News</a></li>
	  <?php } ?>
	  <?php if ($office_news) { ?>
	  <li<?php echo (!$comp_news) ? ' class="active"': ''; ?>><a href="#office-news" data-toggle="tab">Office News</a></li>
	  <?php } ?>
	  <?php if ($events) { ?>
	  <li<?php echo (!$comp_news || !$office_news) ? ' class="active"': ''; ?>><a href="#events" data-toggle="tab">Events</a></li>
	  <?php } ?>
	</ul>
	
	<div class="tab-content">
		
		<?php if ($comp_news) { ?>
		<div class="tab-pane active fade in" id="company-news">
		<?php include (STYLESHEETPATH . '/_/inc/dashboard/news-panel/company-news.php'); ?>
		</div>
		<?php } ?>
		
		<?php if ($office_news) { ?>
		<div class="tab-pane fade" id="office-news">
		<?php include (STYLESHEETPATH . '/_/inc/dashboard/news-panel/office-news.php'); ?>
		</div>
		<?php } ?>
		
		<?php if ($events) { ?>
		<div class="tab-pane fade" id="events">
		<?php include (STYLESHEETPATH . '/_/inc/dashboard/news-panel/events.php'); ?>
		</div>
		<?php } ?>
	</div>
	
</div>