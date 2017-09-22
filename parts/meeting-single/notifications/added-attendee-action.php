<?php if (isset($_GET['action']) && $_GET['action'] == "internal_added") { 
$user = get_user_by('id', $_GET['user']);
$user_meta = get_user_meta($_GET['user']);
//echo '<pre>';print_r($user_meta['first_name'][0]);echo '</pre>';
?>


<div class="alert alert-success">
	<strong><?php echo $user->data->display_name; ?></strong> has been added to Internal attendees.<br> 
	
	<?php if ($start_time > $now) { ?>
	You may now notify <strong><?php echo $user_meta['first_name'][0]; ?></strong> of the meeting.<br><br>
	<?php } else { ?>
	<br>
	<?php } ?>
	
<div class="action-btns">
	
	<?php if ($start_time > $now) { ?>
	<div class="row">
		<div class="col-xs-6">
			<a href="?action=notify_attendee&user_key=<?php echo $_GET['user_key']; ?>&user=<?php echo $_GET['user']; ?>" class="btn btn-success btn-block notify btn-action"><i class="fa fa-bullhorn fa-lg"></i> Notify now</a>
		</div>
		<div class="col-xs-6">
			<a href="<?php the_permalink(); ?>" class="btn btn-success btn-block"><i class="fa fa-clock-o fa-lg"></i> Notify later</a>
		</div>
	</div>
	<?php } else { ?>
	
		<a href="<?php the_permalink(); ?>" class="btn btn-success btn-block">Continue</a>
		
	<?php } ?>
	
</div>

</div>

<div class="rule"></div>

<?php }  ?>

<?php if (isset($_GET['action']) && $_GET['action'] == "external_added") { 
$name = urldecode($_GET['ext_name']);
?>


<div class="alert alert-success">
	<strong><?php echo $name; ?></strong> has been added to External attendees.<br><br>

<div class="action-btns">
	<a href="<?php the_permalink(); ?>" class="btn btn-success btn-block">Continue</a>
</div>

</div>

<div class="rule"></div>

<?php }  ?>