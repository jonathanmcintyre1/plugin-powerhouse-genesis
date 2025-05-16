
<?php
/**
 * The admin settings management class.
 * Handles settings registration and sanitization.
 *
 * @since      1.0.0
 * @package    CopyProtect
 * @subpackage CopyProtect/admin
 */
class CopyProtect_Admin_Settings {

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
}
