<?php
class RW_Delete_Entry {
 
    function __construct() {
        if( ! property_exists( 'GFCommon', 'version' ) || ! version_compare( GFCommon::$version, '1.8.5.8', '>=' ) )
            return;
        add_filter( 'gform_tooltips', array( $this, 'add_delete_tooltip') );
        add_filter( 'gform_form_settings', array( $this, 'add_delete_setting' ), 10, 2 );
        add_action( 'gform_pre_form_settings_save', array( $this, 'save_delete_setting' ), 10 );
        add_action( 'gform_after_submission', array( $this, 'maybe_delete_form_entry' ), 10, 2 );
        add_action( 'gform_activate_user', array( $this, 'delete_form_entry_after_activation' ), 10, 3 );
        add_action( 'gform_user_updated', array( $this, 'delete_form_entry_after_update' ), 10, 3 );
    }
 
    function add_delete_tooltip( $tooltips ) {
        $tooltips['delete_entry'] = "<h6>" . __( "Enable Entry Deletion", "gravityforms" ) . "</h6>" . __( "When enabled, the entry and any uploaded files will be deleted at the end of the submission process. If the form has a User Registration feed the entry will be deleted once the user has been activated/updated.", "gravityforms" );
        return $tooltips;
    }
 
    function add_delete_setting( $settings, $form ) {
        $enable_entry_deletion = ( rgar( $form, 'deleteEntry' ) ) ? 'checked="checked"' : "";
        $settings['Form Options']['deleteEntry'] = '
            <tr>
                <th>' . __( "Delete entry", "gravityforms" ) . ' ' . gform_tooltip( "delete_entry", "", true ) . '</th>
                <td>
                    <input type="checkbox" id="delete_entry" name="delete_entry" value="1" ' . $enable_entry_deletion . ' />
                    <label for="delete_entry">' . __( "Enable entry deletion", "gravityforms" ) . '</label>
                </td>
            </tr>';
        return $settings;
    }
 
    function save_delete_setting( $form ) {
        $form['deleteEntry'] = rgpost( 'delete_entry' );
        return $form;
    }
 
    function maybe_delete_form_entry( $entry, $form ) {
        if ( class_exists( 'GFUser' ) ) {
            $config = GFUser::get_active_config( $form, $entry );
        }
        if ( ! $config['is_active'] ) {
            self::delete_form_entry( $entry );
        }
    }
 
    function delete_form_entry_after_activation( $user_id, $user_data, $signup_meta ) {
        $entry = GFAPI::get_entry( $signup_meta['lead_id'] );
        self::delete_form_entry( $entry );
    }
 
    function delete_form_entry_after_update( $user_id, $config, $lead ) {
        self::delete_form_entry( $lead );
    }
 
    function delete_form_entry( $entry ) {
        $form = GFAPI::get_form( $entry['form_id'] );
        if ( rgar( $form, 'deleteEntry') ) {
            $delete = GFAPI::delete_entry( $entry['id'] );
            $result = ( $delete ) ? "entry {$entry['id']} successfully deleted." : $delete;
            GFCommon::log_debug( "GFAPI::delete_entry() - form #{$form['id']}: " . print_r( $result, true ) );
        }
    }
 
}
new RW_Delete_Entry();
?>