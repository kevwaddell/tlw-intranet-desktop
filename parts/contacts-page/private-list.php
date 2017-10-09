<?php 
global $pr_alpha_contacts;
global $active_contacts;	
sort($pr_alpha_contacts);
?>

<?php foreach ($pr_alpha_contacts as $alpha) { ?>

<div id="letter-<?php echo $alpha; ?>" class="contact-list-group">
	
	<div class="list-label"><?php echo $alpha; ?></div>

<?php foreach ($active_contacts as $k => $uc) { ?>
	<?php
	$id =  $uc['id'];
	$group = $uc['group'];
	$firstname = $uc['fname'];
	$lastname =  $uc['lname'];
	$first_letter = $lastname[0];
	?>
	<?php if ($first_letter == $alpha) { ?>
	<div id="contact-id-<?php echo $id ; ?>" class="list-item<?php echo ($_REQUEST['private-id'] == $id) ? ' active': ''; ?>">
		<a href="?private-id=<?php echo $id ; ?>&group-id=<?php echo $group; ?>"><?php echo $firstname; ?> <strong><?php echo $lastname; ?></strong></a>
	</div>
	<?php } ?>
	
<?php } // Foreach user contact ?>
</div>

<?php } //Foreach Alpha ?>