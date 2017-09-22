<table class="user-list-table">
	
	<tbody>
		<?php foreach ($query->results as $user) { 
		$department_ids = get_the_author_meta( "department", $user->ID );
		$dep_ids_counter = 0;

		
		$job_title = get_the_author_meta( "job_title", $user->ID );
		$ext = get_the_author_meta( "extension", $user->ID );
		$user_counter++;
		//echo '<pre>';print_r($user);echo '</pre>';
		?>
		<tr class="entry-tr">
			<td>
				<table width="100%" border="1" cellspacing="0" cellpadding="0" class="table table-bordered">
				  <tbody>
					 <?php if ($user->ID == $emp_otm_user['ID']) { ?>
					  <tr>
						  <td colspan="7" class="eotm-tag">
							  <i class="fa fa-trophy pull-left"></i> Employee of the Month <i class="fa fa-trophy pull-right"></i>
						  </td>
					  </tr>
					<?php } ?>
				    <tr>
				    	<td width="90" align="center" rowspan="3" class="user-avatar">
					      <?php echo get_avatar( $user->ID, 80 ); ?>
						</td>
						<td width="30" align="center" height="30" class="icon">
					      <i class="fa fa-user"></i>
				    	</td>
						<td width="250" class="txt" align="center">
					      <?php echo get_the_author_meta('display_name', $user->ID);?>
						</td>
				      <td width="30" align="center" class="icon"><i class="fa fa-envelope"></i></td>
				      <td class="txt email-link" colspan="3" align="center"><a href="mailto:<?php echo get_the_author_meta('user_email', $user->ID);?>" title="Email "><?php echo get_the_author_meta('user_email', $user->ID);?></a></td>
				    </tr>
				    <tr>
				      <td height="30" align="center" class="icon"><i class="fa fa-cubes"></i></td>
				      <td class="txt" align="center">
					  <?php if (!empty($department_ids) ) { ?>
									
									<?php foreach ($department_ids as $dep_id) { 
									$dep_ids_counter++;	
									$dep = get_post($dep_id);
									?>
									
									<?php echo $dep->post_title; ?>
									
									<?php } ?>
		
					<?php } ?>
					</td>
				    <td align="center" class="icon" align="center">
					    <i class="fa fa-cube"></i>
					</td>
				    <td class="txt" align="center">
					     <?php if ($job_title) { ?>
							<?php echo $job_title;?>
						<?php } ?>
					</td>
					 <td width="30" align="center" class="icon">
					    <i class="fa fa-phone"></i>
					</td>
				    <td class="txt ext-num" width="50" align="center">
					     <?php if ($ext) { ?>
							<?php echo $ext;?>
						<?php } ?>
					</td>
				    </tr>
				    <tr>
				    <td height="30" align="center" colspan="6" class="view-link">
					    <a href="<?php echo get_author_posts_url($user->ID);?>" title="View Profile" class="btn"><i class="fa fa-eye fa-lg"></i>View Profile</a>
					</td>
				    </tr>
				  </tbody>
				</table>
			 </td>
		</tr>
		<?php } ?>
		
	</tbody>
	
</table>
