<div class="row">
		
<?php foreach ($query->results as $user) { 
$user_counter++;	
//echo '<pre>';print_r($query);echo '</pre>';
?>

<div class="col-xs-5ths">

	<a href="<?php echo get_author_posts_url($user->ID);?>" id="user-link-<?php echo $user_counter; ?>" title="View Profile" class="user-link<?php echo ($user_counter >= 16 && $user_counter <= $number) ? ' last-link':'';?>">
		<?php if ($user->ID == $emp_otm_user['ID']) { ?>
		<span class="eotm-tag"></span>
		<?php } ?>

        <span class="user-avatar"><?php echo get_avatar( $user->ID, 150 ); ?></span>  
        <span class="user-name"> <?php echo get_the_author_meta('first_name', $user->ID);?><br><?php echo get_the_author_meta('last_name', $user->ID);?></span>  
        
    </a>  

</div>

<?php } ?>

</div>
