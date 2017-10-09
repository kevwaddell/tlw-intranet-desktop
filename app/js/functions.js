(function($){
	
	var event_type = 'click';
	
	/* DOCUMENT READY FUNCTIONS */
	$(document).ready(function (){
		
		$('.selectpicker').selectpicker({
		style: 'btn-default',
		size: 4,
		});
		
		$('#meeting-datepicker').datetimepicker({
			format: 'dddd Do MMMM, YYYY',
			daysOfWeekDisabled: [0, 6],
			minDate: moment(),
		});
		
		$('#meeting-startpicker').datetimepicker({
			format: 'LT',
			stepping: 5,
			disabledTimeIntervals: [[moment({ h: 0 }), moment({ h: 8 })], [moment({ h: 18 }), moment({ h: 24 })]]
		});
		
		$('#meeting-endpicker').datetimepicker({
			format: 'LT',
			stepping: 5,
			useCurrent: false,
			disabledTimeIntervals: [[moment({ h: 0 }), moment({ h: 9 })], [moment({ h: 19 }), moment({ h: 24 })]]
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