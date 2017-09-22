<?php include (STYLESHEETPATH . '/_/inc/single-post/notifications/post-update.php'); ?>

<?php get_header(); ?>

<?php if ( have_posts() ): while ( have_posts() ) : the_post(); ?>	

<?php 
global $current_user;
$icon = 'fa-rss';
$color = 'col-aqua';
$cat = get_the_category();
$cat_id = $cat[0]->term_id;
$tags = implode( ", ", wp_get_post_terms($post->ID, 'post_tag', array("fields" => "names") ) ) ; 
$icon = get_field('icon', 'category_'.$cat_id);
$color = get_field('color', 'category_'.$cat_id);
$user_favs = unserialize(get_user_meta($current_user->ID, 'user_favourites', true));
/*
if ($cat[0]->slug == 'events') {
$icon = 'fa-calendar';	
}

if ($cat[0]->slug == 'announcements') {
$icon = 'fa-bullhorn';	
}
*/

//echo '<pre>';print_r($user_favs);echo '</pre>';
?>	
		<article <?php post_class('page'); ?>>

		<h1 class="block-header<?php echo (!empty($color)) ? " col-".$color:" col-gray"; ?>"><i class="fa <?php echo $icon; ?> fa-lg"></i><?php echo $cat[0]->name; ?> </h1>
		
			<div class="row">
				<div class="col-xs-3">
				
				<?php get_sidebar('single'); ?>
				
				</div>
				
				<div class="col-xs-8">
					
					<div class="content-outer">
						<div class="content-inner">
						
							<?php if (isset($_GET['userid']) && $_GET['edit_request'] == "edit_post") { 
								$user_id = get_user_by('id', $_GET['userid']);
							?>
							
							<?php include (STYLESHEETPATH . '/_/inc/single-post/notifications/edit-post-form.php'); ?>
							
							<?php } else {  ?>
							
							<header class="page-header<?php echo (!empty($color)) ? " col-".$color:" col-gray"; ?>">
								<h2><?php the_title(); ?></h2>
							</header>
							
							<?php if ($cat[0]->slug == 'events') { ?>	
							
							<?php include (STYLESHEETPATH . '/_/inc/single-post/event-details-box.php'); ?>
							
							<?php } ?>
							
							<?php if ($cat[0]->slug == 'vacancies') { ?>	
							
							<?php include (STYLESHEETPATH . '/_/inc/single-post/vacancy-details-box.php'); ?>
							
							<?php } ?>

							
							<div class="hentry-txt<?php echo (!empty($color)) ? " col-".$color:" col-gray"; ?>">
								<?php the_content(); ?>
								
								<?php 
									$pag_args = array (
									'before'	=> '<div class="post-pagination"><span class="pag-label">Pages:</span> ',	
									'after'	=> '</div>',
									'link_before'      => '<span class="pg">',
									'link_after'      => '</span>',
									);
								wp_link_pages($pag_args); 
								?>
							</div>
							
							<?php } ?>
							
						</div>
					</div>
					
				</div>
				
				<div class="col-xs-1">
					
					<?php include (STYLESHEETPATH . '/_/inc/single-post/btn-actions.php'); ?>
					
				</div>
			
			</div>
			
			<div class="next-prev-posts<?php echo (!empty($color)) ? " col-".$color:" col-gray"; ?>">
			<?php 
			$next_post = get_adjacent_post( true, '', false);
			$prev_post = get_adjacent_post( true, '', true);
			//echo '<pre>';print_r($prev_post);echo '</pre>';
			?>
				<div class="row">
					<div class="col-xs-6">
						<?php if (!empty($prev_post)) { ?>
						<a href="<?php echo get_permalink($prev_post->ID); ?>" title="View previous post" class="prev-post">
							<i class="fa fa-angle-double-left fa-lg"></i><?php echo $prev_post->post_title; ?>
						</a>
						<?php } ?>
					</div>
					<div class="col-xs-6">
						<?php if (!empty($next_post)) { ?>
						<a href="<?php echo get_permalink($next_post->ID); ?>" title="View next post" class="next-post">
							<?php echo $next_post->post_title; ?><i class="fa fa-angle-double-right fa-lg"></i>
						</a>
						<?php } ?>
					</div>
				</div>
			
			</div>
			
		</article>
		
		<div class="alerts">
			<?php include (STYLESHEETPATH . '/_/inc/single-post/notifications/alerts.php'); ?>
		</div>
		
		
<?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>
