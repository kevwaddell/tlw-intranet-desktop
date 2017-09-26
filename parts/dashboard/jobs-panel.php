<?php
$vac_cat_id = get_cat_ID( 'Vacancies' );
$announcement_args = array(
	'posts_per_page'   => -5,
	'cat'  => $vac_cat_id
);	

$vacancies = get_posts($announcement_args);
?>

<div class="vacancies-content">

<?php if ($vacancies) { ?>

<?php 
  global $post;
  foreach ($vacancies as $post) : 
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
<div class="well text-center"  style="margin-bottom: 0px;">There are no <strong>Vacancies</strong> at the moment.</div>
<?php } ?>


</div>

<div class="panel-btns">
	<?php if ($vacancies) { ?>
	<a href="<?php echo get_category_link( $vac_cat_id ); ?>" class="btn btn-default btn-block"><i class="fa fa-eye fa-lg"></i>All Vacancies</a>
	<?php } ?>
</div>