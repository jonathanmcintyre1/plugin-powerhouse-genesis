
<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @link       https://example.com
 * @since      1.0.0
 *
 * @package    CopyProtect
 */

// If uninstall not called from WordPress, then exit
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// Delete all plugin options
delete_option('copyprotect_general_settings');
delete_option('copyprotect_text_settings');
delete_option('copyprotect_keyboard_settings');
delete_option('copyprotect_image_settings');
delete_option('copyprotect_js_settings');
delete_option('copyprotect_appearance_settings');
delete_option('copyprotect_messages');
delete_option('copyprotect_advanced_settings');

// Clean up any other database entries that might have been created
// For example, if you have user metadata:
// $users = get_users();
// foreach ($users as $user) {
//     delete_user_meta($user->ID, 'copyprotect_user_preference');
// }

// Note: We're not removing any content protection that might be in posts/pages
// since that would potentially damage user content

// Clear any cached data
if (function_exists('wp_cache_flush')) {
    wp_cache_flush();
}
