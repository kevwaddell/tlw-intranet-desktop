(function($){
	
	var event_type = 'click';
	
	/* DOCUMENT READY FUNCTIONS */
	$(document).ready(function (){

		
		$('.holiday-datepicker').datetimepicker({
			format: 'dddd D MMMM YYYY',
			extraFormats: [ 'YYYY-MM-DD' ],
			useCurrent: false
		}).change({
			date: $(this).find('input').val()
		});
			     
	});
		
})(window.jQuery);