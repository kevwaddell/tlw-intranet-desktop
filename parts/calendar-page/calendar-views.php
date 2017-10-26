<?php
global $current_view;	
?>
<?php if ($current_view == 'month') { ?>
<?php  get_template_part( 'parts/calendar-page/month', 'view' ); ?>
<?php } ?>
<?php if ($current_view == 'week') { ?>
<?php  get_template_part( 'parts/calendar-page/week', 'view' ); ?>
<?php } ?>
<?php if ($current_view == 'day') { ?>
<?php  get_template_part( 'parts/calendar-page/day', 'view' ); ?>
<?php } ?>
