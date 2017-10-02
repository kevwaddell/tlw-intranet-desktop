<?php 
global $all_users;
global $alpha_contacts;
global $user_contacts;
global $active_contacts;
?>

<?php if (isset($_GET['private']) || isset($_GET['add-group'])) { ?>

<?php if (count($active_contacts) == 0) { ?>
<?php
	if (isset($_GET['private'])) {
	$action_par = '&private='.$_GET['private'];	
	}
	if (isset($_GET['add-group'])) {
	$action_par = '&private='.sanitize_title($_GET['new-private']);	
	}
?>
<div class="no-name-message text-center">
	<i class="fa fa-group fa-4x block sb-icon"></i>
	<a href="?contact-actions=add-contact<?php echo $action_par; ?>" id="add-contact" class="btn btn-default btn-block caps"><i class="fa fa-plus-circle pull-left"></i> Add contact</a>
</div>

<?php } else {
sort($alpha_contacts);	
?>

<?php foreach ($alpha_contacts as $alpha) { ?>
<div id="letter-<?php echo $alpha; ?>" class="contact-list-group">
	<div class="letter-label"><?php echo $alpha; ?></div>

<?php foreach ($active_contacts as $k => $uc) { ?>
	<?php
	$id =  $uc['id'];
	$group = $uc['group'];
	$firstname = $uc['fname'];
	$lastname =  $uc['lname'];
	$first_letter = $lastname[0];
	$contact_active = "";
	if ( isset($_GET['add-contact']) && $contact_id == $id) {
	$contact_active = " active-contact";	
	}
	if(isset($_GET['private-id']) && $_GET['private-id'] == $id && !$contact_deleted){
	$contact_active = " active-contact";	
	}
	//echo $k;
	?>
	<?php if ($first_letter == $alpha) { ?>
	<div id="contact-id-<?php echo $id ; ?>" class="contact-list-item<?php echo $contact_active; ?>">
		<a href="?private-id=<?php echo $id ; ?>&private=<?php echo $group; ?>"><?php echo $firstname; ?> <strong><?php echo $lastname; ?></strong></a>
	</div>
	<?php } ?>
<?php } // Foreach user contact ?>
</div>
<?php } //Foreach Alpha ?>
<?php } // if else user contacts ?>
</div>
<?php } ?>

<?php if ( isset($_GET['contacts']) ) { ?>
<?php foreach ($alpha_contacts as $alpha) { ?>
<div id="letter-<?php echo $alpha; ?>" class="contact-list-group">
	<div class="letter-label"><?php echo $alpha; ?></div>
	<?php foreach ($all_users as $k => $user) {
	$firstname = get_user_meta($user->ID, 'first_name', true);
	$lastname = get_user_meta($user->ID, 'last_name', true);
	$first_letter = $lastname[0];
	$contact_active = "";
	if ( isset($_GET['id']) && $_GET['id'] == $user->ID) {
	$contact_active = " active-contact";	
	}
	?>
	<?php if ($first_letter == $alpha) { ?>
	<div id="contact-id-<?php echo $user->ID; ?>" data-contact-id="<?php echo $user->ID; ?>" class="contact-list-item<?php echo $contact_active; ?>">
		<a href="?id=<?php echo $user->ID; ?>&contacts=<?php echo $_GET['contacts'] ?>"><?php echo $firstname; ?> <strong><?php echo $lastname; ?></strong></a>
	</div>
	<?php } ?>
	
	<?php } ?>
</div>
<?php } ?>

<?php } ?>


