<div class="page-section section-open">
	
	<h3 class="section-header"><i class="fa fa-plane fa-lg"></i>Out of office</h3>
	<button class="close-section-btn"><i class="fa fa-minus-circle fa-lg"></i><i class="fa fa-chevron-circle-down fa-lg"></i></button>
	
	<div id="holidays-section-inner"  class="section-inner">
	
		<div id="holidays-section-wrap" class="section-wrap">
				
			<div class="data-list-key">
			
				<div class="filters<?php echo (!empty($color)) ? " col-".$color:""; ?>">
					<span><a href="<?php the_permalink(); ?>" <?php echo (!isset($_GET['holiday_sortby'])) ? " class=\"active\"":""; ?>>Today</a></span>
					<span><a href="<?php the_permalink(); ?>?holiday_sortby=tomorrow"<?php echo (isset($_GET['holiday_sortby']) && $_GET['holiday_sortby'] == "tomorrow") ? " class=\"active\"":""; ?>>Tomorrow</a></span>
					<span><a href="<?php the_permalink(); ?>?holiday_sortby=this-week"<?php echo (isset($_GET['holiday_sortby']) && $_GET['holiday_sortby'] == "this-week") ? " class=\"active\"":""; ?>>This week</a></span>
					<span><a href="<?php the_permalink(); ?>?holiday_sortby=next-week"<?php echo (isset($_GET['holiday_sortby']) && $_GET['holiday_sortby'] == "next-week") ? " class=\"active\"":""; ?>>Next week</a></span>
					<span><a href="<?php the_permalink(); ?>?holiday_sortby=this-month"<?php echo (isset($_GET['holiday_sortby']) && $_GET['holiday_sortby'] == "this-month") ? " class=\"active\"":""; ?>>This month</a></span>
					<span><a href="<?php the_permalink(); ?>?holiday_sortby=next-month"<?php echo (isset($_GET['holiday_sortby']) && $_GET['holiday_sortby'] == "next-month") ? " class=\"active\"":""; ?>>Next month</a></span>
				</div>
			
			</div>
		
		<?php 
		//echo '<pre>';print_r(count($your_meetings));echo '</pre>';
		if ( $holidays->have_posts() ):
		$holidays_count = 0;
		?>
		
		<div class="data-list">
			
				<div class="data-list-wrap">
			
					<table class="data-list-table">
					
						<thead class="data-list-header">
							<tr>	
								<th class="name">Name</th>
								<th class="date-long">Start date</th>
								<th class="date-long">End date</th>
							</tr>
						</thead>
					
					<tbody>
					
					<?php while ( $holidays->have_posts() ) :$holidays->the_post();
					$holidays_count++;
					?>	
					
					<?php 
					//echo '<pre>';print_r($post);echo '</pre>';
					$start_date = get_field('holiday_start_date');
					$end_date = get_field('holiday_end_date');
					 ?>	
					<tr id="entry-tr-<?php echo $holidays_count; ?>" class="entry-tr">
						 <td colspan="5">
						 
							<table class="table table-bordered">
								<tbody>
									<tr class="info-tr">
										<td class="name">
											<span class="name"><?php the_author_posts_link(); ?></span>
										</td>
										<td class="date-long">
											<span class="start-date"><?php echo date('D jS F Y', strtotime($start_date) );?></span>
										</td>
										<td class="date-long">
											<span class="end-date"><?php echo date('D jS F Y', strtotime($end_date) );?></span>
										</td>
									</tr>
									</tbody>
								</table>
							 </td>
						 </tr>
	
					<?php endwhile; ?>
					
					</tbody>
					
					</table>
					
				<?php if ($holidays_post_count > $posts_per_page) { ?>
	
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
			                  'total' => $max_num_pages,  
			                  'prev_text' => '&laquo; Previous',  
			                  'next_text' => 'Next &raquo;'  
			                )); 
			                
			     ?>
				</div>	
				
				<?php } ?>
									
				</div>
		
			</div>
			
		<?php else: ?>
		
		<div class="well text-center">
		
		<?php 
			switch ( $_GET['holiday_sortby'] ) { 
			case "next-month": $message = "There are no members of staff out of office next month at the moment.";
			break;
			case "this-month": $message = "There are no members of staff out of office this month at the moment.";
			break;
			case "next-week": $message = "There are no members of staff out of office next week at the moment.";
			break;
			case "this-week": $message = "There are no members of staff out of office this week at the moment.";
			break;
			case "tomorrow": $message = "There are no members of staff out of office tomorrow at the moment.";
			break;
			default: $message = "There are no members of staff out of office today.";
			}  
		 ?>
		 
		 <?php echo $message; ?>
		 
		</div>

		
		<?php endif; 
		wp_reset_query();	
		?>
			
		</div><!-- Section inner wrap -->
		
	</div><!-- Section inner -->
	
</div><!-- Section outer -->
