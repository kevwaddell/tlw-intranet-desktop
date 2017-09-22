(function($){
	
	var event_type;
	var ajaxLoading = false;
	
	if (Modernizr.touch){
	
	 event_type = 'touchstart';
	  
	} else {
	 
	 event_type = 'click';	
	 
	}
    
    $('.scrollable').slimScroll({
        height: 'auto',
        alwaysVisible: true,
        railVisible: true
    });
    
      
    if ( $('input.date-picker').length > 0) {
	    $('input.date-picker').datepicker({
        // Consistent format with the HTML5 picker
        format: 'DD d MM yyyy',
        weekStart: 1,
        todayHighlight: true
		});
    }
    
    if ( $('input.timepicker').length == 1) {
     $('input.timepicker').timepicker();
     }
     
     if ($('select.selectpicker').length > 0) {
	 	$('select.selectpicker').selectpicker({'size': 10}); 
	 }
    
    $('#ooo-carousel').carousel('pause');
    
   /* EMPLOYEE OF THE MONTH FUNCTION */
   
   // VIEW RESULTS BTN
   $('body').on(event_type, '.panel-btns a.panel-action-btn', function(){
	console.log($(this));
	var params = $(this).attr("href");
    var href = window.location.href;
    var parent = $(this).parents('.panel-content');
    
    	//$('.loader').fadeIn('fast');
     	
     	//$('.alerts').empty();
     	//console.log(href);
     	
     	$(parent).load(href+params+" .dash-panel-inner", function(data){
	     
	     $(this).find('.dash-panel-inner').hide().fadeIn('slow');
	     //$('.loader').fadeOut('fast');

     	});
	   
   return false;   
   });
    
	/* ATTENDEE FORM ACTION */
	
	$('body').on('change', 'select#attendee_type', function(){
	
		var val = $(this).val();
		
		if (val == "0") {
			$("#internal_attendee").removeClass('visible').addClass('hidden');
			$("#internal_attendee").find('select').prop('selectedIndex',0);
			
			$("#external_attendee").removeClass('visible').addClass('hidden');
			$("#external_attendee").find('input[type="text"]').val("");
		
		}
		
		if (val == "internal") {
			$("#internal_attendee").removeClass('hidden').addClass('visible');	
			$("#internal_attendee").find('select').prop('selectedIndex',0);
			
			$("#external_attendee").removeClass('visible').addClass('hidden');
			$("#external_attendee").find('input[type="text"]').val("");
		}
		
		if (val == "external") {
			$("#internal_attendee").removeClass('visible').addClass('hidden');
			$("#internal_attendee").find('select').prop('selectedIndex',0);
			
			$("#external_attendee").removeClass('hidden').addClass('visible');
			$("#external_attendee").find('input[type="text"]').val("");
		}
		
	});
	
	$('body').on(event_type,'button#links-dropdown-btn', function(e){
    
    var parent = $(this).parents('.links-dropdown');
    
    parent.toggleClass('inactive active');
    
   	return false;
    });
    
    $('body').on(event_type,'button.close-panel-btn', function(e){
    
    var parent = $(this).parent();
    
    	if (parent.hasClass('panel-closed')) {
    	parent.removeClass('panel-closed').addClass('panel-open');
    	} else {
	    parent.removeClass('panel-open').addClass('panel-closed');	
    	}
    
   	return false;
    });
    
     $('body').on(event_type,'button.close-details-btn', function(e){
    
    var parent = $(this).parent();
    
    	if (parent.hasClass('details-closed')) {
    	parent.removeClass('details-closed').addClass('details-open');
    	} else {
	    parent.removeClass('details-open').addClass('details-closed');	
    	}
    
   	return false;
    });
    
    $('body').on(event_type,'button.close-section-btn', function(e){
    
    var parent = $(this).parent();
    $('button.close-section-btn').not(this).parent().removeClass('section-open').addClass('section-closed');
    
    	if (parent.hasClass('section-closed')) {
    	parent.removeClass('section-closed').addClass('section-open');
    	$.scrollTo(parent, 500);
    	} else {
	    parent.removeClass('section-open').addClass('section-closed');	
    	}
    
   	return false;
    });
    
     $('body').on(event_type,'.notifications > button', function(e){
     
     	var messages = $(this).next();
     	
     	if (messages.hasClass('messages-hidden')) {
	    messages.removeClass('messages-hidden').addClass('messages-show');	
     	} else {	
	    messages.removeClass('messages-show').addClass('messages-hidden');		
     	}
     
     	//console.log($(this));
     
    return false;
    });
    
   /*  USER BTNS */
   
   $('body').on(event_type,'button.user-btn', function(e){
    	
    	var current_id = $(this).attr('id');
    	var current_box = $("#"+current_id+"-box");
    	
    	$(this).siblings().removeClass('active');
    	$(this).removeClass('active');
    	
    	if ($('.user-actions').hasClass('actions-closed')) {
    		
    		$(this).addClass('active');
	    	$('.user-actions').removeClass('actions-closed').addClass('actions-open');
	    	
	    	if ($(current_box).is(':hidden') ) {	
    		
    			$(current_box).fadeIn('slow');
    			
    		} else {
	    		
	    		$(current_box).fadeOut('fast');	
	    		
    		}
	    	
    	} else {
    	
    		if ( $(current_box).is(':hidden') ) {	
    			
    			$(this).addClass('active');
    			
    			$('.user-actions-wrap').hide();
    			$(current_box).fadeIn('slow');
    			
    		} else {
	    		
	    		$(current_box).fadeOut('fast');	
	    		$('.user-actions').removeClass('actions-open').addClass('actions-closed');
	    		
    		}
	    	
	    	
    	}
    	
    	
    	return false;
    });
    
    $('body').on(event_type,'button.favs-btn', function(e){
    
    var list = $(this).next();
    var height = list.find('.user-favs-list').height();
    
    $('button.favs-btn').not(this).removeClass('active');
    $('.list-open').not(list).removeClass('list-open').addClass('list-closed');
    
    $(this).toggleClass('active'); 
    $(list).toggleClass('list-open list-closed'); 
    
    //console.log(height);
    
    $(list).find('.user-favs-list-outer').slimScroll({
    	 height: height+'px',
        alwaysVisible: true
    });
    
    return false;
    });
    
    $('#accordion').on('shown.bs.collapse', function () {
	    var current = $(this).find('div.in');
	    var panel_feed = current.find('.panel-feed-wrap');
	    var height = panel_feed.height();
	    
	    console.log($(this));
		console.log(current);
		console.log(panel_feed.length); 
		console.log(height); 
		
		if (panel_feed.length > 0 && height > 190) {
			$('.panel-feed-wrap').slimScroll({
			 height: height+'px',
			alwaysVisible: true
			});
		}
		
	})
    
    // EDIT PROFILE BTN
    
    $('body').on(event_type,'a.edit-profile', function(){
    
    var parent = $(this).parent();
    var input = $(this).parent().prev();
    
    $(parent).toggleClass('visible hidden');
    $(input).toggleClass('hidden visible');
   
    console.log(parent);
    console.log(input);
       
   	return false;
    });
    
    
    /* 
	 *
	 *
	 *
	 ACTION AND REQUEST FUNCTIONS 
	 - Alert requests and actions
	 - Table button requests
	 - Action button requests
	 *
	 *
	 */
	
	/* MEETING EDIT FORM */
	$('body').on('submit', 'form#edit_meeting_form', function() {
		 
		 var action = $(this).attr('action');
		 
		// console.log(action);
		 
		 $.post( action, $(this).serialize(), function( data ) {
		 	
		 	$('.alerts').empty();
		 	$('.page-section').empty();
		 	$('.loader').fadeIn('fast');
		 	
		 }).done(function(data){
			
			$('.loader').fadeOut('fast');
			var alert = $( data ).find('.actions-wrap');
			var lists = $( data ).find('.lists-wrap');
			
			$(alert).appendTo('.alerts').hide().fadeIn('slow');
			$(lists).appendTo('.page-section');
			 
		 });
		 
		 return false;
	});
	
	/* HOLIDAY FORM ALL DAY SELECT MENUS */
	$('body').on('change', 'input[name="day_amount"]', function(e){
		var end_date_input = $('input#holiday_end_date').parents('.form-group');
		var am_pm_radio = $('input[name="day_time"]').parent();
		var start_half_day = $('input[name="start_half_day"]');
		var val = $(this).val();
		//console.log(val);
		
		if (val=='multiple') {
		end_date_input.removeClass('hidden');
			
			if ( am_pm_radio.is(':visible') || start_half_day.is(':checked') ) {
			am_pm_radio.addClass('hidden');		
			}	
			
		}
		
		if (val=='single') {
		end_date_input.addClass('hidden');	
			
			if (start_half_day.is(':checked')) {
			am_pm_radio.removeClass('hidden');		
			}
		}	
		
	});
	
	$('body').on('change', 'input[name="start_half_day"]', function(e){
		var am_pm_radio = $('input[name="day_time"]').parent();
		var day_amount = $('input#day_amount_single');
		//console.log(e);
		
		if ( am_pm_radio.is(':hidden') && day_amount.is(':checked')) {
		am_pm_radio.removeClass('hidden');	
		} else {
		am_pm_radio.addClass('hidden');		
		}
		
	});
	
	/* TABLE LOADER BUTTON */
	 $('body').on(event_type,'tr.actions-tr a.action-btn', function(e){
     	
     	var params = $(this).attr("href");
     	var href = window.location.href;
     	
     	$('.loader').fadeIn('fast');
     	
     	$('.alerts').empty();
     	//console.log(href);
     	
     	$('.alerts').load(href+params+" .actions-wrap", function(data){
	     
	     $(this).find('.alerts-wrap').hide().fadeIn('slow');
	     $('.loader').fadeOut('fast');
	     
	      if ( $(this).find('input.date-picker').length > 0) {
		    $('input.date-picker').datepicker({
	        // Consistent format with the HTML5 picker
	        format: 'DD d MM yyyy',
	        weekStart: 1,
	        todayHighlight: true,
	        daysOfWeekDisabled: "0,6"
			});
		 }
	     	
     	});
     	
     	return false;
     });
     
     	/* BUTTON ACTIONS LOADER BUTTON */
	 $('body').on(event_type,'.alert a.btn-action', function(e){
     	
     	var params = $(this).attr("href");
     	var href = window.location.href;
     	
     	//console.log(href);
     	
     	$('.alerts').empty();
     	//console.log(href);
     	$('.loader').fadeIn('fast');
     	
     	$('.alerts').load(href+params+" .actions-wrap", function(data){
	     
	     $(this).find('.alerts-wrap').hide().fadeIn('slow');
	     $('.loader').fadeOut('fast');
	     
	     if ( $(this).find('input.date-picker').length > 0) {
		    $('input.date-picker').datepicker({
	        // Consistent format with the HTML5 picker
	        format: 'DD d MM yyyy',
	        weekStart: 1,
	        todayHighlight: true,
	        daysOfWeekDisabled: "0,6"
			});
		 }
	     	
     	});
     	
     	return false;
     });
     
      /* CANCEL BUTTON */
      
      $('body').on(event_type,'a.cancel-btn', function(e){
     	
     	var query = window.location.search;
     	
     	//console.log(query.length);
     	
     	if (query.length == 0) {
	    
		    $('.alerts').find('.actions-wrap').fadeOut('slow', function(){
	    		$('.alerts').empty();
			});
	     	
	 	return false;

     	}
 
     });
    
     /* ADD POST CANCEL BUTTON */
     $('body').on(event_type,'.alert button.close-btn', function(e){
	    
	   $('.alerts').find('.actions-wrap').fadeOut('slow', function(){
	    	$('.alerts').empty();
     	});
	     	
	 	return false;
 
     });

     
     /* REFRESH BUTTON */
      $('body').on(event_type,'.alert a.refresh', function(e){
     	
     	var href = $(this).attr("href");
     	var query = window.location.search;
     	
     	if (query.length == 0) {
	    
		    $('.alerts').fadeOut('slow', function(){
		     $('.alerts').empty();	
	     	});
     	
	     	$('.page-section').load(href+" .lists-wrap", function(data){
		     
		     $(this).find('.lists-wrap').hide().fadeIn('slow');
		     	
	     	});
	 	
	 	return false;

     	}
 
     });
     
    /*  EDIT MEETING BUTTON */
    
     $('body').on(event_type,'.action-btns a.edit-meeting', function(e){
     	
     	var params = $(this).attr("href");
     	var href = window.location.href;
     	
     	$('.loader').fadeIn('fast');
	    
	    $('.meeting-details').load(href+params+" .meeting-details-wrap", function(data){
	     
	     $(this).find('.meeting-details-wrap').hide().fadeIn('slow');
	     $('.loader').fadeOut('fast');
	     
	     if ( $(this).find('input#meeting_date').length > 0) {
		    $('input#meeting_date').datepicker({
	        // Consistent format with the HTML5 picker
	        format: 'DD d MM yyyy',
	        weekStart: 1,
	        todayHighlight: true,
	        daysOfWeekDisabled: "0,6"
			});
		 }
	     	
     	});
     	
	 	return false;
 
     });
     
      /* ACTION BUTTONS */
      
      $('body').on(event_type,'.action-btns a.btn-action', function(e){
      
     	
     	var params = $(this).attr("href");
     	var href = window.location.href;
     	
     	//console.log(href+params);
     	
     	$('.loader').fadeIn('fast');
     	$('.alerts').empty();
     	
     	console.log($('.alerts').length);
	    
	 	$('.alerts').hide().load(href+params+" .actions-wrap", function(data, status, xhr){
	 	
	 	//alert(status);
	 	$(this).fadeIn('fast');
	 	
	 	if (status == "success") {
		 $('.loader').fadeOut('fast');
	     
	      if ( $(this).find('input.date-picker').length > 0) {
		    $('input.date-picker').datepicker({
	        // Consistent format with the HTML5 picker
	        format: 'DD d MM yyyy',
	        weekStart: 1,
	        todayHighlight: true,
	        daysOfWeekDisabled: "0,6"
			});
		 }
		 
		 if ($(this).find('select.selectpicker').length > 0) {
		 $('.selectpicker').selectpicker({'size': 10}); 
		 }
     
	 	}
	
     	});   
     	  	
	 	return false;
 
     });
     
     /* POST ACTION BUTTONS */
      
      $('body').on(event_type,'.post-actions a.btn-action', function(e){
     	
     	var params = $(this).attr("href");
     	var href = window.location.href;
     	
     	$('.loader').fadeIn('fast');	
     	$('.alerts').empty();
     	    
	 	$('.alerts').hide().load(href+params+" .actions-wrap", function(data, status, xhr){
	     
	    $(this).fadeIn('fast');
	     
	     if (status == "success") {
	     
	     $('.loader').fadeOut('fast');
	     
		     if ( $(this).find('input.date-picker').length > 0) {
			    $('input.date-picker').datepicker({
		        // Consistent format with the HTML5 picker
		        format: 'DD d MM yyyy',
		        weekStart: 1,
		        todayHighlight: true,
		        daysOfWeekDisabled: "0,6"
				});
			 }
			 
			 if ($(this).find('select.selectpicker').length > 0) {
			 $('.selectpicker').selectpicker({'size': 10}); 
			 }
		 
		 }

     	});   
     	  	
	 	return false;
 
     });

     
     /* FILTER BTNS */
     $('body').on(event_type,'.filters a', function(e){
		 
		 var href = $(this).attr("href");
		 
		 var section_inner_id = $(this).closest('div.section-inner').attr('id');
		 var section_wrap_id = $(this).closest('div.section-wrap').attr('id');
		 
		 $("#"+section_inner_id).load(href+" #"+section_wrap_id, function(data){
		 
		 //console.log(data);
		     
		   $(this).find('#'+section_wrap_id).hide().fadeIn('slow');
		     	
	     });
    
	 return false;
 
     });
     
      /*  PAGINATION BTNS */
     
      $('body').on(event_type,'.pagination-actions a', function(e){
		 
		 var href = $(this).attr("href");
		 
		 var section_inner_id = $(this).closest('div.section-inner').attr('id');
		 var section_wrap_id = $(this).closest('div.section-wrap').attr('id');
		 
		  $("#"+section_inner_id).load(href+" #"+section_wrap_id, function(data){
		 
		 //console.log(data);
		     
		   $(this).find('#'+section_wrap_id).hide().fadeIn('slow');
		   
		     	
	     });
	       
	 return false;
 
     });
     
     /* USER FILTER SELECT FIELDS */
      $('body').on('change', 'select.selectpicker', function(e){
	     
	     var form = $(this).parents('form');
	     var action = form.attr('action');
	     
	     $('.list-loader').fadeIn('fast');
	     
	     console.log(action);
		 
		 $.get( action, form.serialize()).done(function(data){
			
			var list = $( data ).find('.user-list-inner');
			var picker = $(list).find('select.selectpicker');
			
			 if ($(picker).length > 0) {
				 $(picker).selectpicker({'size': 10}); 
	 		 }
			
			$('.user-list').empty();
			$(list).appendTo('.user-list');
			
			$('.list-loader').fadeOut('fast');
			 
		 });
	   
	 return false;
     });


     /* STAFF MEMBERS PAGINATION BTNS */
      $('body').on(event_type,'.user-pag a', function(e){
		 
		 var href = $(this).attr("href");
		 
		 $('.list-loader').fadeIn('fast');
		 
		 $('.user-list').load(href+" .user-list-inner", function(data){
			 
			$('.list-loader').hide();
		     
		   $(this).find('.user-list-inner').hide().fadeIn('slow');
		   
		    if ($(this).find('select.selectpicker').length > 0) {
			$(this).find('select.selectpicker').selectpicker({'size': 10}); 
	 		}
		     	
	     });
    
	 return false;
 
     });
     
     /* LIST TYPE BUTTONS */
     
     $('body').on(event_type,'.filter-actions a', function(e){
		 
		 var href = $(this).attr("href");
		 
		  $('.list-loader').fadeIn('fast');
		 
		 $('.user-list').load(href+" .user-list-inner", function(data){
			 
			$('.list-loader').hide();
		     
		   $(this).find('.user-list-inner').hide().fadeIn('slow');
		   
		    if ($(this).find('select.selectpicker').length > 0) {
			$(this).find('select.selectpicker').selectpicker({'size': 10}); 
	 		}
		     	
	     });
    
	 return false;
 
     });
     
     /* DATA LIST SETTINGS BTNS */
     
      $('body').on(event_type,'td.settings a', function(e){

		  var actions_id = $(this).parents('.table').find('tr.actions-tr').attr('id');
		  
		  //console.log($(this).parents('.data-list-table').find('a.settings'));
		  
		  $('tr.actions-tr').not("#"+actions_id).removeClass('actions-tr-open').addClass('actions-tr-closed');
		  $(this).parents('.data-list-table').find('a.settings').removeClass('active');
		  
		  if ( $("#"+actions_id).hasClass('actions-tr-open') ) {
			$("#"+actions_id).addClass('actions-tr-closed').removeClass('actions-tr-open'); 
			$(this).removeClass('active');
		  } else {
		  	$(this).addClass('active');
			 $("#"+actions_id).addClass('actions-tr-open').removeClass('actions-tr-closed');  
		  }
    
	 return false;
 
     });
     
    $('#info-alert button.close').click(function () {
		
		$(this).parent().fadeOut('slow', function(){
		
		$('button#show-info').removeClass('disabled');	
			
		}); // hides alert with Bootstrap CSS3 implem
		
	});
	
	$('button#show-info').click(function () {
	
		$('#info-alert').fadeIn('fast').removeClass('hidden');
		
		if (!$(this).hasClass("disabled")) {
		$(this).addClass('disabled');
		}
		
		return false;
	});
	
	/* SET MEETING ROOM */
	$('body').on(event_type, '#meeting-room-select > li > a', function(){
	
	var room = $(this).attr('id');
	var room_id = room.split('room-');
	var room_title = $(this).text();
	$('input#meeting_room').val(room_id[1]);
	$('input#meeting_room_name').val(room_title);
		
	return false;
	});
	
	/* SET START MINS+HOURS */
	$('body').on(event_type, '#start-meeting-hr-select > li > a', function(){
	
	var hr = parseInt($(this).text(), 10);
	$('input#start_hrs').val(hr);
	$('input#end_hrs').val((hr)+1);
		
	return false;
	});
	
	$('body').on(event_type, '#start-hr-select > li > a', function(){
	
	var hr = parseInt($(this).text(), 10);
	
	//console.log(hr+1);
	$('input#start_hrs').val(hr);
	$('input#end_hrs').val(hr+1);
		
	return false;
	});
	
	$('body').on(event_type, '#start-meeting-min-select > li > a', function(){
	
	var min = $(this).text();
	$('input#start_mins').val(min);
		
	return false;
	});
	
	$('body').on(event_type, '#start-min-select > li > a', function(){
	
	var min = $(this).text();
	$('input#start_mins').val(min);
		
	return false;
	});
	
	/* SET END MINS+HOURS */
	$('body').on(event_type, '#end-meeting-hr-select > li > a', function(){
	
	var hr = $(this).text();
	$('input#end_hrs').val(hr);
		
	return false;
	});
	
	$('body').on(event_type, '#end-hr-select > li > a', function(){
	
	var hr = $(this).text();
	$('input#end_hrs').val(hr);
		
	return false;
	});
	
	$('body').on(event_type, '#end-meeting-min-select > li > a', function(){
	
	var min = $(this).text();
	$('input#end_mins').val(min);
		
	return false;
	});
	
	$('body').on(event_type, '#end-min-select > li > a', function(){
	
	var min = $(this).text();
	$('input#end_mins').val(min);
		
	return false;
	});

      
	/* DOCUMENT READY FUNCTIONS */
	$(document).ready(function (){	
	
	});
	
	/* WINDOW RESIZE FUNCTIONS */
	$(window).on("resize", function(e){
	
	});
	
})(window.jQuery);