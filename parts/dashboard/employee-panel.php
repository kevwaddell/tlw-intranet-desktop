<div class="dash-panel-inner">
<?php
$emp_otm_user = get_field('employee_otm', 'options');	
$emp_otm_month = strtotime(get_field('month_otm', 'options'));	
$last_month = strtotime("last month");
$this_month = strtotime("this month");
$emp_otm_reason = get_field('reason_otm', 'options');
$avatar = get_avatar( $emp_otm_user['ID'], 150 );
$results = get_field('results_otm', 'options');
$total_votes = get_field('total_votes', 'options');
$winner_votes = get_field('winner_votes', 'options');
$winner_percent = round(($winner_votes/$total_votes) * 100);
/*
echo '<pre>';
print_r($total_votes);
echo '<br>';
print_r($winner_votes);
echo '<br>';
echo '<br>';
print_r(round(($winner_votes/$total_votes) * 100));
echo '</pre>'; 
*/
?>
 <?php if (isset($_GET['action']) && $_GET['action'] == 'view_results') { 
	 
 ?>
 <div class="eotm-content">
	<h3>Results for <?php echo date('F', $emp_otm_month); ?></h3>
	<ul class="list-unstyled results">
		<li>
			<label><?php echo $emp_otm_user['display_name']; ?> (<?php echo $winner_percent; ?>%)</label>
			<div class="progress">
				<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $winner_percent; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $winner_percent; ?>%">
	  		</div>
			</div>	
		</li>
		<?php foreach ($results as $result) { 
		$percent = round( ($result['number_of_votes']/$total_votes) * 100 );	
		?>
		<li>
			<label><?php echo $result['candidate_otm']['display_name']; ?> (<?php echo $percent; ?>%)</label>
			<div class="progress">
				<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $percent; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $percent; ?>%">
	  		</div>
			</div>	
		</li>
		<?php } ?>
	</ul>
	
	<div class="panel-btns">
		<?php if (is_user_logged_in()) { ?>
		<a href="?request=vote_for_user&userid=" class="btn btn-default btn-block no-arrow action-btn"><i class="fa fa-check fa-lg"></i>Vote for this Months</a>	
		<?php } ?>
		
		<a href="?action=view_winner" class="btn btn-default btn-block no-arrow panel-action-btn"><i class="fa fa-angle-double-left fa-lg"></i>View winner</a>	
	</div>
</div>
<?php } ?>
 
<?php if (!isset($_GET['action']) || $_GET['action'] == 'view_winner') { ?>

<div class="eotm-content"<?php echo (is_user_logged_in() || date('m', $emp_otm_month) == date('m', $last_month)) ? ' style="margin-bottom: 20px;"':'' ?>>
	<div class="row">
		<?php if ($emp_otm_user && date('m', $emp_otm_month) == date('m', $last_month)) { ?>
		<div class="col-xs-8">
			<div class="info">
				<h3><a href="<?php echo get_author_posts_url( $emp_otm_user['ID'], $emp_otm_user['user_nicename']); ?>" title="View <?php echo $emp_otm_user['user_firstname']; ?>'s Profile"><?php echo $emp_otm_user['display_name']; ?></a></h3>
				<p class="date"><?php echo date('F | Y', $emp_otm_month); ?></p>
				<p><?php echo $emp_otm_reason; ?></p>
				<p style="margin-top:10px;"><strong>Congratulations <?php echo $emp_otm_user['user_firstname']; ?>!</strong></p>
			</div>
	
		</div>
		<?php } else { ?>
		
		<div class="col-lg-9">
			<div class="info text-center">
				<h3>Watch this space!</h3>
				<p class="caps"><?php echo date('F', $last_month); ?> voting has ended.</p>
				<p>Votes have been counted and <?php echo date('F', $last_month); ?>'s candidate will be available to view shortly.</p>
				<p><strong>Come back soon!</strong></p>
			</div>
		</div>
		<?php } ?>
		
		<?php if ($emp_otm_user && date('m', $emp_otm_month) == date('m', $last_month)) { ?>
		<div class="col-xs-4">
			<figure class="avatar">
				<?php echo $avatar; ?>
			</figure>
		</div>
		<?php } else { ?>
		<div class="visible-lg col-lg-3">
			<div class="icon">
				<i class="fa fa-trophy fa-4x"></i>
			</div>
		</div>
		<?php } ?>
		
	</div>
</div>
	<?php if (date('m', $emp_otm_month) == date('m', $last_month)) { ?>
	<div class="panel-btns">
		<?php if (is_user_logged_in()) { ?>
		<a href="?request=vote_for_user&userid=" class="btn btn-default btn-block no-arrow action-btn"><i class="fa fa-check fa-lg"></i>Vote for this Months</a>	
		<?php } ?>
		
		<a href="?action=view_results" class="btn btn-default btn-block no-arrow panel-action-btn"><i class="fa fa-eye fa-lg"></i>View Results</a>	
	</div>
	<?php } ?>
	
 <?php } ?>
</div>