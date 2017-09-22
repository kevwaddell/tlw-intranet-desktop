<?php
$vac_start_date = get_field('vac_start_date');
$job_title = get_field('vac_job_title');
$event_time_end = get_field('event_time_end');
$departments = get_field('vac_department');
$managers = get_field('vac_report_to');
$purpose = get_field('vac_job_purpose');
$qualifications = get_field('vac_qualification');
$work_exp = get_field('vac_work_experience');
$job_type = get_field('vac_job_type');
//echo '<pre>';print_r($managers);echo '</pre>';
?>
<div class="details-box details-closed">
	<h3><i class="fa fa-info-circle"></i>Vacancy details</h3>
	<button class="close-details-btn"><i class="fa fa-minus-circle"></i><i class="fa fa-plus-circle"></i></button>
	
	<div class="details-content">
		<table class="table">
			<tbody>
				<?php if ($vac_start_date) { ?>
				<tr class="details-row">
					<td width="25%" class="info-label">Start date:</td>	
					<td width="75%" class="info-details"><?php echo $vac_start_date; ?></td>	
				</tr>
				<?php } ?>
				
				<?php if ($job_title) { ?>
				<tr class="details-row">
					<td width="25%" class="info-label">Job title:</td>	
					<td width="75%" class="info-details"><?php echo $job_title; ?></td>	
				</tr>
				<?php } ?>
				
				<?php if ($job_type) { 
					if ($job_type == 'Part-time') {
					$hrs = get_field('vac_hrs');	
					}
				?>
				<tr class="details-row">
					<td width="25%" class="info-label">Job type:</td>	
					<td width="75%" class="info-details"><?php echo $job_type; ?><?php echo ($hrs) ? ' - '.$hrs.'hrs':''; ?></td>	
				</tr>
				<?php } ?>
				
				<?php if ($departments) { ?>
				<tr class="details-row">
					<td width="25%" class="info-label">Department:</td>	
					<td width="75%" class="info-details">
						<ul class="list-unstyled" style="margin-bottom: 0px;">
						<?php foreach ($departments as $dep) { ?>
							<li><a href="<?php echo get_permalink($dep); ?>"><?php echo get_the_title($dep); ?></a></li>
						<?php } ?>
						</ul>
					</td>	
				</tr>
				<?php } ?>
				
				<?php if ($managers) { ?>
				<tr class="details-row">
					<td width="25%" class="info-label">Manager:</td>	
					<td width="75%" class="info-details">
						<ul class="list-unstyled" style="margin-bottom: 0px;">
						<?php foreach ($managers as $manager) { ?>
							<li><a href="<?php echo get_author_posts_url($manager['ID']); ?>"><?php echo $manager['display_name']; ?></a></li>
						<?php } ?>
						</ul>
					</td>	
				</tr>
				<?php } ?>
				
				<?php if ($purpose) { ?>
				<tr class="details-row">
					<td width="25%" class="info-label">Job purpose:</td>	
					<td width="75%" class="info-details">
						<?php echo $purpose; ?>
					</td>	
				</tr>
				<?php } ?>
				
				<?php if ($qualifications) { ?>
				<tr class="details-row">
					<td width="25%" class="info-label">Qualifications:</td>	
					<td width="75%" class="info-details">
						<?php echo $qualifications; ?>
					</td>	
				</tr>
				<?php } ?>
				
				<?php if ($work_exp) { ?>
				<tr class="details-row">
					<td width="25%" class="info-label">Work Experince:</td>	
					<td width="75%" class="info-details">
						<?php echo $work_exp; ?>
					</td>	
				</tr>
				<?php } ?>
	
			</tbody>
		</table>
	</div>
</div>