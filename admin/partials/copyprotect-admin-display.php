
<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://example.com
 * @since      1.0.0
 *
 * @package    CopyProtect
 * @subpackage CopyProtect/admin/partials
 */

// Prevent direct access
if (!defined('WPINC')) {
    die;
}

// Get all settings from the database with defaults
$general_settings = get_option('copyprotect_general_settings', array(
    'enableProtection' => false,
    'showFrontendNotice' => false,
    'disableForLoggedIn' => false,
    'compatibilityMode' => false,
    'excludedPages' => array(),
));

$text_settings = get_option('copyprotect_text_settings', array(
    'disableRightClick' => false,
    'disableTextSelection' => false,
    'disableDragDrop' => false,
));

$keyboard_settings = get_option('copyprotect_keyboard_settings', array(
    'f12' => false,
    'devTools' => false,
    'ctrlA' => false,
    'ctrlC' => false,
    'ctrlV' => false,
    'ctrlX' => false,
    'ctrlF' => false,
    'f3' => false,
    'f6' => false,
    'f9' => false,
    'ctrlH' => false,
    'ctrlL' => false,
    'ctrlK' => false,
    'ctrlO' => false,
    'altD' => false,
    'ctrlS' => false,
    'ctrlP' => false,
    'ctrlU' => false,
));

$image_settings = get_option('copyprotect_image_settings', array(
    'disableRightClickImages' => false,
    'disableDraggingImages' => false,
    'transparentOverlay' => false,
    'serveCssBackground' => false,
    'preventHotlinking' => false,
    'lazyLoadWithObfuscation' => false,
));

$js_settings = get_option('copyprotect_js_settings', array(
    'disablePrint' => false,
    'disableViewSource' => false,
    'obfuscateHtml' => false,
    'disablePageRefresh' => false,
    'antiInspectTool' => false,
));

$appearance_settings = get_option('copyprotect_appearance_settings', array(
    'showTooltip' => false,
    'showModal' => false,
    'showProtectedBadge' => false,
    'badgePosition' => 'bottom-right',
));

$messages = get_option('copyprotect_messages', array(
    'tooltipText' => 'Content is protected',
    'alertText' => 'This content is protected. Copying is not allowed.',
    'badgeText' => 'Protected',
));

$advanced_settings = get_option('copyprotect_advanced_settings', array(
    'enablePerPostType' => false,
    'applyToBlogPosts' => false,
    'applyToPages' => false,
    'applyToProducts' => false,
    'disableForCategories' => false,
    'disabledCategories' => array(),
));
?>

<div class="wrap copyprotect-admin-wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    
    <?php
    // Show admin notices if needed
    if (isset($_GET['settings-updated'])) {
        add_settings_error('copyprotect_messages', 'copyprotect_message', __('Settings Saved', 'copyprotect'), 'updated');
        settings_errors('copyprotect_messages');
    }
    ?>
    
    <div id="copyprotect-root" class="copyprotect-admin-container">
        <!-- React app will be rendered here -->
        <div class="copyprotect-loading">
            <p><?php _e('Loading CopyProtect Settings...', 'copyprotect'); ?></p>
        </div>
    </div>
</div>

<script type="text/javascript">
    // Pass settings as a global variable to the React app
    var copyProtectSettings = {
        generalSettings: <?php echo wp_json_encode($general_settings); ?>,
        textSettings: <?php echo wp_json_encode($text_settings); ?>,
        keyboardSettings: <?php echo wp_json_encode($keyboard_settings); ?>,
        imageSettings: <?php echo wp_json_encode($image_settings); ?>,
        jsSettings: <?php echo wp_json_encode($js_settings); ?>,
        appearanceSettings: <?php echo wp_json_encode($appearance_settings); ?>,
        messages: <?php echo wp_json_encode($messages); ?>,
        advancedSettings: <?php echo wp_json_encode($advanced_settings); ?>,
        ajaxUrl: "<?php echo esc_url(admin_url('admin-ajax.php')); ?>",
        nonce: "<?php echo wp_create_nonce('copyprotect-admin-nonce'); ?>",
        pluginUrl: "<?php echo esc_url(COPYPROTECT_PLUGIN_URL); ?>",
    };
</script>

<style>
    /* Add some basic loading styles */
    .copyprotect-loading {
        text-align: center;
        padding: 2rem;
        font-size: 1.2rem;
        color: #666;
    }
    
    /* Hide WordPress admin footer on our page for a cleaner look */
    .copyprotect-admin-wrap + #wpfooter {
        display: none;
    }
    
    /* Additional CSS for better WordPress admin integration */
    .copyprotect-admin-container {
        margin-top: 20px;
    }
</style>
