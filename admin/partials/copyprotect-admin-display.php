
<?php
/**
 * Admin settings page template
 */
// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}
?>

<div class="wrap copyprotect-admin">
    <h1>CopyProtect - Content & Image Protection</h1>
    <p class="description"><?php _e('Configure protection settings for your content', 'copyprotect'); ?></p>

    <?php if (isset($_GET['settings-updated']) && $_GET['settings-updated']) : ?>
        <div class="notice notice-success is-dismissible">
            <p><?php _e('Settings saved successfully!', 'copyprotect'); ?></p>
        </div>
    <?php endif; ?>

    <div class="copyprotect-tabs">
        <h2 class="nav-tab-wrapper">
            <a href="#general" class="nav-tab nav-tab-active"><?php _e('General', 'copyprotect'); ?></a>
            <a href="#text" class="nav-tab"><?php _e('Text Protection', 'copyprotect'); ?></a>
            <a href="#image" class="nav-tab"><?php _e('Image Protection', 'copyprotect'); ?></a>
            <a href="#javascript" class="nav-tab"><?php _e('JavaScript Behavior', 'copyprotect'); ?></a>
            <a href="#appearance" class="nav-tab"><?php _e('Appearance & Messaging', 'copyprotect'); ?></a>
            <a href="#advanced" class="nav-tab"><?php _e('Advanced Rules', 'copyprotect'); ?></a>
            <a href="#help" class="nav-tab"><?php _e('Help & Support', 'copyprotect'); ?></a>
        </h2>

        <div class="copyprotect-tab-content">
            <!-- General Settings Tab -->
            <div id="general" class="tab-pane active">
                <form method="post" action="options.php">
                    <?php 
                    settings_fields('copyprotect_general_settings');
                    ?>

                    <div class="card">
                        <h3><?php _e('Core Protection Settings', 'copyprotect'); ?></h3>
                        <p class="description"><?php _e('Configure the global protection behavior for your content', 'copyprotect'); ?></p>
                        
                        <table class="form-table">
                            <tr>
                                <th scope="row"><?php _e('Enable Content Protection', 'copyprotect'); ?></th>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="copyprotect_general_settings[enableProtection]" value="1" <?php checked(isset($general_settings['enableProtection']) ? $general_settings['enableProtection'] : false); ?>>
                                        <span class="slider round"></span>
                                    </label>
                                    <p class="description"><?php _e('Master switch to enable or disable all protection features', 'copyprotect'); ?></p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?php _e('Show Frontend Notice', 'copyprotect'); ?></th>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="copyprotect_general_settings[showFrontendNotice]" value="1" <?php checked(isset($general_settings['showFrontendNotice']) ? $general_settings['showFrontendNotice'] : false); ?> <?php disabled(!isset($general_settings['enableProtection']) || !$general_settings['enableProtection']); ?>>
                                        <span class="slider round"></span>
                                    </label>
                                    <p class="description"><?php _e('Display a subtle "Content Protected" badge on your pages', 'copyprotect'); ?></p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?php _e('Disable for Logged-in Users', 'copyprotect'); ?></th>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="copyprotect_general_settings[disableForLoggedIn]" value="1" <?php checked(isset($general_settings['disableForLoggedIn']) ? $general_settings['disableForLoggedIn'] : false); ?> <?php disabled(!isset($general_settings['enableProtection']) || !$general_settings['enableProtection']); ?>>
                                        <span class="slider round"></span>
                                    </label>
                                    <p class="description"><?php _e('Allow registered users to freely interact with your content', 'copyprotect'); ?></p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?php _e('Compatibility Mode', 'copyprotect'); ?></th>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="copyprotect_general_settings[compatibilityMode]" value="1" <?php checked(isset($general_settings['compatibilityMode']) ? $general_settings['compatibilityMode'] : false); ?> <?php disabled(!isset($general_settings['enableProtection']) || !$general_settings['enableProtection']); ?>>
                                        <span class="slider round"></span>
                                    </label>
                                    <p class="description"><?php _e('Reduce potential conflicts with other plugins or themes', 'copyprotect'); ?></p>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <p class="submit">
                        <input type="submit" class="button-primary" value="<?php _e('Save Changes', 'copyprotect'); ?>" />
                    </p>
                </form>
            </div>

            <!-- Text Protection Tab -->
            <div id="text" class="tab-pane">
                <form method="post" action="options.php">
                    <?php 
                    settings_fields('copyprotect_text_settings');
                    ?>

                    <div class="card">
                        <h3><?php _e('Text Selection Protection', 'copyprotect'); ?></h3>
                        <p class="description"><?php _e('Prevent text selection, copying, or dragging text from your content', 'copyprotect'); ?></p>
                        
                        <table class="form-table">
                            <tr>
                                <th scope="row"><?php _e('Disable Right Click', 'copyprotect'); ?></th>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="copyprotect_text_settings[disableRightClick]" value="1" <?php checked(isset($text_settings['disableRightClick']) ? $text_settings['disableRightClick'] : false); ?>>
                                        <span class="slider round"></span>
                                    </label>
                                    <p class="description"><?php _e('Prevents context menu from appearing when right-clicking on text', 'copyprotect'); ?></p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?php _e('Disable Text Selection', 'copyprotect'); ?></th>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="copyprotect_text_settings[disableTextSelection]" value="1" <?php checked(isset($text_settings['disableTextSelection']) ? $text_settings['disableTextSelection'] : false); ?>>
                                        <span class="slider round"></span>
                                    </label>
                                    <p class="description"><?php _e('Prevents users from selecting and highlighting text on your site', 'copyprotect'); ?></p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?php _e('Disable Drag and Drop', 'copyprotect'); ?></th>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="copyprotect_text_settings[disableDragDrop]" value="1" <?php checked(isset($text_settings['disableDragDrop']) ? $text_settings['disableDragDrop'] : false); ?>>
                                        <span class="slider round"></span>
                                    </label>
                                    <p class="description"><?php _e('Prevents users from dragging content from your site', 'copyprotect'); ?></p>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="card">
                        <h3><?php _e('Keyboard Shortcuts Protection', 'copyprotect'); ?></h3>
                        <p class="description"><?php _e('Block common keyboard shortcuts used to copy or save content', 'copyprotect'); ?></p>
                        
                        <table class="form-table">
                            <tr>
                                <th scope="row"><?php _e('Disable Keyboard Shortcuts', 'copyprotect'); ?></th>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="copyprotect_text_settings[disableKeyboardShortcuts]" value="1" <?php checked(isset($text_settings['disableKeyboardShortcuts']) ? $text_settings['disableKeyboardShortcuts'] : false); ?> class="toggle-control">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                            </tr>
                        </table>

                        <div class="shortcut-options" <?php echo (!isset($text_settings['disableKeyboardShortcuts']) || !$text_settings['disableKeyboardShortcuts']) ? 'style="display: none;"' : ''; ?>>
                            <table class="form-table">
                                <tr>
                                    <th scope="row"><?php _e('Ctrl + A (Select All)', 'copyprotect'); ?></th>
                                    <td>
                                        <label class="switch">
                                            <input type="checkbox" name="copyprotect_text_settings[keyboardShortcuts][ctrlA]" value="1" <?php checked(isset($text_settings['keyboardShortcuts']['ctrlA']) ? $text_settings['keyboardShortcuts']['ctrlA'] : false); ?>>
                                            <span class="slider round"></span>
                                        </label>
                                        <p class="description"><?php _e('Block the Select All shortcut', 'copyprotect'); ?></p>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"><?php _e('Ctrl + C (Copy)', 'copyprotect'); ?></th>
                                    <td>
                                        <label class="switch">
                                            <input type="checkbox" name="copyprotect_text_settings[keyboardShortcuts][ctrlC]" value="1" <?php checked(isset($text_settings['keyboardShortcuts']['ctrlC']) ? $text_settings['keyboardShortcuts']['ctrlC'] : false); ?>>
                                            <span class="slider round"></span>
                                        </label>
                                        <p class="description"><?php _e('Block the Copy shortcut', 'copyprotect'); ?></p>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"><?php _e('Ctrl + X (Cut)', 'copyprotect'); ?></th>
                                    <td>
                                        <label class="switch">
                                            <input type="checkbox" name="copyprotect_text_settings[keyboardShortcuts][ctrlX]" value="1" <?php checked(isset($text_settings['keyboardShortcuts']['ctrlX']) ? $text_settings['keyboardShortcuts']['ctrlX'] : false); ?>>
                                            <span class="slider round"></span>
                                        </label>
                                        <p class="description"><?php _e('Block the Cut shortcut', 'copyprotect'); ?></p>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"><?php _e('Ctrl + S (Save)', 'copyprotect'); ?></th>
                                    <td>
                                        <label class="switch">
                                            <input type="checkbox" name="copyprotect_text_settings[keyboardShortcuts][ctrlS]" value="1" <?php checked(isset($text_settings['keyboardShortcuts']['ctrlS']) ? $text_settings['keyboardShortcuts']['ctrlS'] : false); ?>>
                                            <span class="slider round"></span>
                                        </label>
                                        <p class="description"><?php _e('Block the Save shortcut', 'copyprotect'); ?></p>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"><?php _e('Ctrl + U (View Source)', 'copyprotect'); ?></th>
                                    <td>
                                        <label class="switch">
                                            <input type="checkbox" name="copyprotect_text_settings[keyboardShortcuts][ctrlU]" value="1" <?php checked(isset($text_settings['keyboardShortcuts']['ctrlU']) ? $text_settings['keyboardShortcuts']['ctrlU'] : false); ?>>
                                            <span class="slider round"></span>
                                        </label>
                                        <p class="description"><?php _e('Block View Source shortcut', 'copyprotect'); ?></p>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"><?php _e('F12 (Dev Tools)', 'copyprotect'); ?></th>
                                    <td>
                                        <label class="switch">
                                            <input type="checkbox" name="copyprotect_text_settings[keyboardShortcuts][f12]" value="1" <?php checked(isset($text_settings['keyboardShortcuts']['f12']) ? $text_settings['keyboardShortcuts']['f12'] : false); ?>>
                                            <span class="slider round"></span>
                                        </label>
                                        <p class="description"><?php _e('Block Developer Tools access', 'copyprotect'); ?></p>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <p class="submit">
                        <input type="submit" class="button-primary" value="<?php _e('Save Changes', 'copyprotect'); ?>" />
                    </p>
                </form>
            </div>

            <!-- Image Protection Tab -->
            <div id="image" class="tab-pane">
                <form method="post" action="options.php">
                    <?php 
                    settings_fields('copyprotect_image_settings');
                    ?>

                    <div class="card">
                        <h3><?php _e('Image Interaction Protection', 'copyprotect'); ?></h3>
                        <p class="description"><?php _e('Prevent direct saving, dragging, or inspecting images', 'copyprotect'); ?></p>
                        
                        <table class="form-table">
                            <tr>
                                <th scope="row"><?php _e('Disable Right Click on Images Only', 'copyprotect'); ?></th>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="copyprotect_image_settings[disableRightClickImages]" value="1" <?php checked(isset($image_settings['disableRightClickImages']) ? $image_settings['disableRightClickImages'] : false); ?>>
                                        <span class="slider round"></span>
                                    </label>
                                    <p class="description"><?php _e('Allow right-clicking on text, but prevent it on images', 'copyprotect'); ?></p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?php _e('Disable Dragging of Images', 'copyprotect'); ?></th>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="copyprotect_image_settings[disableDraggingImages]" value="1" <?php checked(isset($image_settings['disableDraggingImages']) ? $image_settings['disableDraggingImages'] : false); ?>>
                                        <span class="slider round"></span>
                                    </label>
                                    <p class="description"><?php _e('Prevent users from dragging images to save them', 'copyprotect'); ?></p>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="card">
                        <h3><?php _e('Image Source Protection', 'copyprotect'); ?></h3>
                        <p class="description"><?php _e('Advanced methods to protect image sources and prevent saving', 'copyprotect'); ?></p>
                        
                        <table class="form-table">
                            <tr>
                                <th scope="row"><?php _e('Transparent Overlay Layer on Images', 'copyprotect'); ?></th>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="copyprotect_image_settings[transparentOverlay]" value="1" <?php checked(isset($image_settings['transparentOverlay']) ? $image_settings['transparentOverlay'] : false); ?>>
                                        <span class="slider round"></span>
                                    </label>
                                    <p class="description"><?php _e('Place invisible layer over images to prevent direct interaction', 'copyprotect'); ?></p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?php _e('Serve Images via CSS Background', 'copyprotect'); ?></th>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="copyprotect_image_settings[serveCssBackground]" value="1" <?php checked(isset($image_settings['serveCssBackground']) ? $image_settings['serveCssBackground'] : false); ?>>
                                        <span class="slider round"></span>
                                    </label>
                                    <p class="description"><?php _e('Display images as CSS backgrounds to obscure image source', 'copyprotect'); ?></p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?php _e('Prevent Image Hotlinking', 'copyprotect'); ?></th>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="copyprotect_image_settings[preventHotlinking]" value="1" <?php checked(isset($image_settings['preventHotlinking']) ? $image_settings['preventHotlinking'] : false); ?>>
                                        <span class="slider round"></span>
                                    </label>
                                    <p class="description"><?php _e('Block other websites from embedding your images directly', 'copyprotect'); ?></p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?php _e('Lazy Load with Obfuscation', 'copyprotect'); ?></th>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="copyprotect_image_settings[lazyLoadWithObfuscation]" value="1" <?php checked(isset($image_settings['lazyLoadWithObfuscation']) ? $image_settings['lazyLoadWithObfuscation'] : false); ?>>
                                        <span class="slider round"></span>
                                    </label>
                                    <p class="description"><?php _e('Load images with delay & via JS to confuse scraping bots', 'copyprotect'); ?></p>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <p class="submit">
                        <input type="submit" class="button-primary" value="<?php _e('Save Changes', 'copyprotect'); ?>" />
                    </p>
                </form>
            </div>

            <!-- JavaScript Behavior Tab -->
            <div id="javascript" class="tab-pane">
                <form method="post" action="options.php">
                    <?php 
                    settings_fields('copyprotect_js_settings');
                    ?>

                    <div class="card">
                        <h3><?php _e('Browser Interaction Controls', 'copyprotect'); ?></h3>
                        <p class="description"><?php _e('Customize JavaScript behavior to control browser interactions', 'copyprotect'); ?></p>
                        
                        <table class="form-table">
                            <tr>
                                <th scope="row"><?php _e('Disable Print', 'copyprotect'); ?></th>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="copyprotect_js_settings[disablePrint]" value="1" <?php checked(isset($js_settings['disablePrint']) ? $js_settings['disablePrint'] : false); ?>>
                                        <span class="slider round"></span>
                                    </label>
                                    <p class="description"><?php _e('Block printing functionality (Ctrl+P) for your content', 'copyprotect'); ?></p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?php _e('Disable View Source', 'copyprotect'); ?></th>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="copyprotect_js_settings[disableViewSource]" value="1" <?php checked(isset($js_settings['disableViewSource']) ? $js_settings['disableViewSource'] : false); ?>>
                                        <span class="slider round"></span>
                                    </label>
                                    <p class="description"><?php _e('Block right-click > inspect and view-source shortcuts', 'copyprotect'); ?></p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?php _e('Obfuscate HTML', 'copyprotect'); ?></th>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="copyprotect_js_settings[obfuscateHtml]" value="1" <?php checked(isset($js_settings['obfuscateHtml']) ? $js_settings['obfuscateHtml'] : false); ?>>
                                        <span class="slider round"></span>
                                    </label>
                                    <p class="description"><?php _e('Lightweight JS encoding of DOM until page load to deter scraping', 'copyprotect'); ?></p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?php _e('Disable Page Refresh', 'copyprotect'); ?></th>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="copyprotect_js_settings[disablePageRefresh]" value="1" <?php checked(isset($js_settings['disablePageRefresh']) ? $js_settings['disablePageRefresh'] : false); ?>>
                                        <span class="slider round"></span>
                                    </label>
                                    <p class="description"><?php _e('Prevent users from refreshing the page (use with caution)', 'copyprotect'); ?></p>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="card">
                        <h3><?php _e('Advanced Protection', 'copyprotect'); ?></h3>
                        <p class="description"><?php _e('Additional protection features with stronger enforcement', 'copyprotect'); ?></p>
                        
                        <?php if(isset($js_settings['antiInspectTool']) && $js_settings['antiInspectTool']) : ?>
                        <div class="notice notice-warning">
                            <p><strong><?php _e('Warning', 'copyprotect'); ?></strong></p>
                            <p><?php _e('This feature can disrupt user experience. Use only if absolutely necessary for content protection.', 'copyprotect'); ?></p>
                        </div>
                        <?php endif; ?>
                        
                        <table class="form-table">
                            <tr>
                                <th scope="row"><?php _e('Anti-Inspect Tool', 'copyprotect'); ?></th>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="copyprotect_js_settings[antiInspectTool]" value="1" <?php checked(isset($js_settings['antiInspectTool']) ? $js_settings['antiInspectTool'] : false); ?>>
                                        <span class="slider round"></span>
                                    </label>
                                    <p class="description"><?php _e('Blur page or redirect if DevTools opens (use sparingly)', 'copyprotect'); ?></p>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <p class="submit">
                        <input type="submit" class="button-primary" value="<?php _e('Save Changes', 'copyprotect'); ?>" />
                    </p>
                </form>
            </div>

            <!-- Appearance & Messaging Tab -->
            <div id="appearance" class="tab-pane">
                <form method="post" action="options.php">
                    <?php 
                    settings_fields('copyprotect_appearance_settings');
                    settings_fields('copyprotect_messages');
                    ?>

                    <div class="card">
                        <h3><?php _e('User Notifications', 'copyprotect'); ?></h3>
                        <p class="description"><?php _e('Customize how users are notified about content protection', 'copyprotect'); ?></p>
                        
                        <table class="form-table">
                            <tr>
                                <th scope="row"><?php _e('Show Tooltip on Right Click', 'copyprotect'); ?></th>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="copyprotect_appearance_settings[showTooltip]" value="1" <?php checked(isset($appearance_settings['showTooltip']) ? $appearance_settings['showTooltip'] : false); ?> class="toggle-control">
                                        <span class="slider round"></span>
                                    </label>
                                    <p class="description"><?php _e('Display a tooltip when users attempt to right-click', 'copyprotect'); ?></p>
                                </td>
                            </tr>
                        </table>

                        <div class="tooltip-options" <?php echo (!isset($appearance_settings['showTooltip']) || !$appearance_settings['showTooltip']) ? 'style="display: none;"' : ''; ?>>
                            <table class="form-table">
                                <tr>
                                    <th scope="row"><?php _e('Tooltip Message', 'copyprotect'); ?></th>
                                    <td>
                                        <input type="text" name="copyprotect_messages[tooltipText]" value="<?php echo esc_attr(isset($messages['tooltipText']) ? $messages['tooltipText'] : 'Content is protected'); ?>" class="regular-text">
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <table class="form-table">
                            <tr>
                                <th scope="row"><?php _e('Show Modal/Alert on Unauthorized Action', 'copyprotect'); ?></th>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="copyprotect_appearance_settings[showModal]" value="1" <?php checked(isset($appearance_settings['showModal']) ? $appearance_settings['showModal'] : false); ?> class="toggle-control">
                                        <span class="slider round"></span>
                                    </label>
                                    <p class="description"><?php _e('Display an alert when protected actions are attempted', 'copyprotect'); ?></p>
                                </td>
                            </tr>
                        </table>

                        <div class="modal-options" <?php echo (!isset($appearance_settings['showModal']) || !$appearance_settings['showModal']) ? 'style="display: none;"' : ''; ?>>
                            <table class="form-table">
                                <tr>
                                    <th scope="row"><?php _e('Alert Message', 'copyprotect'); ?></th>
                                    <td>
                                        <textarea name="copyprotect_messages[alertText]" rows="3" class="large-text"><?php echo esc_textarea(isset($messages['alertText']) ? $messages['alertText'] : 'This content is protected. Copying is not allowed.'); ?></textarea>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="card">
                        <h3><?php _e('Protection Indicators', 'copyprotect'); ?></h3>
                        <p class="description"><?php _e('Visual cues to indicate that content is protected', 'copyprotect'); ?></p>
                        
                        <table class="form-table">
                            <tr>
                                <th scope="row"><?php _e('"Protected" Badge', 'copyprotect'); ?></th>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="copyprotect_appearance_settings[showProtectedBadge]" value="1" <?php checked(isset($appearance_settings['showProtectedBadge']) ? $appearance_settings['showProtectedBadge'] : false); ?> class="toggle-control">
                                        <span class="slider round"></span>
                                    </label>
                                    <p class="description"><?php _e('Display a floating badge to indicate content is guarded', 'copyprotect'); ?></p>
                                </td>
                            </tr>
                        </table>

                        <div class="badge-options" <?php echo (!isset($appearance_settings['showProtectedBadge']) || !$appearance_settings['showProtectedBadge']) ? 'style="display: none;"' : ''; ?>>
                            <table class="form-table">
                                <tr>
                                    <th scope="row"><?php _e('Badge Text', 'copyprotect'); ?></th>
                                    <td>
                                        <input type="text" name="copyprotect_messages[badgeText]" value="<?php echo esc_attr(isset($messages['badgeText']) ? $messages['badgeText'] : 'Protected'); ?>" class="regular-text">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"><?php _e('Badge Position', 'copyprotect'); ?></th>
                                    <td>
                                        <select name="copyprotect_appearance_settings[badgePosition]" class="regular-text">
                                            <option value="top-left" <?php selected(isset($appearance_settings['badgePosition']) ? $appearance_settings['badgePosition'] : 'bottom-right', 'top-left'); ?>><?php _e('Top Left', 'copyprotect'); ?></option>
                                            <option value="top-right" <?php selected(isset($appearance_settings['badgePosition']) ? $appearance_settings['badgePosition'] : 'bottom-right', 'top-right'); ?>><?php _e('Top Right', 'copyprotect'); ?></option>
                                            <option value="bottom-left" <?php selected(isset($appearance_settings['badgePosition']) ? $appearance_settings['badgePosition'] : 'bottom-right', 'bottom-left'); ?>><?php _e('Bottom Left', 'copyprotect'); ?></option>
                                            <option value="bottom-right" <?php selected(isset($appearance_settings['badgePosition']) ? $appearance_settings['badgePosition'] : 'bottom-right', 'bottom-right'); ?>><?php _e('Bottom Right', 'copyprotect'); ?></option>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <p class="submit">
                        <input type="submit" class="button-primary" value="<?php _e('Save Changes', 'copyprotect'); ?>" />
                    </p>
                </form>
            </div>

            <!-- Advanced Rules Tab -->
            <div id="advanced" class="tab-pane">
                <form method="post" action="options.php">
                    <?php 
                    settings_fields('copyprotect_advanced_settings');
                    ?>

                    <div class="card">
                        <h3><?php _e('Granular Content Control', 'copyprotect'); ?></h3>
                        <p class="description"><?php _e('Apply different protection settings per content type', 'copyprotect'); ?></p>
                        
                        <table class="form-table">
                            <tr>
                                <th scope="row"><?php _e('Enable per Post/Page/Custom Post Type', 'copyprotect'); ?></th>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="copyprotect_advanced_settings[enablePerPostType]" value="1" <?php checked(isset($advanced_settings['enablePerPostType']) ? $advanced_settings['enablePerPostType'] : false); ?> class="toggle-control">
                                        <span class="slider round"></span>
                                    </label>
                                    <p class="description"><?php _e('Set specific protection rules for different content types', 'copyprotect'); ?></p>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="post-type-options" <?php echo (!isset($advanced_settings['enablePerPostType']) || !$advanced_settings['enablePerPostType']) ? 'style="display: none;"' : ''; ?>>
                        <div class="card">
                            <h3><?php _e('Blog Posts Protection', 'copyprotect'); ?></h3>
                            <p class="description"><?php _e('Configure protection settings specifically for blog posts', 'copyprotect'); ?></p>
                            
                            <table class="form-table">
                                <tr>
                                    <th scope="row"><?php _e('Apply Protection to Blog Posts', 'copyprotect'); ?></th>
                                    <td>
                                        <label class="switch">
                                            <input type="checkbox" name="copyprotect_advanced_settings[applyToBlogPosts]" value="1" <?php checked(isset($advanced_settings['applyToBlogPosts']) ? $advanced_settings['applyToBlogPosts'] : false); ?> class="toggle-control">
                                            <span class="slider round"></span>
                                        </label>
                                        <p class="description"><?php _e('Enable all protection features for blog post content', 'copyprotect'); ?></p>
                                    </td>
                                </tr>
                                <tr class="disable-categories-option" <?php echo (!isset($advanced_settings['applyToBlogPosts']) || !$advanced_settings['applyToBlogPosts']) ? 'style="display: none;"' : ''; ?>>
                                    <th scope="row"><?php _e('Disable protection on specific categories/tags', 'copyprotect'); ?></th>
                                    <td>
                                        <label class="switch">
                                            <input type="checkbox" name="copyprotect_advanced_settings[disableForCategories]" value="1" <?php checked(isset($advanced_settings['disableForCategories']) ? $advanced_settings['disableForCategories'] : false); ?>>
                                            <span class="slider round"></span>
                                        </label>
                                        <p class="description"><?php _e('Exclude certain categories from content protection', 'copyprotect'); ?></p>
                                    </td>
                                </tr>
                            </table>

                            <?php if(isset($advanced_settings['disableForCategories']) && $advanced_settings['disableForCategories'] && isset($advanced_settings['applyToBlogPosts']) && $advanced_settings['applyToBlogPosts']) : ?>
                            <div class="category-selection">
                                <p><?php _e('Select categories to exclude:', 'copyprotect'); ?></p>
                                <?php
                                $categories = get_categories(array('hide_empty' => false));
                                $excluded_categories = isset($advanced_settings['excludedCategories']) ? (array) $advanced_settings['excludedCategories'] : array();
                                
                                foreach($categories as $category) :
                                ?>
                                <label class="checkbox-container">
                                    <input type="checkbox" name="copyprotect_advanced_settings[excludedCategories][]" value="<?php echo esc_attr($category->term_id); ?>" <?php checked(in_array($category->term_id, $excluded_categories)); ?>>
                                    <?php echo esc_html($category->name); ?>
                                </label>
                                <?php endforeach; ?>
                            </div>
                            <?php endif; ?>
                        </div>

                        <div class="card">
                            <h3><?php _e('Pages Protection', 'copyprotect'); ?></h3>
                            <p class="description"><?php _e('Configure protection settings specifically for WordPress pages', 'copyprotect'); ?></p>
                            
                            <table class="form-table">
                                <tr>
                                    <th scope="row"><?php _e('Apply Protection to Pages', 'copyprotect'); ?></th>
                                    <td>
                                        <label class="switch">
                                            <input type="checkbox" name="copyprotect_advanced_settings[applyToPages]" value="1" <?php checked(isset($advanced_settings['applyToPages']) ? $advanced_settings['applyToPages'] : false); ?>>
                                            <span class="slider round"></span>
                                        </label>
                                        <p class="description"><?php _e('Enable all protection features for page content', 'copyprotect'); ?></p>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <?php if(class_exists('WooCommerce')) : ?>
                        <div class="card">
                            <h3><?php _e('WooCommerce Products', 'copyprotect'); ?></h3>
                            <p class="description"><?php _e('Configure protection settings specifically for WooCommerce products', 'copyprotect'); ?></p>
                            
                            <table class="form-table">
                                <tr>
                                    <th scope="row"><?php _e('Apply Protection to Product Descriptions', 'copyprotect'); ?></th>
                                    <td>
                                        <label class="switch">
                                            <input type="checkbox" name="copyprotect_advanced_settings[applyToProducts]" value="1" <?php checked(isset($advanced_settings['applyToProducts']) ? $advanced_settings['applyToProducts'] : false); ?>>
                                            <span class="slider round"></span>
                                        </label>
                                        <p class="description"><?php _e('Enable protection for WooCommerce product descriptions', 'copyprotect'); ?></p>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <?php endif; ?>
                    </div>

                    <p class="submit">
                        <input type="submit" class="button-primary" value="<?php _e('Save Changes', 'copyprotect'); ?>" />
                    </p>
                </form>
            </div>

            <!-- Help & Support Tab -->
            <div id="help" class="tab-pane">
                <div class="card">
                    <h3><?php _e('Documentation & Support', 'copyprotect'); ?></h3>
                    
                    <div class="help-section">
                        <div class="help-item">
                            <h4><span class="dashicons dashicons-book"></span> <?php _e('Documentation', 'copyprotect'); ?></h4>
                            <p><?php _e('View the complete plugin documentation to learn how to use all features.', 'copyprotect'); ?></p>
                            <a href="#" class="button button-secondary"><?php _e('View Documentation', 'copyprotect'); ?></a>
                        </div>
                        
                        <div class="help-item">
                            <h4><span class="dashicons dashicons-sos"></span> <?php _e('Get Support', 'copyprotect'); ?></h4>
                            <p><?php _e('Need help? Our support team is ready to assist you with any issues.', 'copyprotect'); ?></p>
                            <a href="#" class="button button-secondary"><?php _e('Contact Support', 'copyprotect'); ?></a>
                        </div>
                        
                        <div class="help-item">
                            <h4><span class="dashicons dashicons-star-filled"></span> <?php _e('Rate the Plugin', 'copyprotect'); ?></h4>
                            <p><?php _e('If you enjoy CopyProtect, please leave us a review!', 'copyprotect'); ?></p>
                            <a href="https://wordpress.org/plugins/" class="button button-secondary"><?php _e('Leave a Review', 'copyprotect'); ?></a>
                        </div>
                    </div>
                    
                    <div class="faq-section">
                        <h3><?php _e('Frequently Asked Questions', 'copyprotect'); ?></h3>
                        
                        <div class="faq-item">
                            <h4><?php _e('Will this plugin slow down my website?', 'copyprotect'); ?></h4>
                            <p><?php _e('No, CopyProtect is designed to be lightweight and optimized for performance. It adds minimal overhead to your website.', 'copyprotect'); ?></p>
                        </div>
                        
                        <div class="faq-item">
                            <h4><?php _e('Is this plugin compatible with page builders?', 'copyprotect'); ?></h4>
                            <p><?php _e('Yes, CopyProtect works with all major page builders including Elementor, Beaver Builder, Divi, and more.', 'copyprotect'); ?></p>
                        </div>
                        
                        <div class="faq-item">
                            <h4><?php _e('Can I exclude certain pages from protection?', 'copyprotect'); ?></h4>
                            <p><?php _e('Yes, you can exclude specific pages, posts, or categories from protection using the Advanced Rules tab.', 'copyprotect'); ?></p>
                        </div>
                        
                        <div class="faq-item">
                            <h4><?php _e('Is this 100% effective against all copying methods?', 'copyprotect'); ?></h4>
                            <p><?php _e('While CopyProtect implements many techniques to prevent copying, determined users with technical knowledge may find ways around these protections. However, it will effectively deter most casual attempts to copy your content.', 'copyprotect'); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
