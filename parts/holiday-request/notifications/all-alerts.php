<?php if (isset($_GET['request']) || isset($_GET['action']) || $_SERVER['REQUEST_METHOD'] === 'POST' ) { ?>
	<div class="actions-wrap">

			<div class="alerts-wrap">
			<!-- NOTIFICATION ALERTS -->
			<!-- ADD HOLIDAY ALERTS -->
			<?php include (STYLESHEETPATH . '/_/inc/holiday-request/notifications/add-holiday-request.php'); ?>
			<?php include (STYLESHEETPATH . '/_/inc/holiday-request/notifications/add-holiday-action.php'); ?>
			<?php include (STYLESHEETPATH . '/_/inc/holiday-request/notifications/add-holiday-confirm.php'); ?>
			
			<!-- CANCEL HOLIDAY ALERTS -->
			<?php include (STYLESHEETPATH . '/_/inc/holiday-request/notifications/cancel-holiday-request.php'); ?>
			<?php include (STYLESHEETPATH . '/_/inc/holiday-request/notifications/cancel-holiday-action.php'); ?>
			
			<!-- NOTIFICATION ALERTS -->
			</div>
			
		</div>
		
	</div>
<?php } ?>
