<?php
/*
Template Name: Notes page
*/
?>

<?php get_header(); ?>
<?php 
global $current_user;
$user_notes_raw = get_user_meta($current_user->ID, 'user_notes', true);
$trash_notes_raw = get_user_meta($current_user->ID, 'trash_notes', true);

if (empty($user_notes_raw)) {
$user_notes = array();
add_user_meta($current_user->ID, 'user_notes', serialize($user_notes),true);	
$user_notes_raw = get_user_meta($current_user->ID, 'user_notes', true);	
}

if (empty($trash_notes_raw)) {
$trash_notes = array();
add_user_meta($current_user->ID, 'trash_notes', serialize($trash_notes), true);	
$trash_notes_raw = get_user_meta($current_user->ID, 'trash_notes', true);	
}

$trash_notes = unserialize($trash_notes_raw);
$user_notes = unserialize($user_notes_raw);
$bg_colors = array('yellow','purple','green','pink','orange','blue');
//echo '<pre class="debug">';print_r($user_notes);echo '</pre>';
?>
<?php 	
include (STYLESHEETPATH . '/app/inc/notes-page-vars/post-note.inc');
include (STYLESHEETPATH . '/app/inc/notes-page-vars/get-note.inc');
?>		
<?php if ( have_posts() ): while ( have_posts() ) : the_post(); ?>	
<div id="notes-canvas" class="trash-closed">
	<?php if (!empty($user_notes)) { ?>
	<form action="<?php the_permalink(); ?>" method="post"> 
			<?php foreach ($user_notes as $k => $note) { ?>
			<div id="note-<?php echo $note['note-id']; ?>" data-note="<?php echo $note['note-id']; ?>" class="note draggable bg-<?php echo $note['bg-col']; ?><?php echo ($_GET['note-action'] == 'edit-note' && $_GET['note-id'] == $note['note-id']) ? ' edit-note':'' ?><?php echo ($_GET['note-action'] == 'delete-note' && $_GET['note-id'] == $note['note-id']) ? ' delete-note animated fadeOut':'' ?>" data-x="<?php echo $note['x_pos']; ?>" data-y="<?php echo $note['y_pos']; ?>" style="transform: translate(<?php echo $note['x_pos']; ?>px, <?php echo $note['y_pos']; ?>px)">
				<input type="hidden" name="note-<?php echo $note['note-id']; ?>[note-id]" value="<?php echo $note['note-id']; ?>">
				<?php if ($_GET['note-action'] == 'edit-note' && $_GET['note-id'] == $note['note-id']) { ?>
				<textarea class="note-txt" name="note-<?php echo $note['note-id']; ?>[note-txt]" placeholder="Enter your note"<?php echo ($_GET['note-action'] == 'edit-note' && $_GET['note-id'] == $note['note-id']) ? ' autofocus':'' ?>><?php echo $note['note-txt']; ?></textarea>
				<?php } else { ?>
				<div class="note-txt"><?php echo $note['note-txt']; ?></div>
				<input type="hidden" name="note-<?php echo $note['note-id']; ?>[note-txt]" value="<?php echo $note['note-txt']; ?>">
				<?php } ?>
				<input type="hidden" class="y_pos" name="note-<?php echo $note['note-id']; ?>[y_pos]" value="<?php echo $note['y_pos']; ?>">
				<input type="hidden" class="x_pos" name="note-<?php echo $note['note-id']; ?>[x_pos]" value="<?php echo $note['x_pos']; ?>">
				<input type="hidden" name="note-<?php echo $note['note-id']; ?>[bg-col]" value="<?php echo $note['bg-col']; ?>">
				<div class="note-actions">
					<?php if (!isset($_GET['note-action']) || $_GET['note-id'] != $note['note-id']) { ?>
					<a href="?note-action=edit-note&note-id=<?php echo $note['note-id']; ?>" class="btn btn-default note-btn"><i class="fa fa-edit fa-lg"></i><span class="sr-only">Edit note</span></a>
					<a href="?note-action=delete-note&note-id=<?php echo $note['note-id']; ?>" class="btn btn-default note-btn"><i class="fa fa-trash fa-lg"></i><span class="sr-only">Delete note</span></a>
					<?php } ?>
					<?php if ($_GET['note-action'] == 'edit-note' && $_GET['note-id'] == $note['note-id']) { ?>
					<button type="button" class="btn btn-default note-btn save-note-btn"><i class="fa fa-save fa-lg"></i><span class="sr-only">Save note</span></button>			
					<?php } ?>
					<button type="button" class="btn btn-default note-btn move-btn"><i class="fa fa-arrows fa-lg"></i><span class="sr-only">Move note</span></button>
				</div>
			</div>
			<?php } ?>	
			<input type="hidden" name="edit-note">
			
			<div class="note-canvas-actions">
			<a href="?note-action=add-note" class="btn btn-default"><i class="fa fa-plus fa-2x"></i><span class="sr-only">Add note</span></a>
			<?php if (!empty($trash_notes)) { ?>
			<button id="open-trash-btn" class="btn btn-default"><span class="label label-success"><?php echo count($trash_notes); ?></span><i class="fa fa-trash fa-2x"></i><span class="sr-only">Open trash</span></button>
			<?php } ?>	
			</div>	
	</form>
	<?php } ?>	
	
	<?php if (empty($user_notes) || $_GET['note-action'] == 'add-note') { ?>	
	<form action="<?php the_permalink(); ?>" method="post">
	<?php get_template_part( 'parts/notes-page/note', 'template' ); ?>	
	</form>
	<?php } ?>	
	
</div>	

<?php if (!empty($trash_notes)) { ?>
<aside id="trash-notes" class="hidden-sb sb-closed">
	<div id="trash-notes-list">
		<ul class="list-unstyled">
			<?php foreach ($trash_notes as $k => $tn) { ?>
			<li class="bg-<?php echo $tn['bg-col']; ?>">
				<a href="?note-action=restore-note&note-id=<?php echo $tn['note-id']; ?>">
					<?php echo $tn['note-txt']; ?>
					<span><i class="fa fa-mail-reply"></i></span>
				</a>
			</li>
			<?php } ?>
		</ul>
	</div>
</aside>
<?php } ?>	

<?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>
