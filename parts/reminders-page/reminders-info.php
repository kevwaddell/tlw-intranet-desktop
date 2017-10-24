<?php 
global $current_group;
if ($current_group == 'scheduled' || $current_group == 'meeting') { ?>
<?php if ($current_group == 'scheduled') { ?>
<?php  get_template_part( 'parts/reminders-page/reminders', 'scheduled' ); ?>
<?php } else { ?>
<?php  get_template_part( 'parts/reminders-page/reminders', 'meetings' ); ?>
<?php } ?>
<?php } else { ?>
<?php  get_template_part( 'parts/reminders-page/reminders', 'group' ); ?>
<?php } ?>