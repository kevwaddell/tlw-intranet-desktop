<?php
global $current_month;
global $current_week;
global $current_day;
?>

<div class="calendar-actions text-right">
	<?php if (isset($_REQUEST['calendar-view'])) { ?>
	<?php if ($current_month == 'this-month' && $_REQUEST['calendar-view'] == 'month') { ?>
	<a href="?calendar-view=month&month-actions=next-month" class="btn btn-default btn-sm caps"><i class="fa fa-th-large"></i> Next Month</a>
	<a href="?calendar-view=week&week-actions=this-week" class="btn btn-default btn-sm caps"><i class="fa fa-th-list"></i> This week</a>
	<a href="?calendar-view=day&day-actions=today" class="btn btn-default btn-sm caps"><i class="fa fa-list"></i> Today</a>
	<?php } ?>
	
	<?php if ($current_month == 'next-month' && $_REQUEST['calendar-view'] == 'month') { ?>
	<a href="?calendar-view=month&month-actions=this-month" class="btn btn-default btn-sm caps"><i class="fa fa-th-large"></i> This Month</a>
	<a href="?calendar-view=week&week-actions=this-week" class="btn btn-default btn-sm caps"><i class="fa fa-th-list"></i> This week</a>
	<a href="?calendar-view=day&day-actions=today" class="btn btn-default btn-sm caps"><i class="fa fa-list"></i> Today</a>
	<?php } ?>
	
	<?php if ($current_week == 'this-week' && $_REQUEST['calendar-view'] == 'week') { ?>
	<a href="?calendar-view=month&month-actions=this-month" class="btn btn-default btn-sm caps"><i class="fa fa-th-large"></i> This Month</a>
	<a href="?calendar-view=week&week-actions=next-week" class="btn btn-default btn-sm caps"><i class="fa fa-th-list"></i> Next week</a>
	<a href="?calendar-view=day&day-actions=today" class="btn btn-default btn-sm caps"><i class="fa fa-list"></i> Today</a>
	<?php } ?>
	
	<?php if ($current_week == 'next-week' && $_REQUEST['calendar-view'] == 'week') { ?>
	<a href="?calendar-view=month&month-actions=this-month" class="btn btn-default btn-sm caps"><i class="fa fa-th-large"></i> This Month</a>
	<a href="?calendar-view=week&week-actions=this-week" class="btn btn-default btn-sm caps"><i class="fa fa-th-list"></i> This week</a>
	<a href="?calendar-view=day&day-actions=today" class="btn btn-default btn-sm caps"><i class="fa fa-list"></i> Today</a>
	<?php } ?>

	<?php if ($current_day == 'today' && $_REQUEST['calendar-view'] == 'day') { ?>
	<a href="?calendar-view=month&month-actions=this-month" class="btn btn-default btn-sm caps"><i class="fa fa-th-large"></i> This Month</a>
	<a href="?calendar-view=week&week-actions=this-week" class="btn btn-default btn-sm caps"><i class="fa fa-th-list"></i> This week</a>
	<a href="?calendar-view=day&day-actions=tomorrow" class="btn btn-default btn-sm caps"><i class="fa fa-list"></i> Tomorrow</a>
	<?php } ?>
	
	<?php if ($current_day == 'tomorrow' && $_REQUEST['calendar-view'] == 'day') { ?>
	<a href="?calendar-view=month&month-actions=this-month" class="btn btn-default btn-sm caps"><i class="fa fa-th-large"></i> This Month</a>
	<a href="?calendar-view=week&week-actions=this-week" class="btn btn-default btn-sm caps"><i class="fa fa-th-list"></i> This week</a>
	<a href="?calendar-view=day&day-actions=today" class="btn btn-default btn-sm caps"><i class="fa fa-list"></i> Today</a>
	<?php } ?>
	<?php } else { ?>
	<a href="?calendar-view=month&month-actions=next-month" class="btn btn-default btn-sm caps"><i class="fa fa-th-large"></i> Next Month</a>
	<a href="?calendar-view=week&week-actions=this-week" class="btn btn-default btn-sm caps"><i class="fa fa-th-list"></i> This week</a>
	<a href="?calendar-view=day&day-actions=today" class="btn btn-default btn-sm caps"><i class="fa fa-list"></i> Today</a>
	<?php } ?>
	
	
</div>