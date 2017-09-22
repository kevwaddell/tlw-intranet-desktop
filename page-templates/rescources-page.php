<?php
/*
Template Name: Rescources page
*/
?>

<?php get_header(); ?>

<?php if ( have_posts() ): while ( have_posts() ) : the_post(); ?>	

<?php 
$icon = get_field('icon');
$color = get_field('col');
$child_args = array(
'sort_column' => 'menu_order',
'parent' => get_the_ID(),
'post_type' => 'page'
);
$children = get_pages($child_args);

$related_cats = get_field('categories');

//echo '<pre>';print_r($related_cats);echo '</pre>';
?>	
		<article <?php post_class(); ?>>
			<h1 class="block-header<?php echo (!empty($color)) ? " col-".$color:""; ?>"><?php if (!empty($icon)) {  echo '<i class="fa '.$icon.' fa-lg"></i>'; }?><?php the_title(); ?></h1>
			
			<?php include (STYLESHEETPATH . '/_/inc/global/banner-imgs.php'); ?>
			
			<?php the_content(); ?>
			
			<?php if ($children) { ?>

			<div class="rule"></div>
			
			<section id="recources-list" class="grid-list">
				<div class="row">
			
				<?php foreach ($children as $child) { 
				$icon = get_field('icon', $child->ID);	
				$col = get_field('col', $child->ID);
				?>
					<div class="col-xs-6">
						<div class="list-item">
							<a href="<?php echo get_permalink($child->ID); ?>" class="col-<?php echo $col; ?>" title="View <?php echo $child->post_title; ?>">
								<span class="icon"><i class="fa <?php echo $icon; ?> fa-3x"></i></span>
								<span class="title"><?php echo $child->post_title; ?></span>
							</a>
						</div>
					</div>
				<?php } ?>
				
				<?php if ($related_cats) { ?>
				
				<?php foreach ($related_cats as $cat) { 
				$icon = get_field('icon', 'category_'.$cat->term_id);
				$col = get_field('color', 'category_'.$cat->term_id);
				?>
				<div class="col-xs-6">
					<div class="list-item">
						<a href="<?php echo get_category_link($cat->term_id); ?>" class="col-<?php echo $col; ?>" title="View <?php echo $cat->name; ?>">
							<span class="icon"><i class="fa <?php echo $icon; ?> fa-3x"></i></span>
							<span class="title"><?php echo $cat->name; ?></span>
						</a>
					</div>
				</div>
				<?php } ?>
				
				<?php } ?>
				
				</div>
				
			</section>
			
			<?php } ?>
			
			
		</article>
		
<?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>
