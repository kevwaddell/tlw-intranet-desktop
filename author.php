<?php get_header(); ?>

<?php include (STYLESHEETPATH . '/_/inc/user/user-vars.php') ?>

<?php include (STYLESHEETPATH . '/_/inc/user/user-data-query.php'); ?>

<article class="user-profile page">
<h1 class="block-header col-red"><i class="fa fa-user fa-lg"></i><?php echo ($current_user->ID == $user_id) ?  "Your":"Staff";?> Profile</h1>

<!-- USER PROFILE INFO -->
<?php include (STYLESHEETPATH . '/_/inc/user/user-profile-info.php'); ?>
<!-- USER PROFILE INFO END -->

<div class="alerts">
	<?php include (STYLESHEETPATH . '/_/inc/user/alerts.php'); ?>
</div>


<!-- MEETINGS DATA LIST -->

<?php if ($curauth->ID == 1 && $current_user->ID == 1 && is_user_logged_in()) { ?>

<section class="page-section">	
	<?php include (STYLESHEETPATH . '/_/inc/admin/admin-links.php'); ?>
</section>

<?php } else { ?>

<?php if ($current_user->ID == $user_id) { ?>
<section class="page-section">
	<div class="lists-wrap">
		
	<?php include (STYLESHEETPATH . '/_/inc/user/user-meetings.php'); ?>	
	
	<?php //include (STYLESHEETPATH . '/_/inc/user/user-holidays.php'); ?>
	
	<?php include (STYLESHEETPATH . '/_/inc/user/user-news.php'); ?>	
	
	<?php include (STYLESHEETPATH . '/_/inc/user/user-events.php'); ?>
	
	<?php include (STYLESHEETPATH . '/_/inc/user/user-announcements.php'); ?>
	
	<?php include (STYLESHEETPATH . '/_/inc/user/user-favourites.php'); ?>
		
	</div>
</section>
<?php } else { ?>

<section class="page-section">
	<h3 class="block-header" style="margin-top:0px;"><i class="fa fa-group fa-lg"></i>Send a message to <?php echo $curauth->data->display_name; ?></h3>
	<div class="message-wrap">
	<?php include (STYLESHEETPATH . '/_/inc/user/notifications/user-message-form.php'); ?>
	</div>
</section>	

<?php } ?>

<?php } ?>

</article>

<?php get_footer(); ?>
