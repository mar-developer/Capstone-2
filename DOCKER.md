# Docker Setup for Capstone Laravel Application

This project includes a complete Docker setup that allows you to run the application without installing PHP, Composer, MySQL, or Node.js locally.

## Prerequisites

Only Docker and Docker Compose are required:
- **Docker Desktop** (Windows/Mac): [Download here](https://www.docker.com/products/docker-desktop)
- **Docker Engine + Docker Compose** (Linux): [Installation guide](https://docs.docker.com/engine/install/)

## Quick Start

### 1. Clone and Navigate to Project
```bash
git clone <your-repo-url>
cd Capstone-2
```

### 2. Set Up Environment File
```bash
cp .env.example .env
```

The `.env` file is already configured for Docker. If you need to change database credentials, update these values in both `.env` and `docker-compose.yml`.

### 3. Build and Start Containers
```bash
docker-compose up -d --build
```

This command will:
- Build the Docker image with PHP 8.4, Nginx, and all dependencies
- Start MySQL database container
- Start phpMyAdmin container
- Install Composer dependencies
- Install npm dependencies and build assets

### 4. Generate Application Key
```bash
docker-compose exec app php artisan key:generate
```

### 5. Run Database Migrations
```bash
docker-compose exec app php artisan migrate
```

### 6. (Optional) Seed Database
```bash
docker-compose exec app php artisan db:seed
```

## Access the Application

- **Application**: http://localhost:8000
- **phpMyAdmin**: http://localhost:8080
  - Server: `db`
  - Username: `capstone_user`
  - Password: `capstone_password`

## Common Docker Commands

### View Running Containers
```bash
docker-compose ps
```

### View Logs
```bash
# All containers
docker-compose logs -f

# Specific container
docker-compose logs -f app
docker-compose logs -f db
```

### Stop Containers
```bash
docker-compose stop
```

### Start Containers
```bash
docker-compose start
```

### Restart Containers
```bash
docker-compose restart
```

### Stop and Remove Containers
```bash
docker-compose down
```

### Stop and Remove Containers + Volumes (Database data)
```bash
docker-compose down -v
```

### Rebuild Containers
```bash
docker-compose up -d --build
```

## Running Artisan Commands

```bash
docker-compose exec app php artisan <command>
```

Examples:
```bash
# Clear cache
docker-compose exec app php artisan cache:clear

# Run migrations
docker-compose exec app php artisan migrate

# Create a controller
docker-compose exec app php artisan make:controller UserController

# List routes
docker-compose exec app php artisan route:list
```

## Running Composer Commands

```bash
docker-compose exec app composer <command>
```

Examples:
```bash
# Install a package
docker-compose exec app composer require package/name

# Update dependencies
docker-compose exec app composer update
```

## Running NPM Commands

```bash
docker-compose exec app npm <command>
```

Examples:
```bash
# Install new package
docker-compose exec app npm install package-name

# Rebuild assets
docker-compose exec app npm run build

# Run dev build
docker-compose exec app npm run dev
```

## Database Access

### Using phpMyAdmin
Visit http://localhost:8080 and use the credentials from `docker-compose.yml`.

### Using MySQL Client
```bash
docker-compose exec db mysql -u capstone_user -p
# Password: capstone_password
```

### Database Backup
```bash
docker-compose exec db mysqldump -u capstone_user -p capstone_db > backup.sql
```

### Database Restore
```bash
docker-compose exec -T db mysql -u capstone_user -p capstone_db < backup.sql
```

## File Permissions Issues

If you encounter permission issues on Linux:
```bash
sudo chown -R $USER:$USER .
docker-compose exec app chown -R www-data:www-data /var/www/html/storage
docker-compose exec app chown -R www-data:www-data /var/www/html/bootstrap/cache
```

## Troubleshooting

### Port Already in Use
If ports 8000, 3306, or 8080 are already in use, edit `docker-compose.yml` to change the port mappings:
```yaml
ports:
  - "8001:80"  # Change 8000 to 8001
```

### Container Won't Start
```bash
# View logs
docker-compose logs app

# Rebuild from scratch
docker-compose down -v
docker-compose up -d --build
```

### Database Connection Issues
Make sure the database service is running:
```bash
docker-compose ps db
```

If needed, wait a few seconds for MySQL to fully start, then retry the migration.

### Clear Everything and Start Fresh
```bash
docker-compose down -v
docker system prune -a
docker-compose up -d --build
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan migrate
```

## Development Workflow

For active development with hot reloading:

1. Keep containers running:
```bash
docker-compose up
```

2. Your code changes in the local directory are automatically reflected in the container due to volume mounting.

3. For frontend changes, rebuild assets:
```bash
docker-compose exec app npm run build
```

## Production Deployment

For production, you may want to:

1. Build the image without volume mounts
2. Use environment-specific `.env` files
3. Disable debug mode in `.env`
4. Use proper secrets management
5. Set up SSL/TLS certificates

## Container Structure

- **app**: PHP 8.4-FPM + Nginx + Laravel application
- **db**: MySQL 8.0 database
- **phpmyadmin**: Web interface for MySQL

## Customization

- **PHP settings**: Edit `docker/php/local.ini`
- **Nginx config**: Edit `docker/nginx/default.conf`
- **Supervisor config**: Edit `docker/supervisor/supervisord.conf`
- **Database credentials**: Edit `docker-compose.yml` and `.env`

## Need Help?

- Check the logs: `docker-compose logs -f`
- Restart containers: `docker-compose restart`
- Rebuild: `docker-compose up -d --build`
