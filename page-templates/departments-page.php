<?php
/*
Template Name: Departments list page
*/
?>

<?php get_header(); ?>

<?php if ( have_posts() ): while ( have_posts() ) : the_post(); ?>	

<article <?php post_class(); ?>>
						
</article>
		
<?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>
