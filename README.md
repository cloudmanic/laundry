# Sherwood Laundry

Marketing website for a hyper-local laundry pickup and delivery service. Currently launching in Sherwood, Oregon (sherwoodlaundry.com), with plans to expand to other cities (e.g., bendlaundry.com, newberglaundry.com).

## Multi-City Architecture

This codebase is designed to support multiple cities/domains from a single codebase. Each city has its own configuration including:

- City name and branding
- Contact information (address, phone)
- Pricing plans
- Service areas
- Testimonials

Set the active city via the `CITY_KEY` environment variable. City configurations are defined in `config/city.php`.

## Tech Stack

- **Backend:** Laravel 12
- **Frontend:** Tailwind CSS 4, Alpine.js
- **Build:** Vite
- **Email:** Sendy API integration

## Setup

```bash
# Install dependencies
composer install
npm install

# Configure environment
cp .env.example .env
php artisan key:generate

# Run migrations
php artisan migrate

# Build assets
npm run build
```

## Development

```bash
# Run all services concurrently (server, queue, logs, vite)
composer dev

# Or run individually
php artisan serve   # Laravel server at http://localhost:8000
npm run dev         # Vite dev server
```

## Configuration

### City Configuration

Set the active city in `.env`:

```
CITY_KEY=sherwood
```

To add a new city, add its configuration to `config/city.php` under the `cities` array.

### Sendy Email Marketing

```
SENDY_URL=https://your-sendy-installation.com
SENDY_API_KEY=your_api_key
SENDY_LIST_ID=your_list_id
```

## Pages

- `/` - Landing page with hero, pricing, FAQ, and contact sections
- `/success` - Confirmation page after email signup

## Current Cities

| City | Domain | Status |
|------|--------|--------|
| Sherwood | sherwoodlaundry.com | Launching Feb 2026 |
