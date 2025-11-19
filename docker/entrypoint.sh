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

# Create .env file from .env.example if it doesn't exist
if [ ! -f ".env" ]; then
    if [ -f ".env.example" ]; then
        echo "Creating .env file from .env.example..."
        cp .env.example .env
        # Ensure proper permissions for .env file
        chown www-data:www-data .env 2>/dev/null || true
        chmod 644 .env
        echo "✓ .env file created with proper permissions"
    else
        echo "WARNING: Neither .env nor .env.example found"
    fi
else
    echo "✓ .env file exists"
    # Ensure proper permissions even if file exists
    chown www-data:www-data .env 2>/dev/null || true
    chmod 644 .env
fi

# Install/update composer dependencies if vendor doesn't exist or is empty
if [ ! -d "vendor" ] || [ -z "$(ls -A vendor 2>/dev/null)" ]; then
    echo "Installing Composer dependencies..."
    composer install --no-interaction --prefer-dist --optimize-autoloader
else
    echo "Composer dependencies already installed"
fi

# Generate APP_KEY if it's empty or not set (must run after composer install)
if [ -f ".env" ]; then
    # Extract the current APP_KEY value
    CURRENT_KEY=$(grep "^APP_KEY=" .env 2>/dev/null | cut -d '=' -f2-)

    echo "Checking APP_KEY status..."
    echo "Current APP_KEY value: '${CURRENT_KEY}'"

    # Check if APP_KEY is empty or doesn't contain base64:
    if [ -z "$CURRENT_KEY" ] || [[ ! "$CURRENT_KEY" =~ ^base64: ]]; then
        echo "APP_KEY is empty or invalid, generating new key..."

        # Run key generation with explicit error handling
        if php artisan key:generate --force --ansi 2>&1; then
            echo "✓ Application key generated successfully"

            # Verify the key was actually set
            NEW_KEY=$(grep "^APP_KEY=" .env 2>/dev/null | cut -d '=' -f2-)
            if [ -n "$NEW_KEY" ] && [[ "$NEW_KEY" =~ ^base64: ]]; then
                echo "✓ Verified: APP_KEY is now set correctly"
            else
                echo "WARNING: Key generation completed but APP_KEY still appears invalid!"
                echo "APP_KEY value: '${NEW_KEY}'"
            fi
        else
            echo "ERROR: Failed to generate application key!"
            echo "Please check the logs above for details."
        fi
    else
        echo "✓ Application key already set (starts with base64:)"
    fi
else
    echo "WARNING: .env file not found, cannot generate APP_KEY"
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

# Create storage directories if they don't exist (must be created before setting permissions)
echo "Creating storage directories..."
mkdir -p /var/www/html/storage/framework/cache
mkdir -p /var/www/html/storage/framework/sessions
mkdir -p /var/www/html/storage/framework/views
mkdir -p /var/www/html/storage/logs
mkdir -p /var/www/html/storage/app/public
mkdir -p /var/www/html/bootstrap/cache

# Fix permissions (must be done after creating directories)
echo "Setting permissions on storage and cache directories..."
chown -R www-data:www-data /var/www/html/storage
chown -R www-data:www-data /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage
chmod -R 775 /var/www/html/bootstrap/cache

echo "✓ Storage permissions configured correctly"

# Clear Laravel caches to prevent stale configuration issues
echo "Clearing Laravel caches..."
php artisan config:clear 2>/dev/null || echo "Config cache already clear"
php artisan route:clear 2>/dev/null || echo "Route cache already clear"
php artisan view:clear 2>/dev/null || echo "View cache already clear"
echo "✓ Caches cleared"

# Final verification before starting the application
echo ""
echo "=== Final Configuration Check ==="
if [ -f ".env" ]; then
    FINAL_KEY=$(grep "^APP_KEY=" .env 2>/dev/null | cut -d '=' -f2-)
    if [ -n "$FINAL_KEY" ] && [[ "$FINAL_KEY" =~ ^base64: ]]; then
        echo "✓ APP_KEY is properly configured"
    else
        echo "✗ WARNING: APP_KEY is NOT properly configured!"
        echo "  Current value: '${FINAL_KEY}'"
        echo "  You may need to manually run: php artisan key:generate"
    fi
else
    echo "✗ WARNING: .env file not found!"
fi
echo "================================="
echo ""

echo "Application ready! Starting services..."

# Start supervisor
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
