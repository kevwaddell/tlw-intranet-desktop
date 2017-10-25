<?php
/*
Template Name: Calendar page
*/
?>
<?php get_header(); ?>

<?php if ( have_posts() ): while ( have_posts() ) : the_post(); ?>	

<article id="<?php echo $post->post_name; ?>-page" <?php post_class('fl-wth'); ?>>
	<div class="entry">
		<div id="calendar-wrapper">
			<div class="calendar-inner">
				
				<?php  get_template_part( 'parts/calendar-page/calendar', 'views' ); ?>
				
			</div>
		</div>

	</div>				
</article>
		
<?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>
