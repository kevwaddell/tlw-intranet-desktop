<?php 
global $current_group;
if ($current_group == 'scheduled') { ?>
<?php  get_template_part( 'parts/reminders-page/reminders', 'scheduled' ); ?>
<?php } else { ?>
<?php  get_template_part( 'parts/reminders-page/reminders', 'group' ); ?>
<?php } ?>