(function($){
	
	var event_type = 'click';
	
	/* DOCUMENT READY FUNCTIONS */
	$(document).ready(function (){
		
		$('#show-completed').on(event_type, function(){
			$(this).toggleClass('open');
			$('.completed-list').toggleClass('open');
			return false;
		});
			     
	});
		
})(window.jQuery);