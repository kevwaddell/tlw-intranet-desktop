<?php  
global $user_holidays;	
?>
<?php if (empty($user_holidays) && date('n') >= 6) { ?>
<div class="alert alert-info text-center">
	<h3>Keep your holidays upto date!</h3>
	<p>You have no holidays added for <?php echo date("Y"); ?>.<br>
	Please add any previously approved holidays.</p>
</div>
<?php } ?>
<?php if ($_REQUEST['holiday-added'] == 1) { ?>
<div class="alert alert-success text-center">
	<h3>Holiday added successfuly</h3>
	<p>Your holiday has been added to your list.</p><br>
	<a href="<?php the_permalink() ?>" class="btn btn-success btn-sm">Continue <i class="fa fa-chevron-right"></i></a>
</div>
<?php } ?>
<?php if ($_REQUEST['holiday-updated'] == 1) { ?>
<div class="alert alert-success text-center">
	<h3>Holiday updated successfuly</h3>
	<p>Your holiday has been changed, please check it is correct.</p><br>
	<a href="<?php the_permalink() ?>" class="btn btn-success btn-sm">Continue <i class="fa fa-chevron-right"></i></a>
</div>
<?php } ?>