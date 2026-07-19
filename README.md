# Laravel 13 + Vuetify 4 Starter Kit

A comprehensive starter template for modern web development using Laravel 13 and Vuetify 4.

This repository comes pre-configured with essential tools for rapid development: Filament 5 admin panel, RabbitMQ queues with Horizon, debugging via Telescope and Pail, Meilisearch full-text search, and a monitoring stack with Prometheus and Grafana.

## Tech Stack

- **Backend**: PHP 8.4, Laravel 13
- **Frontend**: Vue 3 (Composition API), Vuetify 4, Tailwind CSS 4, Inertia.js v3
- **State Management**: Pinia 3
- **Database**: PostgreSQL 16, Redis
- **Queues**: RabbitMQ + Laravel Horizon
- **Real-time**: Laravel Reverb + Echo
- **Admin Panel**: Filament 5
- **Testing**: Pest 4
- **Static Analysis**: Larastan 3, Rector 2
- **Tools**: Laravel Pint, Wayfinder (typed routes), Octane (RoadRunner)

## Getting Started

1. **Install dependencies and start containers:**
   ```bash
   make install
   ```

2. **Initialize database and seed data:**
   ```bash
   make dbs
   ```

3. **Start frontend development server:**
   ```bash
   yarn dev
   ```

## Development Commands (Makefile)

- `make up` / `make stop` — Start or stop containers.
- `make dbs` — Fresh migration, seed data, clear queues and reimport search indexes.
- `make lint` — Run all linters (PHPStan, Rector, Pint, ESLint, TypeScript check).
- `make test` — Run tests via Pest.
- `make shell` — Access application container shell.
- `make tinker` — Run Laravel Tinker.
- `make optimize` — Clear cache and generate Wayfinder routes.

## Available Services

- **Application**: [http://localhost:8585](http://localhost:8585)
- **Filament Admin**: [http://localhost:8585/admin](http://localhost:8585/admin)
- **Horizon Dashboard**: [http://localhost:8585/horizon](http://localhost:8585/horizon)
- **Telescope**: [http://localhost:8585/telescope](http://localhost:8585/telescope)
- **Mailpit**: [http://localhost:8025](http://localhost:8025)
- **Meilisearch**: [http://localhost:7700](http://localhost:7700)
- **RabbitMQ Management**: [http://localhost:15672](http://localhost:15672) (guest/guest)
- **Grafana**: [http://localhost:3000](http://localhost:3000) (admin/password)
- **Prometheus**: [http://localhost:9090](http://localhost:9090)

## Monitoring & Logs

Watch logs in real-time using Laravel Pail:
```bash
docker compose exec app php artisan pail
```

Check Octane status:
```bash
docker compose exec app php artisan octane:status
```

## CI/CD

Pre-configured GitHub Actions:
- **Lint & Test**: Runs automatically on push to `main` and `develop`.
- **Deployment**: Template available in `.github/workflows/deploy.yml`.
