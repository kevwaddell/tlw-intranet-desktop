<?php 
$excluded_users = array(1, 60);
$include_users = array();
$emp_otm_user = get_field('employee_otm', 'options');
$staff_members_pg = get_page_by_title('Staff Members');
$departments_pg = get_page_by_title("Departments");
$departments = get_pages('sort_column=post_title&parent='.$departments_pg->ID);
$job_titles = array();
//echo '<pre>';print_r($job_titles);echo '</pre>';
$all_users_args = array(
'exclude'	=> $excluded_users
);
$all_users 	= get_users($all_users_args);

foreach ($all_users as $u) {
$job_title = get_the_author_meta( "job_title", $u->ID );
$department = get_the_author_meta( "department", $u->ID );
//print_r($u->caps);echo '<br>';
	if (empty($u->roles)) {
	//print_r($u->ID);echo '<br>';
	array_push($excluded_users, $u->ID);
	} else {
		if (!in_array($job_title, $job_titles)) {
		array_push($job_titles, $job_title);
		}	
		
		if (isset($_GET['by-department'])) {
			if ($department[0] == $_GET['by-department']) {
			array_push($include_users, $u->ID);	
			}	
		}
		
		if ( isset($_GET['by-name']) ) {
			if ($u->ID == $_GET['by-name']) {
			array_push($include_users, $u->ID);	
			}	
		}
		
		if ( isset($_GET['by-job-title']) ) {
			if ($job_title == $_GET['by-job-title']) {
			array_push($include_users, $u->ID);	
			}	
		}
	}
}

//echo '<pre>';print_r($job_titles);echo '</pre>';


$number 	= 15;
$paged 		= (get_query_var('paged')) ? get_query_var('paged') : 1;
$offset 	= ($paged - 1) * $number;

$users_args = array(
'exclude'	=> $excluded_users
);

$select_users 	= get_users($users_args);

if (!empty($include_users)) {
$users_args['include'] = $include_users;
$number = count($include_users);
}
$users 	= get_users($users_args);

/*
echo '<pre>';
print_r($users);
echo '</pre>';
*/

$query_args = array(
'offset'	=> $offset,
'number'	=> $number,
'exclude'	=> $excluded_users,
'meta_key'	=> 'last_name',
'orderby'	=> 'meta_value'
);

if (!empty($include_users)) {
$query_args['include'] = $include_users;
}

$query 	= new WP_User_Query($query_args);
//echo '<pre>';print_r($query_args);echo '</pre>';

$total_users = count($users);
$total_query = count($query->total_users);
$total_pages = intval($total_users / $number) + 1;
$user_counter = 0;
//echo '<pre>';print_r($users);echo '</pre>';
$icon = get_field('icon');
$color = get_field('col');
?>