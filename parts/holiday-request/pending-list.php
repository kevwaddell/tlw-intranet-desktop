<?php 
//echo '<pre>';print_r(count($your_meetings));echo '</pre>';
if ( $pending_hoidays->have_posts() ):
$pending_holidays_count = 0;
?>

<div class="page-section section-open" style="margin-bottom: 20px;">
	
	<h3 class="section-header"><i class="fa fa-plane fa-lg"></i>Pending <?php the_title(); ?></h3>
	<button class="close-section-btn"><i class="fa fa-minus-circle fa-lg"></i><i class="fa fa-chevron-circle-down fa-lg"></i></button>
	
	<div id="pending-holidays-section-inner"  class="section-inner">
	
		<div id="pending-holidays-section-wrap" class="section-wrap">
		
		<div class="data-list-key">
				
			<div class="actions-key">
				<span class="actions"><i class="fa fa-cogs"></i> Actions</span>
				<span class="status"><i class="fa fa-info-circle"></i> Status</span>
			</div>
			
			<div class="status-key">
				<span class="approved">Approved</span>
				<span class="pending">Pending approval</span>
				<span class="canceled">Canceled</span>
			</div>
					
		</div>
		
		<div class="data-list">
			
				<div class="data-list-wrap">
			
					<table class="data-list-table">
					
						<thead class="data-list-header">
							<tr>	
								<th class="settings"><i class="fa fa-cogs fa-lg"></i></th>
								<th class="name">Name</th>
								<th class="date-long">Start date</th>
								<th class="date-long">End date</th>
								<th class="num-days">Days</th>
							</tr>
						</thead>
					
					<tbody>
					
					<?php while ( $pending_hoidays->have_posts() ) :$pending_hoidays->the_post();
					$pending_holidays_count++;
					?>	
					
					<?php 
					//echo '<pre>';print_r($post);echo '</pre>';
					$start_date = get_field('holiday_start_date');
					$end_date = get_field('holiday_end_date');
					$number_of_days = get_field('number_of_days');
					 ?>	
					<tr id="entry-tr-<?php echo $pending_holidays_count; ?>" class="entry-tr">
						 <td colspan="5">
						 
							<table class="table table-bordered">
								<tbody>
									<tr class="info-tr">
										<td class="settings">
											<a href="#" id="view-btn-<?php echo get_the_ID(); ?>" class="btn btn-default settings"><i class="fa fa-cogs"></i></a>
										</td>
										<td class="name">
											<span class="name"><?php the_author_posts_link(); ?></span>
										</td>
										<td class="date-long">
											<span class="start-date"><?php echo date('D jS F Y', strtotime($start_date) );?></span>
										</td>
										<td class="date-long">
											<span class="end-date"><?php echo date('D jS F Y', strtotime($end_date) );?></span>
										</td>
										<td class="num-days">
											<span class="end-date"><?php echo $number_of_days;?></span>
										</td>
									</tr>
									
									<tr class="actions-tr actions-tr-closed" id="actions-tr-<?php echo get_the_ID(); ?>">
										<td colspan="5">
										<a href="?admin_request=holiday_request&holidayid=<?php echo get_the_ID();?>" class="btn btn-default"><i class="fa fa-thumbs-o-up"></i> <i class="fa fa-thumbs-o-down"></i> Approval</a>
										</td>
									</tr>

									</tbody>
								</table>
							 </td>
						 </tr>
	
					<?php endwhile; ?>
					
					</tbody>
					
					</table>
					
				<?php if ($pending_holidays_post_count > $posts_per_page) { ?>
	
				<div class="pagination-links page-links-data">
				<?php 
				if (isset($_GET['holiday_sortby'])) {
				$format = '&paged=%#%';	
				} else {
				$format = '?paged=%#%';		
				}
				echo paginate_links(array(  
			                  'base' => get_pagenum_link(1) . '%_%',  
			                  'format' => $format,  
			                  'current' => $paged,  
			                  'total' => $pending_max_num_pages,  
			                  'prev_text' => '&laquo; Previous',  
			                  'next_text' => 'Next &raquo;'  
			                )); 
			                
			     ?>
				</div>	
				
				<?php } ?>
									
				</div>
		
			</div>
			
		</div><!-- Section inner wrap -->
		
	</div><!-- Section inner -->
	
</div><!-- Section outer -->

<?php endif; 
wp_reset_query();	
?>
