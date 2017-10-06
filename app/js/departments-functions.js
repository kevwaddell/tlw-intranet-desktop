(function($){
	
	var event_type = 'click';
	
	/* DOCUMENT READY FUNCTIONS */
	$(document).ready(function (){
		
		$('#colapse-sb').on('click', function(){
			
			$('#departments-page').toggleClass('sb-in sb-out');
			$('#departments-list').toggleClass('sb-wide sb-sml');
			$(this).find('i').toggleClass('fa-arrow-circle-left fa-arrow-circle-right');
			
			return false;
		});
		     
	});
		
})(window.jQuery);