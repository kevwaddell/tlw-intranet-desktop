<?php
$timeZone = 'Europe/London';
$now_dateTime = new DateTime("now", new DateTimeZone($timeZone));
$month_before = new DateTime("last month", new DateTimeZone($timeZone));
$month_start = new DateTime("first day of this month", new DateTimeZone($timeZone));
$month_end = new DateTime("last day of this month", new DateTimeZone($timeZone));
$next_month = new DateTime("next month", new DateTimeZone($timeZone));
debug(date("j", strtotime('last sat of '.$month_before->format("F"))));
$sats_counter = 0;
?>

<div class="calendar-header">
			
</div>
		
<div class="month-view">
		<div class="day-col pull-left">
			<div class="day-label">Monday</div>
			
		</div>	
		<div class="day-col pull-left">
			<div class="day-label">Tuesday</div>
			
		</div>	
		<div class="day-col pull-left">
			<div class="day-label">Wednesday</div>
			
		</div>	
		<div class="day-col pull-left">
			<div class="day-label">Thursday</div>
			
		</div>	
		<div class="day-col pull-left">
			<div class="day-label">Friday</div>
			
		</div>	
		<div class="day-col wk-end pull-left">
			<div class="day-label">Saturday</div>
			<?php for ($i = 1; $i <= $month_end->format("j"); $i++) {
			?>
			<?php if ($i == 6 && $sats_counter == 0) { ?>
			<div class="day dim-day">
				<span class="day-number"><?php echo date("j", strtotime('last sat of '.$month_before->format("F"))); ?></span>
			</div>	
			<?php } ?>
			<?php if (date("N",strtotime($now_dateTime->format("F")." ".$i."S" ) ) == 6) { 
			$sats_counter++;	
			?>
				<div class="day">
					<span class="day-number"><?php echo $i; ?><br><?php echo $sats_counter; ?></span>
				</div>	
			<?php } ?>
			<?php if ($sats_counter == 4) { ?>
			<div class="day dim-day">
				<span class="day-number"><?php echo date("j", strtotime('first sat of '.$next_month->format("F"))); ?></span>
			</div>	
			<?php } ?>

			<?php } ?>
		</div>	
		<div class="day-col wk-end pull-left">
			<div class="day-label">Sunday</div>
			<?php for ($i = 1; $i <= $month_end->format("j"); $i++) {?>
			<?php if (date("N",strtotime($now_dateTime->format("F")." ".$i."S" ) ) == 7) {?>
				<div class="day">
					<span class="day-number"><?php echo $i; ?></span>
				</div>	
			<?php } ?>
			<?php } ?>
		</div>			
</div>