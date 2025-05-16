
<?php
/**
 * The admin menu management class.
 * Handles admin menu creation and display.
 *
 * @since      1.0.0
 * @package    CopyProtect
 * @subpackage CopyProtect/admin
 */
class CopyProtect_Admin_Menu {

    /**
     * Add options page to the admin menu
     *
     * @since    1.0.0
     */
    public function add_options_page() {
        add_menu_page(
            esc_html__('CopyProtect', 'copyprotect'),
            esc_html__('CopyProtect', 'copyprotect'),
            'manage_options',
            'copyprotect',
            array($this, 'display_options_page'),
            'dashicons-lock',
            100
        );
    }

    /**
     * Add action links to the plugins page listing
     *
     * @since    1.0.0
     * @param    array    $links    Array of plugin action links
     * @return   array              Modified array of plugin action links
     */
    public function add_action_links($links) {
        $settings_link = '<a href="' . admin_url('admin.php?page=copyprotect') . '">' . esc_html__('Settings', 'copyprotect') . '</a>';
        array_unshift($links, $settings_link);
        return $links;
    }

    /**
     * Display the options page content with proper nonce security
     *
     * @since    1.0.0
     */
    public function display_options_page() {
        // Verify user has proper permissions
        if (!current_user_can('manage_options')) {
            wp_die(esc_html__('You do not have sufficient permissions to access this page.', 'copyprotect'));
        }
        
        // Include the template to display the settings
        include_once COPYPROTECT_PLUGIN_DIR . 'admin/partials/copyprotect-admin-display.php';
    }

    /**
     * Get all pages for the dropdown
     *
     * @since    1.0.0
     * @return   array    Array of pages and posts for exclusion selection
     */
    public function get_pages_for_dropdown() {
        $pages = get_pages(array('sort_column' => 'post_title', 'sort_order' => 'ASC'));
        $posts = get_posts(array('post_type' => 'post', 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC'));
        
        $items = array();
        
        // Add pages
        foreach ($pages as $page) {
            $items[] = array(
                'id' => $page->ID,
                'title' => $page->post_title,
                'type' => 'page'
            );
        }
        
        // Add posts
        foreach ($posts as $post) {
            $items[] = array(
                'id' => $post->ID,
                'title' => $post->post_title,
                'type' => 'post'
            );
        }
        
        return $items;
    }
}
