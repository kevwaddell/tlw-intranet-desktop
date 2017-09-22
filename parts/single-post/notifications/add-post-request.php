<?php if (isset($_GET['userid']) && $_GET['request'] == "edit_post") { 
$user_id = get_user_by('id', $_GET['userid']);
//echo '<pre>';print_r($todays_date_raw);echo '</pre>';
?>
<div class="alert alert-info">

<h4><i class="fa fa-plus-circle"></i> Add Post</h4>

<?php include (STYLESHEETPATH . '/_/inc/single-post/notifications/add-post-form.php'); ?>

</div>

<?php }  ?>
