<?php if (isset($_GET['action']) && $_GET['action'] == "remove_attendee") { 
$user = get_user_by('id', $_GET['user']);
$user_meta = get_user_meta($_GET['user']);

	if ( isset($_GET['user_key']) ) {
	$name = $user->data->display_name;
	}
	
	if ( isset($_GET['external_key']) ) {
	$name = get_post_meta(get_the_ID(), 'attendees_clients_'.$_GET['external_key'].'_attendee_client', true);	
	}
	
?>

<div class="alert alert-warning text-center">
	
	<h4><i class="fa fa-plus-circle"></i> Confirm</h4>
	
	Are you sure you want to remove<br><strong><?php echo $name; ?></strong> from the <strong><?php echo $description; ?></strong> meeting.<br><br>

<div class="action-btns">

	<div class="row">
		<div class="col-xs-6">
		
			<?php if ( isset($_GET['user_key']) ) { ?>
			<a href="?action=delete_attendee&user_key=<?php echo $_GET['user_key']; ?>&user=<?php echo $_GET['user']; ?>" class="btn btn-success btn-block btn-action"><i class="fa fa-check fa-lg"></i> Yes</a>
			<?php }  ?>
			
			<?php if ( isset($_GET['external_key']) ) { ?>
			<a href="?action=delete_attendee&external_key=<?php echo $_GET['external_key']; ?>" class="btn btn-danger btn-block btn-action"><i class="fa fa-check fa-lg"></i> Yes</a>
			<?php }  ?>
		
		</div>
		
		<div class="col-xs-6">
			<a href="<?php the_permalink(); ?>" class="btn btn-danger btn-block"><i class="fa fa-times fa-lg"></i> No</a>
		</div>
	</div>
	
</div>

</div>

<div class="rule"></div>

<?php }  ?>