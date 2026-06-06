# Maison Mode — Fashion & Clothing E-Commerce

A clean, production-ready Laravel e-commerce application for fashion retail, featuring a refined luxury aesthetic.

## Stack

- **Backend**: PHP 8.2+ / Laravel 11
- **Database**: MySQL
- **Session-based Cart**: No extra packages — uses Laravel sessions
- **Frontend**: Blade templates with custom CSS (Cormorant Garamond + DM Sans)

---

## Features

- 🛍️ **Product Catalog** — filterable by category, size, price; full-text search
- 🛒 **Shopping Cart** — session-based, supports size/color variants, qty updates
- 💳 **Checkout** — full address form, COD & bank transfer, order summary
- 📦 **Orders** — auto-generated order numbers, itemized receipts
- ✨ **Elegant UI** — luxury fashion aesthetic, fully responsive

---

## Quick Start

### 1. Clone & Install

```bash
git clone <your-repo-url> fashion-store
cd fashion-store
composer install
```

### 2. Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` and set your MySQL credentials:

```env
DB_DATABASE=fashion_store
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 3. Database Setup

```bash
# Create the database first
mysql -u root -p -e "CREATE DATABASE fashion_store CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# Run migrations and seed sample data
php artisan migrate --seed
```

### 4. Storage Link

```bash
php artisan storage:link
```

### 5. Run

```bash
php artisan serve
```

Open [http://localhost:8000](http://localhost:8000)

---

## Project Structure

```
app/
├── Http/Controllers/
│   ├── ProductController.php   # Shop, product detail, categories
│   ├── CartController.php      # Add, update, remove, clear
│   └── CheckoutController.php  # Checkout form & order placement
├── Models/
│   ├── Category.php
│   ├── Product.php             # With sizes, colors, images (JSON columns)
│   ├── Order.php               # Auto-generated order numbers
│   └── OrderItem.php
├── Services/
│   └── CartService.php         # Session-based cart logic

database/
├── migrations/                 # 4 migration files
└── seeders/
    └── DatabaseSeeder.php      # 4 categories + 11 sample products

resources/views/
├── layouts/app.blade.php       # Master layout (nav, footer, flash)
├── components/
│   └── product-card.blade.php  # Reusable product card
├── products/
│   ├── index.blade.php         # Shop listing + hero
│   ├── show.blade.php          # Product detail
│   └── category.blade.php      # Category page
├── cart/
│   └── index.blade.php         # Cart with qty update / remove
└── checkout/
    ├── index.blade.php          # Checkout form
    └── success.blade.php        # Order confirmation

routes/web.php
```

---

## Routes

| Method | URL | Name | Description |
|--------|-----|------|-------------|
| GET | `/` | `home` | Homepage with hero + featured |
| GET | `/shop` | `shop` | All products (search, filter, sort) |
| GET | `/shop/{slug}` | `products.show` | Product detail |
| GET | `/category/{slug}` | `products.category` | Category page |
| GET | `/cart` | `cart.index` | Shopping bag |
| POST | `/cart/add/{product}` | `cart.add` | Add to cart |
| PATCH | `/cart/update/{rowId}` | `cart.update` | Update qty |
| DELETE | `/cart/remove/{rowId}` | `cart.remove` | Remove item |
| DELETE | `/cart/clear` | `cart.clear` | Clear cart |
| GET | `/checkout` | `checkout.index` | Checkout form |
| POST | `/checkout/place` | `checkout.place` | Place order |
| GET | `/checkout/success/{order}` | `checkout.success` | Confirmation |

---

## Adding Products

### Via Seeder (recommended for dev)

Edit `database/seeders/DatabaseSeeder.php` and add product arrays, then run:

```bash
php artisan db:seed
```

### Via Tinker

```bash
php artisan tinker
```

```php
App\Models\Product::create([
    'category_id'   => 1,
    'name'          => 'Silk Blouse',
    'slug'          => 'silk-blouse',
    'description'   => 'Elegant silk blouse...',
    'price'         => 195.00,
    'compare_price' => 240.00,
    'stock'         => 20,
    'sizes'         => ['XS', 'S', 'M', 'L'],
    'colors'        => ['White', 'Black'],
    'images'        => ['https://example.com/image.jpg'],
    'is_featured'   => true,
    'is_active'     => true,
]);
```

---

## Adding Product Images

Products support multiple images stored as a JSON array in the `images` column. The first image is used as the primary display image.

To use real images, store them in `storage/app/public/products/` and reference them as:

```php
'images' => ['/storage/products/image1.jpg', '/storage/products/image2.jpg']
```

---

## Extending

### Add User Authentication
```bash
composer require laravel/breeze
php artisan breeze:install blade
php artisan migrate
```

### Add Admin Panel
```bash
composer require filament/filament
php artisan filament:install --panels
```

### Add Payment Gateway (Stripe)
```bash
composer require stripe/stripe-php
```

---

## License

MIT
