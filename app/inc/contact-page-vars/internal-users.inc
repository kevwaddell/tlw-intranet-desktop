<?php 
//INTERNAL USER CONTACT LIST FUNCTIONS AND ARRAYS
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
	$uc_alpha_contacts = array();
	foreach ($all_users as $u) {
	$lastname = get_user_meta($u->ID, 'last_name', true);
	$current_letter = $lastname[0];
		if (!in_array($current_letter, $uc_alpha_contacts)) {
		$uc_alpha_contacts[] = $current_letter;	
		}
	}
}
?>