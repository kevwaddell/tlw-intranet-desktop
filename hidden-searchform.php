<div class="search-form">

	<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">

		<input type="search" value="<?php the_search_query(); ?>" placeholder="Search…" class="search-query form-control" name="s" id="s" />
		
		<div class="radio">
		  <label><input type="radio" name="type" id="type-all" value="all" checked>All</label>
		</div>
		
		<div class="radio">
		  <label><input type="radio" name="type" id="type-office-news" value="office-news">Office News</label>
		</div>
		
		<div class="radio">
		  <label><input type="radio" name="type" id="type-company-news" value="company-news">Company News</label>
		</div>
		
		<div class="radio">
		  <label><input type="radio" name="type" id="type-events" value="events">Events</label>
		</div>
		
		<div class="radio">
		  <label><input type="radio" name="type" id="type-announcements" value="announcements">Announcements</label>
		</div>
		
		<div class="radio">
		  <label><input type="radio" name="type" id="type-meetings" value="meetings">Meetings</label>
		</div>
		
		<div class="radio">
		  <label><input type="radio" name="type" id="type-documents" value="documents">Documents</label>
		</div>
		
		<div class="radio">
		  <label><input type="radio" name="type" id="type-procedures" value="procedures">Procedures</label>
		</div>
		
		<div class="action-btns col-gray">
			<input type="submit" id="searchsubmit" value="Go" class="search-submit btn btn-default btn-block" />
		</div>
	</form>

</div>
