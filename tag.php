<?php get_header(); ?>

<?php 
$news_page = get_page( get_option('page_for_posts') );	
$post_thumbnail_id = get_post_thumbnail_id( $news_page->ID );
$feat_img = wp_get_attachment_image_src($post_thumbnail_id, 'img-4-col-crop' );	
?>

<article class="page">
	<h1 class="block-header col-red"><i class="fa fa-tag fa-lg"></i>Tag: <?php single_tag_title(); ?></h1>

	<div class="row">
	
		<div class="col-xs-4">

		<?php get_sidebar(); ?>
		
		</div>
		
		<div class="col-xs-8">
			
			<section class="page-section section-open">
				
				<div id="post-section-wrap" class="section-wrap">
				
					<div id="post-section-inner" class="section-inner">
					
						<div class="pagination-links pagination-actions top">
							<?php wp_pagenavi(); ?>						
						</div>
				
						<?php if ( have_posts() ): ?>	
					
						<?php while ( have_posts() ) : the_post(); 
							if ($slug == 'events') {
							$event_date = get_field('event_date');
							$event_time_from = get_field('event_time');
							$event_time_end = get_field('event_time_end');
							}
							//print_r($wp_query->current_post);
						?>		
								
								<div class="list-item">
									<header class="list-item-header">
										<h2><a href="<?php esc_url( the_permalink() ); ?>" title="Permalink to <?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
									</header>
									<?php the_excerpt(); ?>
									<footer class="list-item-footer">
										<?php if ($slug == 'events' && $event_date) { ?>
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
						<div class="well text-center">
							No more <strong><?php single_tag_title(); ?></strong> at the moment.
						</div>
						<?php endif; ?>
						
						<div class="pagination-links pagination-actions">
							<?php wp_pagenavi(); ?>							
						</div>	
				
					</div>
				
				</div>
			
			</section>
		</div>
	
	</div>

</article>

<?php get_footer(); ?>
