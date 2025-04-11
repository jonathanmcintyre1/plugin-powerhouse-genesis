
<?php
/**
 * The core plugin class.
 */
class CopyProtect {

    /**
     * The loader that's responsible for maintaining and registering all hooks.
     */
    protected $loader;

    /**
     * Define the core functionality of the plugin.
     */
    public function __construct() {
        $this->load_dependencies();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    /**
     * Load the required dependencies for this plugin.
     */
    private function load_dependencies() {
        require_once COPYPROTECT_PLUGIN_DIR . 'includes/class-copyprotect-loader.php';
        require_once COPYPROTECT_PLUGIN_DIR . 'admin/class-copyprotect-admin.php';
        require_once COPYPROTECT_PLUGIN_DIR . 'public/class-copyprotect-public.php';

        $this->loader = new CopyProtect_Loader();
    }

    /**
     * Register all of the hooks related to the admin area.
     */
    private function define_admin_hooks() {
        $plugin_admin = new CopyProtect_Admin();
        
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
        $this->loader->add_action('admin_menu', $plugin_admin, 'add_options_page');
        $this->loader->add_action('admin_init', $plugin_admin, 'register_settings');
    }

    /**
     * Register all of the hooks related to the public-facing functionality.
     */
    private function define_public_hooks() {
        $plugin_public = new CopyProtect_Public();
        
        // Only add the hooks if protection is enabled
        $options = get_option('copyprotect_general_settings');
        if (isset($options['enableProtection']) && $options['enableProtection']) {
            // Check if we should disable for logged-in users
            if (!(isset($options['disableForLoggedIn']) && $options['disableForLoggedIn'] && is_user_logged_in())) {
                $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
                $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
                $this->loader->add_action('wp_head', $plugin_public, 'add_protection_scripts');
            }
        }
    }

    /**
     * Run the loader to execute all the hooks.
     */
    public function run() {
        $this->loader->run();
    }
}
