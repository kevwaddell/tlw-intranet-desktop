
		</div>
		<!-- MAIN CONTENT END -->
		
		<!-- USER ACTIONS -->
		<?php include (STYLESHEETPATH . '/_/inc/global/user-actions.php'); ?>
		<!-- USER ACTIONS END -->
		
		<div id="log-in-alert" class="modal fade">
		  
		  <div class="modal-dialog modal-sm">
		   
		    <div class="modal-content">
		      
		      <div class="modal-header">
		      	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		        <h4 class="modal-title">Login</h4>
		      </div>
		      
		      <div class="modal-body">
		     	 <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('User actions') ) : ?><?php endif; ?></div>
			 </div><!-- /.modal-content -->
		    
		  </div><!-- /.modal-dialog -->
		  
		</div>
		
		<?php include (STYLESHEETPATH . '/_/inc/global/loader.php'); ?>
						
		<?php wp_footer(); ?>

	</body>
</html>