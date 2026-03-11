# UAniDB — Українська Аніме База Даних

**Ukrainian Anime Database** — open-source anime catalog with Ukrainian translations, powered by Laravel.

[![PHP](https://img.shields.io/badge/PHP-8.4-777BB4?logo=php&logoColor=white)](https://php.net)
[![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?logo=laravel&logoColor=white)](https://laravel.com)
[![Filament](https://img.shields.io/badge/Filament-5-FDAE4B)](https://filamentphp.com)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?logo=mysql&logoColor=white)](https://mysql.com)
[![Docker](https://img.shields.io/badge/Docker-Compose-2496ED?logo=docker&logoColor=white)](https://docker.com)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

---

## About

UAniDB aggregates anime data from [MyAnimeList](https://myanimelist.net) (via [Jikan API](https://jikan.moe)) and [AniDB](https://anidb.net), translates it to Ukrainian using the DeepL API, and provides a full-featured admin panel for managing the catalog.

### Key Features

- **Automated Import** — fetch anime, episodes, characters, staff, studios, and promotional videos from MAL
- **Ukrainian Translations** — auto-translate synopses and episode titles via DeepL; import proper Ukrainian titles from AniDB
- **Filament Admin Panel** — full CRUD for all entities with import actions, translation progress dashboard, and settings management
- **Media Management** — poster and character image downloads via Spatie MediaLibrary
- **Queue-Driven Pipeline** — all imports and translations run as chained background jobs
- **Rich Data Model** — 17 models covering anime, episodes, characters, voice actors, studios, seasons, genres, themes, reviews, watchlists, and more

### Data Pipeline

```
MyAnimeList ──(Jikan API)──► Import Service ──► Database
                                   │
AniDB ──(Title Dump XML)───► Title Import   ──► Ukrainian Titles
                                   │
DeepL API ◄─────────────── Translation Service
```

---

## Tech Stack

| Layer | Technology |
|---|---|
| Backend | PHP 8.4, Laravel 12 |
| Admin UI | Filament 5 (Livewire + Alpine.js + Tailwind CSS) |
| Database | MySQL 8.0 |
| Cache & Queue | Redis |
| Web Server | Nginx |
| Infrastructure | Docker Compose |
| Build | Vite |
| API Auth | Laravel Sanctum |
| Images | Spatie MediaLibrary |
| Translations | DeepL PHP SDK |
| Anime Data | Jikan PHP (MAL API) |
| Code Style | Laravel Pint (PSR-12) |
| Testing | PHPUnit 11 |

---

## Getting Started

### Prerequisites

- [Docker](https://www.docker.com/) and Docker Compose

### Installation

```bash
# Clone the repository
git clone https://github.com/your-username/uanidb.git
cd uanidb

# Copy environment file
cp .env.example .env

# Start containers
docker compose up -d

# Install dependencies
docker compose exec app composer install

# Generate app key
docker compose exec app php artisan key:generate

# Run migrations
docker compose exec app php artisan migrate

# Seed seasons
docker compose exec app php artisan db:seed-seasons
```

### Development Mode

Start with the `dev` profile to enable the Vite dev server and Mailpit:

```bash
docker compose --profile dev up -d
```

| Service | URL |
|---|---|
| Application | `http://localhost` |
| Admin Panel | `http://localhost/admin` |
| Mailpit | `http://localhost:8025` |
| MySQL | `localhost:23306` |

---

## Usage

### Importing Anime

```bash
# Import a single anime by MAL ID (queued, with images and translation)
docker compose exec app php artisan import:anime 1 --queue --with-images --translate

# Import a full season
docker compose exec app php artisan import:seasonal --year=2025 --season=winter

# Import top anime
docker compose exec app php artisan import:top --pages=3
```

### Ukrainian Titles from AniDB

```bash
docker compose exec app php artisan anidb:import-titles --all
docker compose exec app php artisan anidb:import-episodes
```

### Translating Content

```bash
docker compose exec app php artisan translate:anime --untranslated
docker compose exec app php artisan translate:episodes
```

### Queue Worker

```bash
docker compose exec app php artisan queue:work
```

Or use the production profile with a dedicated queue worker and scheduler:

```bash
docker compose --profile production up -d
```

## Code Quality

### PHP Static Analysis Tool (PHPStan/Larastan)

This project uses Larastan (a PHPStan extension for Laravel) for static code analysis. Run the analyzer to detect potential errors:
```bash
./vendor/bin/phpstan analyse --memory-limit=2G > report.txt
```

You can also run with different rule levels (0-9, higher is more strict):
```bash
./vendor/bin/phpstan analyse --memory-limit=2G --level=5
```

### PHP Instant Upgrades and Automated Refactoring (Rector/Laravel rules)

This project uses Rector for automated code refactoring and upgrades. Rector helps modernize your codebase by automatically applying coding standards and upgrading to newer PHP versions.



---

## Testing

```bash
# Run all tests
docker compose exec app php artisan test --compact

# Run a specific test file
docker compose exec app php artisan test --compact tests/Feature/ExampleTest.php

# Filter by test name
docker compose exec app php artisan test --compact --filter=testMethodName
```

---

## Project Structure

```
app/
├── Console/Commands/       # Artisan commands (import, translate, seed)
├── Contracts/Services/     # Interfaces (AnimeDataProvider, TranslationProvider, etc.)
├── Dto/                    # Data Transfer Objects
├── Enums/                  # Native PHP 8.4 backed enums
├── Filament/               # Admin panel resources, pages, widgets
├── Jobs/                   # Queued import and translation jobs
├── Models/                 # Eloquent models
├── Providers/              # Service providers (DI wiring)
└── Services/
    ├── AnimeImport/        # Strategy-pattern import orchestrator + processors
    ├── Translation/        # DeepL translation service
    ├── TitleImport/        # AniDB Ukrainian title import
    └── AnimeApi/           # Jikan API client wrapper
database/
├── factories/              # Model factories
├── migrations/             # Database migrations
└── seeders/                # Seeders
docker/                     # Docker configs (nginx, php, mysql)
tests/
├── Feature/                # PHPUnit feature tests
└── Unit/                   # PHPUnit unit tests
```

---

## Data Model

```
Anime ─────┬── Episodes
            ├── Characters ──── Voice Actors (People)
            ├── Staff (People)
            ├── Studios / Producers / Licensors
            ├── Genres & Themes
            ├── Seasons
            ├── Titles (multilingual)
            ├── Promotion Videos
            ├── External Links
            ├── Related Anime (self-referencing)
            ├── Reviews (polymorphic)
            └── Comments (polymorphic, threaded)

Users ──────┬── Watchlists
            ├── Reviews
            └── Comments
```

---

## Roadmap

- [x] Data import pipeline (MAL via Jikan API)
- [x] AniDB Ukrainian title import
- [x] DeepL translation integration
- [x] Filament admin panel with full CRUD
- [x] Media management (Spatie MediaLibrary)
- [x] Queue-driven job pipeline
- [ ] Public REST API v1 (anime, characters, seasons, search)
- [ ] User authentication (Sanctum)
- [ ] Watchlist API
- [ ] Reviews & Comments API
- [ ] Full-text search
- [ ] Public-facing frontend

---

## Contributing

Contributions are welcome! Please:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/your-feature`)
3. Follow PSR-12 coding standards (enforced by Laravel Pint)
4. Write PHPUnit tests for new functionality
5. Use Ukrainian for user-facing content, English for code
6. Submit a pull request

---

## License

This project is open-sourced software licensed under the [MIT License](LICENSE).
