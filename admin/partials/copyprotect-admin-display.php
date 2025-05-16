
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
?>

<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    <div id="copyprotect-root" class="copyprotect-admin-container"></div>
</div>

<script type="text/javascript">
    // Pass settings as a global variable to the React app
    var copyProtectSettings = {
        generalSettings: <?php echo json_encode(get_option('copyprotect_general_settings', array())); ?>,
        textSettings: <?php echo json_encode(get_option('copyprotect_text_settings', array())); ?>,
        keyboardSettings: <?php echo json_encode(get_option('copyprotect_keyboard_settings', array())); ?>,
        imageSettings: <?php echo json_encode(get_option('copyprotect_image_settings', array())); ?>,
        jsSettings: <?php echo json_encode(get_option('copyprotect_js_settings', array())); ?>,
        appearanceSettings: <?php echo json_encode(get_option('copyprotect_appearance_settings', array())); ?>,
        messages: <?php echo json_encode(get_option('copyprotect_messages', array())); ?>,
        advancedSettings: <?php echo json_encode(get_option('copyprotect_advanced_settings', array())); ?>,
        ajaxUrl: "<?php echo esc_url(admin_url('admin-ajax.php')); ?>",
        nonce: "<?php echo wp_create_nonce('copyprotect-admin-nonce'); ?>",
        pluginUrl: "<?php echo COPYPROTECT_PLUGIN_URL; ?>",
    };
</script>
