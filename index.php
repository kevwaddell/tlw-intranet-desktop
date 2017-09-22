<?php get_header(); ?>

<?php
$news_page = get_page( get_option('page_for_posts') );
$icon = get_field('icon', $news_page->ID);
$post_thumbnail_id = get_post_thumbnail_id( $news_page->ID );
$feat_img = wp_get_attachment_image_src($post_thumbnail_id, 'img-4-col-crop' );
$content = apply_filters('the_content', $news_page->post_content );
$color = get_field('col', $news_page->ID);
//echo '<pre>';print_r($feat_img[0]);echo '</pre>';
$found_posts = $wp_query->found_posts;
//echo '<pre>';print_r($found_posts);echo '</pre>';
?>

<article class="page">
	<h1 class="block-header<?php echo (!empty($color)) ? " col-".$color:" col-gray"; ?>"><?php if (!empty($icon)) {  echo '<i class="fa '.$icon.' fa-lg"></i>'; }?><?php echo $news_page->post_title; ?></h1>
	
	<div class="row">
	
		<div class="col-xs-4">

		<?php get_sidebar(); ?>
		
		</div>
		
		<div class="col-xs-8">
		
			<section class="page-section section-open">
			
			<div id="post-section-wrap" class="section-wrap">
				
				<div id="post-section-inner" class="section-inner">
					
					<?php if ($found_posts > 0) { ?>
					<div class="pagination-links pagination-actions top">
						<?php wp_pagenavi(); ?>						
					</div>
					<?php } ?>
	
					<?php if ( have_posts() ): ?>	
					
					<?php while ( have_posts() ) : the_post(); ?>	
					<?php 
					$post_categories = wp_get_post_categories( get_the_ID() );
					$post_category = get_category($post_categories[0]);
					$cat_slug = $post_category->slug;
					$cat_title = $post_category->name;
					//echo '<pre>';print_r($post_category);echo '</pre>';
					
					if ($cat_slug == 'events') {
					$event_date = get_field('event_date');
					$event_time_from = get_field('event_time');
					$event_time_end = get_field('event_time_end');	
					}
					 ?>	
					<div class="list-item">
						<header class="list-item-header">
							<span class="label label-default"><?php echo $cat_title; ?></span>
							<h2><a href="<?php esc_url( the_permalink() ); ?>" title="Permalink to <?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
						</header>
						<?php the_excerpt(); ?>
						<footer class="list-item-footer">
							<?php if ($cat_slug == 'events' && $event_date) { ?>
							<time><i class="fa fa-calendar"></i> <?php echo date('F j, Y', strtotime($event_date)); ?> - <?php echo $event_time_from; ?>
							<?php echo ($event_time_end) ? " to ".$event_time_end : ""; ?></time>
							<?php } else { ?>
							<time><i class="fa fa-calendar"></i> <?php echo get_the_date(); ?> - <?php the_time(); ?></time>
							<?php } ?>
							<span><i class="fa fa-user"></i> <?php the_author(); ?></span>
							
							<a href="<?php esc_url( the_permalink() ); ?>" title="View details"><span class="sr-only">View details</span></a>
						</footer>
					</div>
					<?php endwhile; ?>
			
					<?php else: ?>
					<div class="well well-lg no-posts-message text-center" style="margin-top: 10px;">
						<i class="fa fa-rss fa-3x"></i>
						<h3>Sorry</h3>
						<p>There is no news at the moment.</p>
					</div>
					<?php endif; ?>
					
					<?php if ($found_posts > 0) { ?>
					<div class="pagination-links pagination-actions top">
						<?php wp_pagenavi(); ?>						
					</div>
					<?php } ?>
				
				</div>
				
			</div>
	
			</section>

		</div>
		
	</div>

</article>

<?php get_footer(); ?>
