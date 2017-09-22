<div id="book-a-room" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title"><?php echo $form->title; ?></h4>
      </div>
      <div class="modal-body">
     	 <?php if (is_user_logged_in()) { ?>
	 	 <?php gravity_form($form->id, false, false, false, '', true, 1); ; ?>
	 	 <?php } else { ?>
	 	 <div class="alert alert-danger">
		 
		 You must be logged in to book a meeting room.<br/><br/>
		 <a href="/login/" title="Login" class="btn btn-danger btn-lg">Login now <i class="fa fa-angle-right"></i></a>
		 	 
	 	 </div>
	 	 <?php } ?>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->