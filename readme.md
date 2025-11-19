# Capstone - Inventory Management System

A comprehensive inventory management system built with Laravel and Vue.js, designed to track items, manage user requests, and maintain transaction logs.

## Features

- **User Management**: Admin and user role-based access control
- **Inventory Tracking**: Manage items with serial numbers
- **Request System**: Users can request items, admins can approve/reject
- **Transaction Logging**: Complete audit trail of all inventory movements
- **User Authentication**: Secure login system with account approval workflow
- **Admin Dashboard**: Comprehensive admin panel for managing users and inventory
- **Database Seeding**: Pre-populated test data for development

## Tech Stack

- **Backend**: Laravel (PHP)
- **Frontend**: Vue.js 3 with Vite
- **Database**: MySQL 8.0
- **Containerization**: Docker & Docker Compose
- **Styling**: Bootstrap 5, Sass
- **Additional Libraries**: jQuery, Axios, Lodash

## Prerequisites

- Docker Desktop installed and running
- Git (for cloning the repository)
- Basic knowledge of Laravel and Docker

## Quick Start

### 1. Clone the Repository

```bash
git clone <repository-url>
cd Capstone-2
```

### 2. Run the Start Script

```bash
chmod +x start.sh
./start.sh
```

The `start.sh` script will:
- Check if Docker is running
- Create `.env` file from `.env.example`
- Build and start Docker containers
- Install dependencies
- Generate application key
- Drop all tables and run fresh migrations
- Seed the database with test data

### 3. Access the Application

- **Application**: http://localhost:8000
- **phpMyAdmin**: http://localhost:8080

## Manual Setup

If you prefer to set up manually:

```bash
# Copy environment file
cp .env.example .env

# Start Docker containers
docker-compose up -d --build

# Install dependencies
docker-compose exec app composer install

# Generate application key
docker-compose exec app php artisan key:generate

# Run migrations and seed database
docker-compose exec app php artisan migrate:fresh --seed
```

## Configuration

### Environment Variables

Key environment variables in `.env`:

```env
APP_NAME=Capstone
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=capstone_db
DB_USERNAME=capstone_user
DB_PASSWORD=capstone_password
```

### Database Access

**phpMyAdmin Credentials:**
- Server: `db`
- Username: `root`
- Password: `root_password`

Or use the application user:
- Username: `capstone_user`
- Password: `capstone_password`

## User Roles

The system supports three access levels:

1. **Super Admin**: Full system access
2. **Admin**: Can manage users, items, and requests
3. **User**: Can view catalog and make requests

### Test Accounts

After running the seeders, you'll have test accounts available. Check the `UserSeeder.php` file for credentials.

## Frontend Development

To run the Vite development server for hot module replacement:

```bash
npm install
npm run dev
```

The Vite dev server will run on the default port (5173).

## Project Structure

```
Capstone-2/
├── app/
│   ├── Http/
│   │   ├── Controllers/      # Application controllers
│   │   └── Middleware/        # Custom middleware
│   └── User.php               # User model
├── database/
│   ├── migrations/            # Database migrations
│   └── seeders/               # Database seeders
├── docker/                    # Docker configuration files
├── resources/
│   ├── js/                    # Vue.js components
│   ├── sass/                  # Styling
│   └── views/                 # Blade templates
├── routes/
│   ├── web.php               # Web routes
│   └── api.php               # API routes
├── docker-compose.yml        # Docker services configuration
├── start.sh                  # Automated startup script
└── vite.config.js           # Vite configuration
```

## Database Schema

The application includes the following main tables:

- **users**: User accounts with access levels
- **items**: Inventory items
- **serials**: Serial numbers for items
- **transactions**: Item request/return transactions
- **logs**: System activity logs

## Useful Docker Commands

```bash
# View logs
docker-compose logs -f

# View app logs only
docker-compose logs -f app

# Stop containers
docker-compose stop

# Restart containers
docker-compose restart

# Access app container shell
docker-compose exec app bash

# Run artisan commands
docker-compose exec app php artisan <command>

# Rebuild containers
docker-compose down
docker-compose up -d --build
```

## Development Workflow

1. Make code changes in your local files
2. For PHP changes: Rebuild the Docker image
   ```bash
   docker-compose down
   docker-compose up -d --build
   ```
3. For frontend changes: Run `npm run dev` for hot reload
4. Database changes: Create migrations and run them
   ```bash
   docker-compose exec app php artisan make:migration <migration_name>
   docker-compose exec app php artisan migrate
   ```

## Troubleshooting

### Docker Container Issues

If containers fail to start:
```bash
docker-compose down
docker-compose up -d --build
docker-compose logs
```

### Permission Issues

If you encounter permission errors:
```bash
docker-compose exec app chmod -R 775 storage bootstrap/cache
docker-compose exec app chown -R www-data:www-data storage bootstrap/cache
```

### Database Connection Issues

1. Ensure the database container is running:
   ```bash
   docker-compose ps
   ```
2. Check database logs:
   ```bash
   docker-compose logs db
   ```

### Port Conflicts

If ports 8000, 8080, or 3306 are already in use, modify the port mappings in `docker-compose.yml`.

## Recent Updates

- Fixed AdminMiddleware to properly check user access levels
- Updated start.sh to include database cleanup and seeding
- Configured for Docker deployment with MySQL database

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License.

## Support

For issues and questions, please open an issue in the repository.
