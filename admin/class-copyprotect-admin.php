
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
        // Default values for options
        $default_general = array(
            'enableProtection' => false,
            'showFrontendNotice' => false,
            'disableForLoggedIn' => true,
            'compatibilityMode' => false,
        );

        $default_text = array(
            'disableRightClick' => true,
            'disableTextSelection' => true,
            'disableDragDrop' => true,
            'disableKeyboardShortcuts' => true,
            'keyboardShortcuts' => array(
                'ctrlA' => true,
                'ctrlC' => true,
                'ctrlX' => true,
                'ctrlS' => true,
                'ctrlU' => true,
                'f12' => true,
            ),
        );

        $default_image = array(
            'disableRightClickImages' => true,
            'disableDraggingImages' => true,
            'transparentOverlay' => false,
            'serveCssBackground' => false,
            'preventHotlinking' => true,
            'lazyLoadWithObfuscation' => false,
        );

        $default_js = array(
            'disablePrint' => true,
            'disableViewSource' => true,
            'obfuscateHtml' => false,
            'disablePageRefresh' => false,
            'antiInspectTool' => false,
        );

        $default_appearance = array(
            'showTooltip' => true,
            'showModal' => false,
            'showProtectedBadge' => true,
        );

        $default_messages = array(
            'tooltipText' => 'Content is protected',
            'alertText' => 'This content is protected. Copying is not allowed.',
            'badgeText' => 'Protected',
        );

        $default_advanced = array(
            'enablePerPostType' => false,
            'applyToBlogPosts' => true,
            'applyToPages' => true,
            'applyToProducts' => true,
            'disableForCategories' => false,
        );

        // Get saved options
        $general_settings = get_option('copyprotect_general_settings', $default_general);
        $text_settings = get_option('copyprotect_text_settings', $default_text);
        $image_settings = get_option('copyprotect_image_settings', $default_image);
        $js_settings = get_option('copyprotect_js_settings', $default_js);
        $appearance_settings = get_option('copyprotect_appearance_settings', $default_appearance);
        $messages = get_option('copyprotect_messages', $default_messages);
        $advanced_settings = get_option('copyprotect_advanced_settings', $default_advanced);

        // Include the template to display the settings
        include_once COPYPROTECT_PLUGIN_DIR . 'admin/partials/copyprotect-admin-display.php';
    }
}
