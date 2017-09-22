<?php
/*
Template Name: User edit profile page
*/
?>
<?php get_header(); ?>

<?php if ( have_posts() ): while ( have_posts() ) : the_post(); ?>	

<?php 
$icon = get_field('icon');
$color = get_field('col');

?>	
		<article <?php post_class(); ?>>
			<h1 class="block-header<?php echo (!empty($color)) ? " col-".$color:""; ?>"><?php if (!empty($icon)) {  echo '<i class="fa '.$icon.' fa-lg"></i>'; }?><?php the_title(); ?></h1>
			
			<div class="user-details">
			
			<div class="action-btns col-red" style="margin-bottom: 20px;">
			<a href="<?php echo get_author_posts_url( $current_user->ID, $current_user->user_nicename); ?>" class="btn btn-default btn-block" title="Back to your profile">Back to your profile</a>
			</div>
			
				<div class="row">
				
					<div class="col-xs-2">
						<div class="user-avatar">  
							<?php echo get_avatar( $current_user->ID, 200 ); ?>      
						</div> 
					</div>
					
					<div class="col-xs-10">
						<?php the_content(); ?>
					</div>
				
				</div>
			
			</div>
						
		</article>
		
<?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>
