<?php if (isset($_GET['userid']) && $_GET['request'] == "add_holiday") { 
$user_id = get_user_by('id', $_GET['userid']);
//echo '<pre>';print_r($todays_date_raw);echo '</pre>';
?>
<div class="alert alert-info">

<h4>Holiday request</h4>

<?php include (STYLESHEETPATH . '/_/inc/holiday-request/notifications/add-form.php'); ?>

</div>

<?php }  ?>
