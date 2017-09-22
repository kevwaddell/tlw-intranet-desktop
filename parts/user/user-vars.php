<?php
$curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
$emp_otm_user = get_field('employee_otm', 'options');
global $current_user;
/*
echo '<pre>';
print_r($curauth);
echo '</pre>';
*/
get_currentuserinfo();
$user_meta = get_user_meta($curauth->ID);
$nickname = $user_meta['nickname'][0];
$firstname = $user_meta['first_name'][0];
/*
echo '<pre>';
print_r($user_meta['nickname'][0]);
echo '</pre>';
*/
//echo '<pre>';print_r($curauth);echo '</pre>';
$now_date = new DateTime(date('l jS F Y'));
$user_start_date_raw = get_field('user_start_date', 'user_'.$curauth->ID);
$user_start_date = date("l jS F Y", strtotime($user_start_date_raw));
$user_s_date = new DateTime($user_start_date);
//$user_allocated_holidays = get_the_author_meta( "allocated_holidays", $curauth->ID );
//$user_crossover_holidays = get_the_author_meta( "crossover_holidays", $curauth->ID );
//$user_total_holidays = get_the_author_meta( "total_holidays", $curauth->ID );
//$user_holidays = get_the_author_meta( "number_of_holidays", $curauth->ID );
//$extra_days = get_the_author_meta('extra_holidays', $curauth->ID);

$start_of_year = strtotime( "01/01/".date("Y") );
$end_of_year = strtotime( date('d/m/Y', $start_of_year)." +1 year" );
$end_of_nxt_year = strtotime( date('d/m/Y', $end_of_year)." +1 year" );
$today = strtotime("today");

/* USER HOLIDAYS CHECK */
//if (current_user_can("subscriber") || current_user_can("editor") || current_user_can("administrator") || $current_user->ID == $hb_admin['ID']) {

//include (STYLESHEETPATH . '/_/inc/user/holidays-check-init.php');

//include (STYLESHEETPATH . '/_/inc/user/extra_days_code.php');

//include (STYLESHEETPATH . '/_/inc/user/holidays-check.php');

//echo '<pre>';print_r($extra_days);echo '</pre>';

//}
/* END OF USER HOLIDAYS CHECK */

$user_job_title = get_the_author_meta( "job_title", $curauth->ID );
$user_department = get_the_author_meta( "department", $curauth->ID );
$extention = get_the_author_meta( "extension", $curauth->ID );
//echo '<pre>';print_r($extention);echo '</pre>';
$job_description = get_the_author_meta( "description", $curauth->ID );
$user_name = get_the_author_meta( "user_login", $curauth->ID );
$user_first_name = get_the_author_meta( "first_name", $curauth->ID );
$user_display_name = get_the_author_meta( "display_name", $curauth->ID );
$user_id = get_the_author_meta( "ID", $curauth->ID );
$user_email = get_the_author_meta( "user_email", $curauth->ID );
//echo '<pre>';print_r($user_id);echo '</pre>';
$rb_admin = get_field('rb_admin', 'options');
$hb_admin = get_field('hb_admin', 'options');
$partners = get_field('tlw_partners', 'options');
//echo '<pre>';print_r($hb_admin);echo '</pre>';
/*
if (in_array_r($current_user->ID, $partners)) {
echo '<pre>';print_r($partners);echo '</pre>';	
}
*/
?>