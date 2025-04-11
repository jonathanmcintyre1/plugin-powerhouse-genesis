
<?php
/**
 * The admin-specific functionality of the plugin.
 */
class CopyProtect_Admin {

    /**
     * Initialize the class and set its properties.
     */
    public function __construct() {}

    /**
     * Register the stylesheets for the admin area.
     */
    public function enqueue_styles() {
        wp_enqueue_style('copyprotect-admin', COPYPROTECT_PLUGIN_URL . 'admin/css/copyprotect-admin.css', array(), COPYPROTECT_VERSION, 'all');
    }

    /**
     * Register the JavaScript for the admin area.
     */
    public function enqueue_scripts() {
        wp_enqueue_script('copyprotect-admin', COPYPROTECT_PLUGIN_URL . 'admin/js/copyprotect-admin.js', array('jquery'), COPYPROTECT_VERSION, false);
        
        // Pass data to admin JS
        wp_localize_script('copyprotect-admin', 'copyprotectAdmin', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('copyprotect-admin-nonce'),
            'pages' => $this->get_pages_for_dropdown(),
        ));
    }
    
    /**
     * Get all pages for the dropdown
     */
    private function get_pages_for_dropdown() {
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

    /**
     * Add options page to the admin menu
     */
    public function add_options_page() {
        add_menu_page(
            __('CopyProtect', 'copyprotect'),
            __('CopyProtect', 'copyprotect'),
            'manage_options',
            'copyprotect',
            array($this, 'display_options_page'),
            'dashicons-lock',
            100
        );
    }

    /**
     * Register settings for the plugin
     */
    public function register_settings() {
        // General Settings
        register_setting('copyprotect_general_settings', 'copyprotect_general_settings');
        
        // Text Protection Settings
        register_setting('copyprotect_text_settings', 'copyprotect_text_settings');
        
        // Keyboard Shortcuts Settings
        register_setting('copyprotect_keyboard_settings', 'copyprotect_keyboard_settings');
        
        // Image Protection Settings
        register_setting('copyprotect_image_settings', 'copyprotect_image_settings');
        
        // JavaScript Behavior Settings
        register_setting('copyprotect_js_settings', 'copyprotect_js_settings');
        
        // Appearance & Messaging Settings
        register_setting('copyprotect_appearance_settings', 'copyprotect_appearance_settings');
        register_setting('copyprotect_messages', 'copyprotect_messages');
        
        // Advanced Rules Settings
        register_setting('copyprotect_advanced_settings', 'copyprotect_advanced_settings');
    }

    /**
     * Display the options page content
     */
    public function display_options_page() {
        // Default values for options (all disabled by default)
        $default_general = array(
            'enableProtection' => false,
            'showFrontendNotice' => false,
            'disableForLoggedIn' => false,
            'compatibilityMode' => false,
            'excludedPages' => '',
        );

        $default_text = array(
            'disableRightClick' => false,
            'disableTextSelection' => false,
            'disableDragDrop' => false,
        );
        
        $default_keyboard = array(
            // Developer tools
            'f12' => false,
            'devTools' => false,
            
            // Selection/editing
            'ctrlA' => false,
            'ctrlC' => false,
            'ctrlV' => false,
            'ctrlX' => false,
            'ctrlF' => false,
            
            // Navigation/browser
            'f3' => false,
            'f6' => false,
            'f9' => false,
            'ctrlH' => false,
            'ctrlL' => false,
            'ctrlK' => false,
            'ctrlO' => false,
            'altD' => false,
            
            // Save/print/view
            'ctrlS' => false,
            'ctrlU' => false,
            'ctrlP' => false,
        );

        $default_image = array(
            'disableRightClickImages' => false,
            'disableDraggingImages' => false,
            'transparentOverlay' => false,
            'serveCssBackground' => false,
            'preventHotlinking' => false,
            'lazyLoadWithObfuscation' => false,
        );

        $default_js = array(
            'disablePrint' => false,
            'disableViewSource' => false,
            'obfuscateHtml' => false,
            'disablePageRefresh' => false,
            'antiInspectTool' => false,
        );

        $default_appearance = array(
            'showTooltip' => false,
            'showModal' => false,
            'showProtectedBadge' => false,
            'badgePosition' => 'bottom-right',
        );

        $default_messages = array(
            'tooltipText' => 'Content is protected',
            'alertText' => 'This content is protected. Copying is not allowed.',
            'badgeText' => 'Protected',
        );

        $default_advanced = array(
            'enablePerPostType' => false,
            'applyToBlogPosts' => false,
            'applyToPages' => false,
            'applyToProducts' => false,
            'disableForCategories' => false,
            'disabledCategories' => array(),
        );

        // Get saved options
        $general_settings = get_option('copyprotect_general_settings', $default_general);
        $text_settings = get_option('copyprotect_text_settings', $default_text);
        $keyboard_settings = get_option('copyprotect_keyboard_settings', $default_keyboard);
        $image_settings = get_option('copyprotect_image_settings', $default_image);
        $js_settings = get_option('copyprotect_js_settings', $default_js);
        $appearance_settings = get_option('copyprotect_appearance_settings', $default_appearance);
        $messages = get_option('copyprotect_messages', $default_messages);
        $advanced_settings = get_option('copyprotect_advanced_settings', $default_advanced);

        // Include the template to display the settings
        include_once COPYPROTECT_PLUGIN_DIR . 'admin/partials/copyprotect-admin-display.php';
    }
}
