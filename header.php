<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>

	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content ="width=device-width,user-scalable=yes" />
			   
	<link rel="icon" type="image/png" href="/favicon-32x32.png?v=zXdkgBvmkj" sizes="32x32">
	<link rel="icon" type="image/png" href="/favicon-16x16.png?v=zXdkgBvmkj" sizes="16x16">

	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

	<div id="app-wrapper">
						
		<!-- TOP BAR START -->
		<header role="banner">
			<div class="container-fluid"><div class="row">
				<div class="col-xs-4">
					<a href="<?php echo get_option('home'); ?>/" id="logo" class="text-hide">
					<?php bloginfo('name'); ?> <?php bloginfo('description'); ?>
					</a>
				</div>
				
				<div class="col-xs-4">
					
				</div>
				
				<div class="col-xs-4">
					
				</div>
				
			</div></div>
		</header>
			
		<!-- MAIN CONTENT START -->
		<section role="main">