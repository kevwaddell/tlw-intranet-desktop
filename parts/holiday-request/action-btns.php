<div class="action-btns<?php echo (!empty($color)) ? " col-".$color:" col-gray"; ?>">
	<?php if (is_user_logged_in()) { ?>
	
	<a href="?request=add_holiday&userid=<?php echo $current_user_ID ; ?>" class="btn btn-default btn-block btn-action"><i class="fa fa-check fa-lg"></i>Make a holiday request</a>
	<?php } else { ?>
	<a href="<?php echo wp_login_url(); ?>" class="btn btn-default btn-block" data-toggle="modal"><i class="fa fa-check fa-lg"></i>Make a holiday request</a>
	<?php } ?>
	
	<?php if (current_user_can("administrator") || $current_user_ID == $rb_admin['ID'] || $current_user_ID == $hb_admin['ID']) { ?>
	<a href="webcal://<?php echo $ical_page_split_url[1]; ?>" class="btn btn-default btn-block"><i class="fa fa-calendar fa-lg"></i>Download holidays calendar</a>
	<?php } ?>
</div>
