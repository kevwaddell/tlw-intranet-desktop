<?php
/* Sort posts in wp_list_table by column in ascending or descending order. */
if(is_admin()){

function custom_post_order($query){

    $post_type = $query->get('post_type');
	
	//echo '<pre>';print_r($query);echo '</pre>';
    
    if($post_type == 'tlw_meeting'){
    
        /* Post Column: e.g. title */
        if($query->get('orderby') == ''){
        	 $query->set('meta_key', 'meeting_date');
        	$query->set('orderby', 'meta_value_num');
        }
        /* Post Order: ASC / DESC */
        if($query->get('order') == ''){
            $query->set('order', 'DESC');
        }
    }
    
     if($post_type == 'tlw_holiday'){
    
        /* Post Column: e.g. title */
        if($query->get('orderby') == ''){
        	 $query->set('meta_key', 'holiday_start_date');
        	$query->set('orderby', 'meta_value_num');
        }
        /* Post Order: ASC / DESC */
        if($query->get('order') == ''){
            $query->set('order', 'DESC');
        }
    }
}

add_action('pre_get_posts', 'custom_post_order');

}

 ?>