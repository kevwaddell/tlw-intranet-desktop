<?php 
global $all_users;
global $uc_alpha_contacts;
sort($uc_alpha_contacts);
?>

<?php if ( isset($_GET['contacts']) ) { ?>
<?php foreach ($uc_alpha_contacts as $alpha) { ?>
<div id="letter-<?php echo $alpha; ?>" class="contact-list-group">
	<div class="letter-label"><?php echo $alpha; ?></div>
	<?php foreach ($all_users as $k => $user) {
	$firstname = get_user_meta($user->ID, 'first_name', true);
	$lastname = get_user_meta($user->ID, 'last_name', true);
	$first_letter = $lastname[0];
	?>
	<?php if ($first_letter == $alpha) { ?>
	<div id="contact-id-<?php echo $user->ID; ?>" data-contact-id="<?php echo $user->ID; ?>" class="contact-list-item<?php echo($user->ID == $_GET['id']) ? ' contact-active':''; ?>">
		<a href="?id=<?php echo $user->ID; ?>&contacts=<?php echo $_GET['contacts'] ?>"><?php echo $firstname; ?> <strong><?php echo $lastname; ?></strong></a>
	</div>
	<?php } ?>
	
	<?php } ?>
</div>
<?php } ?>

<?php } ?>


