<?php 
$meetings_pg = get_page_by_path( 'meetings' );
$redirect = get_permalink($meetings_pg->ID);
wp_redirect( $redirect );
exit; 

//echo '<pre class="debug">';print_r($post);echo '</pre>';
	
?>