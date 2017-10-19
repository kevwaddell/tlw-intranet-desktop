(function($){
	
	var event_type = 'click';
	
	/* DOCUMENT READY FUNCTIONS */
	$(document).ready(function (){
		
		$('.selectpicker').selectpicker({
		style: 'btn-default',
		size: 5,
		});
		
		$('.sml-selectpicker').selectpicker({
		style: 'btn-default btn-sm',
		size: 5,
		});
			
		/* MAIN NAV BTN FUNCTION */
		$('body').on(event_type, 'button#main-nav-btn', function(){
			
			$('body').toggleClass('nav-closed nav-open');
			$('#hidden-nav').toggleClass('nav-closed nav-open');
			$(this).toggleClass('nav-open');
			
			return false;
		});
		     
	});
		
})(window.jQuery);