<?php
/*
Template Name: Notes page
*/
?>

<?php get_header(); ?>
<?php 
global $current_user;
$user_notes_raw = get_user_meta($current_user->ID, 'user_notes', true);

if (empty($users_groups_raw)) {
$user_notes = array();
add_user_meta($current_user->ID, 'user_notes', serialize($user_notes),true);	
$user_notes_raw = get_user_meta($current_user->ID, 'user_notes', true);	
}

$user_notes = unserialize($user_notes_raw);
$user_notes_test = array(
	array('note-id'=>'234', 'note-txt'=>'This is note 1', 'y' => '200', 'x'=> '500', 'bg-col' => 'blue'),
	array('note-id'=>'567', 'note-txt'=>'This is note 2', 'y' => '100', 'x'=> '100' ,'bg-col' => 'purple'),
	array('note-id'=>'876', 'note-txt'=>'This is note 3', 'y' => '300', 'x'=> '900' ,'bg-col' => 'green')
);
$bg_colors = array('yellow','purple','green','pink','orange','blue');
//echo '<pre>';print_r($bg_colors);echo '</pre>';

?>
<?php if (!empty($_POST)) { 
$user_notes_test[0]['p-left'] = $_POST['p-left']['234'] ;
$user_notes_test[0]['p-top'] = 	$_POST['p-top']['234'];
?>
<?php 
echo '<pre class="debug">';
print_r($_POST['p-left']);
print_r("<br>----------------------<br>");
print_r($_POST['p-top']);
echo '</pre>';
?>			
<?php } ?>
<?php if ( have_posts() ): while ( have_posts() ) : the_post(); ?>	
<div id="notes-canvas">
	<form action="<?php the_permalink(); ?>" method="post"> 
		<?php if (!empty($user_notes_test)) { ?>
			<?php foreach ($user_notes_test as $note) { ?>
			<div id="note-<?php echo $note['note-id']; ?>" data-note="<?php echo $note['note-id']; ?>" class="note draggable bg-<?php echo $note['bg-col']; ?><?php echo ($_GET['note-action'] == 'edit-note' && $_GET['note-id'] == $note['note-id']) ? ' edit-note':'' ?>" data-x="<?php echo $note['x']; ?>" data-y="<?php echo $note['y']; ?>" style="transform: translate(<?php echo $note['x']; ?>px, <?php echo $note['y']; ?>px)">
				<?php if ($_GET['note-action'] == 'edit-note' && $_GET['note-id'] == $note['note-id']) { ?>
				<textarea class="note-txt" name="note-text[<?php echo $note['note-id']; ?>]" placeholder="Enter your note"<?php echo ($_GET['note-action'] == 'edit-note' && $_GET['note-id'] == $note['note-id']) ? ' autofocus':'' ?>><?php echo $note['note-txt']; ?></textarea>
				<?php } else { ?>
				<div class="note-txt"><?php echo $note['note-txt']; ?></div>
				<input type="hidden" name="note-txt[<?php echo $note['note-id']; ?>]" value="<?php echo $note['note-txt']; ?>">
				<?php } ?>
				<input type="hidden" name="note-id[<?php echo $note['note-id']; ?>]" value="<?php echo $note['note-id']; ?>">
				<input type="hidden" name="p-top[<?php echo $note['note-id']; ?>]" value="<?php echo $note['p-top']; ?>">
				<input type="hidden" name="p-left[<?php echo $note['note-id']; ?>]" value="<?php echo $note['p-left']; ?>">
				<input type="hidden" name="bg-col[<?php echo $note['note-id']; ?>]" value="<?php echo $note['bg-col']; ?>">
				<div class="note-actions">
					<?php if (!isset($_GET['note-action']) || $_GET['note-id'] != $note['note-id']) { ?>
					<a href="?note-action=edit-note&note-id=<?php echo $note['note-id']; ?>" class="btn btn-default note-btn"><i class="fa fa-edit fa-lg"></i><span class="sr-only">Edit note</span></a>
					<a href="?note-action=delete-note&note-id=<?php echo $note['note-id']; ?>" class="btn btn-default note-btn"><i class="fa fa-trash fa-lg"></i><span class="sr-only">Delete note</span></a>
					<?php } ?>
					<?php if ($_GET['note-action'] == 'edit-note' && $_GET['note-id'] == $note['note-id']) { ?>
					<button type="button" class="btn btn-default note-btn"><i class="fa fa-save fa-lg"></i><span class="sr-only">Save note</span></button>			
					<?php } ?>
					<button type="button" class="btn btn-default note-btn move-btn"><i class="fa fa-arrows fa-lg"></i><span class="sr-only">Move note</span></button>
				</div>
			</div>
			<?php } ?>		
		<?php } ?>
		<div class="note-canvas-actions">
			<button type="button" id="add-note" class="btn btn-default"><i class="fa fa-plus fa-2x"></i><span class="sr-only">Add note</span></button>	
			<button type="submit" id="save-note" class="btn btn-default"><i class="fa fa-save fa-2x"></i><span class="sr-only">Save note</span></button>	
		</div>	
	</form>
</div>	
<?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>
