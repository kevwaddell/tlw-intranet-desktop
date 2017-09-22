<?php if (isset($_GET['request']) || isset($_GET['action']) || $_SERVER['REQUEST_METHOD'] === 'POST' ) { ?>
<div class="actions-wrap">

	<div class="alerts-wrap">
<!-- NOTIFICATION ALERTS -->
<?php include (STYLESHEETPATH . '/_/inc/meeting-rooms/notifications/add-meeting-request.php'); ?>
<?php include (STYLESHEETPATH . '/_/inc/meeting-rooms/notifications/add-meeting-post.php'); ?>
<?php include (STYLESHEETPATH . '/_/inc/meeting-rooms/notifications/add-meeting-action.php'); ?>
			
<?php include (STYLESHEETPATH . '/_/inc/meeting-rooms/notifications/approve-meeting-request.php'); ?>
<?php include (STYLESHEETPATH . '/_/inc/meeting-rooms/notifications/approve-meeting-action.php'); ?>

<?php include (STYLESHEETPATH . '/_/inc/meeting-rooms/notifications/reject-meeting-request.php'); ?>
<?php include (STYLESHEETPATH . '/_/inc/meeting-rooms/notifications/reject-meeting-action.php'); ?>

<?php include (STYLESHEETPATH . '/_/inc/meeting-rooms/notifications/cancel-meeting-request.php'); ?>
<?php include (STYLESHEETPATH . '/_/inc/meeting-rooms/notifications/cancel-meeting-action.php'); ?>

<?php include (STYLESHEETPATH . '/_/inc/meeting-rooms/notifications/notify-attendees-cancel-action.php'); ?>

<?php include (STYLESHEETPATH . '/_/inc/meeting-rooms/notifications/delete-meeting-request.php'); ?>
<?php include (STYLESHEETPATH . '/_/inc/meeting-rooms/notifications/delete-meeting-action.php'); ?>

<?php include (STYLESHEETPATH . '/_/inc/meeting-rooms/notifications/edit-meeting-request.php'); ?>
<?php include (STYLESHEETPATH . '/_/inc/meeting-rooms/notifications/edit-meeting-action.php'); ?>
	<!-- NOTIFICATION ALERTS -->
	</div>
	
</div>
<?php } ?>
