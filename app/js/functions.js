(function($){
	
	var event_type = 'click';
	var options = { 
    //target:        '.reminder-alerts',   // target element(s) to be updated with server response 
    beforeSubmit:  showRequest,  // pre-submit callback 
    success:       showResponse,  // post-submit callback 

    // other available options: 
    //url:       url         // override for form's 'action' attribute 
    //type:      type        // 'get' or 'post', override for form's 'method' attribute 
    //dataType:  null        // 'xml', 'script', or 'json' (expected server response type) 
    //clearForm: true        // clear all form fields after successful submit 
    //resetForm: true        // reset the form after successful submit 

    // $.ajax options can be used here too, for example: 
    timeout:   3000 
	}; 

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
		
				
		$('body').on(event_type, '#reminders-alert-btn', function(){
			$(this).toggleClass('closed open');
			$('.reminder-alerts').toggleClass('reminders-closed reminders-open');
			return false;
		});
		
				 
    	// bind form using 'ajaxForm' 
   		$('.reminder-alerts-form').ajaxForm(options); 
   		
   		console.log(location.href);
		     
	});
	
	// pre-submit callback 
	function showRequest(formData, jqForm, options) { 
	    // formData is an array; here we use $.param to convert it to a string to display it 
	    // but the form plugin does this for you automatically when it submits the data 
	    var queryString = $.param(formData); 
	 
	    // jqForm is a jQuery object encapsulating the form element.  To access the 
	    // DOM element for the form do this: 
	    var formElement = jqForm[0]; 
		var rem_id = $('button[type="submit"]').fieldValue(); 
		
		$('#reminder-'+rem_id).fadeOut(function(){
		console.log('About to submit: \n\n' + queryString); 	
		}); 
	 
	    // here we could return false to prevent the form from being submitted; 
	    // returning anything other than false will allow the form submit to continue 
	    return true; 
	};
	 
	// post-submit callback 
	function showResponse(responseText, statusText, xhr, $form)  { 
	    // for normal html responses, the first argument to the success callback 
	    // is the XMLHttpRequest object's responseText property 
	 
	    // if the ajaxForm method was passed an Options Object with the dataType 
	    // property set to 'xml' then the first argument to the success callback 
	    // is the XMLHttpRequest object's responseXML property 
	 
	    // if the ajaxForm method was passed an Options Object with the dataType 
	    // property set to 'json' then the first argument to the success callback 
	    // is the json data object returned by the server 
		$(".reminder-alerts").load(location.href + " .reminder-alerts-inner", function(){
			$('.reminder-alerts-form').ajaxForm(options);
		});
		$(".reminder-alerts-btn").load(location.href + " #reminders-alert-btn", function(){
			$('#reminders-alert-btn').bind(event);
		});
	    console.log('status: ' + statusText + '\n\nThe output div should have already been updated with the responseText.'); 
	}; 
		
})(window.jQuery);