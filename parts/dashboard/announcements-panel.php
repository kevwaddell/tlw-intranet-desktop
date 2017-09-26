<?php
$home_url = get_option('home');
$add_announcement_pg = get_page_by_title('Add Announcement');
$an_cat_id = get_cat_ID( 'Announcements' );
$announcement_args = array(
	'posts_per_page'   => 1,
	'cat'  => $an_cat_id
);	

$announcements = get_posts($announcement_args);
?>

<div class="announce-content">

<?php if ($announcements) { ?>

<?php 
  global $post;
  foreach ($announcements as $post) : 
  setup_postdata($post);  
  //echo '<pre>';print_r($img_url);echo '</pre>';
  ?>
  <h3><?php the_title(); ?></h3>
  <?php the_excerpt(); ?>
  <a href="<?php the_permalink(); ?>">View Details</a>		
  
 <?php 
 
 endforeach; 
 wp_reset_postdata(); 
 ?>


<?php } else { ?>
<div class="well text-center" style="margin-bottom: 0px;">There are no <strong>Announcements</strong> at the moment.</div>
<?php } ?>


</div>

<div class="panel-btns">
	<?php if ($announcements) { ?>
	<a href="<?php echo get_category_link( $an_cat_id ); ?>" class="btn btn-default btn-block"><i class="fa fa-eye fa-lg"></i>All Announcments</a>
	<?php } ?>
	
	<?php if (is_user_logged_in() && current_user_can("administrator")) { ?>
	<a href="<?php echo get_permalink($add_announcement_pg->ID); ?>?httpref=<?php echo $home_url; ?>" class="btn btn-default btn-block"><i class="fa fa-plus-circle fa-lg"></i>Submit an Announcment</a>
	<?php } ?>
</div>