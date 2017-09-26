<?php

	add_filter('post_row_actions','tlw_custom_post_row_actions');
    
    function tlw_custom_post_row_actions($actions) {
    //echo '<pre>';print_r(get_post_type());echo '</pre>';
    
	    if( get_post_type() === 'tlw_holiday' ) {
	        unset( $actions['inline hide-if-no-js'] );
	    }
	    
	    if( get_post_type() === 'tlw_meeting' ) {
	        unset( $actions['inline hide-if-no-js'] );
	    }
	    
		return $actions;
	}
	
?>