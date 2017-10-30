<?php
global $current_user;
$firstname = get_user_meta($current_user->ID, 'first_name', true);
$lastname = get_user_meta($current_user->ID, 'last_name', true);
$settings_pg = get_page_by_path( 'settings' );
$notes_pg = get_page_by_path( 'notes' );
$reminders_pg = get_page_by_path( 'reminders' );
$calendar_pg = get_page_by_path( 'calendar' );
$holidays_pg = get_page_by_path( 'holidays' );
//echo '<pre>';print_r($edit_profile_pg);echo '</pre>';
?>
<div class="user-banner-links btn-group pull-right" role="group">
	
	 <div class="user-dropdown btn-group" role="group">
	    <button type="button" class="btn btn-default no-rounded dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	      <span class="fa fa-user-circle fa-2x"></span> <?php echo $firstname. " " .$lastname; ?> <i class="fa fa-angle-down"></i>
	    </button>
	    <ul class="dropdown-menu">
	      <li><a href="<?php echo get_permalink( $settings_pg); ?>"><i class="fa fa-cogs"></i> <?php echo get_the_title( $settings_pg ); ?></a></li>
	      <li><a href="<?php echo get_permalink( $notes_pg); ?>"><i class="fa fa-pencil"></i> <?php echo get_the_title( $notes_pg ); ?></a></li>
	      <li><a href="<?php echo get_permalink( $reminders_pg); ?>"><i class="fa fa-bell"></i> <?php echo get_the_title( $reminders_pg ); ?></a></li>
	      <li><a href="<?php echo get_permalink( $calendar_pg); ?>"><i class="fa fa-calendar"></i> <?php echo get_the_title( $calendar_pg ); ?></a></li>
	      <?php if (!current_user_can("administrator")) { ?>
	      	<li><a href="<?php echo get_permalink( $holidays_pg); ?>" target="_blank"><i class="fa fa-plane"></i> <?php echo get_the_title( $holidays_pg ); ?></a></li>		
	      <?php } ?>
	      <?php if (current_user_can("administrator")) { ?>
	      	<li><a href="<?php echo admin_url(); ?>" target="_blank"><i class="fa fa-dashboard"></i> Admin</a></li>		
	      <?php } ?>
	    </ul>
	 </div>
	  <?php if (!is_front_page()) { ?>
	   <a href="<?php echo get_option('home'); ?>/" id="launch-pad-btn" class="user-link btn btn-default no-rounded"><i class="fa fa-rocket fa-2x"></i></a>			
	  <?php } ?>
	  <a href="?global-actions=view-help" id="banner-help-btn" class="user-link btn btn-default no-rounded"><i class="fa fa-question-circle fa-2x"></i></a>
	  <a href="<?php echo wp_logout_url(); ?>" class="user-link btn btn-defaul no-rounded"><i class="fa fa-power-off fa-2x"></i></a>
  
 </div>