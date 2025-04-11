
<?php
/**
 * The public-facing functionality of the plugin.
 */
class CopyProtect_Public {

    /**
     * Initialize the class and set its properties.
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
        wp_enqueue_script('copyprotect-public', COPYPROTECT_PLUGIN_URL . 'public/js/copyprotect-public.js', array('jquery'), COPYPROTECT_VERSION, false);
        
        // Pass settings to JS
        $appearance_settings = get_option('copyprotect_appearance_settings', array());
        $messages = get_option('copyprotect_messages', array());
        
        wp_localize_script('copyprotect-public', 'copyprotectSettings', array(
            'showTooltip' => isset($appearance_settings['showTooltip']) ? $appearance_settings['showTooltip'] : false,
            'showModal' => isset($appearance_settings['showModal']) ? $appearance_settings['showModal'] : false,
            'showProtectedBadge' => isset($appearance_settings['showProtectedBadge']) ? $appearance_settings['showProtectedBadge'] : false,
            'tooltipText' => isset($messages['tooltipText']) ? $messages['tooltipText'] : 'Content is protected',
            'alertText' => isset($messages['alertText']) ? $messages['alertText'] : 'This content is protected. Copying is not allowed.',
            'badgeText' => isset($messages['badgeText']) ? $messages['badgeText'] : 'Protected',
            'badgePosition' => isset($appearance_settings['badgePosition']) ? $appearance_settings['badgePosition'] : 'bottom-right',
        ));
    }

    /**
     * Add protection scripts to wp_head
     */
    public function add_protection_scripts() {
        // Get settings
        $general_settings = get_option('copyprotect_general_settings', array());
        $text_settings = get_option('copyprotect_text_settings', array());
        $image_settings = get_option('copyprotect_image_settings', array());
        $js_settings = get_option('copyprotect_js_settings', array());
        $keyboard_settings = get_option('copyprotect_keyboard_settings', array());
        $advanced_settings = get_option('copyprotect_advanced_settings', array());
        
        // Check if we should apply protection
        if (!isset($general_settings['enableProtection']) || !$general_settings['enableProtection']) {
            return;
        }
        
        // Check if current page should be excluded
        $excluded_pages = isset($general_settings['excludedPages']) ? explode(',', $general_settings['excludedPages']) : array();
        if (!empty($excluded_pages)) {
            global $post;
            if ($post && in_array($post->ID, $excluded_pages)) {
                return;
            }
        }
        
        // Check post type restrictions
        if (isset($advanced_settings['enablePerPostType']) && $advanced_settings['enablePerPostType']) {
            global $post;
            if ($post) {
                $apply_to_posts = isset($advanced_settings['applyToBlogPosts']) && $advanced_settings['applyToBlogPosts'];
                $apply_to_pages = isset($advanced_settings['applyToPages']) && $advanced_settings['applyToPages'];
                $apply_to_products = isset($advanced_settings['applyToProducts']) && $advanced_settings['applyToProducts'];
                
                $post_type = get_post_type($post);
                
                // Check if we should apply to this post type
                if (($post_type == 'post' && !$apply_to_posts) || 
                    ($post_type == 'page' && !$apply_to_pages) || 
                    ($post_type == 'product' && !$apply_to_products)) {
                    return;
                }
                
                // Check categories if needed
                if ($post_type == 'post' && isset($advanced_settings['disableForCategories']) && $advanced_settings['disableForCategories']) {
                    $disabled_categories = isset($advanced_settings['disabledCategories']) ? $advanced_settings['disabledCategories'] : array();
                    $post_categories = wp_get_post_categories($post->ID);
                    
                    foreach ($post_categories as $cat_id) {
                        if (in_array($cat_id, $disabled_categories)) {
                            return; // Skip protection for this post
                        }
                    }
                }
            }
        }
        
        // Start building JavaScript protection code
        ?>
        <script type="text/javascript">
            (function() {
                'use strict';
                
                // Helper to check if any protection is active in a category
                function isAnyActive(settings, prefix) {
                    if (!settings) return false;
                    
                    for (var key in settings) {
                        if (key.indexOf(prefix) === 0 && settings[key]) {
                            return true;
                        }
                    }
                    return false;
                }
                
                <?php if (isset($text_settings['disableRightClick']) && $text_settings['disableRightClick']) : ?>
                // Disable right click - entire site
                document.addEventListener('contextmenu', function(e) {
                    e.preventDefault();
                    
                    <?php if (isset($appearance_settings['showTooltip']) && $appearance_settings['showTooltip']) : ?>
                    showTooltip(e.pageX, e.pageY);
                    <?php endif; ?>
                    
                    <?php if (isset($appearance_settings['showModal']) && $appearance_settings['showModal']) : ?>
                    showModal();
                    <?php endif; ?>
                    
                    return false;
                });
                <?php endif; ?>
                
                <?php if (isset($image_settings['disableRightClickImages']) && $image_settings['disableRightClickImages']) : ?>
                // Disable right click on images only
                document.addEventListener('contextmenu', function(e) {
                    if (e.target.tagName === 'IMG') {
                        e.preventDefault();
                        
                        <?php if (isset($appearance_settings['showTooltip']) && $appearance_settings['showTooltip']) : ?>
                        showTooltip(e.pageX, e.pageY);
                        <?php endif; ?>
                        
                        <?php if (isset($appearance_settings['showModal']) && $appearance_settings['showModal']) : ?>
                        showModal();
                        <?php endif; ?>
                        
                        return false;
                    }
                });
                <?php endif; ?>
                
                <?php if (isset($text_settings['disableTextSelection']) && $text_settings['disableTextSelection']) : ?>
                // Disable text selection
                document.body.style.userSelect = 'none';
                document.body.style.webkitUserSelect = 'none';
                document.body.style.msUserSelect = 'none';
                document.body.style.mozUserSelect = 'none';
                <?php endif; ?>
                
                <?php if (isset($text_settings['disableDragDrop']) && $text_settings['disableDragDrop']) : ?>
                // Disable drag and drop
                document.addEventListener('dragstart', function(e) {
                    e.preventDefault();
                    return false;
                });
                <?php endif; ?>
                
                <?php if (isset($image_settings['disableDraggingImages']) && $image_settings['disableDraggingImages']) : ?>
                // Disable dragging images
                document.addEventListener('dragstart', function(e) {
                    if (e.target.tagName === 'IMG') {
                        e.preventDefault();
                        return false;
                    }
                });
                <?php endif; ?>
                
                // Keyboard shortcuts protection
                document.addEventListener('keydown', function(e) {
                    <?php
                    // Developer tools shortcuts
                    if (isset($keyboard_settings['f12']) && $keyboard_settings['f12']) : ?>
                    if (e.key === 'F12') {
                        e.preventDefault();
                        return false;
                    }
                    <?php endif; ?>
                    
                    <?php if (isset($keyboard_settings['devTools']) && $keyboard_settings['devTools']) : ?>
                    if ((e.ctrlKey || e.metaKey) && e.shiftKey && (e.key.toLowerCase() === 'i' || e.key === 'I')) {
                        e.preventDefault();
                        return false;
                    }
                    <?php endif; ?>
                    
                    <?php 
                    // Selection/editing shortcuts
                    if (isset($keyboard_settings['ctrlA']) && $keyboard_settings['ctrlA']) : ?>
                    if ((e.ctrlKey || e.metaKey) && (e.key.toLowerCase() === 'a' || e.key === 'A')) {
                        e.preventDefault();
                        return false;
                    }
                    <?php endif; ?>
                    
                    <?php if (isset($keyboard_settings['ctrlC']) && $keyboard_settings['ctrlC']) : ?>
                    if ((e.ctrlKey || e.metaKey) && (e.key.toLowerCase() === 'c' || e.key === 'C')) {
                        e.preventDefault();
                        return false;
                    }
                    <?php endif; ?>
                    
                    <?php if (isset($keyboard_settings['ctrlV']) && $keyboard_settings['ctrlV']) : ?>
                    if ((e.ctrlKey || e.metaKey) && (e.key.toLowerCase() === 'v' || e.key === 'V')) {
                        e.preventDefault();
                        return false;
                    }
                    <?php endif; ?>
                    
                    <?php if (isset($keyboard_settings['ctrlX']) && $keyboard_settings['ctrlX']) : ?>
                    if ((e.ctrlKey || e.metaKey) && (e.key.toLowerCase() === 'x' || e.key === 'X')) {
                        e.preventDefault();
                        return false;
                    }
                    <?php endif; ?>
                    
                    <?php if (isset($keyboard_settings['ctrlF']) && $keyboard_settings['ctrlF']) : ?>
                    if ((e.ctrlKey || e.metaKey) && (e.key.toLowerCase() === 'f' || e.key === 'F')) {
                        e.preventDefault();
                        return false;
                    }
                    <?php endif; ?>
                    
                    <?php
                    // Navigation shortcuts
                    if (isset($keyboard_settings['f3']) && $keyboard_settings['f3']) : ?>
                    if (e.key === 'F3') {
                        e.preventDefault();
                        return false;
                    }
                    <?php endif; ?>
                    
                    <?php if (isset($keyboard_settings['f6']) && $keyboard_settings['f6']) : ?>
                    if (e.key === 'F6') {
                        e.preventDefault();
                        return false;
                    }
                    <?php endif; ?>
                    
                    <?php if (isset($keyboard_settings['f9']) && $keyboard_settings['f9']) : ?>
                    if (e.key === 'F9') {
                        e.preventDefault();
                        return false;
                    }
                    <?php endif; ?>
                    
                    <?php if (isset($keyboard_settings['ctrlH']) && $keyboard_settings['ctrlH']) : ?>
                    if ((e.ctrlKey || e.metaKey) && (e.key.toLowerCase() === 'h' || e.key === 'H')) {
                        e.preventDefault();
                        return false;
                    }
                    <?php endif; ?>
                    
                    <?php if (isset($keyboard_settings['ctrlL']) && $keyboard_settings['ctrlL']) : ?>
                    if ((e.ctrlKey || e.metaKey) && (e.key.toLowerCase() === 'l' || e.key === 'L')) {
                        e.preventDefault();
                        return false;
                    }
                    <?php endif; ?>
                    
                    <?php if (isset($keyboard_settings['ctrlK']) && $keyboard_settings['ctrlK']) : ?>
                    if ((e.ctrlKey || e.metaKey) && (e.key.toLowerCase() === 'k' || e.key === 'K')) {
                        e.preventDefault();
                        return false;
                    }
                    <?php endif; ?>
                    
                    <?php if (isset($keyboard_settings['ctrlO']) && $keyboard_settings['ctrlO']) : ?>
                    if ((e.ctrlKey || e.metaKey) && (e.key.toLowerCase() === 'o' || e.key === 'O')) {
                        e.preventDefault();
                        return false;
                    }
                    <?php endif; ?>
                    
                    <?php if (isset($keyboard_settings['altD']) && $keyboard_settings['altD']) : ?>
                    if ((e.altKey && (e.key.toLowerCase() === 'd' || e.key === 'D')) || 
                        (e.metaKey && (e.key.toLowerCase() === 'd' || e.key === 'D'))) {
                        e.preventDefault();
                        return false;
                    }
                    <?php endif; ?>
                    
                    <?php
                    // Save/print shortcuts
                    if (isset($keyboard_settings['ctrlS']) && $keyboard_settings['ctrlS']) : ?>
                    if ((e.ctrlKey || e.metaKey) && (e.key.toLowerCase() === 's' || e.key === 'S')) {
                        e.preventDefault();
                        return false;
                    }
                    <?php endif; ?>
                    
                    <?php if (isset($keyboard_settings['ctrlU']) && $keyboard_settings['ctrlU']) : ?>
                    if ((e.ctrlKey || e.metaKey) && (e.key.toLowerCase() === 'u' || e.key === 'U')) {
                        e.preventDefault();
                        return false;
                    }
                    <?php endif; ?>
                    
                    <?php if (isset($keyboard_settings['ctrlP']) && $keyboard_settings['ctrlP']) : ?>
                    if ((e.ctrlKey || e.metaKey) && (e.key.toLowerCase() === 'p' || e.key === 'P')) {
                        e.preventDefault();
                        return false;
                    }
                    <?php endif; ?>
                });
                
                <?php if (isset($js_settings['disablePrint']) && $js_settings['disablePrint']) : ?>
                // Disable printing
                window.addEventListener('beforeprint', function(e) {
                    e.preventDefault();
                    return false;
                });
                <?php endif; ?>
                
                <?php if (isset($js_settings['disableViewSource']) && $js_settings['disableViewSource']) : ?>
                // Additional measure to help prevent view source
                document.addEventListener('keydown', function(e) {
                    if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'u') {
                        e.preventDefault();
                        return false;
                    }
                });
                <?php endif; ?>
                
                <?php if (isset($js_settings['disablePageRefresh']) && $js_settings['disablePageRefresh']) : ?>
                // Try to disable page refresh
                window.addEventListener('keydown', function(e) {
                    if (e.key === 'F5' || ((e.ctrlKey || e.metaKey) && e.key === 'r')) {
                        e.preventDefault();
                        return false;
                    }
                });
                <?php endif; ?>
                
                <?php if (isset($image_settings['transparentOverlay']) && $image_settings['transparentOverlay']) : ?>
                // Add transparent overlay to images
                document.addEventListener('DOMContentLoaded', function() {
                    var images = document.getElementsByTagName('img');
                    for (var i = 0; i < images.length; i++) {
                        var img = images[i];
                        var parent = img.parentNode;
                        
                        // Create wrapper
                        var wrapper = document.createElement('div');
                        wrapper.style.position = 'relative';
                        wrapper.style.display = 'inline-block';
                        
                        // Add overlay
                        var overlay = document.createElement('div');
                        overlay.style.position = 'absolute';
                        overlay.style.top = '0';
                        overlay.style.left = '0';
                        overlay.style.width = '100%';
                        overlay.style.height = '100%';
                        overlay.style.zIndex = '10';
                        
                        // Replace img with wrapper
                        parent.replaceChild(wrapper, img);
                        wrapper.appendChild(img);
                        wrapper.appendChild(overlay);
                    }
                });
                <?php endif; ?>
                
                <?php if (isset($js_settings['antiInspectTool']) && $js_settings['antiInspectTool']) : ?>
                // Anti-inspect tool
                (function() {
                    function detectDevTools() {
                        var isOpen = false;
                        
                        // Check for devtools via console.log
                        var checkDevConsole = function() {
                            var startTime = new Date();
                            debugger;
                            return new Date() - startTime > 100;
                        };
                        
                        // Detect via window size (works in some browsers)
                        var checkWindowSize = function() {
                            var widthThreshold = window.outerWidth - window.innerWidth > 160;
                            var heightThreshold = window.outerHeight - window.innerHeight > 160;
                            return widthThreshold || heightThreshold;
                        };
                        
                        // Check periodically
                        setInterval(function() {
                            var devToolsOpen = checkDevConsole() || checkWindowSize();
                            
                            if (devToolsOpen && !isOpen) {
                                isOpen = true;
                                
                                // Blur page content
                                document.body.style.filter = 'blur(5px)';
                                document.body.style.pointerEvents = 'none';
                                
                                // Optional: Show warning
                                var warning = document.createElement('div');
                                warning.style.position = 'fixed';
                                warning.style.top = '0';
                                warning.style.left = '0';
                                warning.style.width = '100%';
                                warning.style.height = '100%';
                                warning.style.background = 'rgba(0,0,0,0.8)';
                                warning.style.color = '#fff';
                                warning.style.zIndex = '9999';
                                warning.style.display = 'flex';
                                warning.style.justifyContent = 'center';
                                warning.style.alignItems = 'center';
                                warning.style.fontSize = '24px';
                                warning.style.textAlign = 'center';
                                warning.style.padding = '20px';
                                warning.innerHTML = 'Developer tools detected. Page functionality limited.';
                                
                                document.body.appendChild(warning);
                            } else if (!devToolsOpen && isOpen) {
                                isOpen = false;
                                document.body.style.filter = '';
                                document.body.style.pointerEvents = '';
                                var warning = document.querySelector('div[style*="position: fixed"][style*="z-index: 9999"]');
                                if (warning) {
                                    warning.parentNode.removeChild(warning);
                                }
                            }
                        }, 1000);
                    }
                    
                    detectDevTools();
                })();
                <?php endif; ?>
                
                <?php if (isset($appearance_settings['showTooltip']) && $appearance_settings['showTooltip']) : ?>
                // Tooltip functionality
                var tooltipTimeout;
                
                function showTooltip(x, y) {
                    clearTimeout(tooltipTimeout);
                    
                    // Remove any existing tooltip
                    var existingTooltip = document.querySelector('.copyprotect-tooltip');
                    if (existingTooltip) {
                        document.body.removeChild(existingTooltip);
                    }
                    
                    // Create tooltip
                    var tooltip = document.createElement('div');
                    tooltip.className = 'copyprotect-tooltip';
                    tooltip.innerHTML = '<?php echo esc_js($messages['tooltipText'] ?? 'Content is protected'); ?>';
                    tooltip.style.left = x + 'px';
                    tooltip.style.top = (y - 40) + 'px';
                    
                    document.body.appendChild(tooltip);
                    
                    // Auto-hide after 2 seconds
                    tooltipTimeout = setTimeout(function() {
                        if (tooltip.parentNode) {
                            document.body.removeChild(tooltip);
                        }
                    }, 2000);
                }
                <?php endif; ?>
                
                <?php if (isset($appearance_settings['showModal']) && $appearance_settings['showModal']) : ?>
                // Modal functionality
                var modalShown = false;
                
                function showModal() {
                    if (modalShown) return;
                    modalShown = true;
                    
                    // Remove any existing modal
                    var existingModal = document.querySelector('.copyprotect-modal');
                    if (existingModal) {
                        document.body.removeChild(existingModal);
                    }
                    
                    // Create modal
                    var modal = document.createElement('div');
                    modal.className = 'copyprotect-modal';
                    
                    var modalContent = document.createElement('div');
                    modalContent.className = 'copyprotect-modal-content';
                    modalContent.innerHTML = '<?php echo esc_js($messages['alertText'] ?? 'This content is protected. Copying is not allowed.'); ?>';
                    
                    var closeButton = document.createElement('button');
                    closeButton.className = 'copyprotect-modal-close';
                    closeButton.innerHTML = 'Close';
                    closeButton.onclick = function() {
                        document.body.removeChild(modal);
                        modalShown = false;
                    };
                    
                    modalContent.appendChild(document.createElement('br'));
                    modalContent.appendChild(closeButton);
                    modal.appendChild(modalContent);
                    document.body.appendChild(modal);
                }
                <?php endif; ?>
                
                <?php if (isset($appearance_settings['showProtectedBadge']) && $appearance_settings['showProtectedBadge']) : ?>
                // Add protected badge
                document.addEventListener('DOMContentLoaded', function() {
                    var badge = document.createElement('div');
                    badge.className = 'copyprotect-badge';
                    badge.innerHTML = '<span class="copyprotect-badge-icon">🔒</span> <?php echo esc_js($messages['badgeText'] ?? 'Protected'); ?>';
                    
                    // Position
                    var position = '<?php echo esc_js($appearance_settings['badgePosition'] ?? 'bottom-right'); ?>';
                    badge.classList.add('copyprotect-badge-' + position);
                    
                    document.body.appendChild(badge);
                });
                <?php endif; ?>
            })();
        </script>
        <?php
    }
}
