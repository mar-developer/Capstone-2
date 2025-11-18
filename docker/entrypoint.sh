#!/bin/bash
set -e

echo "Starting Laravel Application..."

# Navigate to application directory
cd /var/www/html

# Check if composer.json exists
if [ ! -f "composer.json" ]; then
    echo "ERROR: composer.json not found in /var/www/html"
    echo "Current directory contents:"
    ls -la /var/www/html
    echo ""
    echo "This usually means the application files were not copied correctly."
    echo "Please rebuild the Docker image: docker-compose build --no-cache"
    exit 1
fi

# Install/update composer dependencies if vendor doesn't exist or is empty
if [ ! -d "vendor" ] || [ -z "$(ls -A vendor 2>/dev/null)" ]; then
    echo "Installing Composer dependencies..."
    composer install --no-interaction --prefer-dist --optimize-autoloader
else
    echo "Composer dependencies already installed"
fi

# Install npm dependencies if node_modules doesn't exist or is empty
if [ ! -d "node_modules" ] || [ -z "$(ls -A node_modules)" ]; then
    echo "Installing NPM dependencies..."
    npm install
else
    echo "NPM dependencies already installed"
fi

# Build assets if public/build doesn't exist
if [ ! -d "public/build" ]; then
    echo "Building frontend assets..."
    npm run build
else
    echo "Frontend assets already built"
fi

# Fix permissions
echo "Setting permissions..."
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true

# Create storage directories if they don't exist
mkdir -p /var/www/html/storage/framework/cache
mkdir -p /var/www/html/storage/framework/sessions
mkdir -p /var/www/html/storage/framework/views
mkdir -p /var/www/html/storage/logs

echo "Application ready!"

# Start supervisor
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
