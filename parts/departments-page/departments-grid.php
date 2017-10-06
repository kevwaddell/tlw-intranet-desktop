<?php 
global $children;
global $active_department;
?>
<?php foreach ($children as $child) { ?>
<?php
$icon = get_field( 'icon', $child->ID );
?>
<li>
	<a href="?id=<?php echo $child->ID; ?>" id="department-<?php echo $child->ID; ?>" class="grid-list-item<?php echo($child->ID == $_GET['id'] || $child->ID == $active_department->ID) ? ' active':''; ?>">
		<i class="fa <?php echo $icon; ?> fa-5x"></i>
		<span class="title"><span><?php echo get_the_title( $child->ID ); ?></span></span>
	</a>
</li>
<?php } ?>


