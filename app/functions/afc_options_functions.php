<?php 
/*
*  Change the Options Page menu to 'Theme Options'
*/

if(function_exists('acf_add_options_page')) { 
	
	acf_add_options_page(array('page_title' => 'Theme Options Settings', 'menu_slug' => 'theme-general-settings'));
	
	acf_add_options_sub_page( array('page_title' => 'Global Admin Settings', 'menu_title' => 'Global', 'parent_slug' => 'theme-general-settings') );
	acf_add_options_sub_page( array('page_title' => 'Dashboard Panels Settings', 'menu_title' => 'Dashboard', 'parent_slug' => 'theme-general-settings') );
}

 ?>