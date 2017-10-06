<?php
/*
Template Name: Department page
*/
?>
<?php 
$departments_pg = get_page_by_path( 'departments' );
$redirect = get_permalink($departments_pg->ID)."?id=".$post->ID;
wp_redirect( $redirect );
exit; 

//echo '<pre class="debug">';print_r($post);echo '</pre>';
	
?>