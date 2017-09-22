<?php
/*
Template Name: Users list page
*/
?>

<?php get_header(); ?>

<?php include (STYLESHEETPATH . '/_/inc/users-page/users-vars.php'); ?>

<article <?php post_class('page'); ?>>

<h1 class="block-header<?php echo (!empty($color)) ? " col-".$color:"col-gray"; ?>"><?php if (!empty($icon)) {  echo '<i class="fa '.$icon.' fa-lg"></i>'; }?><?php echo the_title(); ?></h1>

<div class="list-loader">
	<i class="fa fa-spinner fa-4x fa-spin"></i>
</div>

<?php if ($total_users > 0) { ?>

<div class="user-list">

	<div class="user-list-inner">
		
		<?php include (STYLESHEETPATH . '/_/inc/users-page/user-filters.php'); ?>
			
		<?php include (STYLESHEETPATH . '/_/inc/users-page/pagination-top.php'); ?>
			
		<?php if (!isset($_GET['list_style']) || $_GET['list_style'] == 'grid') { ?>
			<?php include (STYLESHEETPATH . '/_/inc/users-page/users-grid.php'); ?>
		<?php } ?>
		
		<?php if (isset($_GET['list_style']) && $_GET['list_style'] == 'list') { ?>
			<?php include (STYLESHEETPATH . '/_/inc/users-page/users-list.php'); ?>
		<?php } ?>
				
		<?php include (STYLESHEETPATH . '/_/inc/users-page/pagination-bottom.php'); ?>
		
	</div>
	
</div>

<?php } else { ?>
<p>No users at the moment.</p>
<?php } ?>

</article>


<?php get_footer(); ?>
