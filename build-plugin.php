
<?php
/**
 * CopyProtect Plugin Build Script
 * 
 * This script prepares the plugin for production by:
 * 1. Creating necessary directories
 * 2. Copying built assets to the correct locations
 * 3. Setting up proper file structure for WordPress
 */

// Configuration
$plugin_name = 'CopyProtect';
$plugin_slug = 'copyprotect';
$dist_dir = 'dist';
$admin_js_dir = 'admin/js';
$admin_css_dir = 'admin/css';
$admin_assets_dir = 'admin/assets';
$public_js_dir = 'public/js';
$public_css_dir = 'public/css';

// Ensure directories exist
$dirs_to_check = [
    $admin_js_dir,
    $admin_css_dir,
    $admin_assets_dir,
    $public_js_dir,
    $public_css_dir
];

foreach ($dirs_to_check as $dir) {
    if (!is_dir($dir)) {
        echo "Creating directory: $dir\n";
        mkdir($dir, 0755, true);
    }
}

// Check if dist directory exists (build output)
if (!is_dir($dist_dir)) {
    die("Error: Build output directory '$dist_dir' not found. Run 'npx vite build' first.\n");
}

// Copy JS assets
echo "Copying JS assets...\n";
$js_files = glob("$dist_dir/assets/*.js");
if (!empty($js_files)) {
    // Find the main JS file
    $main_js = '';
    foreach ($js_files as $file) {
        if (strpos($file, 'index') !== false) {
            $main_js = $file;
            break;
        }
    }
    
    // If we found a main JS file, copy it
    if ($main_js) {
        file_put_contents("$admin_js_dir/copyprotect-admin.js", file_get_contents($main_js));
        echo "Admin JS copied successfully.\n";
    } else {
        // Just copy the first JS file if we can't identify the main one
        file_put_contents("$admin_js_dir/copyprotect-admin.js", file_get_contents($js_files[0]));
        echo "Admin JS copied (using first available JS file).\n";
    }
    
    // Copy any map files for debugging
    foreach (glob("$dist_dir/assets/*.js.map") as $map_file) {
        $dest = "$admin_js_dir/" . basename($map_file);
        copy($map_file, $dest);
        echo "Copied map file: " . basename($map_file) . "\n";
    }
    
    // Copy any chunk files (if any)
    foreach ($js_files as $js_file) {
        if ($js_file != $main_js) {
            $dest = "$admin_js_dir/" . basename($js_file);
            copy($js_file, $dest);
            echo "Copied JS chunk: " . basename($js_file) . "\n";
        }
    }
} else {
    echo "Warning: No JS files found in build output.\n";
}

// Copy CSS assets
echo "Copying CSS assets...\n";
$css_files = glob("$dist_dir/assets/*.css");
if (!empty($css_files)) {
    file_put_contents("$admin_css_dir/copyprotect-admin.css", file_get_contents($css_files[0]));
    echo "Admin CSS copied successfully.\n";
    
    // Copy any CSS map files
    foreach (glob("$dist_dir/assets/*.css.map") as $map_file) {
        $dest = "$admin_css_dir/" . basename($map_file);
        copy($map_file, $dest);
        echo "Copied CSS map file: " . basename($map_file) . "\n";
    }
} else {
    echo "Warning: No CSS files found in build output.\n";
}

// Copy other asset files (images, fonts, etc.)
echo "Copying other assets...\n";
$asset_files = array_merge(
    glob("$dist_dir/assets/*.{png,jpg,jpeg,gif,svg}", GLOB_BRACE),
    glob("$dist_dir/assets/*.{woff,woff2,ttf,eot}", GLOB_BRACE)
);

if (!empty($asset_files)) {
    foreach ($asset_files as $asset) {
        $filename = basename($asset);
        copy($asset, "$admin_assets_dir/$filename");
        echo "Copied asset: $filename\n";
    }
    echo "Other assets copied successfully.\n";
}

// Create public JS file if it doesn't exist
if (!file_exists("$public_js_dir/copyprotect-public.js")) {
    echo "Creating default public JS file...\n";
    $public_js_content = <<<'JS'
/**
 * CopyProtect Public JavaScript
 * 
 * This file contains the public-facing JavaScript for content protection
 */
(function() {
    'use strict';

    // Get protection settings from WordPress
    const copyProtectSettings = window.copyProtectSettings || {};

    // Initialize protection features
    document.addEventListener('DOMContentLoaded', function() {
        // Apply protection based on settings
        if (copyProtectSettings.disableRightClick) {
            disableRightClick();
        }
        
        if (copyProtectSettings.disableTextSelection) {
            disableTextSelection();
        }
        
        if (copyProtectSettings.disableDragDrop) {
            disableDragDrop();
        }
    });

    // Right-click prevention
    function disableRightClick() {
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
            return false;
        });
    }

    // Text selection prevention
    function disableTextSelection() {
        document.body.style.userSelect = 'none';
        document.body.style.webkitUserSelect = 'none';
        document.body.style.msUserSelect = 'none';
        document.body.style.mozUserSelect = 'none';
    }

    // Drag and drop prevention
    function disableDragDrop() {
        document.addEventListener('dragstart', function(e) {
            e.preventDefault();
            return false;
        });
    }
})();
JS;
    file_put_contents("$public_js_dir/copyprotect-public.js", $public_js_content);
    echo "Public JS created.\n";
}

// Create public CSS file if it doesn't exist
if (!file_exists("$public_css_dir/copyprotect-public.css")) {
    echo "Creating default public CSS file...\n";
    $public_css_content = <<<'CSS'
/**
 * CopyProtect Public CSS
 * 
 * This file contains the public-facing styles for content protection
 */

/* Protected image styles */
img.copyprotect-protected {
    pointer-events: none;
}

/* Protection overlay styles */
.copyprotect-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: transparent;
    z-index: 1000;
    pointer-events: none;
}

/* No-copy notification styles */
.copyprotect-notice {
    position: fixed;
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
    background: rgba(0, 0, 0, 0.8);
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    z-index: 10000;
    display: none;
    animation: copyprotect-fade 2s ease-in-out;
}

@keyframes copyprotect-fade {
    0% { opacity: 0; }
    20% { opacity: 1; }
    80% { opacity: 1; }
    100% { opacity: 0; }
}
CSS;
    file_put_contents("$public_css_dir/copyprotect-public.css", $public_css_content);
    echo "Public CSS created.\n";
}

echo "\nBuild process completed successfully!\n";
echo "Plugin files are ready for WordPress installation.\n";
echo "\nNext steps:\n";
echo "1. Zip the entire plugin directory\n";
echo "2. Upload to WordPress via Plugins > Add New > Upload Plugin\n";
echo "3. Activate and configure the plugin\n";

?>
