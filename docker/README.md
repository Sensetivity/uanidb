# UANIDB Docker Setup

## Services

| Service   | Container        | Port          | Description                    |
|-----------|------------------|---------------|--------------------------------|
| app       | uanidb-app       | 9000          | PHP 8.4 FPM                    |
| nginx     | uanidb-nginx     | 80            | Nginx web server               |
| mysql     | uanidb-mysql     | 3306          | MySQL 8.0 database             |
| redis     | uanidb-redis     | 6379          | Redis cache/queue              |
| node      | uanidb-node      | 5173          | Node.js for Vite (dev profile) |
| mailpit   | uanidb-mailpit   | 1025/8025     | Email testing (dev profile)    |
| queue     | uanidb-queue     | -             | Queue worker (prod profile)    |
| scheduler | uanidb-scheduler | -             | Task scheduler (prod profile)  |

## Quick Start

### Windows (PowerShell or CMD)

```batch
# Copy environment file
copy .env.docker .env

# First-time installation
docker.bat install

# Visit http://localhost
```

### Linux/macOS

```bash
# Copy environment file
cp .env.docker .env

# First-time installation
make install

# Visit http://localhost
```

## Commands

### Using docker.bat (Windows)

```batch
docker.bat build       # Build images
docker.bat up          # Start containers
docker.bat up-dev      # Start with dev services (node, mailpit)
docker.bat down        # Stop containers
docker.bat logs        # View logs
docker.bat shell       # Access app shell
docker.bat mysql       # Access MySQL CLI
docker.bat redis       # Access Redis CLI
docker.bat migrate     # Run migrations
docker.bat test        # Run tests
docker.bat fresh       # Fresh install (migrate:fresh + seed)
```

### Using Make (Linux/macOS)

```bash
make build       # Build images
make up          # Start containers
make up-dev      # Start with dev services
make down        # Stop containers
make logs        # View logs
make shell       # Access app shell
make mysql       # Access MySQL CLI
make migrate     # Run migrations
make test        # Run tests
make fresh       # Fresh install
```

### Direct Docker Commands

```bash
# Build and start
docker compose build
docker compose up -d

# With dev services (Vite, Mailpit)
docker compose --profile dev up -d

# With production services (Queue, Scheduler)
docker compose --profile production up -d

# Run artisan commands
docker compose exec app php artisan migrate
docker compose exec app php artisan tinker

# Run composer
docker compose exec app composer install
docker compose exec app composer require package/name

# Run npm
docker compose run --rm node npm install
docker compose run --rm node npm run build
```

## Development Workflow

### Frontend Development (Vite)

```bash
# Start with dev profile (includes node container)
docker compose --profile dev up -d

# Or start node separately
docker compose run --rm -p 5173:5173 node npm run dev -- --host
```

Vite dev server will be available at `http://localhost:5173`

### Email Testing

```bash
# Start with dev profile (includes mailpit)
docker compose --profile dev up -d
```

- SMTP: `localhost:1025`
- Web UI: `http://localhost:8025`

### Database Access

```bash
# MySQL CLI
docker compose exec mysql mysql -u uanidb -psecret uanidb

# External connection
Host: localhost
Port: 3306
User: uanidb
Password: secret
Database: uanidb
```

### Redis Access

```bash
docker compose exec redis redis-cli
```

## Production Deployment

```bash
# Use production profile
docker compose --profile production up -d

# Optimize Laravel
docker compose exec app php artisan config:cache
docker compose exec app php artisan route:cache
docker compose exec app php artisan view:cache

# Build frontend assets
docker compose run --rm node npm run build
```

## Troubleshooting

### Permission Issues

```bash
# Fix storage permissions
docker compose exec app chmod -R 775 storage bootstrap/cache
docker compose exec app chown -R www:www storage bootstrap/cache
```

### MySQL Connection Refused

Wait for MySQL to fully start (check health status):

```bash
docker compose ps
# Wait until mysql shows "healthy"
```

### Clear All Caches

```bash
docker compose exec app php artisan optimize:clear
```

### Rebuild Everything

```bash
docker compose down -v  # Remove volumes too
docker compose build --no-cache
docker compose up -d
```

## File Structure

```
docker/
├── mysql/
│   └── init/           # SQL files to run on first start
├── nginx/
│   └── default.conf    # Nginx configuration
├── php/
│   ├── Dockerfile      # PHP-FPM image
│   └── php.ini         # PHP configuration
└── README.md           # This file

.dockerignore           # Files to exclude from build
.env.docker             # Docker-specific environment
docker-compose.yml      # Docker Compose configuration
docker.bat              # Windows helper script
Makefile                # Linux/macOS helper commands
```
