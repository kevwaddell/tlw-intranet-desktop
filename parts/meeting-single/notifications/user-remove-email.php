<!-- REJECT NOTIFICATION -->
<?php if (isset($_GET['action']) && $_GET['action'] == 'delete_attendee') { 
$user = get_user_by('id', $_GET['user']);
$user_meta = get_user_meta($_GET['user']);
$from_name = $booked_by->data->display_name;
$from_email = $booked_by->data->user_email;
$attendees_staff_total = $total_int;

	/* INTERNAL ATTENDEE DELETE ACTION */
	if ( isset($_GET['user_key']) ) {
	
	$name = $user->data->display_name;
	$field_staff = get_post_meta(get_the_ID(), '_attendees_staff_'.$_GET['user_key'].'_attendee_staff', true);
	$field_status = get_post_meta(get_the_ID(), '_attendees_staff_'.$_GET['user_key'].'_status', true);
			
		if ($attendees_staff_total > 1 ) {
			
			//echo '<pre>';
			
			foreach ($staff_attendees as $int_key => $internal) {
			
			$int_id = $internal['attendee_staff']['ID'];
			$int_status = $internal['status'];
					
					
					if ( $int_key == $_GET['user_key'] ) {
					
					//print_r("This is removed = ".$int_key."<br>");
					delete_post_meta(get_the_ID(), "attendees_staff_".$_GET['user_key']."_attendee_staff");
					delete_post_meta(get_the_ID(), "_attendees_staff_".$_GET['user_key']."_attendee_staff");
					delete_post_meta(get_the_ID(), "attendees_staff_".$_GET['user_key']."_status");
					delete_post_meta(get_the_ID(), "_attendees_staff_".$_GET['user_key']."_status");
					} 
					
					if ( $int_key  > $_GET['user_key'] ) {
					//print_r("These are changed = ".$int_key."<br>");
					//print_r("These are changed to  = ".($int_key - 1)."<br>");
					add_post_meta(get_the_ID(), "attendees_staff_". ($int_key - 1) ."_attendee_staff", $int_id);	
					add_post_meta(get_the_ID(), "_attendees_staff_". ($int_key - 1) ."_attendee_staff", $field_staff);	
					add_post_meta(get_the_ID(), "attendees_staff_". ($int_key - 1) ."_status", $int_status);	
					add_post_meta(get_the_ID(), "_attendees_staff_". ($int_key - 1) ."_status", $field_status);
					
					delete_post_meta(get_the_ID(), "attendees_staff_".$int_key."_attendee_staff");
					delete_post_meta(get_the_ID(), "_attendees_staff_".$int_key."_attendee_staff");
					delete_post_meta(get_the_ID(), "attendees_staff_".$int_key."_status");
					delete_post_meta(get_the_ID(), "_attendees_staff_".$int_key."_status");
					}
					
					
				
			}
			
			//echo '</pre>';
			
		} else {
			delete_post_meta(get_the_ID(), "attendees_staff_".$_GET['user_key']."_attendee_staff");
			delete_post_meta(get_the_ID(), "_attendees_staff_".$_GET['user_key']."_attendee_staff");
			delete_post_meta(get_the_ID(), "attendees_staff_".$_GET['user_key']."_status");
			delete_post_meta(get_the_ID(), "_attendees_staff_".$_GET['user_key']."_status");
		}
		
		update_post_meta(get_the_ID(), 'attendees_staff', $attendees_staff_total-1);
	
	    if ($start_time > $today_time ) {
		
			$subject = "TLW Solicitors meeting notification from ".$from_name;
			$message = "<h3>This is a notification from ".$from_name.".</h3>";
			$message .= "You do not need to attend the <strong>'". $description ."'</strong> meeting ";
			$message .= "on <strong>".  date('D jS F Y', $date_convert) ."</strong>.";
			$headers = "From: $from_name <$from_email>";
			
			function wps_set_content_type(){
				return "text/html";
				}
				
			add_filter( 'wp_mail_content_type','wps_set_content_type' );
			
				if ($_SERVER['REMOTE_ADDR'] != '127.0.0.1') {
				wp_mail( $user->data->user_email, $subject, $message, $headers );
				} else {
				wp_mail( "kwaddelltlw@icloud.com", $subject, $message, $headers );
				}
			
			remove_filter( 'wp_mail_content_type', 'set_html_content_type' );
		
		}
	
	}

	/* EXTERNAL ATTENDEE DELETE ACTION */
	if ( isset($_GET['external_key']) ) {	
	
	$name = get_post_meta(get_the_ID(), 'attendees_clients_'.$_GET['external_key'].'_attendee_client', true);
	$field = get_post_meta(get_the_ID(), '_attendees_clients_'.$_GET['external_key'].'_attendee_client', true);
	$attendees_external_total = $total_ext;
	
	if ($attendees_external_total > 1 ) {
	
	foreach ($client_attendees as $ext_key => $external) {
		
	$ext_name = $external['attendee_client'];

		
		if ( $ext_key == $_GET['external_key'] ) {
		delete_post_meta(get_the_ID(), "attendees_clients_".$_GET['external_key']."_attendee_client");
		delete_post_meta(get_the_ID(), "_attendees_clients_".$_GET['external_key']."_attendee_client");
		} 
		
		if ( $ext_key > $_GET['external_key'] ) {
		add_post_meta(get_the_ID(), "attendees_clients_". ($ext_key - 1) ."_attendee_client", $ext_name);	
		add_post_meta(get_the_ID(), "_attendees_clients_". ($ext_key - 1) ."_attendee_client", $field);	
		delete_post_meta(get_the_ID(), "attendees_clients_". $ext_key ."_attendee_client");
		delete_post_meta(get_the_ID(), "_attendees_clients_". $ext_key ."_attendee_client");
		}
	}
	
	} else {
		delete_post_meta(get_the_ID(), "attendees_clients_".$_GET['external_key']."_attendee_client");
		delete_post_meta(get_the_ID(), "_attendees_clients_".$_GET['external_key']."_attendee_client");
	}
	
	update_post_meta(get_the_ID(), 'attendees_clients', $attendees_external_total-1);	
	
	}

?>
<div class="alert alert-danger text-center">
	
	<h4><i class="fa fa-minus-circle"></i> Removed</h4>
	
	<strong><?php echo $name; ?></strong> has been removed from the attendee list.<br>
	
	<?php if ( isset($_GET['user_key']) && $start_time > $today_time) { ?>
	The attendee has been notified of removal.<br><br>
	<?php } ?>
	
	<?php if ( isset($_GET['external_key'])  || $start_time < $today_time) { ?>
	<br>
	<?php } ?>
	
	<div class="action-btns">
	<a href="<?php the_permalink(); ?>" class="btn btn-danger btn-block">Continue</a>
	</div>
</div>
<?php } ?>
