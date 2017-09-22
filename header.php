<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head id="www-tlw-intranet-dev" data-template-set="tlw-intranet-theme" profile="http://gmpg.org/xfn/11">

	<meta charset="<?php bloginfo('charset'); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	
	<?php if (is_search()) { ?>
	<meta name="robots" content="noindex, nofollow" /> 
	<?php } ?>
	
	<?php if (wp_is_mobile()) { ?>
	<meta name="viewport" content="user-scalable=1.0,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="format-detection" content="telephone=yes">
		   
	<link rel="apple-touch-icon" href="<?php bloginfo('template_directory'); ?>/_/img/touch-icon-iphone.png" /> 
	<link rel="apple-touch-icon" sizes="76x76" href="<?php bloginfo('template_directory'); ?>/_/img/touch-icon-ipad.png" /> 
	<link rel="apple-touch-icon" sizes="120x120" href="<?php bloginfo('template_directory'); ?>/_/img/touch-icon-iphone-retina.png" />
	<link rel="apple-touch-icon" sizes="152x152" href="<?php bloginfo('template_directory'); ?>/_/img/touch-icon-ipad-retina.png" />
	<link rel="apple-touch-startup-image" href="<?php bloginfo('template_directory'); ?>/_/img/apple-start-up-img.png">
	<?php } ?>
	
	<title>
		   <?php
		   	  bloginfo('name'); echo ' '; bloginfo('description');
		      if (function_exists('is_tag') && is_tag()) {
		          echo '&quot; | '; single_tag_title("Tag Archive for &quot;");}
		      elseif (is_category()) {
		          echo ' | '; single_cat_title(''); }
		      elseif (is_search()) {
		         echo ' | '; echo 'Search for &quot;'.wp_specialchars($s).'&quot;'; }
		      elseif (!(is_404()) && (is_single()) || (is_page()) && (!is_front_page())) {
		          echo ' | '; wp_title(''); }
		      elseif (is_404()) {
		         echo ' | Not Found'; }

		      if ($paged>1) {
		         echo ' | page '. $paged; }
		   ?>
	</title>
			   
	<link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/_/img/favicon.ico">
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<?php wp_head(); ?>
	
	<?php 
	$url = explode('/',$_SERVER['REQUEST_URI']);
	$dir = $url[1] ? $url[1] : 'dashboard';
	
	if ( is_singular('post') ) {
	$dir = $url[4];
	}

	?>
	
	
	
</head>

<body id="<?php echo $dir ?>" <?php body_class(); ?>>

					
	<!-- TOP BAR START -->
	<header role="main-head">
	
	<a href="<?php echo get_option('home'); ?>/" id="logo" class="text-hide">
		<?php bloginfo('name'); ?> <?php bloginfo('description'); ?>
	</a>
	
	<?php include (STYLESHEETPATH . '/_/inc/global/todays-date.php'); ?>
		
	<?php wp_nav_menu(array( 
	'container' => 'false', 
	'menu' => 'Main Menu', 
	'menu_class'  => 'menu list-unstyled',
	'fallback_cb' => false 
	) ); 
	?>
	
	<?php if (is_user_logged_in()) { ?>
	<?php include (STYLESHEETPATH . '/_/inc/global/user-notifications.php'); ?>
	<?php } ?>	
	
	</header>
	
	
	<?php if (!is_front_page()) { ?>
	<div class="top-breadcrumb">
		<?php if (is_author()) { 
			$auth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
			?>
	 		<a title="Go to Dashboard" href="<?php echo get_option('home'); ?>" class="home"><span class="fa fa-home"></span> Dashboard</a>
	 		<i class="fa fa-angle-double-right"></i>
	 		<a title="Go to Staff Members." href="<?php echo get_option('home'); ?>/staff-members/" class="post post-page">Staff Members</a>
	 		<i class="fa fa-angle-double-right"></i>
	 		<span><?php echo $auth->display_name; ?></span>
	 	<?php } else { ?>
		 	<?php if(function_exists('bcn_display')) { bcn_display(); }?>
	 	<?php } ?>
	</div>
	<?php } ?>
		
	<!-- MAIN CONTENT START -->
	<div class="content">