
<?php
/**
 * The core plugin class.
 *
 * @since      1.0.0
 * @package    CopyProtect
 * @subpackage CopyProtect/includes
 */
class CopyProtect {

    /**
     * The loader that's responsible for maintaining and registering all hooks.
     *
     * @since    1.0.0
     * @access   protected
     * @var      CopyProtect_Loader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * Define the core functionality of the plugin.
     *
     * @since    1.0.0
     */
    public function __construct() {
        $this->load_dependencies();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies() {
        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once COPYPROTECT_PLUGIN_DIR . 'includes/class-copyprotect-loader.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once COPYPROTECT_PLUGIN_DIR . 'admin/class-copyprotect-admin.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once COPYPROTECT_PLUGIN_DIR . 'public/class-copyprotect-public.php';

        $this->loader = new CopyProtect_Loader();
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks() {
        $plugin_admin = new CopyProtect_Admin();
        
        // Admin styles and scripts
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
        
        // Admin menu and settings
        $this->loader->add_action('admin_menu', $plugin_admin, 'add_options_page');
        $this->loader->add_action('admin_init', $plugin_admin, 'register_settings');
        
        // Add plugin action links
        $this->loader->add_filter('plugin_action_links_' . plugin_basename(COPYPROTECT_PLUGIN_DIR . 'copyprotect.php'), $plugin_admin, 'add_action_links');
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
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
     * Run the loader to execute all the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run() {
        $this->loader->run();
    }
}
