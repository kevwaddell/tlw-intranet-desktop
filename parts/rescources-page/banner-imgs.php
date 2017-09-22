<?php 
$banner_img_left = get_field('left_img');
$banner_img_mid = get_field('mid_img');
$banner_img_right = get_field('right_img');

$banner_imgs = get_field('banner_imgs');
//echo '<pre>';print_r($banner_imgs);echo '</pre>';
?>

<?php if (!empty($banner_imgs)) { 
$total_imgs = count($banner_imgs);
//echo '<pre>';print_r($total_imgs);echo '</pre>';
?>

<div class="banner-imgs">
	
	<?php if ($total_imgs > 1) { ?>
	<div class="row">
		<?php foreach ($banner_imgs as $img) { 
		$img_url = $img['banner_img']['sizes']['img-6-col-crop'];
		//echo '<pre>';print_r($img_url);echo '</pre>';
		?>
		<?php if ($total_imgs > 2) { 
		$img_url = $img['banner_img']['sizes']['img-4-col-crop'];	
		?>
		<div class="col-xs-4">
		<?php } else { ?>
		<div class="col-xs-6">
		<?php } ?>
			<figure class="img">
				<img src="<?php echo $img_url; ?>" width="100%">
			</figure>
		</div>
		<?php } ?>
			
	</div>
	<?php } else { 
	$img_url = $banner_imgs[0]['banner_img']['sizes']['img-12-col-crop'];	
	?>
		<figure class="img">
			<img src="<?php echo $img_url; ?>" width="100%">
		</figure>
	<?php } ?>
	
	
</div>


<?php } ?>