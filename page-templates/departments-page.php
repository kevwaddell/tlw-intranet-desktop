<?php
/*
Template Name: Departments list page
*/
?>

<?php get_header(); ?>

<?php if ( have_posts() ): while ( have_posts() ) : the_post(); ?>	
<?php
$args = array('child_of' => $post->ID, 'sort_column'=> 'menu_order');
$children = get_pages($args);
$active_department = $children[0];
//echo '<pre class="debug">';print_r($active_department);echo '</pre>';
//echo '<pre class="debug">';print_r($children);echo '</pre>';
?>
<article id="<?php echo $post->post_name; ?>-page" <?php post_class('sb-out'); ?>>
	<div class="entry">
		<?php  get_template_part( 'parts/departments-page/department', 'info' ); ?>
	</div>				
</article>

<aside id="departments-list" class="scrollable sb-wide">
	<div class="sb-inner">
		<ul class="icon-list list-unstyled">
		<?php get_template_part( 'parts/departments-page/departments', 'grid' ); ?>
		</ul>
	</div>
	<div class="sb-actions">
		<button id="colapse-sb" class="btn btn-default btn-lg no-rounded pull-right" type="button">
			<i class="fa fa-arrow-circle-left fa-lg"></i>
		</button>
	</div>
</aside>
		
<?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>
