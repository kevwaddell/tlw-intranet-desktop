<?php 
global $user_notes_raw;
global $user_notes;
if (!empty($_POST)) {
	
	if (isset($_POST['edit-note'])) {
	
		foreach ($_POST as $k => $un) {
			if (!empty($un)) {
			$dif = array_diff($un, $user_notes[$k]);
				if (!empty($dif)) 	{
				$user_notes[$k] = $un;
				$notes_updated = update_user_meta($current_user->ID, 'user_notes', serialize($user_notes), $user_notes_raw);
				}	
			}
		}
	}

	if ( isset($_POST['add-note']) ) {
		$user_notes['note-'.$_POST['add-note']] = $_POST['note-'.$_POST['add-note']];
		$note_added = update_user_meta($current_user->ID, 'user_notes', serialize($user_notes), $user_notes_raw);
	}
	$user_notes_raw = get_user_meta($current_user->ID, 'user_notes', true);
	$user_notes = unserialize($user_notes_raw);
}
?>