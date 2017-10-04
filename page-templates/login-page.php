<?php
/*
Template Name: Login page
*/
?>

<?php get_header('user'); ?>

<?php if ( have_posts() ): while ( have_posts() ) : the_post(); ?>	
	<div class="login-wrapper">	
		<?php the_content(); ?>
	</div>
	<div class="launchpad-animated-bg">
		<div class="circle circle-1"></div>
		<div class="circle circle-2"></div>
		<div class="circle circle-3"></div>
		<div class="circle circle-4"></div>
		<div class="circle circle-5"></div>
		<div class="circle circle-6"></div>
		<div class="circle circle-7"></div>
	</div>
<?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>
