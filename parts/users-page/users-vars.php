<?php 
$excluded_users = array(1, 60);
$all_users_args = array(
'exclude'	=> $excluded_users,
'meta_key' => 'last_name',
'orderby'	=> 'meta_value'
);
$all_users = get_users($all_users_args);
$total_users = count($all_users);
//echo '<pre class="debug">';
foreach ($all_users as $u) {
$firstname = get_user_meta($u->ID, 'first_name', true);
$lastname = get_user_meta($u->ID, 'last_name', true);
//print_r($u);
}
//echo '</pre>';
//echo '<pre>';print_r($total_users);echo '</pre>';
?>