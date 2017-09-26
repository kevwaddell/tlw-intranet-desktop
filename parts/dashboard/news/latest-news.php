<?php 
$home_url = get_option('home');
$add_article_pg = get_page_by_title('Add Article');
//echo '<pre>';print_r($add_article_pg);echo '</pre>';
//echo '<pre>';print_r($events);echo '</pre>';
?>

<div class="panel-articles">

	<ul class="nav nav-tabs">
	  <li class="active"><a href="#company-news" data-toggle="tab">Company News</a></li>
	  <li class=""><a href="#office-news" data-toggle="tab">Office News</a></li>
	  <li class=""><a href="#events" data-toggle="tab">Events</a></li>
	</ul>
	
	<div class="tab-content">
		
		<div class="tab-pane active fade in" id="company-news">
		<?php get_template_part( 'parts/dashboard/news/company', 'news' ); ?>
		</div>
		
		<div class="tab-pane fade" id="office-news">
		<?php get_template_part( 'parts/dashboard/news/office', 'news' ); ?>
		</div>
		
		<div class="tab-pane fade" id="events">
		<?php get_template_part( 'parts/dashboard/news/events', 'news' ); ?>
		</div>

	</div>
	
</div>