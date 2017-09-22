<?php if ($total_int > 0) { 
//echo '<pre>';print_r($staff_attendees);echo '</pre>';
?>
				
<div class="data-list-wrap"<?php echo ($total_ext > 0) ? ' style="margin-bottom: 20px;"':''; ?>>

	<table class="data-list-table">
	
		<thead class="data-list-header">
			<tr>
				<?php if (is_user_logged_in()) { ?>
				<th class="settings"><i class="fa fa-cogs fa-lg"></i></th>
				<?php } ?>
				<th class="marker"><i class="fa fa-info-circle fa-lg"></i></th>
				<th class="attendee">Internal attendees</th>
				<th class="email">Email address</th>
			</tr>
		</thead>
	
		<tbody>
			<?php foreach ($staff_attendees as $key => $staff_attendee) { 
			//echo '<pre>';print_r($staff_attendee['attendee_staff']['ID']);echo '</pre>';
			$avatar = get_avatar( $staff_attendee['attendee_staff']['ID'], 50 );	
			?>
			<tr class="entry-tr">
				<td colspan="<?php echo (is_user_logged_in()) ? "4":"3"; ?>">
					<table class="table table-bordered">
						<tbody>
							<tr id="internal_attendee_<?php echo $key; ?>" class="info-tr">
								<?php if (is_user_logged_in()) { ?>
								<td class="settings">
									<?php if ( current_user_can("administrator") || $post->post_author == $current_user_ID || $staff_attendee['attendee_staff']['ID'] == $current_user_ID) { ?>
									<a href="#" id="view-btn-<?php echo $key; ?>"class="btn btn-default settings"><i class="fa fa-cogs"></i></a>
									<?php } ?>
								</td>
								<?php } ?>
								<td class="marker <?php echo $staff_attendee['status'];?>">
									<i class="fa fa-square"></i>
								</td>
								<td class="attendee">
									<table class="table">
										<tbody>
											<tr>
												<td class="avatar">
													<?php echo $avatar; ?> 
												</td>
												<td>
													<?php echo $staff_attendee['attendee_staff']['display_name']; ?>
												</td>
											</tr>
										</tbody>
									</table>
								</td>
								<td class="email"><a href="mailto:<?php echo $staff_attendee['attendee_staff']['user_email']; ?>" title="Email <?php echo $staff_attendee['attendee_staff']['user_firstname']; ?>"><?php echo $staff_attendee['attendee_staff']['user_email']; ?></a></td>
								
							</tr>
							
							<?php if (is_user_logged_in()) { ?>
								
								<tr class="actions-tr actions-tr-closed" id="internal-actions-tr-<?php echo $key; ?>">
									<td colspan="4">
										
										<?php if ( current_user_can("administrator") || $post->post_author == $current_user_ID) { ?>
										
										<?php if ( $start_time > $now && $staff_attendee['status'] == "pending" ) { ?>
										<a href="?action=notify_attendee&user_key=<?php echo $key; ?>&user=<?php echo $staff_attendee['attendee_staff']['ID']; ?>" class="btn btn-default notify action-btn"><i class="fa fa-bullhorn"></i> Notify staff member</a>
										<?php } ?>
										
										<a href="?action=remove_attendee&user_key=<?php echo $key; ?>&user=<?php echo $staff_attendee['attendee_staff']['ID']; ?>" class="btn btn-default delete action-btn"><i class="fa fa-trash-o"></i> Delete</a>
										
										<?php } ?>
										
										<?php if ( $current_user_ID == $staff_attendee['attendee_staff']['ID'] && ( $staff_attendee['status'] == "pending" || $staff_attendee['status'] == "rejected") ) { ?>	
										<a href="?action=attendee_accept&user_key=<?php echo $key; ?>&user=<?php echo $staff_attendee['attendee_staff']['ID']; ?>" class="btn btn-default accept action-btn"><i class="fa fa-thumbs-o-up"></i> Accept invite</a>
										<?php } ?>
										
										<?php if ( $current_user_ID == $staff_attendee['attendee_staff']['ID'] && ( $staff_attendee['status'] == "accepted" || $staff_attendee['status'] == "pending") ) { ?>	
										<a href="?action=attendee_reject&user_key=<?php echo $key; ?>&user=<?php echo $staff_attendee['attendee_staff']['ID']; ?>" class="btn btn-default reject action-btn"><i class="fa fa-thumbs-o-down"></i> Reject invite</a>
										<?php } ?>
										
										
										<a href="<?php echo get_author_posts_url($staff_attendee['attendee_staff']['ID']);?>" class="btn btn-default"><i class="fa fa-user"></i> View profile</a>
									</td>
								</tr>
								
							<?php } ?>

						</tbody>
					</table>
				 </td>
			</tr>
			<?php } ?>
			
		</tbody>
	
	</table>

</div>

<?php }  ?>
