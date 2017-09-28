<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>

	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content ="width=device-width,user-scalable=yes" />
			   
	<link rel="icon" type="image/png" href="/favicon-32x32.png?v=zXdkgBvmkj" sizes="32x32">
	<link rel="icon" type="image/png" href="/favicon-16x16.png?v=zXdkgBvmkj" sizes="16x16">

	<?php wp_head(); ?>
	
	<?php 
	global $post;
	$pg_icon = get_field( 'icon', $post->ID );
	?>

</head>

<body <?php body_class('nav-closed'); ?>>
	
	<?php if (!is_front_page()) { ?>
	<nav id="hidden-nav">
		<?php wp_nav_menu(array( 
		'container' => 'false', 
		'menu' => 'Hidden menu', 
		'menu_class'  => 'menu list-inline text-center',
		'fallback_cb' => false 
		) ); 
		?>
	</nav>
	<?php } ?>
	
	<div id="app-wrapper">
						
		<!-- TOP BAR START -->
		<header role="banner">
			<div class="container-fluid"><div class="row">
				<div class="col-xs-4">
					<?php if (!is_front_page()) { ?>
					<button id="main-nav-btn" class="btn btn-default"><i class="fa fa-bars fa-2x"></i></button>			
					<?php } ?>
					<?php if (!empty($pg_icon)) { ?>
					<div class="title"><i class="fa <?php echo $pg_icon; ?> fa-lg"></i><?php the_title() ?></div>
					<?php } ?>
				</div>
				
				<div class="col-xs-4">
					<a href="<?php echo get_option('home'); ?>/" id="logo" class="text-hide">
					<?php bloginfo('name'); ?> <?php bloginfo('description'); ?>
					</a>
				</div>
				
				<div class="col-xs-4">
					<?php if (is_user_logged_in()) { ?>
						<?php get_template_part( 'parts/user/user', 'links' ); ?>		
					<?php } ?>
				</div>
				
			</div></div>
		</header>
			
		<!-- MAIN CONTENT START -->
		<section role="main">