<?php if ( isset($_GET['request']) || isset($_GET['action']) ) { ?>
	<div class="actions-wrap">

			<div class="alerts-wrap">
				<?php //include (STYLESHEETPATH . '/_/inc/holiday-request/notifications/alerts.php'); ?>
				<?php include (STYLESHEETPATH . '/_/inc/global/notifications/remove-favourite-alerts.php'); ?>
				<?php include (STYLESHEETPATH . '/_/inc/global/notifications/remove-all-favourite-alerts.php'); ?>

			</div>
			
		</div>
		
	</div>
<?php } ?>