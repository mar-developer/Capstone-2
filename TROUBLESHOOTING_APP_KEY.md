# APP_KEY Generation Troubleshooting Guide

## The Issue
Laravel requires an `APP_KEY` for encryption. Without it, you'll see:
```
No application encryption key has been specified.
```

## The Fix
The entrypoint script now automatically generates the APP_KEY. To apply:

### Step 1: Rebuild the Docker Image
```bash
docker compose down
docker compose build --no-cache
```

### Step 2: Start the Containers
```bash
docker compose up -d
```

### Step 3: Check the Logs
Watch the container startup logs to see the key generation process:
```bash
docker compose logs -f app
```

## What to Look For in the Logs

### Successful Key Generation
You should see output like this:
```
Starting Laravel Application...
✓ .env file created with proper permissions
Installing Composer dependencies...
Checking APP_KEY status...
Current APP_KEY value: ''
APP_KEY is empty or invalid, generating new key...
Application key set successfully.
✓ Application key generated successfully
✓ Verified: APP_KEY is now set correctly

=== Final Configuration Check ===
✓ APP_KEY is properly configured
=================================

Application ready! Starting services...
```

### If Key Generation Fails
Look for error messages like:
```
ERROR: Failed to generate application key!
```
or
```
✗ WARNING: APP_KEY is NOT properly configured!
```

## Manual Fix (If Automatic Generation Fails)

If the automatic generation doesn't work, you can manually generate the key:

### Option 1: Inside the Container
```bash
# Enter the container
docker compose exec app bash

# Generate the key
php artisan key:generate --force

# Verify it's set
grep APP_KEY /var/www/html/.env

# Exit the container
exit

# Restart the container
docker compose restart app
```

### Option 2: From Host Machine
```bash
docker compose exec app php artisan key:generate --force
docker compose restart app
```

## Verify the Fix

After the containers are running, check if the key is set:

```bash
docker compose exec app grep APP_KEY /var/www/html/.env
```

You should see something like:
```
APP_KEY=base64:randombase64encodedstringhere
```

Then visit your application:
```bash
curl http://localhost:8000
# or open in browser: http://localhost:8000
```

## Common Issues

### Issue 1: Container Keeps Restarting
**Check logs**: `docker compose logs app`
**Solution**: Look for errors before the APP_KEY generation step

### Issue 2: Permission Denied
**Check**: File permissions inside container
```bash
docker compose exec app ls -la /var/www/html/.env
```
**Solution**: The entrypoint now sets correct permissions automatically

### Issue 3: .env File Not Created
**Check**: Does .env.example exist?
```bash
docker compose exec app ls -la /var/www/html/.env*
```
**Solution**: Ensure .env.example is in your repository

### Issue 4: Artisan Command Not Found
**Check**: Are composer dependencies installed?
```bash
docker compose exec app ls -la /var/www/html/vendor
```
**Solution**: The entrypoint runs composer install before key generation

## Still Having Issues?

1. **Get detailed logs**:
   ```bash
   docker compose logs app > app_logs.txt
   ```

2. **Check the entrypoint execution**:
   ```bash
   docker compose exec app cat /var/www/html/.env
   ```

3. **Verify artisan works**:
   ```bash
   docker compose exec app php artisan --version
   ```

4. **Nuclear option - complete rebuild**:
   ```bash
   docker compose down -v
   docker system prune -f
   docker compose build --no-cache
   docker compose up -d
   ```

## Expected Behavior After Fix

✓ Container starts without errors
✓ APP_KEY is automatically generated
✓ Application loads without "No encryption key" error
✓ Logs show successful key generation
✓ .env file contains `APP_KEY=base64:...`
