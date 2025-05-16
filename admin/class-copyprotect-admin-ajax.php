
<?php
/**
 * The admin AJAX handling class.
 * Processes AJAX requests in the admin area.
 *
 * @since      1.0.0
 * @package    CopyProtect
 * @subpackage CopyProtect/admin
 */
class CopyProtect_Admin_Ajax {
    
    /**
     * AJAX handler for saving settings
     */
    public function save_settings() {
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
        
        // Get the settings handler class
        $settings_handler = new CopyProtect_Admin_Settings();
        $sanitize_method = 'sanitize_' . $settings_type;
        
        // Sanitize settings using the appropriate method if it exists
        if (method_exists($settings_handler, $sanitize_method)) {
            $sanitized_settings = call_user_func(array($settings_handler, $sanitize_method), $settings);
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
}
