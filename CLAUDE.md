# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Important Rules

- **Never start servers** (`php artisan serve`, `npm run dev`, `composer dev`). The user runs these manually. If a server is needed, ask the user to start it.

## Project Overview

This is a multi-city laundry service marketing website. Currently launching in Sherwood, Oregon (sherwoodlaundry.com), but the codebase is designed to support multiple cities/domains (e.g., bendlaundry.com, newberglaundry.com) from a single codebase.

**Key architectural decision:** All city-specific content (pricing, contact info, service areas, branding) is configuration-driven via `config/city.php`. The active city is set by the `CITY_KEY` environment variable. Never hardcode city-specific values in templates.

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

**Multi-City Configuration (`config/city.php`):**
- Each city has: name, brand, contact info, pricing plans, service areas, testimonials
- Active city determined by `CITY_KEY` env variable
- City config is shared to all views via `AppServiceProvider`
- Access in Blade templates via `$city['key']`

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

## Adding a New City

1. Add city configuration to `config/city.php` under the `cities` array
2. Set `CITY_KEY=newcity` in the deployment's `.env`
3. No code changes needed - templates automatically use the active city's config

## Key Technical Details

- Uses Tailwind CSS 4 with `@tailwindcss/vite` plugin
- Alpine.js loaded via CDN with collapse plugin for FAQ accordion
- Fonts: Inter (body) and Playfair Display (headings) via Google Fonts
- SQLite database by default
- Frontend uses Livewire components

## Coding Standards

### Verbose Logging
Always add verbose logging throughout the codebase. This is a standard practice for this project:
- Log all significant actions (user registration, login, subscription changes, payments, etc.)
- Log at appropriate levels: `info` for normal operations, `warning` for unusual but handled cases, `error` for failures
- Include relevant context in log messages (user ID, action, relevant data)
- Use structured logging with context arrays: `Log::info('User registered', ['user_id' => $user->id, 'email' => $user->email])`
- Log entry and exit of important methods when debugging complex flows
- Never log sensitive data (passwords, full credit card numbers, etc.)

### UI/UX for Conversion Funnels
This is a subscription business where users come from paid ads (Facebook, etc.). Every user-facing page should:
- Be sales-minded with clear value propositions
- Include trust signals and social proof
- Minimize friction in the signup/checkout flow
- Have clear CTAs that guide users to the next step
- Reinforce benefits at each step to prevent drop-off
