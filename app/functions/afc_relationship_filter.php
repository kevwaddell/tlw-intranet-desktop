<?php 
function my_acf_result_query( $args, $field, $post )
{
	$departments_pg = get_page_by_title("Departments");

    $args['post_parent'] = $departments_pg->ID;
 
    return $args;
}

add_filter('acf/fields/relationship/query/key=field_53e8989e4c16d', 'my_acf_result_query', 10, 3);


 ?>