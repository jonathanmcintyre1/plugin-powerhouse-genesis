
# CopyProtect Plugin Deployment Guide

This guide will help you prepare and deploy the CopyProtect WordPress plugin for production use.

## Build and Deployment Process

### Prerequisites
- Node.js and npm installed
- PHP installed (for running the build script)
- WordPress installation for testing

### Step 1: Install Dependencies
```bash
npm install
```

### Step 2: Build the React Admin Interface
```bash
npx vite build
```

### Step 3: Prepare Plugin Files
```bash
php build-plugin.php
```

This script will:
- Create necessary directories
- Copy built assets to the correct WordPress plugin locations
- Set up default public-facing JS and CSS files if needed

### Step 4: Create Plugin ZIP File
Zip the entire plugin directory excluding development files:

```bash
zip -r copyprotect.zip . -x "*.git*" "node_modules/*" "src/*" "*.lock" "*.json" "*.md" "*.config.*" "dist/*"
```

### Step 5: Install in WordPress
1. Go to WordPress Admin > Plugins > Add New > Upload Plugin
2. Select the copyprotect.zip file
3. Click "Install Now"
4. Activate the plugin

## Testing Your Plugin
After activation:
1. Go to the CopyProtect settings page in WordPress admin
2. Configure protection settings
3. Visit your site frontend to verify protection features work correctly

## Troubleshooting
If you experience styling issues:
1. Check browser console for errors
2. Verify CSS paths are correct in the plugin's PHP enqueue functions
3. Clear WordPress cache and browser cache
4. Ensure file permissions allow WordPress to access the CSS/JS files

## File Structure Reference
```
copyprotect/
├── admin/
│   ├── css/
│   │   └── copyprotect-admin.css
│   ├── js/
│   │   └── copyprotect-admin.js
│   ├── class-copyprotect-admin.php
│   └── partials/
├── includes/
│   ├── class-copyprotect.php
│   └── class-copyprotect-loader.php
├── languages/
├── public/
│   ├── css/
│   │   └── copyprotect-public.css
│   ├── js/
│   │   └── copyprotect-public.js
│   └── class-copyprotect-public.php
├── copyprotect.php
├── index.php
└── uninstall.php
```
