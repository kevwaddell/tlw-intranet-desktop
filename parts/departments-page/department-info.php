<?php 
global $active_department;

if ( isset($_GET['id']) ) {
$active_department = get_page($_GET['id']);	
} 
$contacts_pg = get_page_by_path( 'contacts' );
$user_args = array(
	'meta_key' => 'department',
	'meta_value' => $active_department->ID,
	'orderby'	=> 'display_name',
	'exclude'	=> array(60)
);
$dep_members = get_users( $user_args );

//$dep_members = get_field('team', $active_department->ID);
//$first_member_data = get_userdata( $dep_members[0]['team_member']['ID'] );	
//echo '<pre>';print_r($members);echo '</pre>';
?>

<?php if (!empty($dep_members)) { ?>
<div id="team-grid">
	<?php foreach ($dep_members as $member) { 
	$id = $member->ID;
	$member_data = get_userdata( $id );	
	$profile_img_id = get_user_meta($id, 'profile_img', true);
	$profile_img = wp_get_attachment_image_src($profile_img_id, 'img-3-col-crop' );
	$fname = get_user_meta($id, 'first_name', true);
	$lname = get_user_meta($id, 'last_name', true);
	$email = $member->user_email;
	$job_title = get_user_meta($id, 'job_title', true);
	$extension = get_user_meta($id, 'extension', true);
	$linkedIn = $member->user_url;
	?>
	<div class="member-profile">
		<div class="profile-img" style="background-image: url(<?php echo $profile_img[0]; ?>)"></div>
		<div class="profile-info">
			<div class="name"><a href="<?php echo get_permalink($contacts_pg->ID); ?>?id=<?php echo $id; ?>&contacts=team"><?php echo $fname; ?> <?php echo $lname; ?></a></div>
			<div class="job-title">Role: <strong><?php echo $job_title; ?></strong></div>
			<div class="ext">Ext: <strong><?php echo $extension; ?></strong></div>
			<?php if (!empty($linkedIn)) { ?>
			<a href="<?php echo $linkedIn; ?>" target="_blank" class="social-link"><i class="fa fa-linkedin-square fa-2x"></i></a>
			<?php } ?>
		</div>
		<a href="mailto:<?php echo $email; ?>" class="btn btn-default btn-block">Email <?php echo $fname; ?><i class="fa fa-paper-plane fa-lg"></i></a>
	</div>
	<?php } ?>
</div>
<?php } ?>
