
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
 * License: GPL v2 or later
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

define('COPYPROTECT_VERSION', '1.0.0');
define('COPYPROTECT_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('COPYPROTECT_PLUGIN_URL', plugin_dir_url(__FILE__));

// Include the core class
require_once COPYPROTECT_PLUGIN_DIR . 'includes/class-copyprotect.php';

/**
 * Begins execution of the plugin.
 */
function run_copyprotect() {
    $plugin = new CopyProtect();
    $plugin->run();
}
run_copyprotect();
