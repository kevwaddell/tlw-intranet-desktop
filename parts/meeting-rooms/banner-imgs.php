<?php 
$args = array( 'hide_empty' => 0 );
$rooms = get_terms('tlw_rooms_tax', $args);
//echo '<pre>';print_r($rooms);echo '</pre>';
 ?>

<?php if ($rooms) { ?>

<div class="banner-imgs">
	<div class="row">
		<?php foreach ($rooms as $room) { 
		$feat_img = get_field('img', $room->taxonomy.'_'.$room->term_id);	
		$img_url = $feat_img['sizes']['img-4-col-crop'];
		//echo '<pre>';print_r($img_url);echo '</pre>';
		?>
		<div class="col-xs-4">
			<figure class="img">
				<img src="<?php echo $img_url; ?>" width="100%">
				<figcaption><?php echo $room->name; ?></figcaption>
			</figure>
			
		</div>
		<?php } ?>
			
	</div>
</div>

<?php } ?>