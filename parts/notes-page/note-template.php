<div class="note new-note bg-<?php echo $bg_colors[rand(0, count($bg_colors) - 1)]; ?>" style="top: <?php echo  ?>; left: <?php echo  ?>">
	<?php if ($_GET['note-action'] == 'edit-note') { ?>
	<textarea class="note-txt" placeholder="Enter your note"></textarea>
	<?php } else { ?>
	<div class="note-txt"><?php echo ; ?></div>
	<?php } ?>
	<div class="note-actions">
		<a href="?note-action=edit-note?note-id=<?php echo ; ?>" class="edit-note-btn note-btn"><i class="fa fa-edit fa-lg"></i><span class="sr-only">Edit note</span></a>
		<a href="?note-action=delete-note?note-id=<?php echo ; ?>" class="edit-note-btn note-btn"><i class="fa fa-trash fa-lg"></i><span class="sr-only">Delete note</span></a>
	</div>
</div>