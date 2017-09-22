<?php if (isset($_GET['request']) && $_GET['request'] == "add_attendee") { ?>

<div class="alert alert-info">

<h4><i class="fa fa-plus-circle"></i> Add Attendee</h4>

<?php include (STYLESHEETPATH . '/_/inc/meeting-single/notifications/add-attendee-form.php'); ?>

</div>

<div class="rule"></div>

<?php }  ?>