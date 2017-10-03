<?php if (!$contact_deleted) { ?>
<?php 
global $active_contacts;
$active_contact = $active_contacts[ getArraykey( $_REQUEST['private-id'] , $active_contacts) ];
//echo '<pre>';print_r($active_contact);echo '</pre>';
$ac_id = $active_contact['id'];
$ac_group = $active_contact['group'];
$ac_fname = $active_contact['fname'];
$ac_lname = $active_contact['lname'];
$ac_email = $active_contact['email'];	
$ac_company = $active_contact['company'];
$ac_tel = $active_contact['tel'];
$ac_mobile = $active_contact['mobile'];
?>
<table class="table table-striped">
	<?php if ($_GET['contact-actions'] == 'edit-contact') { ?>
		<form action="<?php the_permalink(); ?>" method="post">		
	<?php } ?>
	<thead>
		<tr>
			<th width="170" class="text-right"><i class="private-icon fa fa-user-circle"></i></th>
			<th>
				<?php if ($_GET['contact-actions'] == 'edit-contact') { ?>
				<input type="text" class="input-name" name="fname" value="<?php echo $ac_fname; ?>"><br>
				<input type="text" class="input-name" name="lname" value="<?php echo $ac_lname; ?>">
				<?php } else { ?>
				<h1><?php echo $ac_fname; ?><br><?php echo $ac_lname; ?></h1>
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
				<input type="hidden" name="group-id" value="<?php echo $ac_group; ?>">
				<input type="hidden" name="private-id" value="<?php echo $ac_id; ?>">
				<button type="submit" class="btn btn-default caps" name="edit-contact"><i class="fa fa-save"></i> Save</button>
				<a href="<?php the_permalink(); ?><?php echo (isset($_GET['group-id'])) ? '?group-id='.$_GET['group-id']:''; ?>&private-id=<?php echo $ac_id; ?>" class="btn btn-default caps">Cancel <i class="fa fa-times"></i></a>
				<?php } else { ?>
				<a href="?contact-actions=edit-contact&private-id=<?php echo $ac_id; ?>&group-id=<?php echo $ac_group; ?>" class="btn btn-default caps"><i class="fa fa-edit"></i> Edit</a>
				<a href="?contact-actions=delete-contact&private-id=<?php echo $ac_id; ?>&group-id=<?php echo $ac_group; ?>" class="btn btn-default caps"><i class="fa fa-trash"></i> Delete</a>
				<?php } ?>
			</td>
		</tr>
	</tbody>
</table>		
	<?php if ($_GET['contact-actions'] == 'edit-contact') { ?>
		</form>		
	<?php } ?>			
<?php } ?>