<?php
/*
Template Name: Contact list page
*/
?>

<?php get_header(); ?>

<?php 
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

if (!isset($_GET['contacts']) || $_GET['contacts'] == 'team') {
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
$active_contact = $all_users[0];
if (isset($_GET['id'])) {
$active_contact = get_userdata( $_GET['id'] );
}
$ac_all_meta = get_user_meta($active_contact->ID);
//echo '<pre class="debug">';print_r($ac_all_meta);echo '</pre>';

$ac_firstname = get_user_meta($active_contact->ID, 'first_name', true);
$ac_lastname = get_user_meta($active_contact->ID, 'last_name', true);
$ac_email = $active_contact->user_email;
$ac_job_title = get_user_meta($active_contact->ID, 'job_title', true);
$ac_department = get_user_meta($active_contact->ID, 'department', true);
$ac_extension = get_user_meta($active_contact->ID, 'extension', true);
$avatar_args = array(
	'size'	=> 200
);
$avatar = get_avatar_data($active_contact->ID, $avatar_args);
?>
<?php //echo '<pre class="debug">';print_r($avatar);echo '</pre>'; ?>
<article <?php post_class(); ?>>
	
	<div class="entry">
		
		<table class="table table-striped">
			<thead>
				<tr>
					<th width="20%"><figure class="profile-img" style="background: url(<?php echo $avatar[url]; ?>)"></figure></th>
					<th><h1><?php echo $ac_firstname; ?> <?php echo $ac_lastname; ?></h1></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="bold text-right" width="20%">Email</td>
					<td><a href="mailto:<?php echo $ac_email; ?>"><?php echo $ac_email; ?></a></td>
				</tr>
				<tr>
					<td class="bold text-right">Job title</td>
					<td><?php echo $ac_job_title; ?></td>
				</tr>
				<tr>
					<td class="bold text-right">Department</td>
					<td>
						<?php echo $ac_department; ?>
					</td>
				</tr>
				<tr>
					<td class="bold text-right">Extension</td>
					<td><?php echo $ac_extension; ?></td>
				</tr>
			</tbody>
		</table>

	</div>
	
</article>

<aside class="scrollable sb-left">
	<div class="address-books">
	  <a href="?contacts=team" class="address-group-item active">TLW Team</a>
	  <a href="?contacts=support" class="address-group-item">TLW Support</a>
	  <a href="?contacts=admin" class="address-group-item">TLW Admin</a>
	</div>
</aside>

<aside id="names-list" class="scrollable sb-right">
	<div class="contact-names">
		<?php get_template_part( 'parts/users-page/users', 'list' ); ?>	
	</div>
</aside>


<?php get_footer(); ?>
