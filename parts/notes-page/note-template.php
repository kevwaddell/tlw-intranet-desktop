<?php
global $bg_colors;
$bg_color = $bg_colors[rand(0, count($bg_colors)-1)];
$note_id = uniqid();
?>
<input type="hidden" name="add-note" value="<?php echo $note_id; ?>">
<div id="note-<?php echo $note_id; ?>" data-note="<?php echo $note_id; ?>" class="note bg-<?php echo $bg_color; ?> new-note" style="transform: translate(-50%, -50%) scale(1.5);">
	<input type="hidden" name="note-<?php echo $note_id; ?>[note-id]" value="<?php echo $note_id; ?>">
	<textarea class="note-txt" name="note-<?php echo $note_id; ?>[note-txt]" placeholder="Enter your note" autofocus></textarea>
	<input type="hidden" class="y_pos" name="note-<?php echo $note_id; ?>[y_pos]" value="">
	<input type="hidden" class="x_pos" name="note-<?php echo $note_id; ?>[x_pos]" value="">
	<input type="hidden" name="note-<?php echo $note_id; ?>[bg-col]" value="<?php echo $bg_color; ?>">
	<div class="note-actions">
		<button type="submit" class="btn btn-default note-btn"><i class="fa fa-save fa-lg"></i><span class="sr-only">Save note</span></button>			
	</div>
</div>
<script type="text/javascript">
	(function($){
		$(document).ready(function (){
			//$('.new-note').offset().left + $
			var cw = $('#notes-canvas').width();
			var ch = $('#notes-canvas').height();
			var nw = $('.new-note')[0].getBoundingClientRect().width;
			var nh = $('.new-note')[0].getBoundingClientRect().height;
			var x_pos = (cw / 2) - nw + (nw / 1.5);
			var y_pos = (ch / 2) - nh + (nh / 1.5);
			console.log( x_pos );
			console.log( y_pos );
			$('.new-note').find('.x_pos').val(x_pos);
			$('.new-note').find('.y_pos').val(y_pos);
		});	
	})(window.jQuery);
</script>
