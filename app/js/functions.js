(function($){
	var event_type;
	
	if (Modernizr.touch){
	 event_type = 'touchstart';
	} else {
	 event_type = 'click';	
	}
	
	/* DOCUMENT READY FUNCTIONS */
	$(document).ready(function (){	
		
		/* MAIN NAV BTN FUNCTION */
		$('body').on(event_type, 'button#main-nav-btn', function(){
			
			$('body').toggleClass('nav-closed nav-open');
			$(this).toggleClass('nav-open');
			
			return false;
		});
		
	/* 
	CONTACTS PAGE FUNCTIONS
		
	CONTACT NAME FUNCTION
	-- When clicked contact will be change in main content area with know browser refresh	
	*/
     $('body').on(event_type,'.contact-list-item a', function(e){
		 
		 var href = $(this).attr("href");
		 $('.contact-list-item').removeClass('active-contact');
		 $(this).parent().addClass('active-contact');
		 
		  
		 $('article.page').load(href+" .entry", function(data){

		   $(this).find('.entry').hide().fadeIn('slow');
		      	
	     });
    
	 return false;
 
     });
     
     /* 
	ADDRESS BOOK FUNCTION
	-- When clicked contact will be change in main content area with know browser refresh	
	*/
     $('body').on(event_type,'.address-books a', function(e){
		 
		var href = $(this).attr("href");
		 //console.log(href);
		 
		 $(this).siblings().removeClass('active');
		 $(this).addClass('active');
		 
		  
		 $('#names-list').load(href+" .contact-names", function(data){
		 	
		   $(this).find('.contact-names').slimScroll({height: 'auto'}).hide().fadeIn('slow');
		   $(this).find('.active-contact a').trigger(event_type); 
		      	
	     });
    
	 	return false;
	 });
	 
	 $('.contact-names').slimScroll({height: 'auto'});
     
	});
		
})(window.jQuery);