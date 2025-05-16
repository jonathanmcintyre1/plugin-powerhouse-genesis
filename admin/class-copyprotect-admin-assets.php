
<?php
/**
 * The admin assets management class.
 * Handles scripts and styles for the admin area.
 *
 * @since      1.0.0
 * @package    CopyProtect
 * @subpackage CopyProtect/admin
 */
class CopyProtect_Admin_Assets {

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles($hook) {
        // Only load on our plugin page
        if ('toplevel_page_copyprotect' !== $hook) {
            return;
        }
        
        // Enqueue the main admin CSS with version for cache busting
        wp_enqueue_style(
            'copyprotect-admin', 
            COPYPROTECT_PLUGIN_URL . 'admin/css/copyprotect-admin.css', 
            array(), 
            COPYPROTECT_VERSION . '.' . time(), // Add time to force reload during development
            'all'
        );
        
        // Enqueue WordPress standard admin styles for compatibility
        wp_enqueue_style('wp-components');
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts($hook) {
        // Only load on our plugin page
        if ('toplevel_page_copyprotect' !== $hook) {
            return;
        }
        
        // Enqueue React admin app
        wp_enqueue_script(
            'copyprotect-admin-react', 
            COPYPROTECT_PLUGIN_URL . 'admin/js/copyprotect-admin.js', 
            array('jquery', 'wp-element', 'wp-components', 'wp-i18n'), 
            COPYPROTECT_VERSION . '.' . time(), // Add time to force reload during development
            true
        );
        
        // Additional scripts needed
        wp_enqueue_media();
        wp_enqueue_script('wp-api');
        
        // Add inline script to handle any initialization that might be needed
        wp_add_inline_script('copyprotect-admin-react', '
            // Ensure WordPress admin globals are available to React
            window.copyprotectWP = {
                ajaxUrl: "' . admin_url('admin-ajax.php') . '",
                adminUrl: "' . admin_url() . '",
                siteUrl: "' . site_url() . '",
                pluginUrl: "' . COPYPROTECT_PLUGIN_URL . '",
                pluginVersion: "' . COPYPROTECT_VERSION . '"
            };
        ');
    }
}
