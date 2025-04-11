
<?php
/**
 * Fired when the plugin is uninstalled.
 */

// If uninstall not called from WordPress, then exit
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// Delete all plugin options
delete_option('copyprotect_general_settings');
delete_option('copyprotect_text_settings');
delete_option('copyprotect_image_settings');
delete_option('copyprotect_js_settings');
delete_option('copyprotect_appearance_settings');
delete_option('copyprotect_messages');
delete_option('copyprotect_advanced_settings');
