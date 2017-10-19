(function($){
	
	var event_type = 'click';
	
	/* DOCUMENT READY FUNCTIONS */
	$(document).ready(function (){

		
		$('#reminder-datepicker').datetimepicker({
			format: 'dddd Do MMMM, YYYY',
			daysOfWeekDisabled: [0, 6],
			useCurrent: false
		});
		
		$('#reminder-timepicker').datetimepicker({
			format: 'H:mm',
			stepping: 15,
			disabledTimeIntervals: [[moment({ h: 0 }), moment({ h: 8 })], [moment({ h: 18 }), moment({ h: 24 })]]
		});
		
		$('#show-completed').on(event_type, function(){
			$(this).toggleClass('open');
			$('.completed-list').toggleClass('open');
			return false;
		});
		
		$('.view-reminder-details').on(event_type, function(){
			var parent = $(this).parents('.reminder');
			
			$(parent).siblings().removeClass('active-reminder');
			$(parent).toggleClass('active-reminder');
			
			return false;
		});
		
		$('.details').on(event_type, function(){

			$(this).parent().find('.view-reminder-details').trigger(event_type);
			
			return false;
		});

			     
	});
		
})(window.jQuery);