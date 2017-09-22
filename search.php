<?php get_header(); ?>

<?php 
if (isset($_GET['type'])) {

	switch ($_GET['type']) {
		case "all": $search_args = array('s'=>$s, 'posts_per_page' => -1 );
		break;
		case "office-news":
		case "company-news":
		case "events":
		case "announcements": 
		$search_args = array('s'=>$s, 'post_type' => 'post' ,'posts_per_page' => -1, 'category_name' =>  $_GET['type']);
		break;
		case "meetings":
		$search_args = array('s'=>$s, 'post_type' => 'tlw_meeting' ,'posts_per_page' => -1);
		break;
	}
	
} else {
$search_args = array('s'=>$s, 'posts_per_page' => -1 );
}

$allsearch = new WP_Query($search_args); 
wp_reset_query();
$search_count = $allsearch->post_count;
$search_query = get_search_query(); 
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$search_args['paged'] = $paged;
$search_args['posts_per_page'] = 10;
$wp_query = new WP_Query( $search_args );
//echo '<pre>';print_r($wp_query);echo '</pre>';
?>

<?php
$icon = 'fa-search';
$color = 'red';
?>

<article class="page">
<h1 class="block-header<?php echo (!empty($color)) ? " col-".$color:" col-gray"; ?>"><?php if (!empty($icon)) {  echo '<i class="fa '.$icon.' fa-lg"></i>'; }?>Search Results</h1>
	
	<div class="row">
		<div class="col-xs-4 col-xs-offset-4">
			<p class="intro text-center">You Searched for: "<?php the_search_query(); ?>"<br> Results: <?php echo $search_count; ?></p>
			
			<div class="search-form-wrap">
			<?php get_search_form(); ?>
			</div>
		</div>
	</div>
	<div class="rule"></div>
	
	<section class="search-list">

<?php if ( have_posts() ): while ( have_posts() ) : the_post(); ?>		
		
		<article class="list-item">
			<header class="list-item-header">
				<h2><a href="<?php esc_url( the_permalink() ); ?>" title="Permalink to <?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
				
				<?php 
				if ($post->post_type == 'post') { 
				$cats = get_the_category();	
				$article_type = "News article";
				//echo '<pre>';print_r($cats[0]->slug);echo '</pre>';
				
					if ($cats[0]->slug == 'events') {
					$article_type = "Event";	
					}
					
					if ($cats[0]->slug == 'announcements') {
					$article_type = "Message";	
					}
					
					if ($cats[0]->slug == 'vacancies') {
					$article_type = "Vacancy";	
					}
				}
				
				if ($post->post_type == 'page') { 
				$article_type = "Page";
				}
				
				?>
				
				<?php 
				if ($post->post_type == 'tlw_meeting') { 
				$article_type = "Meeting";
				$meeting_date = get_field('meeting_date');
				$start_time = get_field('start_time');
				$end_time = get_field('end_time');
				$room = wp_get_post_terms( get_the_ID(), 'tlw_rooms_tax');
				$total_int = get_post_meta( get_the_ID(), 'attendees_staff', true );
				$total_ext = get_post_meta( get_the_ID(), 'attendees_clients', true );
				//echo '<pre>';print_r($start_time);echo '</pre>';
				}
				
				if ($post->post_type == 'page') { 
				$article_type = "Page";
				}
				?>

				<?php if ($post->post_type == 'post') { ?>
				<time datetime="<?php the_time( 'Y-m-d' ); ?>" pubdate><span>Published on: </span> <?php the_date(); ?> at <?php the_time(); ?></time>
				<?php } ?>
				
				<?php if ($post->post_type == 'tlw_meeting') { ?>
				<time datetime="<?php the_time( 'Y-m-d' ); ?>" pubdate><span>Date: </span> <?php echo date('F j, Y', strtotime($meeting_date)); ?> at <?php echo date('g:i a', $start_time); ?> to <?php echo date('g:i a', $end_time); ?></time>
				<?php } ?>
				
				<div class="extra-info">
					<span class="label label-default"><?php echo $article_type; ?></span>
					
					<?php if ($post->post_type == 'post') { ?>
					<span class="label label-default">Posted by: <?php the_author_posts_link(); ?></span>
					<?php } ?>
					
					<?php if ($post->post_type == 'tlw_meeting') { ?>
					<span class="label label-default">Booked by: <?php the_author_posts_link(); ?></span>
					<?php } ?>
					
					<?php if ($post->post_type == 'tlw_meeting') { ?>
					<span class="label label-default">Room: <?php echo $room[0]->name; ?></span>
					<?php } ?>
					
					<?php if (get_the_category()) { ?>
					<span class="label label-default">
						<?php if (count(get_the_category()) > 1) { ?>
						Categories:
						<?php } else { ?>
						Category:
						<?php } ?>

						<?php the_category(' | '); ?> 
					</span>
					<?php } ?>
				</div>
			</header>
			
			<?php if ($post->post_type == 'post' || $post->post_type == 'page') { ?>
			<?php the_excerpt(); ?>
			<?php } ?>
			
			<?php if ($post->post_type == 'tlw_meeting' && ($total_int + $total_ext) > 1) { ?>
			<p>Total Attendees: <?php echo ($total_int + $total_ext); ?></p>
			<?php } ?>
			
			<div class="action-btns col-red">
				<a href="<?php the_permalink(); ?>" title="View details" class="btn btn-default btn-block"><i class="fa fa-eye fa-lg"></i>View <?php echo $article_type; ?> details</a>
			</div>

		</article>
<?php endwhile; ?>
		
		<div class="pagination-links" style="margin-top: 30px;">
		
		<?php wp_pagenavi(); ?>		
		
		</div>	
		
<?php else: ?>

	<div class="well well-lg no-posts-message text-center col-gray">
		<i class="fa fa-exclamation-triangle fa-3x"></i>
		<h3 class="text-center">Sorry</h3>
		<p class="text-center">There are no search results for "<?php echo $search_query; ?>". Please try again.</p>
	</div>
	
	<?php endif; ?>
	
	</section>

</div>

<?php get_footer(); ?>
