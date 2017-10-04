(function($){
	
	/* DOCUMENT READY FUNCTIONS */
	$(document).ready(function (){
	
	$(".note").on("dragover",function(e){
    e.preventDefault();
    //console.log(e);
	});
  	
	$(".note").on("dragstart",function(e){
		e.originalEvent.dataTransfer.setData("Text",e.target.id);
		 $(this).addClass('dragging');
  	});
    
    $(".note").on("dragend",function(e){
		e.preventDefault();
		var data = e.originalEvent.dataTransfer.getData("Text");
		var percent_l = e.pageX / $(window).width() * 100;
		var percent_t = e.pageY / $(window).width() * 100;
		
		$(this).css({top: percent_t+'%', left: percent_l+'%'}).removeClass('dragging');
		$(this).find('input[name="p-top"]').val(Math.round(percent_t));
		$(this).find('input[name="p-left"]').val(Math.round(percent_l));
		$(this).parent().submit();
		
		 console.log(percent_l);
		 console.log(percent_t);
	});

	});
		
})(window.jQuery);