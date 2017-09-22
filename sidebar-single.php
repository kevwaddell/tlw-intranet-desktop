<?php 
global $cat;
global $tags;
global $post;
global $color;
$tag_links = wp_get_post_tags($post->ID);

	
/*
echo '<pre>';
print_r($tag_links);
echo '</pre>';
*/
?>
<aside class="sidebar<?php echo (!empty($color)) ? " col-".$color:" col-gray"; ?>">
	<?php if (function_exists('has_post_thumbnail') && has_post_thumbnail()) { 
	$post_thumbnail_id = get_post_thumbnail_id();
	$lg = wp_get_attachment_image_src($post_thumbnail_id, 'large');	
	?>
		<figure class="feat-img">
			<a href="<?php echo $lg[0]; ?>" rel="fancybox" class="zoomable">
				<?php the_post_thumbnail('img-3-col-crop'); ?>
				<span class="zoom-mask"><i class="fa fa-search fa-2x"></i></span>
			</a>
		</figure>
		
	<?php } ?>
	<div class="hentry-details">
		<time datetime="<?php the_time( 'Y-m-d' ); ?>" pubdate>
			<i class="fa fa-clock-o"></i>
			<?php the_date(); ?>
		</time>
		
		<h3 class="sb-label">
			<i class="fa fa-user"></i>
			Post Author
		</h3>
		<div class="sb-box">
			<?php the_author_posts_link(); ?>
		</div>
				
		<?php if ($cat) { ?>
		<h3 class="sb-label">
			<i class="fa fa-thumb-tack"></i>
			Categories
		</h3>
		<div class="sb-box">
			<ul class="links-list">
			<?php foreach ($cat as $c) { ?>
				<li><a href="<?php echo get_category_link( $c->term_id ); ?>" title="View posts under <?php echo $c->name; ?> category"><?php echo $c->name; ?></a></li>
			<?php } ?>
			</ul>
		</div>
		<?php } ?>
		
		<?php if ($tags) { ?>
		<h3 class="sb-label">
			<i class="fa fa-tags"></i>
			Tags
		</h3>
		<div class="sb-box">
		<div class="tags-list">
			<?php foreach ($tag_links as $tag_link) { ?>
			<a href="<?php echo get_tag_link($tag_link->term_id); ?>" title="View posts under <?php echo $tag_link->name; ?> tag"><?php echo $tag_link->name; ?></a>
			<?php } ?>
		</ul>
		</div>
		<?php } ?>
		
	</div>
</aside>
