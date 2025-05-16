
<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @since      1.0.0
 * @package    CopyProtect
 * @subpackage CopyProtect/admin
 */

// Load the required admin classes
require_once COPYPROTECT_PLUGIN_DIR . 'admin/class-copyprotect-admin-assets.php';
require_once COPYPROTECT_PLUGIN_DIR . 'admin/class-copyprotect-admin-menu.php';
require_once COPYPROTECT_PLUGIN_DIR . 'admin/class-copyprotect-admin-settings.php';
require_once COPYPROTECT_PLUGIN_DIR . 'admin/class-copyprotect-admin-ajax.php';

class CopyProtect_Admin {

    /**
     * Assets manager for admin styles and scripts.
     *
     * @var CopyProtect_Admin_Assets
     */
    private $assets;

    /**
     * Menu manager for admin pages.
     *
     * @var CopyProtect_Admin_Menu
     */
    private $menu;

    /**
     * Settings manager for registering settings.
     *
     * @var CopyProtect_Admin_Settings
     */
    private $settings;

    /**
     * Ajax handler for admin ajax requests.
     *
     * @var CopyProtect_Admin_Ajax
     */
    private $ajax;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     */
    public function __construct() {
        $this->assets = new CopyProtect_Admin_Assets();
        $this->menu = new CopyProtect_Admin_Menu();
        $this->settings = new CopyProtect_Admin_Settings();
        $this->ajax = new CopyProtect_Admin_Ajax();
        
        $this->init_hooks();
    }

    /**
     * Register all necessary hooks.
     * 
     * @return void
     */
    private function init_hooks() {
        // Register assets hooks
        add_action('admin_enqueue_scripts', array($this->assets, 'enqueue_styles'));
        add_action('admin_enqueue_scripts', array($this->assets, 'enqueue_scripts'));
        
        // Register menu hooks
        add_action('admin_menu', array($this->menu, 'add_options_page'));
        add_filter('plugin_action_links_' . plugin_basename(COPYPROTECT_PLUGIN_DIR . 'copyprotect.php'), array($this->menu, 'add_action_links'));
        
        // Register settings hooks
        add_action('admin_init', array($this->settings, 'register_settings'));
        
        // Register AJAX hooks
        add_action('wp_ajax_copyprotect_save_settings', array($this->ajax, 'save_settings'));
    }

    /**
     * Display the options page content.
     * This is a wrapper for the menu class method.
     *
     * @since    1.0.0
     */
    public function display_options_page() {
        $this->menu->display_options_page();
    }
}
