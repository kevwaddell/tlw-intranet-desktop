(function($){
	
	var event_type = 'click';
	
	/* DOCUMENT READY FUNCTIONS */
	$(document).ready(function (){
		
		$('#meeting-datepicker').datetimepicker({
			format: 'dddd Do MMMM, YYYY',
			minDate: moment().toNow(),
			daysOfWeekDisabled: [0, 6],
			useCurrent: false,
			minDate: moment(),
		});
		
		$('#meeting-startpicker').datetimepicker({
			format: 'H:mm',
			stepping: 30,
			disabledTimeIntervals: [[moment({ h: 0 }), moment({ h: 8 })], [moment({ h: 18 }), moment({ h: 24 })]]
		});
		
		$('#meeting-endpicker').datetimepicker({
			format: 'H:mm',
			stepping: 30,
			disabledTimeIntervals: [[moment({ h: 0 }), moment({ h: 9 })], [moment({ h: 19 }), moment({ h: 24 })]]
		});
		
		$('.add-staff-btn').on(event_type, function(){
			
			return false;
		});
		     
	});
		
})(window.jQuery);