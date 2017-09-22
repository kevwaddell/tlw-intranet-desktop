<?php 
$today = date('Ymd', strtotime("today"));
$out_of_office_args = array(
	'posts_per_page'   => -1,
	'post_status'	=> 'publish',
	'post_type'  => 'tlw_holiday',
	'order'	=> 'DESC',
	'meta_key'	=> 'holiday_start_date',
	'orderby' => 'meta_value_num',
	'meta_query' => array(
		
		'relation' => 'AND',
		array(
			'key' => 'holiday_start_date',
			'value' => $today,
			'compare' => '<=',
			'type' => 'NUMERIC'
		),
		array(
			'key' => 'holiday_end_date',
			'value' => $today,
			'compare' => '>=',
			'type' => 'NUMERIC'
		)
	)
);

$out_of_office = get_posts($out_of_office_args);

//echo '<pre>';print_r($out_of_office);echo '</pre>';
 ?>
 
<?php if ($out_of_office) { ?>

<div id="ooo-carousel" class="carousel slide">
	
	<?php if (count($out_of_office) > 1) { ?>
	<ol class="carousel-indicators">
    <?php for ($oo = 0; $oo < count($out_of_office); $oo++) { ?>
		<li data-target="#ooo-carousel" data-slide-to="<?php echo $oo; ?>"<?php echo ($oo == 0) ? ' class="active"':''; ?>></li>
  	<?php } ?>
	</ol>
	<?php } ?>
	
	<div class="carousel-inner">
	
	<?php foreach ($out_of_office as $user) { ?>
		
		<?php if ($user == reset($out_of_office)) { ?>
		<div class="item active">
		<?php } else { ?>
		<div class="item">
		<?php } ?>
				<figure class="avatar">
					<img src="http://www.tlwsolicitors.co.uk/wp-content/uploads/2014/02/Marc-Davidson-200x200-1392040834.jpg" alt="" width="100" height="100">
				</figure>
				<div class="info">
					<h3 class="name">Marc Davison</h3>
					<p class="date"><span>Return Date:</span> Tuesday 2nd September 2014</p>
					<a href="mailto:mdavison@tlwsolicitors.co.uk"><i class="fa fa-envelope"></i> mdavison@tlwsolicitors.co.uk</a>
					<a href="#"><i class="fa fa-eye"></i> View Profile</a>
				</div>
			</div>
	<?php } ?>
			
	</div>
	
	<?php if (count($out_of_office) > 1) { ?>
	
	<div class="panel-btns">
		<div class="row">
		
			<div class="col-xs-6">
			
				 <a class="btn btn-default btn-block prev" href="#ooo-carousel" data-slide="prev"><i class="fa fa-chevron-circle-left"></i>Previous</a>
			
			</div>
			
			<div class="col-xs-6">
			
				<a class="btn btn-default btn-block next" href="#ooo-carousel" data-slide="next"><i class="fa fa-chevron-circle-right"></i>Next</a>
			
			</div>
		
		</div>
	</div>
	
	<?php } ?>

</div>

 <?php } else { ?>
 
 <div class="well text-center" style="margin-bottom: 0px;">
 	<span>There are no members of staff out of the office today.</span>
 </div>

 <?php } ?>