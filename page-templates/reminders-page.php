<?php
/*
Template Name: Reminders page
*/
?>

<?php get_header(); ?>

<article <?php post_class('page'); ?>>
	
	<?php if ( have_posts() ): while ( have_posts() ) : the_post(); ?>	
		
	<?php endwhile; ?>
	<?php endif; ?>

</article>

<?php get_footer(); ?>