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
	array('note-id'=>'234', 'note-txt'=>'This is note 1', 'p-top' => '20', 'p-left'=> '10', 'bg-col' => 'blue'),
	array('note-id'=>'567', 'note-txt'=>'This is note 2', 'p-top' => '30', 'p-left'=> '70' ,'bg-col' => 'purple'),
	array('note-id'=>'876', 'note-txt'=>'This is note 3', 'p-top' => '60', 'p-left'=> '30' ,'bg-col' => 'green')
);
$bg_colors = array('yellow','purple','green','pink','orange','blue');
//echo '<pre>';print_r($bg_colors);echo '</pre>';

?>
<?php if (!empty($_POST)) { 
$user_notes_test[0]['p-left'] = $_POST['p-left'] ;
$user_notes_test[0]['p-top'] = 	$_POST['p-top'];
?>
<?php 
echo '<pre class="debug">';
print_r($_POST);
echo '</pre>';
?>			
<?php } ?>
<?php if ( have_posts() ): while ( have_posts() ) : the_post(); ?>	
<div id="notes-canvas">
	<form action="<?php the_permalink(); ?>" method="post"> 
		<?php if (!empty($user_notes_test)) { ?>
			<?php foreach ($user_notes_test as $note) { ?>
			<div id="note-<?php echo $note['note-id']; ?>" class="note bg-<?php echo $note['bg-col']; ?><?php echo ($_GET['note-action'] == 'edit-note' && $_GET['note-id'] == $note['note-id']) ? ' edit-note':'' ?>" style="top: <?php echo $note['p-top'];  ?>%; left: <?php echo $note['p-left']  ?>%" draggable="<?php echo (!isset($_GET['note-action']) || $_GET['note-id'] != $note['note-id']) ? 'true':'false'; ?>">
				<?php if ($_GET['note-action'] == 'edit-note' && $_GET['note-id'] == $note['note-id']) { ?>
				<textarea class="note-txt" name="note-text" placeholder="Enter your note"<?php echo ($_GET['note-action'] == 'edit-note' && $_GET['note-id'] == $note['note-id']) ? ' autofocus':'' ?>><?php echo $note['note-txt']; ?></textarea>
				<?php } else { ?>
				<div class="note-txt"><?php echo $note['note-txt']; ?></div>
				<input type="hidden" name="note-txt" value="<?php echo $note['note-txt']; ?>">
				<?php } ?>
				<input type="hidden" name="note-id" value="<?php echo $note['note-id']; ?>">
				<input type="hidden" name="p-top" value="<?php echo $note['p-top']; ?>">
				<input type="hidden" name="p-left" value="<?php echo $note['p-left']; ?>">
				<input type="hidden" name="bg-col" value="<?php echo $note['bg-col']; ?>">
				<div class="note-actions">
					<?php if (!isset($_GET['note-action']) || $_GET['note-id'] != $note['note-id']) { ?>
					<a href="?note-action=edit-note&note-id=<?php echo $note['note-id']; ?>" class="btn btn-default note-btn"><i class="fa fa-edit fa-lg"></i><span class="sr-only">Edit note</span></a>
					<a href="?note-action=delete-note&note-id=<?php echo $note['note-id']; ?>" class="btn btn-default note-btn"><i class="fa fa-trash fa-lg"></i><span class="sr-only">Delete note</span></a>
					<?php } ?>
					<?php if ($_GET['note-action'] == 'edit-note' && $_GET['note-id'] == $note['note-id']) { ?>
					<button type="submit" class="btn btn-default note-btn"><i class="fa fa-save fa-lg"></i><span class="sr-only">Save note</span></button>			
					<?php } ?>
				</div>
			</div>
			<?php } ?>		
		<?php } ?>
		<div class="note-canvas-actions">
			<button type="button" id="add-note" class="btn btn-default"><i class="fa fa-plus fa-2x"></i><span class="sr-only">Add note</span></button>	
		</div>	
	</form>
</div>	
<?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>
