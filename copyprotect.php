
<?php
/**
 * Plugin Name: CopyProtect
 * Plugin URI: https://example.com/copyprotect
 * Description: Elegant content & image protection for WordPress websites
 * Version: 1.0.0
 * Author: Your Name
 * Author URI: https://example.com
 * Text Domain: copyprotect
 * Domain Path: /languages
 * Requires at least: 5.0
 * Requires PHP: 7.2
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

define('COPYPROTECT_VERSION', '1.0.0');
define('COPYPROTECT_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('COPYPROTECT_PLUGIN_URL', plugin_dir_url(__FILE__));

/**
 * Load plugin text domain for translations.
 */
function copyprotect_load_textdomain() {
    load_plugin_textdomain('copyprotect', false, dirname(plugin_basename(__FILE__)) . '/languages/');
}
add_action('plugins_loaded', 'copyprotect_load_textdomain');

// Include the core class
require_once COPYPROTECT_PLUGIN_DIR . 'includes/class-copyprotect.php';

/**
 * Begins execution of the plugin.
 */
function run_copyprotect() {
    $plugin = new CopyProtect();
    $plugin->run();
}

/**
 * Hook to plugins_loaded to ensure WordPress core functions are available
 */
function copyprotect_init() {
    // Instantiate the plugin when WordPress has fully loaded
    run_copyprotect();
}
add_action('plugins_loaded', 'copyprotect_init', 15); // Higher priority (15) ensures it runs after most plugins

/**
 * Activation hook
 */
function copyprotect_activate() {
    // Set default options if not already set
    if (!get_option('copyprotect_general_settings')) {
        $default_general = array(
            'enableProtection' => true,
            'showFrontendNotice' => false,
            'disableForLoggedIn' => true,
            'compatibilityMode' => false,
        );
        add_option('copyprotect_general_settings', $default_general);
    }
    
    if (!get_option('copyprotect_text_settings')) {
        $default_text = array(
            'disableRightClick' => true,
            'disableTextSelection' => true,
            'disableDragDrop' => true,
        );
        add_option('copyprotect_text_settings', $default_text);
    }
    
    // Clear any cached data
    if (function_exists('wp_cache_flush')) {
        wp_cache_flush();
    }
}
register_activation_hook(__FILE__, 'copyprotect_activate');

/**
 * Deactivation hook
 */
function copyprotect_deactivate() {
    // Clean up temporary data if needed
}
register_deactivation_hook(__FILE__, 'copyprotect_deactivate');

