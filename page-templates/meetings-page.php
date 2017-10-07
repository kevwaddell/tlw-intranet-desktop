<?php
/*
Template Name: Meetings page
*/
?>

<?php get_header(); ?>

<?php  
$rooms = get_terms('tlw_rooms_tax', 'hide_empty=0');
//echo '<pre class="debug">';print_r($rooms);echo '</pre>';
?>

<article <?php post_class('page'); ?>>
	<div class="entry">
		<?php if ( isset($_REQUEST['meeting-id']) ) { ?>
			<?php  get_template_part( 'parts/meetings-page/meetings', 'info' ); ?>
		<?php } ?>
	</div>
</article>

<aside id="rooms-list" class="scrollable sb-left">
	<div class="sb-inner">
		<div class="address-books">
		  <?php foreach ($rooms as $room) { ?>
			  <a href="?room-id=<?php echo $room->term_id; ?>" class="address-group-item<?php echo ($_REQUEST['room-id'] == $room->term_id) ? ' active':'' ?>"><?php echo $room->name; ?></a>
		  <?php } ?>
		 </div>
	</div>
</aside>

<aside id="meetings-list" class="scrollable sb-right">
	<div class="sb-inner">
		<?php  if ( isset($_REQUEST['room-id']) ) { ?>
		<div class="meetings">
		<?php get_template_part( 'parts/meetings-page/meetings', 'list' ); ?>
		</div>
		<?php } ?>		
		
		<?php if ( empty($_REQUEST)) { ?>
		<div class="no-name-message text-center">
			<i class="fa fa-group fa-4x block"></i>
			Select a meeting room
		</div>
		<?php } ?>	

	</div>
	<div class="sb-actions">
		<div class="actions-inner">
		<?php if (isset($_REQUEST['room-id'])) { ?>
			<a href="?meeting-actions=add-meeting<?php echo (isset($_REQUEST['room-id'])) ? '&room-id='.$_REQUEST['room-id']:''; ?>" class="btn btn-default btn-lg no-rounded pull-right" id="add-contact" ><i class="fa fa-plus fa-lg"></i><span class="sr-only">Add Meeting</span></a>
			<?php } ?>	
		</div>
	</div>
</aside>

<?php get_footer(); ?>
