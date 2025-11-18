#!/bin/bash

echo "=========================================="
echo "Docker Application Health Check"
echo "=========================================="
echo ""

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

check_passed=0
check_failed=0

function check_status() {
    if [ $1 -eq 0 ]; then
        echo -e "${GREEN}✓${NC} $2"
        ((check_passed++))
    else
        echo -e "${RED}✗${NC} $2"
        ((check_failed++))
    fi
}

# Check if containers are running
echo "1. Checking Docker containers..."
docker-compose ps app | grep -q "Up"
check_status $? "App container is running"

docker-compose ps db | grep -q "Up"
check_status $? "Database container is running"

echo ""
echo "2. Checking application files..."

# Check if vendor exists
docker-compose exec -T app test -d /var/www/html/vendor
check_status $? "Composer dependencies installed (vendor/ exists)"

# Check if node_modules exists
docker-compose exec -T app test -d /var/www/html/node_modules
check_status $? "NPM dependencies installed (node_modules/ exists)"

# Check if public/build exists
docker-compose exec -T app test -d /var/www/html/public/build
check_status $? "Frontend assets built (public/build/ exists)"

# Check if .env exists
docker-compose exec -T app test -f /var/www/html/.env
check_status $? ".env file exists"

echo ""
echo "3. Checking Laravel application..."

# Check Laravel version
docker-compose exec -T app php artisan --version > /dev/null 2>&1
check_status $? "Laravel artisan is working"

# Check database connection
docker-compose exec -T app php artisan db:show > /dev/null 2>&1
check_status $? "Database connection successful"

# Check if APP_KEY is set
docker-compose exec -T app php artisan tinker --execute="echo config('app.key') ? 'SET' : 'NOT_SET'" 2>/dev/null | grep -q "SET"
check_status $? "Application key is generated"

echo ""
echo "4. Testing HTTP endpoints..."

# Test if application responds
HTTP_CODE=$(curl -s -o /dev/null -w "%{http_code}" http://localhost:8000/)
if [ "$HTTP_CODE" = "200" ] || [ "$HTTP_CODE" = "302" ]; then
    check_status 0 "Application responds (HTTP $HTTP_CODE)"
else
    check_status 1 "Application responds (HTTP $HTTP_CODE - Expected 200 or 302)"
fi

# Test /up health check endpoint
curl -s http://localhost:8000/up > /dev/null 2>&1
check_status $? "Health check endpoint (/up) is accessible"

echo ""
echo "5. Checking logs for errors..."

# Check for PHP errors
docker-compose logs app 2>&1 | grep -i "error" | grep -v "ERROR_LOG" | tail -3
if [ $? -eq 0 ]; then
    echo -e "${YELLOW}⚠${NC}  Errors found in logs (see above)"
else
    echo -e "${GREEN}✓${NC} No errors in application logs"
fi

echo ""
echo "=========================================="
echo "Summary"
echo "=========================================="
echo -e "${GREEN}Passed: $check_passed${NC}"
echo -e "${RED}Failed: $check_failed${NC}"
echo ""

if [ $check_failed -eq 0 ]; then
    echo -e "${GREEN}✓ All checks passed! Application is ready.${NC}"
    echo ""
    echo "Access your application at:"
    echo "  • Application:  http://localhost:8000"
    echo "  • phpMyAdmin:   http://localhost:8080"
    echo "  • Health Check: http://localhost:8000/up"
else
    echo -e "${RED}✗ Some checks failed. Please review the errors above.${NC}"
    echo ""
    echo "Common fixes:"
    echo "  • Rebuild containers:    docker-compose down && docker-compose up -d --build"
    echo "  • View logs:             docker-compose logs -f app"
    echo "  • Restart containers:    docker-compose restart"
    echo "  • Run migrations:        docker-compose exec app php artisan migrate"
fi

echo ""
