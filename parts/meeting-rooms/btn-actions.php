<div class="action-btns<?php echo (!empty($color)) ? " col-".$color:""; ?>">
	<?php if (is_user_logged_in()) { ?>
	<a href="<?php echo get_permalink($meetings->ID); ?>?request=room_booking&userid=<?php echo $current_user_ID ; ?>" class="btn btn-default btn-block btn-action no-arrow" data-toggle="modal"><i class="fa fa-check fa-lg"></i>Book a meeting room</a>
	<?php } else { ?>
	<a href="<?php echo wp_login_url(); ?>" class="btn btn-default btn-block no-arrow" data-toggle="modal"><i class="fa fa-check fa-lg"></i>Book a meeting room</a>
	<?php } ?>
	<a href="webcal://<?php echo $ical_page_split_url[1]; ?>" class="btn btn-default btn-block"><i class="fa fa-calendar fa-lg"></i>Download <?php echo $meetings->post_title; ?> calendar</a>
</div>
