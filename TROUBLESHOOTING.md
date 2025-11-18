# Docker Troubleshooting Guide

## Common Issues and Solutions

### 1. "docker-compose: command not found"

**Problem:** Docker or Docker Compose is not installed or not in PATH.

**Solution:**
- Install Docker Desktop: https://www.docker.com/products/docker-desktop
- After installation, restart your terminal
- Verify with: `docker --version` and `docker-compose --version`

---

### 2. "Cannot connect to the Docker daemon"

**Problem:** Docker Desktop is not running.

**Solution:**
- Start Docker Desktop application
- Wait for it to fully start (icon should be steady, not animated)
- Try your command again

---

### 3. "Port is already allocated" or "Address already in use"

**Problem:** Ports 8000, 3306, or 8080 are already in use.

**Solution:**

**Option A - Stop conflicting services:**
```bash
# On Windows
netstat -ano | findstr :8000
# Note the PID and kill it in Task Manager

# On Linux/Mac
lsof -ti:8000 | xargs kill -9
```

**Option B - Change ports in docker-compose.yml:**
```yaml
services:
  app:
    ports:
      - "8001:80"  # Change 8000 to 8001
  db:
    ports:
      - "3307:3306"  # Change 3306 to 3307
  phpmyadmin:
    ports:
      - "8081:80"  # Change 8080 to 8081
```

Then update APP_URL in .env to match the new port.

---

### 4. "error running docker-compose exec app php artisan..."

**Problem:** Container may not be running or not fully started.

**Solution:**

**Step 1 - Check container status:**
```bash
docker-compose ps
```

You should see containers with status "Up". If not:

**Step 2 - View container logs:**
```bash
docker-compose logs app
docker-compose logs db
```

**Step 3 - Common fixes:**

If containers keep restarting:
```bash
# Stop everything
docker-compose down

# Remove volumes (WARNING: deletes database data)
docker-compose down -v

# Rebuild from scratch
docker-compose up -d --build
```

**Step 4 - Wait for database:**
The database needs time to initialize. Wait 15-30 seconds after `docker-compose up`, then try:
```bash
# Check database is ready
docker-compose exec db mysql -u capstone_user -pcapstone_password -e "SELECT 1"
```

---

### 5. Build Fails During "npm install" or "composer install"

**Problem:** Network issues or dependency conflicts.

**Solution:**

**Check build logs:**
```bash
docker-compose build --no-cache app
```

**If npm fails:**
- Check your internet connection
- Try using a different DNS: Add to docker-compose.yml under app service:
```yaml
dns:
  - 8.8.8.8
  - 8.8.4.4
```

**If composer fails:**
```bash
# Build without installing deps, then install manually
docker-compose up -d
docker-compose exec app composer install
docker-compose exec app npm install
docker-compose exec app npm run build
```

---

### 6. "SQLSTATE[HY000] [2002] Connection refused"

**Problem:** App can't connect to database.

**Solution:**

**Check .env file has correct database host:**
```env
DB_HOST=db        # For Docker (service name)
# NOT DB_HOST=localhost or 127.0.0.1
```

**Clear config cache:**
```bash
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan cache:clear
```

**Verify database is running:**
```bash
docker-compose ps db
docker-compose logs db
```

**Test connection:**
```bash
docker-compose exec app php artisan tinker
# Then type: DB::connection()->getPdo();
```

---

### 7. "Permission denied" errors in storage/logs

**Problem:** File permission issues (common on Linux/Mac).

**Solution:**
```bash
# On Linux/Mac
sudo chown -R $USER:$USER .
docker-compose exec app chown -R www-data:www-data /var/www/html/storage
docker-compose exec app chown -R www-data:www-data /var/www/html/bootstrap/cache
docker-compose exec app chmod -R 775 /var/www/html/storage
docker-compose exec app chmod -R 775 /var/www/html/bootstrap/cache
```

---

### 8. "404 Not Found" on all routes

**Problem:** Nginx can't find Laravel's public directory.

**Solution:**

**Check nginx logs:**
```bash
docker-compose logs app | grep nginx
```

**Access container and verify:**
```bash
docker-compose exec app bash
ls -la /var/www/html/public/
cat /var/www/html/public/index.php
```

**Restart nginx:**
```bash
docker-compose exec app supervisorctl restart nginx
```

---

### 9. White screen or 500 error

**Problem:** Application error without details.

**Solution:**

**Check Laravel logs:**
```bash
docker-compose exec app tail -f storage/logs/laravel.log
```

**Enable debug mode in .env:**
```env
APP_DEBUG=true
```

**Clear all caches:**
```bash
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan route:clear
docker-compose exec app php artisan view:clear
```

---

### 10. CSS/JS not loading or outdated

**Problem:** Assets not built or cached.

**Solution:**
```bash
# Rebuild assets
docker-compose exec app npm run build

# Clear browser cache (Ctrl+F5 or Cmd+Shift+R)

# If still not working, check public/build exists:
docker-compose exec app ls -la public/build/
```

---

## Diagnostic Commands

### Check everything is working:
```bash
# Container status
docker-compose ps

# View all logs
docker-compose logs

# Follow logs in real-time
docker-compose logs -f

# Check specific service
docker-compose logs app
docker-compose logs db

# Check resources
docker stats

# Access app container shell
docker-compose exec app bash

# Access database shell
docker-compose exec db mysql -u capstone_user -pcapstone_password capstone_db
```

### Reset everything:
```bash
# Nuclear option - delete everything and start fresh
docker-compose down -v
docker system prune -a --volumes
docker-compose up -d --build

# Wait 30 seconds for DB to initialize
# Then:
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan migrate
```

---

## Windows Specific Issues

### WSL2 Backend Issues

If using WSL2 backend:
```bash
# Update WSL2
wsl --update

# Restart WSL2
wsl --shutdown
```

### File Watching Issues

If you see file watching errors:
- This is normal and doesn't affect functionality
- Just ignore warnings about "illegal operation on directory"

### Slow Performance

If containers are slow on Windows:
1. Make sure WSL2 backend is enabled in Docker Desktop settings
2. Clone project inside WSL2 filesystem, not Windows drives
3. Allocate more resources in Docker Desktop → Settings → Resources

---

## Still Having Issues?

1. **Check Docker Desktop Status**
   - Look for the Docker icon in system tray
   - Should be steady (not animated)
   - Try restarting Docker Desktop

2. **View Build Output**
   ```bash
   docker-compose build --no-cache --progress=plain app
   ```

3. **Get Container Details**
   ```bash
   docker inspect capstone-app
   docker inspect capstone-db
   ```

4. **Test Each Component**
   ```bash
   # Test PHP
   docker-compose exec app php -v

   # Test Composer
   docker-compose exec app composer --version

   # Test Database Connection
   docker-compose exec db mysql -u root -proot_password -e "SHOW DATABASES;"

   # Test Laravel
   docker-compose exec app php artisan --version
   ```

5. **Share Your Error**
   - Copy the full error message
   - Run `docker-compose logs app > error-log.txt`
   - Check error-log.txt for details
