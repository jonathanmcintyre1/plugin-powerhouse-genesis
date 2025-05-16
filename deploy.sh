
#!/bin/bash
# CopyProtect Plugin Deployment Script

echo "===== CopyProtect Plugin Deployment ====="
echo "This script will prepare and package your plugin for WordPress installation."

# Check if npm is installed
if ! command -v npm &> /dev/null; then
    echo "Error: npm is not installed. Please install Node.js and npm first."
    exit 1
fi

# Check if PHP is installed
if ! command -v php &> /dev/null; then
    echo "Error: PHP is not installed. Please install PHP first."
    exit 1
fi

# Step 1: Install dependencies
echo -e "\n[1/4] Installing dependencies..."
npm install

# Step 2: Build the React app
echo -e "\n[2/4] Building React admin interface..."
npx vite build

# Step 3: Run the PHP build script
echo -e "\n[3/4] Preparing plugin files..."
php build-plugin.php

# Step 4: Create the ZIP file
echo -e "\n[4/4] Creating plugin ZIP file..."
zip -r copyprotect.zip . -x "*.git*" "node_modules/*" "src/*" "*.lock" "*.json" "*.md" "*.config.*" "dist/*" "deploy.sh" "build-plugin.php"

echo -e "\n✅ Plugin package created: copyprotect.zip"
echo -e "\nInstallation Instructions:"
echo "1. Go to WordPress Admin > Plugins > Add New > Upload Plugin"
echo "2. Select the copyprotect.zip file"
echo "3. Click 'Install Now'"
echo "4. Activate the plugin"

# Make the script executable with: chmod +x deploy.sh
