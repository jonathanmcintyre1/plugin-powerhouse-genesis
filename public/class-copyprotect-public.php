
<?php
/**
 * The public-facing functionality of the plugin.
 */
class CopyProtect_Public {

    /**
     * Initialize the class.
     */
    public function __construct() {}

    /**
     * Register the stylesheets for the public-facing side of the site.
     */
    public function enqueue_styles() {
        wp_enqueue_style('copyprotect-public', COPYPROTECT_PLUGIN_URL . 'public/css/copyprotect-public.css', array(), COPYPROTECT_VERSION, 'all');
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     */
    public function enqueue_scripts() {
        wp_enqueue_script('copyprotect-public', COPYPROTECT_PLUGIN_URL . 'public/js/copyprotect-public.js', array('jquery'), COPYPROTECT_VERSION, true);
        
        // Pass settings to JS
        $this->localize_script_data();
    }

    /**
     * Pass plugin settings to JavaScript
     */
    private function localize_script_data() {
        $general_settings = get_option('copyprotect_general_settings', array());
        $text_settings = get_option('copyprotect_text_settings', array());
        $image_settings = get_option('copyprotect_image_settings', array());
        $js_settings = get_option('copyprotect_js_settings', array());
        $appearance_settings = get_option('copyprotect_appearance_settings', array());
        $messages = get_option('copyprotect_messages', array());
        $advanced_settings = get_option('copyprotect_advanced_settings', array());
        
        // Check if we should apply protection based on post type
        $apply_protection = true;
        
        if (isset($advanced_settings['enablePerPostType']) && $advanced_settings['enablePerPostType']) {
            $apply_protection = false;
            
            if (is_single() && isset($advanced_settings['applyToBlogPosts']) && $advanced_settings['applyToBlogPosts']) {
                // Check for excluded categories
                if (isset($advanced_settings['disableForCategories']) && $advanced_settings['disableForCategories']) {
                    $excluded_categories = isset($advanced_settings['excludedCategories']) ? (array) $advanced_settings['excludedCategories'] : array();
                    $post_categories = wp_get_post_categories(get_the_ID());
                    
                    $has_excluded_category = false;
                    foreach ($post_categories as $category) {
                        if (in_array($category, $excluded_categories)) {
                            $has_excluded_category = true;
                            break;
                        }
                    }
                    
                    $apply_protection = !$has_excluded_category;
                } else {
                    $apply_protection = true;
                }
            } elseif (is_page() && isset($advanced_settings['applyToPages']) && $advanced_settings['applyToPages']) {
                $apply_protection = true;
            } elseif (function_exists('is_product') && is_product() && isset($advanced_settings['applyToProducts']) && $advanced_settings['applyToProducts']) {
                $apply_protection = true;
            }
        }
        
        // Check if user is logged in and we should disable protection
        if (isset($general_settings['disableForLoggedIn']) && $general_settings['disableForLoggedIn'] && is_user_logged_in()) {
            $apply_protection = false;
        }
        
        // Don't apply protection in admin area
        if (is_admin()) {
            $apply_protection = false;
        }
        
        // Combine all settings into one array for JavaScript
        $settings = array(
            'textProtection' => $text_settings,
            'imageProtection' => $image_settings,
            'jsProtection' => $js_settings,
            'appearance' => $appearance_settings,
            'messages' => $messages,
            'applyProtection' => $apply_protection
        );
        
        wp_localize_script('copyprotect-public', 'copyProtectSettings', $settings);
    }
    
    /**
     * Add protection scripts directly to the head if needed
     */
    public function add_protection_scripts() {
        $appearance_settings = get_option('copyprotect_appearance_settings', array());
        $messages = get_option('copyprotect_messages', array());
        
        // Add protected badge if enabled
        if (isset($appearance_settings['showProtectedBadge']) && $appearance_settings['showProtectedBadge']) {
            $badge_position = isset($appearance_settings['badgePosition']) ? $appearance_settings['badgePosition'] : 'bottom-right';
            $badge_text = isset($messages['badgeText']) ? esc_html($messages['badgeText']) : 'Protected';
            
            $position_class = '';
            switch ($badge_position) {
                case 'top-left':
                    $position_class = 'top-left';
                    break;
                case 'top-right':
                    $position_class = 'top-right';
                    break;
                case 'bottom-left':
                    $position_class = 'bottom-left';
                    break;
                case 'bottom-right':
                default:
                    $position_class = 'bottom-right';
                    break;
            }
            
            echo '<div id="copyprotect-badge" class="' . esc_attr($position_class) . '">' . $badge_text . '</div>';
        }
        
        // Add any immediate protection scripts if needed
        $image_settings = get_option('copyprotect_image_settings', array());
        
        // Add image hotlinking protection if enabled
        if (isset($image_settings['preventHotlinking']) && $image_settings['preventHotlinking']) {
            echo "<script>
                // Simple anti-hotlinking script
                document.addEventListener('DOMContentLoaded', function() {
                    var images = document.getElementsByTagName('img');
                    for (var i = 0; i < images.length; i++) {
                        images[i].addEventListener('error', function() {
                            this.style.display = 'none';
                        });
                    }
                });
            </script>";
        }
    }
}
