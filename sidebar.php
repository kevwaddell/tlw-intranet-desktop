<aside class="sidebar posts">
<?php
global $slug;
global $feat_img;
global $content;
global $found_posts;

if (is_home() || is_date() || is_tag()) {
$feat_img_url = $feat_img[0];	
$feat_img_title = "TLW Solicitors";
}

if (is_category()){
//echo '<pre>';print_r($feat_img['title']);echo '</pre>';
$feat_img_url = $feat_img['sizes']['img-4-col-crop'];
$feat_img_title = $feat_img['title'];
}

global $color;
global $cat_id;
$categories = get_categories('hide_empty=0&exclude=1');
//echo '<pre>';print_r($categories);echo '</pre>';
?>

<?php if ($feat_img) { ?>
	<figure class="feat-img">
		<img src="<?php echo $feat_img_url; ?>" alt="<?php echo $feat_img_title; ?>" width="100%" height="auto">
	</figure>
<?php } ?>

<?php if (category_description() != '') : ?>
<div class="lead">
	<?php echo category_description(); ?>
</div>
<div class="rule"></div>
<?php endif; ?>

<?php if (is_home() || is_date() || is_tag() && $content) : ?>
<div class="lead">
	<?php echo $content; ?>
</div>
<div class="rule"></div>
<?php endif; ?>


<?php if (is_user_logged_in() && is_category() && current_user_can("administrator") && $slug != 'vacancies') : ?>
<div class="sidebar-actions">
	<div class="action-btns<?php echo (!empty($color)) ? " col-".$color:" col-gray"; ?>">
<?php include (STYLESHEETPATH . '/_/inc/category-page/btn-actions.php'); ?>
	</div>
</div>
<div class="rule"></div>
<?php endif; ?>

<h3 class="sb-label">
	<i class="fa fa-search"></i>
	Search
</h3>
<div class="sb-box">
	<?php get_search_form(); ?>
</div>

<?php if ($categories) { ?>
<h3 class="sb-label">
	<i class="fa fa-thumb-tack"></i>
	Categories
</h3>
<div class="sb-box">
<?php foreach ($categories as $cat) { ?>
<a href="<?php echo get_category_link( $cat->term_id ); ?>" title="View posts under <?php echo $cat->name; ?> category"<?php echo ($slug == $cat->slug) ? ' class="current-cat"':''; ?>><?php echo $cat->name; ?></a>
<?php } ?>

</div>
<?php } ?>

<?php if ($found_posts > 0) { ?>
<h3 class="sb-label">
	<i class="fa fa-calendar"></i>
	News Calendar
</h3>
<div class="sb-box">
<?php get_calendar(); ?>
</div>
<?php } ?>

</aside>