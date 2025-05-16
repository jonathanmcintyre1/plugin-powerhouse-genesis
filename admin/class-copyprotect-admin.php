<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @since      1.0.0
 * @package    CopyProtect
 * @subpackage CopyProtect/admin
 */
class CopyProtect_Admin {

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     */
    public function __construct() {
        // Constructor can be extended as needed
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {
        // Enqueue the main admin CSS with version for cache busting
        wp_enqueue_style(
            'copyprotect-admin', 
            COPYPROTECT_PLUGIN_URL . 'admin/css/copyprotect-admin.css', 
            array(), 
            COPYPROTECT_VERSION, 
            'all'
        );
        
        // Add WordPress default admin styles for consistency
        wp_enqueue_style('wp-admin');
        wp_enqueue_style('wp-components');
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {
        wp_enqueue_script('jquery');
        
        wp_enqueue_script(
            'copyprotect-admin', 
            COPYPROTECT_PLUGIN_URL . 'admin/js/copyprotect-admin.js', 
            array('jquery'), 
            COPYPROTECT_VERSION, 
            false
        );
        
        // Pass data to admin JS with proper nonce for security
        wp_localize_script('copyprotect-admin', 'copyprotectAdmin', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('copyprotect-admin-nonce'),
            'pages' => $this->get_pages_for_dropdown(),
        ));
    }
    
    /**
     * Get all pages for the dropdown
     *
     * @since    1.0.0
     * @return   array    Array of pages and posts for exclusion selection
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
     * Register settings for the plugin using the WordPress Settings API
     *
     * @since    1.0.0
     */
    public function register_settings() {
        // General Settings
        register_setting(
            'copyprotect_general_settings', 
            'copyprotect_general_settings',
            array($this, 'sanitize_general_settings')
        );
        
        // Text Protection Settings
        register_setting(
            'copyprotect_text_settings', 
            'copyprotect_text_settings',
            array($this, 'sanitize_text_settings')
        );
        
        // Keyboard Shortcuts Settings
        register_setting(
            'copyprotect_keyboard_settings', 
            'copyprotect_keyboard_settings',
            array($this, 'sanitize_keyboard_settings')
        );
        
        // Image Protection Settings
        register_setting(
            'copyprotect_image_settings', 
            'copyprotect_image_settings',
            array($this, 'sanitize_image_settings')
        );
        
        // JavaScript Behavior Settings
        register_setting(
            'copyprotect_js_settings', 
            'copyprotect_js_settings',
            array($this, 'sanitize_js_settings')
        );
        
        // Appearance & Messaging Settings
        register_setting(
            'copyprotect_appearance_settings', 
            'copyprotect_appearance_settings',
            array($this, 'sanitize_appearance_settings')
        );
        
        register_setting(
            'copyprotect_messages', 
            'copyprotect_messages',
            array($this, 'sanitize_messages')
        );
        
        // Advanced Rules Settings
        register_setting(
            'copyprotect_advanced_settings', 
            'copyprotect_advanced_settings',
            array($this, 'sanitize_advanced_settings')
        );
    }
    
    /**
     * Sanitize general settings
     *
     * @since    1.0.0
     * @param    array    $input    The settings array
     * @return   array              The sanitized settings array
     */
    public function sanitize_general_settings($input) {
        $sanitized = array();
        
        // Sanitize boolean fields
        $sanitized['enableProtection'] = isset($input['enableProtection']) ? (bool) $input['enableProtection'] : false;
        $sanitized['showFrontendNotice'] = isset($input['showFrontendNotice']) ? (bool) $input['showFrontendNotice'] : false;
        $sanitized['disableForLoggedIn'] = isset($input['disableForLoggedIn']) ? (bool) $input['disableForLoggedIn'] : false;
        $sanitized['compatibilityMode'] = isset($input['compatibilityMode']) ? (bool) $input['compatibilityMode'] : false;
        
        // Sanitize excluded pages (array of integers)
        if (isset($input['excludedPages']) && is_array($input['excludedPages'])) {
            $sanitized['excludedPages'] = array_map('absint', $input['excludedPages']);
        } else {
            $sanitized['excludedPages'] = array();
        }
        
        return $sanitized;
    }
    
    /**
     * Sanitize text settings
     *
     * @since    1.0.0
     * @param    array    $input    The settings array
     * @return   array              The sanitized settings array
     */
    public function sanitize_text_settings($input) {
        $sanitized = array();
        
        // Sanitize boolean fields
        $sanitized['disableRightClick'] = isset($input['disableRightClick']) ? (bool) $input['disableRightClick'] : false;
        $sanitized['disableTextSelection'] = isset($input['disableTextSelection']) ? (bool) $input['disableTextSelection'] : false;
        $sanitized['disableDragDrop'] = isset($input['disableDragDrop']) ? (bool) $input['disableDragDrop'] : false;
        
        return $sanitized;
    }
    
    /**
     * Sanitize keyboard settings
     *
     * @since    1.0.0
     * @param    array    $input    The settings array
     * @return   array              The sanitized settings array
     */
    public function sanitize_keyboard_settings($input) {
        $sanitized = array();
        
        // List of all possible keyboard shortcut options
        $keyboard_options = array(
            'f12', 'devTools', 'ctrlA', 'ctrlC', 'ctrlV', 'ctrlX', 'ctrlF',
            'f3', 'f6', 'f9', 'ctrlH', 'ctrlL', 'ctrlK', 'ctrlO', 'altD',
            'ctrlS', 'ctrlU', 'ctrlP'
        );
        
        // Sanitize all keyboard settings as booleans
        foreach ($keyboard_options as $option) {
            $sanitized[$option] = isset($input[$option]) ? (bool) $input[$option] : false;
        }
        
        return $sanitized;
    }
    
    /**
     * Sanitize image settings
     *
     * @since    1.0.0
     * @param    array    $input    The settings array
     * @return   array              The sanitized settings array
     */
    public function sanitize_image_settings($input) {
        $sanitized = array();
        
        // List of all possible image protection options
        $image_options = array(
            'disableRightClickImages', 'disableDraggingImages', 'transparentOverlay',
            'serveCssBackground', 'preventHotlinking', 'lazyLoadWithObfuscation'
        );
        
        // Sanitize all image settings as booleans
        foreach ($image_options as $option) {
            $sanitized[$option] = isset($input[$option]) ? (bool) $input[$option] : false;
        }
        
        return $sanitized;
    }
    
    /**
     * Sanitize JavaScript behavior settings
     *
     * @since    1.0.0
     * @param    array    $input    The settings array
     * @return   array              The sanitized settings array
     */
    public function sanitize_js_settings($input) {
        $sanitized = array();
        
        // List of all possible JavaScript behavior options
        $js_options = array(
            'disablePrint', 'disableViewSource', 'obfuscateHtml',
            'disablePageRefresh', 'antiInspectTool'
        );
        
        // Sanitize all JavaScript settings as booleans
        foreach ($js_options as $option) {
            $sanitized[$option] = isset($input[$option]) ? (bool) $input[$option] : false;
        }
        
        return $sanitized;
    }
    
    /**
     * Sanitize appearance settings
     *
     * @since    1.0.0
     * @param    array    $input    The settings array
     * @return   array              The sanitized settings array
     */
    public function sanitize_appearance_settings($input) {
        $sanitized = array();
        
        // Sanitize boolean fields
        $sanitized['showTooltip'] = isset($input['showTooltip']) ? (bool) $input['showTooltip'] : false;
        $sanitized['showModal'] = isset($input['showModal']) ? (bool) $input['showModal'] : false;
        $sanitized['showProtectedBadge'] = isset($input['showProtectedBadge']) ? (bool) $input['showProtectedBadge'] : false;
        
        // Sanitize badge position (allow only specific values)
        $allowed_positions = array('top-left', 'top-right', 'bottom-left', 'bottom-right');
        $sanitized['badgePosition'] = isset($input['badgePosition']) && in_array($input['badgePosition'], $allowed_positions) 
            ? $input['badgePosition'] 
            : 'bottom-right';
        
        return $sanitized;
    }
    
    /**
     * Sanitize message settings
     *
     * @since    1.0.0
     * @param    array    $input    The settings array
     * @return   array              The sanitized settings array
     */
    public function sanitize_messages($input) {
        $sanitized = array();
        
        // Sanitize text fields
        $sanitized['tooltipText'] = isset($input['tooltipText']) ? sanitize_text_field($input['tooltipText']) : '';
        $sanitized['alertText'] = isset($input['alertText']) ? sanitize_text_field($input['alertText']) : '';
        $sanitized['badgeText'] = isset($input['badgeText']) ? sanitize_text_field($input['badgeText']) : '';
        
        return $sanitized;
    }
    
    /**
     * Sanitize advanced settings
     *
     * @since    1.0.0
     * @param    array    $input    The settings array
     * @return   array              The sanitized settings array
     */
    public function sanitize_advanced_settings($input) {
        $sanitized = array();
        
        // Sanitize boolean fields
        $sanitized['enablePerPostType'] = isset($input['enablePerPostType']) ? (bool) $input['enablePerPostType'] : false;
        $sanitized['applyToBlogPosts'] = isset($input['applyToBlogPosts']) ? (bool) $input['applyToBlogPosts'] : false;
        $sanitized['applyToPages'] = isset($input['applyToPages']) ? (bool) $input['applyToPages'] : false;
        $sanitized['applyToProducts'] = isset($input['applyToProducts']) ? (bool) $input['applyToProducts'] : false;
        $sanitized['disableForCategories'] = isset($input['disableForCategories']) ? (bool) $input['disableForCategories'] : false;
        
        // Sanitize categories array (integers)
        if (isset($input['disabledCategories']) && is_array($input['disabledCategories'])) {
            $sanitized['disabledCategories'] = array_map('absint', $input['disabledCategories']);
        } else {
            $sanitized['disabledCategories'] = array();
        }
        
        return $sanitized;
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
