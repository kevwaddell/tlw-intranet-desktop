<?php get_header(); ?>

<?php if ( have_posts() ): while ( have_posts() ) : the_post(); ?>	

<?php 
$icon = get_field('icon');
$color = get_field('col');
$uc_active = get_field('uc_active');
?>	
		<article <?php post_class(); ?>>
					
			<h1 class="block-header<?php echo (!empty($color)) ? " col-".$color:""; ?>"><?php if (!empty($icon)) {  echo '<i class="fa '.$icon.' fa-lg"></i>'; }?><?php the_title(); ?></h1>
			
			<?php if ($uc_active) { 
			$uc_message = get_field('uc_message');
			?>
			<div class="well well-lg uc-message">
				<i class="fa fa-wrench fa-3x"></i>
				<?php echo $uc_message; ?>
			</div>
			<?php } else { ?>
			
			<?php the_content(); ?>
			
			<div class="rule"></div>
			
			<?php } ?>
			
			
		</article>
		
<?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>
