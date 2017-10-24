<?php
/*
Template Name: Calendar page
*/
?>

<?php get_header(); ?>

<?php if ( have_posts() ): while ( have_posts() ) : the_post(); ?>	

<article id="<?php echo $post->post_name; ?>-page" <?php post_class('full-width'); ?>>
	<div class="entry">
		
	</div>				
</article>
		
<?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>
