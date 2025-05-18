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
        add_action('admin_enqueue_scripts', array($this, 'enqueue_styles'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('admin_menu', array($this, 'add_options_page'));
        add_filter('plugin_action_links_' . plugin_basename(COPYPROTECT_PLUGIN_DIR . 'copyprotect.php'), array($this, 'add_action_links'));
        add_action('admin_init', array($this, 'register_settings'));
        
        // Add AJAX handlers for saving settings
        add_action('wp_ajax_copyprotect_save_settings', array($this, 'ajax_save_settings'));
    }

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
            COPYPROTECT_VERSION, 
            'all'
        );
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
        
        wp_enqueue_script(
            'copyprotect-admin', 
            COPYPROTECT_PLUGIN_URL . 'admin/js/copyprotect-admin.js', 
            array('jquery'), 
            COPYPROTECT_VERSION, 
            true
        );
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
     * AJAX handler for saving settings
     */
    public function ajax_save_settings() {
        // Check nonce for security
        if (!check_ajax_referer('copyprotect-admin-nonce', 'nonce', false)) {
            wp_send_json_error('Invalid security token');
            return;
        }
        
        // Check user capabilities
        if (!current_user_can('manage_options')) {
            wp_send_json_error('Insufficient permissions');
            return;
        }
        
        $settings_type = isset($_POST['settings_type']) ? sanitize_text_field($_POST['settings_type']) : '';
        $settings = isset($_POST['settings']) ? json_decode(stripslashes($_POST['settings']), true) : array();
        
        if (empty($settings_type) || !is_array($settings)) {
            wp_send_json_error('Invalid data format');
            return;
        }
        
        $option_name = 'copyprotect_' . $settings_type;
        $sanitize_method = 'sanitize_' . $settings_type;
        
        // Sanitize settings using the appropriate method if it exists
        if (method_exists($this, $sanitize_method)) {
            $sanitized_settings = call_user_func(array($this, $sanitize_method), $settings);
        } else {
            // Basic sanitization fallback
            $sanitized_settings = array();
            foreach ($settings as $key => $value) {
                if (is_bool($value)) {
                    $sanitized_settings[$key] = (bool) $value;
                } elseif (is_numeric($value)) {
                    $sanitized_settings[$key] = absint($value);
                } elseif (is_string($value)) {
                    $sanitized_settings[$key] = sanitize_text_field($value);
                } elseif (is_array($value)) {
                    $sanitized_settings[$key] = array_map('sanitize_text_field', $value);
                }
            }
        }
        
        // Update the option in the database
        update_option($option_name, $sanitized_settings);
        
        wp_send_json_success('Settings saved successfully');
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
}
