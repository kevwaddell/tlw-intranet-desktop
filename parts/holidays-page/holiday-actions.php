<?php
global $user_holidays_nextY;
global $current_year;	
?>
<div class="holiday-actions">
	<div class="row">
		<div class="col-xs-4">
			<a href="?holiday-actions=add-holiday" class="btn btn-default btn-sm btn-block caps icon-btn<?php echo ($_REQUEST['holiday-actions'] == 'add-holiday') ? ' active':'' ?>"><i class="fa fa-plus"></i> Add approved holiday</a>
		</div>
		<div class="col-xs-4">
			<a href="?holiday-actions=request-holiday" class="btn btn-default btn-sm btn-block caps icon-btn<?php echo ($_REQUEST['holiday-actions'] == 'request-holiday') ? ' active':'' ?>"><i class="fa fa-paper-plane"></i> Create Holiday Request</a>
		</div>
		<div class="col-xs-4">
			<button type="button" class="btn btn-default btn-sm btn-block caps icon-btn" onclick="printPage()"><i class="fa fa-print"></i> Print holidays list</a>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
		<?php if (!empty($user_holidays_lastY_raw)) { ?>
			<a href="?holiday-actions=last-year" class="btn btn-default btn-sm btn-block caps icon-btn<?php echo ($current_year == date('Y', strtotime("last year"))) ? ' active':'' ?>"><i class="fa fa-angle-left"></i> Last year</a>
		<?php } ?>
		</div>
		<div class="col-xs-4">
			<a href="<?php the_permalink(); ?>" class="btn btn-default btn-sm btn-block caps icon-btn<?php echo ($current_year == date('Y')) ? ' active':'' ?>"><i class="fa fa-check"></i> This year</a>
		</div>
		<div class="col-xs-4">
			<a href="?holiday-actions=next-year" class="btn btn-default btn-sm btn-block caps icon-btn<?php echo ($current_year == date('Y', strtotime("next year"))) ? ' active':'' ?>">Next Year <i class="fa fa-angle-right"></i> </a>
		</div>	
	</div>			
</div>

<script>
	function printPage() {
	    window.print();
		    //workaround for Chrome bug - https://code.google.com/p/chromium/issues/detail?id=141633
		    if (window.stop) {
		        location.reload(); //triggering unload (e.g. reloading the page) makes the print dialog appear
		        window.stop(); //immediately stop reloading
		    }
		    return false;
		}
</script>