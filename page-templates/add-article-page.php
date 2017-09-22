<?php
/*
Template Name: Add article page
*/
?>

<?php get_header(); ?>

<?php if ( have_posts() ): while ( have_posts() ) : the_post(); ?>	

<?php 
$icon = get_field('icon');
$color = get_field('col');

$return_url = get_home_url();

if ( isset($_GET['httpref']) ) {
$return_url = urldecode($_GET['httpref']);
}

$news_editors = get_field('news_editors', 'options');

//echo '<pre>';print_r($news_editors);echo '</pre>';
?>	

	<div class="alerts">
	<?php if (isset($_GET['request']) || isset($_GET['action']) || $_SERVER['REQUEST_METHOD'] === 'POST' ) { ?>
		<div class="actions-wrap">
			<div class="alerts-wrap">
				
			<?php include (STYLESHEETPATH . '/_/inc/add-item/add-post/notifications/add-post-action.php'); ?>	
			<?php include (STYLESHEETPATH . '/_/inc/add-item/add-post/notifications/confirm-post-action.php'); ?>	
			
			</div>
		</div>
	<?php } ?>
	</div>

	<article <?php post_class(); ?>>
		<h1 class="block-header<?php echo (!empty($color)) ? " col-".$color:""; ?>"><?php if (!empty($icon)) {  echo '<i class="fa '.$icon.' fa-lg"></i>'; }?><?php the_title(); ?></h1>
		
		<?php if (!empty($post->post_content)) { ?>
		<div id="info-alert" class="alert alert-info<?php echo (isset($_GET['request']) || isset($_GET['action']) || $_SERVER['REQUEST_METHOD'] === 'POST') ? " hidden":""; ?>">
		<button type="button" class="close"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		
		<?php the_content(); ?>
		</div>
		<?php } ?>
		
		<div class="editor-form-wrap">
			<div class="row">
				<div class="col-xs-11">
					<?php include (STYLESHEETPATH . '/_/inc/add-item/add-post/add-post-form.php'); ?>
				</div>
				<div class="col-xs-1">
					<?php include (STYLESHEETPATH . '/_/inc/add-item/btn-actions.php'); ?>
				</div>
			</div>
		</div>
		
	</article>
	
	<?php include (STYLESHEETPATH . '/_/inc/add-item/help-video.php'); ?>
					
<?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>
