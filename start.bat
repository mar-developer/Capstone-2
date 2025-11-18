@echo off
echo ======================================
echo Starting Capstone Laravel Application
echo ======================================
echo.

REM Check if Docker is running
docker info >nul 2>&1
if %errorlevel% neq 0 (
    echo X Docker is not running. Please start Docker Desktop and try again.
    pause
    exit /b 1
)

echo [OK] Docker is running
echo.

REM Check if .env exists
if not exist .env (
    echo Creating .env file from .env.example...
    copy .env.example .env >nul
    echo [OK] .env file created
) else (
    echo [OK] .env file already exists
)

echo.
echo Building and starting Docker containers...
echo This may take a few minutes on first run...
echo.

docker-compose up -d --build

if %errorlevel% neq 0 (
    echo.
    echo X Failed to start containers. Check the error above.
    echo Run 'docker-compose logs' to see detailed logs.
    pause
    exit /b 1
)

echo.
echo [OK] Containers started successfully
echo.

REM Wait for database to be ready
echo Waiting for database to be ready...
timeout /t 10 /nobreak >nul

REM Generate app key if needed
findstr /C:"APP_KEY=" .env | findstr /C:"APP_KEY=$" >nul
if %errorlevel% equ 0 (
    echo Generating application key...
    docker-compose exec -T app php artisan key:generate
    echo [OK] Application key generated
) else (
    echo [OK] Application key already exists
)

echo.
echo Running database migrations...
docker-compose exec -T app php artisan migrate --force

if %errorlevel% equ 0 (
    echo [OK] Database migrations completed
) else (
    echo [!] Migration failed. You may need to run it manually:
    echo    docker-compose exec app php artisan migrate
)

echo.
echo ======================================
echo [OK] Application is ready!
echo ======================================
echo.
echo Access your application at:
echo   * Application:  http://localhost:8000
echo   * phpMyAdmin:   http://localhost:8080
echo.
echo Useful commands:
echo   * View logs:    docker-compose logs -f
echo   * Stop:         docker-compose stop
echo   * Restart:      docker-compose restart
echo   * Shell:        docker-compose exec app bash
echo.
pause
