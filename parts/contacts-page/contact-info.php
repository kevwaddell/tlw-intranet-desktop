<?php 
$active_contact = get_userdata( $_GET['id'] );
$ac_firstname = get_user_meta($active_contact->ID, 'first_name', true);
$ac_lastname = get_user_meta($active_contact->ID, 'last_name', true);
$ac_email = $active_contact->user_email;
$ac_linkedIn = $active_contact->user_url;
$ac_job_title = get_user_meta($active_contact->ID, 'job_title', true);
$ac_department = get_user_meta($active_contact->ID, 'department', true);
$ac_extension = get_user_meta($active_contact->ID, 'extension', true);
$profile_img_id = get_user_meta($active_contact->ID, 'profile_img', true);
$profile_img = wp_get_attachment_image_src($profile_img_id, 'img-3-col-crop' );
//echo '<pre>';print_r($profile_img);echo '</pre>';
?>
<table class="table table-striped">
	<thead>
		<tr>
			<th width="170" class="text-right"><div class="profile-img" style="background-image: url(<?php echo $profile_img[0]; ?>)"></div></th>
			<th><h1><?php echo $ac_firstname; ?><br><?php echo $ac_lastname; ?></h1></th>
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
				<?php echo get_the_title($ac_department); ?>
			</td>
		</tr>
		<tr>
			<td class="bold text-right">Extension</td>
			<td><?php echo $ac_extension; ?></td>
		</tr>
		<?php if (!empty($ac_linkedIn)) { ?>
		<tr>
			<td class="bold text-right"><i class="fa fa-linkedin-square fa-lg col-linkedIn"></i></td>
			<td><a href="<?php echo $ac_linkedIn; ?>" target="_blank"><?php echo str_replace('https://', '', $ac_linkedIn); ?></a></td>
		</tr>			
		<?php } ?>
	</tbody>
</table>