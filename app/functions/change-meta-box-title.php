<?php 
add_action('add_meta_boxes', 'change_metabox_titles', 10, 2);
function change_metabox_titles($post_type, $post) {
    global $wp_meta_boxes; // array of defined metaboxes
   
    $wp_meta_boxes['tlw_meeting']['normal']['core']['authordiv']['title'] = 'booked by';
    $wp_meta_boxes['tlw_holiday']['normal']['core']['authordiv']['title'] = 'booked by';
    
    //echo '<pre>';print_r($wp_meta_boxes);echo '</pre>';
    // cycle through the array, change the titles you want
}
 ?>