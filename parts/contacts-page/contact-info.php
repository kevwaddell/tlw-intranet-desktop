<?php
global $active_contact;
?>
<?php if (isset($_GET['id'])) { ?>
<?php 
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
			<th width="20%"><div class="profile-img" style="background-image: url(<?php echo $profile_img[0]; ?>)"></div></th>
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
		<?php if (!empty($ac_linkedIn)) { ?>
		<tr>
			<td class="bold text-right"><i class="fa fa-linkedin-square fa-lg col-linkedIn"></i></td>
			<td><a href="<?php echo $ac_linkedIn; ?>" target="_blank"><?php echo str_replace('https://', '', $ac_linkedIn); ?></a></td>
		</tr>			
		<?php } ?>
	</tbody>
</table>			
<?php } ?>
<?php if ( isset($_GET['private-id']) ) { ?>
			
<?php if (!$contact_deleted) { ?>
<?php 
$id = $active_contact['id'];
$ac_group = $active_contact['group'];
$ac_firstname = $active_contact['fname'];
$ac_lastname = $active_contact['lname'];
$ac_email = $active_contact['email'];	
$ac_company = $active_contact['company'];
$ac_tel = $active_contact['tel'];
$ac_mobile = $active_contact['mobile'];
?>
<table class="table table-striped">
	<?php if ($_GET['contact-actions'] == 'edit-contact') { ?>
		<form action="<?php the_permalink(); ?>" method="get">		
	<?php } ?>
	<thead>
		<tr>
			<th width="20%"><i class="fa fa-user-circle fa-5x pull-right"></i></th>
			<th>
				<?php if ($_GET['contact-actions'] == 'edit-contact') { ?>
				<input type="text" class="input-name" name="fname" value="<?php echo $ac_firstname; ?>"><br>
				<input type="text" class="input-name" name="lname" value="<?php echo $ac_lastname; ?>">
				<?php } else { ?>
				<h1><?php echo $ac_firstname; ?><br><?php echo $ac_lastname; ?></h1>
				<?php } ?>
				
			</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="bold text-right" width="20%">Email</td>
			<td>
				<?php if ($_GET['contact-actions'] == 'edit-contact') { ?>
				<input type="email" name="email" class="form-control" value="<?php echo $ac_email; ?>">
				<?php } else { ?>
				<a href="mailto:<?php echo $ac_email; ?>"><?php echo $ac_email; ?></a>
				<?php } ?>
			</td>
		</tr>
		<tr>
			<td class="bold text-right">Company</td>
			<td>
				<?php if ($_GET['contact-actions'] == 'edit-contact') { ?>
				<input type="text" class="form-control" name="company" value="<?php echo $ac_company; ?>">
				<?php } else { ?>
				<?php echo $ac_company; ?>
				<?php } ?>
			</td>
		</tr>
		<tr>
			<td class="bold text-right">Tel</td>
			<td>
				<?php if ($_GET['contact-actions'] == 'edit-contact') { ?>
				<input type="text" class="form-control" placeholder="(000) 000 000 000" name="tel" value="<?php echo $ac_tel; ?>">
				<?php } else { ?>
				<?php echo $ac_tel; ?>
				<?php } ?>
			</td>
		</tr>
		<tr>
			<td class="bold text-right">Mobile</td>
			<td>
				<?php if ($_GET['contact-actions'] == 'edit-contact') { ?>
				<input type="text" class="form-control" placeholder="077 789 678 77" name="mobile" value="<?php echo $ac_mobile; ?>">
				<?php } else { ?>
				<?php echo $ac_mobile; ?>
				<?php } ?>
			</td>
		</tr>
		<tr>
			<td></td>
			<td>
				<?php if ($_GET['contact-actions'] == 'edit-contact') { ?>
				<input type="hidden" name="private" value="<?php echo $ac_group; ?>">
				<input type="hidden" name="private-id" value="<?php echo $id; ?>">
				<button type="submit" class="btn btn-default caps" name="edit-contact" value="update-contact"><i class="fa fa-save"></i> Save</button>
				<a href="<?php the_permalink(); ?><?php echo (isset($_GET['private'])) ? '?private='.$_GET['private']:''; ?>&private-id=<?php echo $id; ?>" class="btn btn-danger btn-lg">Cancel <i class="fa fa-times"></i></a>
				<?php } else { ?>
				<a href="?contact-actions=edit-contact&private-id=<?php echo $id; ?>&private=<?php echo $ac_group; ?>" class="btn btn-default caps"><i class="fa fa-edit"></i> Edit</a>
				<a href="?contact-actions=delete-contact&private-id=<?php echo $id; ?>&private=<?php echo $ac_group; ?>" class="btn btn-default caps"><i class="fa fa-trash"></i> Delete</a>
				<?php } ?>
			</td>
		</tr>
	</tbody>
</table>		
	<?php if ($_GET['contact-actions'] == 'edit-contact') { ?>
		</form>		
	<?php } ?>			
<?php } ?>	
<?php } ?>
