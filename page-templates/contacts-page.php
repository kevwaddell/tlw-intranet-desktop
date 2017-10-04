<?php
/*
Template Name: Contact list page
*/
?>

<?php get_header(); ?>

<?php 
global $current_user;

include (STYLESHEETPATH . '/app/inc/contact-page-vars/internal-users.inc');

//USER CONTACTS FUNCTIONS AND ARRAYS
$users_groups_raw = get_user_meta($current_user->ID, 'users_groups', true);	
$user_contacts_raw = get_user_meta($current_user->ID, 'user_contacts', true);	

if (empty($users_groups_raw)) {
$users_groups = array();
add_user_meta($current_user->ID, 'users_groups', serialize($users_groups),true);	
$users_groups_raw = get_user_meta($current_user->ID, 'users_groups', true);	
//echo '<pre class="debug">';print_r("No user contacts");echo '</pre>';	
}

if (empty($user_contacts_raw)) {
$user_contacts = array();
add_user_meta($current_user->ID, 'user_contacts', serialize($user_contacts),true);	
$user_contacts_raw = get_user_meta($current_user->ID, 'user_contacts', true);	
//echo '<pre class="debug">';print_r("No user contacts");echo '</pre>';	
}

$user_contacts = unserialize($user_contacts_raw);
array_multisort($user_contacts);
$users_groups = unserialize($users_groups_raw);

// ADD, EDIT AND DELETE - CONTACT AND GROUP FUNCTIONS
include (STYLESHEETPATH . '/app/inc/contact-page-vars/add-contact.inc');

include (STYLESHEETPATH . '/app/inc/contact-page-vars/add-group.inc');

include (STYLESHEETPATH . '/app/inc/contact-page-vars/edit-contact.inc');

include (STYLESHEETPATH . '/app/inc/contact-page-vars/edit-group.inc');

include (STYLESHEETPATH . '/app/inc/contact-page-vars/delete-contact.inc');

include (STYLESHEETPATH . '/app/inc/contact-page-vars/delete-group.inc');

if ( isset($_REQUEST['group-id']) ) {
$pr_alpha_contacts = array();
$active_contacts = array();
$group = $_REQUEST['group-id'];
	foreach ($user_contacts as $k => $uc) {
	$lastname = $uc['lname'];
	$u_group = $uc['group'];
	$current_letter = $lastname[0];
		
		if ($_REQUEST['group-id'] == $u_group) {
		$active_contacts[] = $uc;
			if (!in_array($current_letter, $pr_alpha_contacts)) {
			$pr_alpha_contacts[] = $current_letter;	
			}
		}
	}
}

$cur_user_meta = get_user_meta($current_user->ID);
?>
<article <?php post_class(); ?>>
	
	<div class="entry">
				
		<?php if ( $contact_added  || $group_added || $contact_updated || $group_updated  || $contact_deleted || $group_deleted) { ?>
			<?php  get_template_part( 'parts/contacts-page/contact', 'alerts' ); ?>
		<?php } ?>
		
		<?php if ($_GET['contact-actions'] || !empty($add_group_errors) || !empty($add_contact_errors) || !empty($edit_group_errors)) { ?>
			
			<?php if ($_GET['contact-actions'] == "add-group" || !empty($add_group_errors)) { ?>
			<?php get_template_part( 'parts/contacts-page/add', 'group' ); ?>
			<?php } ?>
			
			<?php if ($_GET['contact-actions'] == "edit-group" || !empty($edit_group_errors)) { ?>
			<?php get_template_part( 'parts/contacts-page/edit', 'group' ); ?>
			<?php } ?>
			
			<?php if ($_GET['contact-actions'] == "add-contact" || !empty($add_contact_errors) ) { ?>
			<?php get_template_part( 'parts/contacts-page/add', 'contact' ); ?>
			<?php } ?>
			
		<?php } ?>
			
		<?php if ( isset($_GET['id']) ) { ?>
			<?php  get_template_part( 'parts/contacts-page/contact', 'info' ); ?>
		<?php } ?>
		
		<?php if ( isset($_REQUEST['private-id']) && !$contact_deleted) { ?>
			<?php  get_template_part( 'parts/contacts-page/private', 'info' ); ?>
		<?php } ?>
		
	</div>
	
</article>

<aside class="scrollable sb-left">
	<div class="sb-inner">
		<div class="address-books">
		  <a href="?contacts=team" class="address-group-item<?php echo($_GET['contacts'] == 'team') ? ' active':''; ?>">TLW Team</a>
		  <a href="?contacts=support" class="address-group-item<?php echo($_GET['contacts'] == 'support') ? ' active':''; ?>">TLW Support</a>
		  <a href="?contacts=admin" class="address-group-item<?php echo($_GET['contacts'] == 'admin') ? ' active':''; ?>">TLW Admin</a>
		  <?php if (count($users_groups) > 0) { ?>
		  <h3>Private contacts</h3>
		  <?php usort($users_groups, "cmp");
			  foreach ($users_groups as $ug) { ?>
			  <a href="?group-id=<?php echo $ug[0]; ?>" class="address-group-item<?php echo ($_REQUEST['group-id'] == $ug[0]) ? ' active':'' ?>"><?php echo $ug[1]; ?></a>
			  <?php } ?>
	
		  <?php } ?>
		 </div>
	</div>
	<div class="contact-actions">
		<div class="contact-actions-inner">
			<?php if ( isset($_REQUEST['group-id']) ) { ?>
			<div class="btn-group dropup pull-left">
			  <button id="contact-actions" class="btn btn-default btn-lg no-rounded dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			    <i class="fa fa-cogs fa-lg"></i>
			  </button>
			  <ul class="dropdown-menu">
			    <li><a href="?contact-actions=delete-group&group-id=<?php echo $_REQUEST['group-id']; ?>"<?php echo (isset($_REQUEST['group-id']) && empty($active_contacts)) ? '':' class="disabled"'; ?>>Delete group</a></li>
			    <li><a href="?contact-actions=edit-group&group-id=<?php echo $_REQUEST['group-id']; ?>"<?php echo (isset($_REQUEST['group-id'])) ? '':' class="disabled"'; ?>>Edit group</a></li>
				<?php if (!empty($active_contacts)) { ?>
				<li><a href="?contact-actions=edit-contact&private-id=<?php echo $_REQUEST['private-id']; ?>&group-id=<?php echo $_REQUEST['group-id']; ?>"<?php echo ( !isset($_REQUEST['private-id'])) ? ' class="disabled"':''; ?>>Edit contact</a></li>
			    <li><a href="?contact-actions=delete-contact&private-id=<?php echo $_REQUEST['private-id']; ?>&group-id=<?php echo $_REQUEST['group-id']; ?>"<?php echo ( !isset($_REQUEST['private-id']) ) ? ' class="disabled"':''; ?>>Delete contact</a></li>				
			    <?php } ?>
			  </ul>
			</div>			
			<?php } ?>
			<div class="btn-group dropup pull-right">
			  <button id="add-contact-actions" class="btn btn-default btn-lg no-rounded dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			    <i class="fa fa-plus fa-lg"></i>
			  </button>
			  <ul class="dropdown-menu">
			    <li><a href="?contact-actions=add-group" id="add-group">Add group</a></li>
				<li><a href="?contact-actions=add-contact<?php echo (isset($_REQUEST['group-id'])) ? '&group-id='.$_REQUEST['group-id']:''; ?>" id="add-contact" <?php echo ( isset($_REQUEST['group-id']) ) ? '':' class="disabled"'; ?>>Add contact</a></li>
			  </ul>
			</div>
		</div>
	</div>			
</aside>

<aside id="names-list" class="scrollable sb-right">
	<div class="sb-inner">
		
		<?php  if ( isset($_REQUEST['group-id']) && !$group_deleted) { ?>
		<?php if (count($active_contacts) == 0) { ?>
		<div class="no-name-message text-center">
			<i class="fa fa-user-circle fa-4x block sb-icon"></i>
			<a href="?contact-actions=add-contact&group-id=<?php echo sanitize_title($_REQUEST['group-id']); ?>" id="add-contact" class="btn btn-default btn-block caps"><i class="fa fa-plus-circle pull-left"></i> Add contact</a>
		</div>
		<?php } else {?>
		<div class="contact-names">
		<?php get_template_part( 'parts/contacts-page/private', 'list' ); ?>
		</div>
		<?php } ?>	
		<?php } ?>	
		
		<?php  if ( isset($_GET['contacts']) ) { ?>
		<div class="contact-names">
		<?php get_template_part( 'parts/contacts-page/contact', 'list' ); ?>
		</div>
		<?php } ?>		
		
		<?php if ( empty($_REQUEST) || $group_deleted) { ?>
		<div class="no-name-message text-center">
			<i class="fa fa-group fa-4x block"></i>
			Select a contact group
		</div>
		<?php } ?>	
	</div>
</aside>

<?php get_footer(); ?>
