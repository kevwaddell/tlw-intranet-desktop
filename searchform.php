<div class="search-form">

	<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
	
		<?php if (is_category()) { ?>
		<input type="hidden" name="post_type" value="post" />
		<?php } ?>

		<input type="search" value="<?php the_search_query(); ?>" placeholder="Search…" class="search-query form-control text-center" name="s" id="s" />
		
		<?php if (is_search()) { ?>
		<div class="form-group form-inline text-center">
			<div class="radio">
			  <label><input type="radio" name="type" id="type-all" value="all"<?php echo (!isset($_GET['type']) || $_GET['type'] == 'all') ? ' checked="checked"':'' ; ?>> All</label>
			</div>
			
			<div class="radio">
			  <label><input type="radio" name="type" id="type-office-news" value="office-news"<?php echo (isset($_GET['type']) && $_GET['type'] == 'office-news') ? ' checked="checked"':'' ; ?>> Office News</label>
			</div>
			
			<div class="radio">
			  <label><input type="radio" name="type" id="type-company-news" value="company-news"<?php echo (isset($_GET['type']) && $_GET['type'] == 'company-news') ? ' checked="checked"':'' ; ?>> Company News</label>
			</div>
			
			<div class="radio">
			  <label><input type="radio" name="type" id="type-events" value="events"<?php echo (isset($_GET['type']) && $_GET['type'] == 'events') ? ' checked="checked"':'' ; ?>> Events</label>
			</div>
			
			<div class="radio">
			  <label><input type="radio" name="type" id="type-announcements" value="announcements"<?php echo (isset($_GET['type']) && $_GET['type'] == 'announcements') ? ' checked="checked"':'' ; ?>> Announcements</label>
			</div>
			
			<div class="radio">
			  <label><input type="radio" name="type" id="type-meetings" value="meetings"<?php echo (isset($_GET['type']) && $_GET['type'] == 'meetings') ? ' checked="checked"':'' ; ?>> Meetings</label>
			</div>
			
			<div class="radio">
			  <label><input type="radio" name="type" id="type-documents" value="documents"<?php echo (isset($_GET['type']) && $_GET['type'] == 'documents') ? ' checked="documents"':'' ; ?>> Documents</label>
			</div>
			
			<div class="radio">
			  <label><input type="radio" name="type" id="type-procedures" value="procedures"<?php echo (isset($_GET['type']) && $_GET['type'] == 'procedures') ? ' checked="procedures"':'' ; ?>> Procedures</label>
			</div>
		</div>
		<?php } ?>
		
		<div class="action-btns col-gray">
			<input type="submit" id="searchsubmit" value="Go" class="search-submit btn btn-default btn-block" />
		</div>
	</form>

</div>
