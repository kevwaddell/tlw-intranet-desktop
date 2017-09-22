<?php 
$your_news_ids = array();

$news_args = array(
'post_type' => 'post',
'posts_per_page' => -1,
'order'	=> 'DESC',
'orderby' => 'date',
'author'=> $user_id,
'category_name'	=> 'company-news, office-news'
);

if (!isset($_GET['post_sortby'])) {
$news_args['post_status'] = array('pending', 'publish', 'draft');
}

if (isset($_GET['post_sortby']) && $_GET['post_sortby'] == 'publish') {
$news_args['post_status'] = 'publish';
}

if (isset($_GET['post_sortby']) && $_GET['post_sortby'] == 'pending') {
$news_args['post_status'] = 'pending';
}

if (isset($_GET['post_sortby']) && $_GET['post_sortby'] == 'draft') {
$news_args['post_status'] = 'draft';
}

$news = get_posts($news_args);

foreach ($news as $article) {
	
	if (!in_array($article->ID, $your_news_ids)) {	
	array_push($your_news_ids, $article->ID);
	}		
}

if (!empty($your_news_ids)) {
$news_max_num_pages = ceil( count($your_news_ids)/10);

	if (isset($_GET['yn_pg'])) {
	$slice_from = 10 * ($_GET['yn_pg'] - 1);
	$news_ids = array_slice($your_news_ids, $slice_from , 10);	
	} else {
	$news_ids = array_slice($your_news_ids, 0 , 10);	
	}

$news_args['post__in' ] = $news_ids;
}

$news_query = new WP_Query( $news_args );
 ?>