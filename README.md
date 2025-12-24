<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# How does the application works?
1. User uploads a photo of the receipt.
2. Application analyzes it.
3. Application automatically extracts the Vendor, Date, Line Items, Tax, and Total into a downloadable file (CSV format).

# How to install application?
## Requirements
- PHP 8.1+
- Composer
- Node.js 16+
- MySQL/Postgres

## Quick start (dev)
### 1. Clone repo
### 2. Backend:
   ```bash
   composer install
   cp .env.example .env
   php artisan key:generate
   # edit .env -> DB_*
   php artisan migrate --seed
   php artisan storage:link
   php artisan serve
   ```
### 3. Frontend:
    ```bash
    cd client
    npm install
    // set NUXT_PUBLIC_API_BASE_URL in client/.env
    npm run dev
    ```
