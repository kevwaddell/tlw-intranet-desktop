<div class="data-list-key">
	
	<div class="filters<?php echo (!empty($color)) ? " col-".$color:""; ?>">
		<span><a href="<?php echo get_permalink($meetings->ID); ?>" <?php echo (!isset($_GET['sortby'])) ? " class=\"active\"":""; ?>>Today's</a></span>
		<span><a href="<?php echo get_permalink($meetings->ID); ?>?sortby=pending"<?php echo (isset($_GET['sortby']) && $_GET['sortby'] == "pending") ? " class=\"active\"":""; ?>>Pending</a></span>
		<span><a href="<?php echo get_permalink($meetings->ID); ?>?sortby=future"<?php echo (isset($_GET['sortby']) && $_GET['sortby'] == "future") ? " class=\"active\"":""; ?>>Future</a></span>
		<span><a href="<?php echo get_permalink($meetings->ID); ?>?sortby=past"<?php echo (isset($_GET['sortby']) && $_GET['sortby'] == "past") ? " class=\"active\"":""; ?>>Past</a></span>
		<span><a href="<?php echo get_permalink($meetings->ID); ?>?sortby=canceled"<?php echo (isset($_GET['sortby']) && $_GET['sortby'] == "canceled") ? " class=\"active\"":""; ?>>Canceled</a></span>
		<span><a href="<?php echo get_permalink($meetings->ID); ?>?sortby=all"<?php echo (isset($_GET['sortby']) && $_GET['sortby'] == "all") ? " class=\"active\"":""; ?>>All</a></span>
	</div>
	
</div>
