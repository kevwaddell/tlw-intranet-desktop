<?php
global $user_notes_raw;
global $user_notes;
global $trash_notes_raw;
global $trash_notes;
//echo '<pre class="debug">';
if (isset($_GET['note-action'])) {
	
	if ($_GET['note-action'] == 'delete-note') {
		foreach ($user_notes as $k => $note) { 
			if ($note['note-id'] == $_GET['note-id']) {
			unset($user_notes[$k]);
			$trash_notes[$k] = $note;
			$note_removed = update_user_meta($current_user->ID, 'user_notes', serialize($user_notes), $user_notes_raw);
			$trash_added = update_user_meta($current_user->ID, 'trash_notes', serialize($trash_notes), $trash_notes_raw);
			//print_r($note);	
			}
		}	
	}
	
	if ($_GET['note-action'] == 'restore-note') {
		foreach ($trash_notes as $k => $note) { 
			if ($note['note-id'] == $_GET['note-id']) {
			unset($trash_notes[$k]);
			$user_notes[$k] = $note;
			$note_restored = update_user_meta($current_user->ID, 'user_notes', serialize($user_notes), $user_notes_raw);
			$trash_removed = update_user_meta($current_user->ID, 'trash_notes', serialize($trash_notes), $trash_notes_raw);
			//print_r($note);	
			}
		}	
	}
		
}
$user_notes_raw = get_user_meta($current_user->ID, 'user_notes', true);
$trash_notes_raw = get_user_meta($current_user->ID, 'trash_notes', true);
$trash_notes = unserialize($trash_notes_raw);
$user_notes = unserialize($user_notes_raw);
//print_r($user_notes);
//print_r($trash_notes);	
//echo '</pre>';
?>