<?php
/*
Template Name: Contact list page
*/
?>

<?php get_header(); ?>

<?php 
global $current_user;

//USER CONTACTS FUNCTIONS AND ARRAYS
$add_group_errors = array();
$add_contact_errors = array();
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

//ADD PRIVATE CONTACT META
if ( isset($_GET['add-contact']) && $_GET['add-contact'] == 'new-contact') {
	//echo '<pre class="debug">';print_r($_POST);echo '</pre>';
	
	if (isset($_GET['new-private'])) {
	$group = trim($_GET['new-private']);
	$group_name = sanitize_title($group);
	}
	
	if (isset($_GET['private'])) {
	$group = $_GET['private'];
	$group_name = sanitize_title($group);
	}
	
	$fname = trim($_GET['fname']);
	$lname = trim($_GET['lname']);
	$email = trim($_GET['email']);
	$company = trim($_GET['company']);
	$tel = trim($_GET['tel']);
	$mobile = trim($_GET['mobile']);
	$id = $_GET['private-id'];
	
	//Check if required fields are empty and show error if they are
	if ( $group == '0' ) {
	$add_contact_errors['private'] = '<span class="help-block">Please choose a contact group name</span>';	
	}
	if ( isset($_GET['new-private']) && empty( trim($_GET['new-private']) ) ) {
	$add_contact_errors['new-private'] = '<span class="help-block">Please enter a contact group name</span>';	
	}
	if (empty($fname)) {
	$add_contact_errors['fname'] = '<span class="help-block">Please enter a contact first name</span>';	
	}
	
	if (empty($add_contact_errors)) {
		
		$contact_details = array(
		'id'	=> $id,
		'group' => $group_name,
		'fname' => $fname,
		'lname' => $lname,
		'email' => $email,
		'company' => $company,
		'tel'	=> $tel,
		'mobile' => $mobile
		);
		
		if (!in_array(array($group, $group_name), $users_groups)) {
		$users_groups[] = array($group, $group_name);
		$group_added = update_user_meta($current_user->ID, 'users_groups', serialize($users_groups), $users_groups_raw);	
		$users_groups_raw = get_user_meta($current_user->ID, 'users_groups', true);	
		$users_groups = unserialize($users_groups_raw);
		}
		
		if (!in_array($contact_details, $user_contacts)) {
		$user_contacts[] = $contact_details;
		$contact_id = $id;
		$contact_added = update_user_meta($current_user->ID, 'user_contacts', serialize($user_contacts), $user_contacts_raw); 
		$user_contacts_raw = get_user_meta($current_user->ID, 'user_contacts', true);
		$user_contacts = unserialize($user_contacts_raw);
		array_multisort($user_contacts);
		}
	}
}

//ADD PRIVATE CONTACT META
if ( isset($_GET['add-group']) && $_GET['add-group'] == 'new-group') {
	if (isset($_GET['new-private'])) {
	$group = trim($_GET['new-private']);
	$group_name = sanitize_title($group);
	}
	
	if ( isset($_GET['new-private']) && empty( trim($_GET['new-private']) ) ) {
	$add_group_errors['new-private'] = '<span class="help-block">Please enter a contact group name</span>';	
	}
	
	if (in_array(array($group, $group_name), $users_groups)) {
	$add_group_errors['new-private'] = '<span class="help-block">Group already exists</span>';		
	}
	
	if (empty($add_group_errors)) {
		$users_groups[] = array($group, $group_name);
		$group_added = update_user_meta($current_user->ID, 'users_groups', serialize($users_groups), $users_groups_raw);	
		$users_groups_raw = get_user_meta($current_user->ID, 'users_groups', true);	
		$users_groups = unserialize($users_groups_raw);
	}
}

//ADD EDIT CONTACT META
if ( isset($_GET['edit-contact']) && $_GET['edit-contact'] == 'update-contact' ) {
//echo '<pre class="debug">';print_r($_POST);echo '</pre>';
	
	$fname = trim($_GET['fname']);
	$lname = trim($_GET['lname']);
	$email = trim($_GET['email']);
	$company = trim($_GET['company']);
	$tel = trim($_GET['tel']);
	$mobile = trim($_GET['mobile']);
	$private = $_GET['private'];
	$private_id = $_GET['private-id'];
	
		$edit_contact_details = array(
		'id'	=> $private_id,
		'group' => $private,
		'fname' => $fname,
		'lname' => $lname,
		'email' => $email,
		'company' => $company,
		'tel'	=> $tel,
		'mobile' => $mobile
		);	
		
	foreach ($user_contacts as $k => $uc) {
		if ($uc['id'] == $_GET['private-id']) {
		$user_contacts[$k] = $edit_contact_details;
		$contact_updated = update_user_meta($current_user->ID, 'user_contacts', serialize($user_contacts), $user_contacts_raw);	
		}
	}
		
		$user_contacts_raw = get_user_meta($current_user->ID, 'user_contacts', true);
		$user_contacts = unserialize($user_contacts_raw);
		array_multisort($user_contacts);
		
}

//ADD DELETE CONTACT META
if ( isset($_GET['contact-actions']) && $_GET['contact-actions'] == 'delete-contact') {
	foreach ($user_contacts as $k => $uc) {
		if ($uc['id'] == $_GET['private-id']) {
		$fname = $uc['fname'];
		$lname = $uc['lname'];
		
		unset( $user_contacts[ $k ] );
		$contact_deleted = "Your contact <strong>$fname $lname</strong> has been deleted.";
		}	
	}
	
	$contact_deleted = update_user_meta($current_user->ID, 'user_contacts', serialize($user_contacts), $user_contacts_raw);
	$user_contacts_raw = get_user_meta($current_user->ID, 'user_contacts', true);
	$user_contacts = unserialize($user_contacts_raw);
	array_multisort($user_contacts);
	
}

//ADD DELETE CONTACT META
if ( isset($_GET['contact-actions']) && $_GET['contact-actions'] == 'delete-group') {
	
	foreach ($users_groups as $k => $ug) {
	
		if ($_GET['private'] == $ug[1]) {
		$group = $ug[0];
		unset( $users_groups[ $k ] );
		}	
	}
	
	/*
echo '<pre class="debug">';
	print_r($users_groups_raw);
	echo '</pre>';
*/
	
	$group_deleted = update_user_meta($current_user->ID, 'users_groups', serialize($users_groups), $users_groups_raw);
	$users_groups_raw = get_user_meta($current_user->ID, 'users_groups', true);	
	$users_groups = unserialize($users_groups_raw);
	
}

//CONTACT LIST FUNCTIONS AND ARRAYS
$excluded_users = array();
$support_users = array();
$office_admin = array();
$excluded_users_raw = get_field('excluded_contacts', 'options');
$support_users_raw = get_field('tlw_support', 'options');
$office_admin_raw = get_field('tlw_admin', 'options');
foreach ($excluded_users_raw as $k => $eu) { 
	$excluded_users[$k] = $eu[ID];
}
foreach ($support_users_raw as $k => $su) { 
	$support_users[$k] = $su[ID];
}
foreach ($office_admin_raw as $k => $oa) { 
	$office_admin[$k] = $oa[ID];
}

$users_args = array(
'exclude'	=> $excluded_users,
'meta_key' => 'last_name',
'orderby'	=> 'meta_value'
);

if (isset($_GET['contacts'])) {
	if ($_GET['contacts'] == 'support') {
	unset($users_args['exclude']);
	$users_args['include'] = $support_users;
	}
	if ($_GET['contacts'] == 'admin') {
	unset($users_args['exclude']);
	$users_args['include'] = $office_admin;
	}
}

$all_users = get_users($users_args);
$total_users = count($all_users);

if (isset($_GET['contacts'])) {
	$alpha_contacts = array();
	foreach ($all_users as $u) {
	$lastname = get_user_meta($u->ID, 'last_name', true);
	$current_letter = $lastname[0];
		if (!in_array($current_letter, $alpha_contacts)) {
		$alpha_contacts[] = $current_letter;	
		}
	}
}

//echo '</pre>';
//FIRST INITIAL CONTACT
if (isset($_GET['id'])) {
$active_contact = get_userdata( $_GET['id'] );
}
if (isset($_GET['private']) || isset($_GET['add-contact'])  && !$contact_deleted && !$group_deleted) {
$alpha_contacts = array();
$active_contacts = array();
	foreach ($user_contacts as $k => $uc) {
	$lastname = $uc['lname'];
	$group = $uc['group'];
	$current_letter = $lastname[0];
		if ($uc['id'] == $_GET['private-id']) {
		$active_contact = $user_contacts[$k];
		}
		if (!in_array($current_letter, $alpha_contacts)) {
		$alpha_contacts[] = $current_letter;	
		}
		if ($_GET['private'] == $group) {
		$active_contacts[] = $uc;
		}
	}
}
$cur_user_meta = get_user_meta($current_user->ID);

/*
echo '<pre class="debug">';
print_r($users_groups);
print_r("------------------------------<br>");
print_r($user_contacts);
print_r("------------------------------<br>");
print_r(count($active_contacts));
echo '</pre>';
*/
?>
<article <?php post_class(); ?>>
	
	<div class="entry">
				
		<?php if ( isset($_GET['add-contact']) || isset($_GET['add-group'])) { ?>
			<?php  get_template_part( 'parts/contacts-page/contact', 'alerts' ); ?>
		<?php } ?>
		
		<?php if ($_GET['contact-actions'] || !empty($add_group_errors) || !empty($add_contact_errors) ) { ?>
			
			<?php if ($_GET['contact-actions'] == "add-group" || !empty($add_group_errors)) { ?>
			<?php get_template_part( 'parts/contacts-page/add', 'group' ); ?>
			<?php } ?>
			
			<?php if ($_GET['contact-actions'] == "add-contact" || !empty($add_contact_errors) ) { ?>
			<?php get_template_part( 'parts/contacts-page/add', 'contact' ); ?>
			<?php } ?>
			
		<?php } ?>
			
		<?php if ( isset($_GET['id']) || isset($_GET['private-id'])) { ?>
			<?php  get_template_part( 'parts/contacts-page/contact', 'info' ); ?>
		<?php } ?>
		
	</div>
	
</article>

<aside class="scrollable sb-left">
	<div class="address-books">
	  <a href="?contacts=team" class="private address-group-item<?php echo($_GET['contacts'] == 'team') ? ' active':''; ?>">TLW Team</a>
	  <a href="?contacts=support" class="private address-group-item<?php echo($_GET['contacts'] == 'support') ? ' active':''; ?>">TLW Support</a>
	  <a href="?contacts=admin" class="private address-group-item<?php echo($_GET['contacts'] == 'admin') ? ' active':''; ?>">TLW Admin</a>
	  <?php foreach ($users_groups as $ug) { 
		  $active = "";
		  if ($_GET['private'] == $ug[1]) {
			$active = " active";  
		  }
		  if ( isset($_GET['add-contact']) && $group_name == $ug[1] ) {
			$active = " active";    
		  }
		   if ( isset($_GET['add-group']) && $$_GET['new-private'] == $ug[0] ) {
			$active = " active";    
		  }
	  ?>
	   <a href="?private=<?php echo $ug[1]; ?>" class="private address-group-item<?php echo $active; ?>"><?php echo $ug[0]; ?></a>
	  <?php } ?>
	</div>
	<div class="contact-actions">
		<div class="contact-actions-inner">
			<?php if (isset($_GET['private']) || isset($_GET['private-id'])) { ?>
			<div class="btn-group dropup pull-left">
			  <button id="contact-actions" class="btn btn-default btn-lg no-rounded dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			    <i class="fa fa-trash fa-lg"></i>
			  </button>
			  <ul class="dropdown-menu">
			    <li><a href="?contact-actions=delete-group&private=<?php echo $_GET['private']; ?>"<?php echo (isset($_GET['private']) && empty($active_contacts)) ? '':' class="disabled"'; ?>>Delete group</a></li>
			    <li><a href="?contact-actions=delete-contact&private-id=<?php echo $_GET['private-id']; ?>&private=<?php echo $_GET['private']; ?>"<?php echo ( !isset($_GET['private-id']) ) ? ' class="disabled"':''; ?>>Delete contact</a></li>
			  </ul>
			</div>			
			<?php } ?>
			<div class="btn-group dropup pull-right">
			  <button id="add-contact-actions" class="btn btn-default btn-lg no-rounded dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			    <i class="fa fa-plus fa-lg"></i>
			  </button>
			  <ul class="dropdown-menu">
			    <li><a href="?contact-actions=add-group" id="add-group">Add group</a></li>
				<li><a href="?contact-actions=add-contact<?php echo (isset($_GET['private'])) ? '&private='.$_GET['private']:''; ?>" id="add-contact">Add contact</a></li>
			  </ul>
			</div>
		</div>
	</div>			
</aside>

<aside id="names-list" class="scrollable sb-right">
	<div class="contact-names">
		<?php  
		switch (true) {
		case isset($_GET['add-contact']):
		case isset($_GET['add-group']):
		case isset($_GET['contacts']):
		case isset($_GET['private']):
		case isset($_GET['edit-contact']):
		case isset($_GET['delete-contact']) : $show_list = true;
		break;
		default: $show_list = false;
		}
		?>
		<?php if ($show_list) { ?>
		<?php get_template_part( 'parts/contacts-page/contact', 'list' ); ?>
		<?php } else { ?>
		<div class="no-name-message text-center">
			<i class="fa fa-group fa-4x block"></i>
			Select a contact group
		</div>
		<?php } ?>	
	</div>
</aside>


<?php get_footer(); ?>
