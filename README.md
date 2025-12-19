# Sherwood Laundry

Marketing website for Sherwood Laundry, a premium laundry pickup and delivery service serving Sherwood, Newberg, Dundee, and Chehalem Valley in Oregon.

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

Add your Sendy credentials to `.env`:

```
SENDY_URL=https://your-sendy-installation.com
SENDY_API_KEY=your_api_key
SENDY_LIST_ID=your_list_id
```

## Pages

- `/` - Landing page with hero, pricing, FAQ, and contact sections
- `/success` - Confirmation page after email signup
