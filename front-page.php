<?php get_header(); ?>

<?php if ( have_posts() ): while ( have_posts() ) : the_post(); ?>	

<div id="launchpad-nav" class="launchpad-wrap hp-lp" role="navigation">
	<div class="launchpad-wrap-inner">
		<?php wp_nav_menu(array( 
		'container' => 'false', 
		'menu' => 'Launchpad Menu', 
		'menu_class'  => 'menu list-inline',
		'fallback_cb' => false 
		) ); 
		?>
	</div>
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
