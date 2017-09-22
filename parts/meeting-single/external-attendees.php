<?php if ($total_ext > 0) { ?>

<div class="data-list-wrap">

	<table class="data-list-table">
	
		<thead class="data-list-header">
			<tr>
				<?php if (is_user_logged_in() && ($post->post_author == $current_user_ID || current_user_can("administrator") ) ) { ?>
				<th class="settings"><i class="fa fa-cogs fa-lg"></i></th>
				<?php } ?>
				<th class="marker"><i class="fa fa-info-circle fa-lg"></i></th>
				<th class="attendee">External attendeess</th>
			</tr>
		</thead>
	
		<tbody>
			<?php foreach ($client_attendees as $key => $client_attendee) { 
			//echo '<pre>';print_r($staff_attendee['attendee_staff']['ID']);echo '</pre>';
			?>
			<tr class="entry-tr">
				<td colspan="<?php echo (is_user_logged_in() && ($post->post_author == $current_user_ID || current_user_can("administrator") )) ? "3":"2"; ?>">
				
					<table class="table table-bordered">
						<tbody>
						
							<tr id="external_attendee_<?php echo $key; ?>" class="info-tr">
								<?php if (is_user_logged_in() && ($post->post_author == $current_user_ID || current_user_can("administrator") ) ) { ?>
								<td class="settings">
									<a href="#" id="view-btn-<?php echo $key; ?>"class="btn btn-default settings"><i class="fa fa-cogs"></i></a>
								</td>
								<?php } ?>
								<td class="marker accepted">
									<i class="fa fa-square"></i>
								</td>
	
								<td class="attendee"><?php echo $client_attendee['attendee_client']; ?></td>			
							</tr>
							
							<?php if (is_user_logged_in() && ($post->post_author == $current_user_ID || current_user_can("administrator") ) ) { ?>
									
							<tr class="actions-tr actions-tr-closed" id="external-actions-tr-<?php echo $key; ?>">
								<td colspan="3">
									<a href="<?php the_permalink(); ?>?action=remove_attendee&external_key=<?php echo $key; ?>" class="btn btn-default delete action-btn"><i class="fa fa-trash-o fa-lg"></i> Delete</a>
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