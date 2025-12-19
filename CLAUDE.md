# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Important Rules

- **Never start servers** (`php artisan serve`, `npm run dev`, `composer dev`). The user runs these manually. If a server is needed, ask the user to start it.

## Project Overview

Sherwood Laundry is a Laravel 12 marketing website for a laundry pickup and delivery service. The frontend uses Tailwind CSS 4 with Vite, and Alpine.js for interactivity.

## Development Commands

```bash
# Start all services (server, queue, logs, vite) concurrently
composer dev

# Or run individually:
php artisan serve          # Laravel dev server
npm run dev                # Vite dev server

# Build for production
npm run build

# Run tests
composer test
# Or: php artisan test
# Single test: php artisan test --filter=TestClassName

# Code formatting (Laravel Pint)
./vendor/bin/pint

# Initial setup
composer setup
```

## Architecture

**Controllers:**
- `PageController` - Renders landing and success pages
- `SubscribeController` - Handles email signups via Sendy API

**Views Structure:**
- `layouts/app.blade.php` - Base layout with fonts (Inter, Playfair Display) and Alpine.js
- `components/` - Reusable Blade components (header, hero, pricing, faq, footer, etc.)
- `pages/` - Page templates that assemble components

**Routes:**
- `GET /` - Landing page
- `GET /success` - Post-signup confirmation
- `POST /subscribe` - Sendy API submission

**External Services:**
- Sendy email marketing (configured in `.env`: `SENDY_URL`, `SENDY_API_KEY`, `SENDY_LIST_ID`)

## Key Technical Details

- Uses Tailwind CSS 4 with `@tailwindcss/vite` plugin
- Alpine.js loaded via CDN with collapse plugin for FAQ accordion
- Fonts: Inter (body) and Playfair Display (headings) via Google Fonts
- SQLite database by default
