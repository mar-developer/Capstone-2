#!/bin/bash

echo "======================================"
echo "Starting Capstone Laravel Application"
echo "======================================"
echo ""

# Check if Docker is running
if ! docker info > /dev/null 2>&1; then
    echo "❌ Docker is not running. Please start Docker Desktop and try again."
    exit 1
fi

echo "✓ Docker is running"
echo ""

# Check if .env exists
if [ ! -f .env ]; then
    echo "Creating .env file from .env.example..."
    cp .env.example .env
    echo "✓ .env file created"
else
    echo "✓ .env file already exists"
fi

echo ""
echo "Building and starting Docker containers..."
echo "This may take a few minutes on first run..."
echo ""

docker-compose up -d --build

if [ $? -ne 0 ]; then
    echo ""
    echo "❌ Failed to start containers. Check the error above."
    echo "Run 'docker-compose logs' to see detailed logs."
    exit 1
fi

echo ""
echo "✓ Containers started successfully"
echo ""

# Wait for application setup (dependencies installation + database)
echo "Installing dependencies and waiting for database..."
echo "This may take a few minutes on first run..."
sleep 30
echo ""
echo "Checking application status..."
docker-compose logs app | grep "Application ready" || echo "Still initializing..."
echo ""

# Check if app key exists
if grep -q "APP_KEY=$" .env || grep -q "APP_KEY=\"\"" .env; then
    echo "Generating application key..."
    docker-compose exec -T app php artisan key:generate
    echo "✓ Application key generated"
else
    echo "✓ Application key already exists"
fi

echo ""
echo "Running database migrations..."
docker-compose exec -T app php artisan migrate --force

if [ $? -eq 0 ]; then
    echo "✓ Database migrations completed"
else
    echo "⚠️  Migration failed. You may need to run it manually:"
    echo "   docker-compose exec app php artisan migrate"
fi

echo ""
echo "======================================"
echo "✓ Application is ready!"
echo "======================================"
echo ""
echo "Access your application at:"
echo "  • Application:  http://localhost:8000"
echo "  • phpMyAdmin:   http://localhost:8080"
echo ""
echo "Useful commands:"
echo "  • View logs:    docker-compose logs -f"
echo "  • Stop:         docker-compose stop"
echo "  • Restart:      docker-compose restart"
echo "  • Shell:        docker-compose exec app bash"
echo ""
