<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head id="www-tlw-intranet-dev" data-template-set="tlw-intranet-theme" profile="http://gmpg.org/xfn/11">

	<meta charset="<?php bloginfo('charset'); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	
	<meta name="robots" content="noindex, nofollow" /> 
	
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
		   <?php bloginfo('name'); echo ' | '; wp_title(''); ?>
	</title>
			   
	<link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/_/img/favicon.ico">

	<?php wp_head(); ?>

</head>

<body id="user-page" <?php body_class(); ?>>

					
<!-- TOP BAR START -->
<header class="user-header">
	<a href="<?php echo get_option('home'); ?>/" id="logo">
		<i class="fa fa-angle-double-left fa-lg"></i> Back to Dashboard
	</a>
</header>

<div class="user-wrapper">