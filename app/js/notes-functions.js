(function($){
	
	var event_type = 'click';
	
	/* DOCUMENT READY FUNCTIONS */
	$(document).ready(function (){

	interact('.draggable', {allowFrom: '.move-btn'})
		.draggable({
		inertia: true,
		restrict: {
			restriction: "parent",
			endOnly: true,
			elementRect: { top: 0, left: 0, bottom: 1, right: 1 }
			},
		onstart: dragNoteStart,
		onmove: dragNoteListener,
		onend: dragNoteEnd
  	});	
  	
  	function dragNoteStart (event) {
		var target = event.target; 	
		$(target).addClass('dragging');
  	}
  		
  	function dragNoteEnd (event) {
	 	var target = event.target;
		var end_x = target.getAttribute('data-x');
		var end_y = target.getAttribute('data-y');
    
		var note_id = $(target).data('note');
		var input_x = $(target).find('input.x_pos');
		var input_y = $(target).find('input.y_pos');
		
		$(input_x).val(end_x);
		$(input_y).val(end_y);
		
/*
		console.log("--------------------------");
		console.log(end_x);
		console.log(end_y);
*/
		$(target).removeClass('dragging');
		$(target).parent().submit();
			
  	}	
  		
  	function dragNoteListener (event) {
    var target = event.target;
    var x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx;
    var y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy;
		
    // translate the element
    target.style.webkitTransform = target.style.transform = 'translate(' + x + 'px, ' + y + 'px)';

    // update the posiion attributes
    target.setAttribute('data-x', x);
    target.setAttribute('data-y', y);
	
	//console.log(x);
	//console.log(y);
  	}
  	
  	window.dragNoteListener = dragNoteListener;
  	
  	$('.save-note-btn').on(event_type, function(){
		$(this).parents('form').submit();
		return false;	
  	});
  	
  	$('#open-trash-btn').on(event_type, function(){
	  	$(this).toggleClass('active');
		$('#notes-canvas').toggleClass('trash-closed trash-open');
		$('#trash-notes').toggleClass('sb-closed sb-open');
		return false;	
  	});

	});
		
})(window.jQuery);