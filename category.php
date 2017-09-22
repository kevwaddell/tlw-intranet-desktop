<?php get_header(); ?>

<?php
$exclude_posts = array();
$category = single_term_title("", false);
$slug = get_query_var('category_name');
$cat_id = get_cat_ID( $category );
$icon = get_field('icon', 'category_'.$cat_id);
$feat_img = get_field('feat_img', 'category_'.$cat_id);
$color = get_field('color', 'category_'.$cat_id);
//echo '<pre>';print_r($post_count);echo '</pre>';

include (STYLESHEETPATH . '/_/inc/category-page/cats-query.php');

//echo '<pre>';print_r($wp_query->found_posts);echo '</pre>';
?>

<article class="page">
	<h1 class="block-header<?php echo (!empty($color)) ? " col-".$color:" col-gray"; ?>"><?php if (!empty($icon)) {  echo '<i class="fa '.$icon.' fa-lg"></i>'; }?><?php single_cat_title(); ?></h1>

	<div class="row">
	
		<div class="col-xs-4">

		<?php get_sidebar(); ?>
		
		</div>
		
		<div class="col-xs-8">
			
			<?php if (count($exclude_posts) > 0) { 
			global $post;
			$indicator_counter = 0;	
			$item_counter = 0;	
			?>

			<section class="hero-posts<?php echo (!empty($color)) ? " col-".$color:" col-gray"; ?>">
				<div id="hero-posts-slider" class="carousel slide" data-ride="carousel">
					
					<?php if (count($exclude_posts) > 1) { ?>
					<ol class="carousel-indicators">
						<?php foreach ($feat_cats as $indicator) { ?>
						<li data-target="#hero-posts-slider" data-slide-to="<?php echo $indicator_counter; ?>"<?php echo ($indicator_counter == 0) ? ' class="active"': ''; ?>></li>
						<?php 
						$indicator_counter++;
						} ?>
					</ol>
					<?php }  ?>

					<div class="carousel-inner">
					<?php foreach ($feat_cats as $post) { 
					setup_postdata( $post );
					if ($slug == 'events') {
					$event_date = get_field('event_date');
					$event_time_from = get_field('event_time');
					$event_time_end = get_field('event_time_end');
					}
					$item_counter++;
					?>
					    <div class="item<?php echo ($item_counter == 1) ? ' active': ''; ?>">
							<article class="hero-post">
								
								<div class="hero-details">

									<header class="hero-post-header">
										<h3><?php the_title(); ?></h3>
										
										<?php if ($slug == 'events' && $event_date) { ?>
										<time><span>Event date:</span> <?php echo date('F j, Y', strtotime($event_date)); ?> - <?php echo $event_time_from; ?>
										<?php echo ($event_time_end) ? " to ".$event_time_end : ""; ?></time>
										<?php } else { ?>
										<time><span>Published on:</span> <?php echo get_the_date(); ?> - <?php the_time(); ?></time>
										<?php } ?>
		
									</header>
									<div class="txt">
									<?php the_excerpt(); ?>
									</div>
								</div>
								
								<footer class="hero-post-footer">
									<div class="action-btns<?php echo (!empty($color)) ? " col-".$color:" col-gray"; ?>">
										<a href="<?php the_permalink(); ?>" title="View details" class="btn btn-default btn-block"><i class="fa fa-eye fa-lg"></i>View details</a>
									</div>
								</footer>
							</article>
					    </div>
					    
					<?php } wp_reset_postdata(); ?>
					</div>
					
				</div>
			</section>
			
			<?php } ?>
			
			<section class="page-section <?php echo (count($exclude_posts) > 0) ? 'section-closed':'section-open'; ?>">
			<?php if (count($exclude_posts) > 0) { ?>
			<h3 class="section-header"><?php echo ($slug == 'events') ? 'Past':'More'; ?> <?php single_cat_title(); ?></h3>
			<button class="close-section-btn"><i class="fa fa-minus-circle fa-lg"></i><i class="fa fa-plus-circle fa-lg"></i></button>	
			<?php }  ?>
				
				<div id="post-section-wrap" class="section-wrap">
				
					<div id="post-section-inner" class="section-inner">
					
						<?php if (count($exclude_posts) == 0 && $found_posts > 0) { ?>
						<div class="pagination-links pagination-actions top">
							<?php wp_pagenavi(); ?>						
						</div>
						<?php }  ?>
				
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
						<div class="well well-lg no-posts-message text-center<?php echo (!empty($color)) ? " col-".$color:" col-gray"; ?>" style="margin-top: 10px;">
						<i class="fa fa-rss fa-3x"></i>
						<h3>Sorry</h3>
						<p>There is no <?php echo(count($exclude_posts) > 0)?' more ':''; ?><strong><?php single_cat_title(); ?></strong> at the moment.</p>
						</div>
						<?php endif; ?>
						
						<?php if ($found_posts > 0) { ?>
						<div class="pagination-links pagination-actions">
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
