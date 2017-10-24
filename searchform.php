<div class="search-form">

	<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">

		<input type="search" value="<?php the_search_query(); ?>" placeholder="Search…" class="search-query form-control text-center" name="s" id="s" />
				
		<div class="action-btns col-gray">
			<input type="submit" id="searchsubmit" value="Go" class="search-submit btn btn-default btn-block" />
		</div>
	</form>

</div>
