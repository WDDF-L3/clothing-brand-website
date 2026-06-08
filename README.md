# Maison Mode — Fashion & Clothing E-Commerce

A Laravel 11 e-commerce application for fashion retail with a luxury aesthetic, full shopping cart, checkout, and admin dashboard.

## Stack

- **Backend**: PHP 8.2+ / Laravel 11
- **Database**: MySQL 8+
- **Cart**: Session-based (no extra packages)
- **Frontend**: Blade + custom CSS (Cormorant Garamond + DM Sans)
- **Admin**: Custom dashboard at `/admin`

---

## Features

- 🛍️ Product catalog — category filter, size/color variants, search, sort
- 🛒 Shopping cart — session-based, qty update, remove
- 💳 Checkout — address form, COD & bank transfer
- 📦 Orders — auto order numbers, itemized receipts
- 🖥️ Admin dashboard — manage products, categories, orders, homepage banner
- 🖼️ Image uploads — drag & drop from local folder

---

## Prerequisites

Make sure you have these installed before starting:

- PHP 8.2 or higher
- Composer
- MySQL 8+
- Git

Check your versions:
```bash
php -v
composer -V
mysql --version
```

---

## Setup (Step by Step)

### 1. Clone the repository

```bash
git clone https://github.com/WDDF-L3/clothing-brand-website.git
cd clothing-brand-website
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Create your environment file

```bash
# On Mac/Linux:
cp .env.example .env

# On Windows PowerShell:
copy .env.example .env
```

### 4. Generate application key

```bash
php artisan key:generate
```

### 5. Configure the database

Open `.env` and set your MySQL credentials:

```env
DB_DATABASE=fashion_store
DB_USERNAME=root
DB_PASSWORD=your_mysql_password
```

> ⚠️ Use `fashion_store` with an **underscore**, not a hyphen. Hyphens break MySQL.

### 6. Create the database

```bash
mysql -u root -p -e "CREATE DATABASE fashion_store CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

### 7. Run migrations and seed sample data

```bash
php artisan migrate --seed
```

This creates all tables and seeds:
- 4 categories (Women, Men, Bags, Shoes)
- 11 sample products

### 8. Create storage symlink

```bash
php artisan storage:link
```

This allows uploaded images to be served from `public/storage`.

### 9. Start the development server

```bash
php artisan serve
```

Open **http://localhost:8000** in your browser.

---

## Admin Dashboard

Access the admin panel at: **http://localhost:8000/admin/login**

Default credentials:
| Field    | Value                      |
|----------|----------------------------|
| Email    | admin@maisonmode.com       |
| Password | admin123                   |

> ⚠️ Change these in `app/Http/Controllers/Admin/AuthController.php` before going live.

### Admin Features

| Section    | What you can do                                              |
|------------|--------------------------------------------------------------|
| Dashboard  | Revenue stats, pending orders, low stock alerts              |
| Products   | Add/edit/delete products, upload images from your computer   |
| Categories | Create, rename, activate/deactivate categories               |
| Orders     | View all orders, update status, delete                       |
| Homepage   | Edit banner text, upload background image, change colors     |

---

## Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/              # Admin panel controllers
│   │   │   ├── AuthController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── ProductController.php
│   │   │   ├── OrderController.php
│   │   │   ├── CategoryController.php
│   │   │   └── HomepageController.php
│   │   ├── ProductController.php
│   │   ├── CartController.php
│   │   └── CheckoutController.php
│   └── Middleware/
│       └── AdminAuth.php
├── Models/
│   ├── Category.php
│   ├── Product.php
│   ├── Order.php
│   ├── OrderItem.php
│   └── HomepageSetting.php
└── Services/
    └── CartService.php

database/
├── migrations/          # 5 migration files
└── seeders/
    ├── DatabaseSeeder.php
    └── HomepageSettingsSeeder.php

resources/views/
├── layouts/app.blade.php
├── admin/               # All admin views
├── products/
├── cart/
└── checkout/

routes/
├── web.php
└── console.php

tests/
├── Feature/
│   ├── HomepageTest.php
│   └── CartTest.php
└── Unit/
    └── CartServiceTest.php
```

---

## Routes

### Public Store

| Method | URL                         | Description             |
|--------|-----------------------------|-------------------------|
| GET    | `/`                         | Homepage                |
| GET    | `/shop`                     | All products            |
| GET    | `/shop/{slug}`              | Product detail          |
| GET    | `/category/{slug}`          | Category page           |
| GET    | `/cart`                     | Shopping bag            |
| POST   | `/cart/add/{product}`       | Add to cart             |
| PATCH  | `/cart/update/{rowId}`      | Update quantity         |
| DELETE | `/cart/remove/{rowId}`      | Remove item             |
| DELETE | `/cart/clear`               | Clear cart              |
| GET    | `/checkout`                 | Checkout form           |
| POST   | `/checkout/place`           | Place order             |
| GET    | `/checkout/success/{order}` | Order confirmation      |

### Admin

| Method | URL                          | Description             |
|--------|------------------------------|-------------------------|
| GET    | `/admin/login`               | Login page              |
| GET    | `/admin`                     | Dashboard               |
| GET    | `/admin/products`            | Products list           |
| GET    | `/admin/products/create`     | New product form        |
| GET    | `/admin/products/{id}/edit`  | Edit product            |
| GET    | `/admin/orders`              | Orders list             |
| GET    | `/admin/orders/{id}`         | Order detail            |
| GET    | `/admin/categories`          | Categories              |
| GET    | `/admin/homepage`            | Homepage banner editor  |

---

## Running Tests

```bash
php artisan test
```

Or run specific suites:

```bash
php artisan test --testsuite=Feature
php artisan test --testsuite=Unit
```

---

## Common Issues & Fixes

### "Could not open input file: artisan"
You're in the wrong directory. Make sure you're inside the project folder that contains `artisan`, `composer.json`, etc.

### "Base table not found: fashion-store.cache"
Your `DB_DATABASE` in `.env` has a hyphen. Change it to `fashion_store` (underscore).

### "bootstrap/cache directory must be present and writable"
```bash
mkdir bootstrap/cache
```

### "Class App\Http\Controllers\Controller not found"
Download the missing base controller:
```powershell
# Windows PowerShell:
Invoke-WebRequest -Uri "https://raw.githubusercontent.com/laravel/laravel/11.x/app/Http/Controllers/Controller.php" -OutFile "app/Http/Controllers/Controller.php"
```

### Images not showing after upload
Run `php artisan storage:link` — this creates the symlink between `storage/app/public` and `public/storage`.

---

## Security Notes

- ✅ `.env` is in `.gitignore` — never committed
- ✅ `vendor/` is in `.gitignore` — never committed
- ⚠️ Change admin credentials before deploying
- ⚠️ Set `APP_DEBUG=false` in production
- ⚠️ Set `APP_ENV=production` in production

---

## License

MIT
