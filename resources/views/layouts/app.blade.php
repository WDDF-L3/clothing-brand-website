<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'MH Clothing Brand') — Clothing Brand</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;1,300;1,400&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --cream:   #f9f6f1;
            --warm:    #efe9df;
            --stone:   #c8bfb0;
            --ink:     #1a1714;
            --muted:   #7a736b;
            --accent:  #a8855a;
            --danger:  #c0392b;
            --success: #27734e;
            --border:  #e4ddd4;
            --r:       2px;
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 300;
            background: var(--cream);
            color: var(--ink);
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        a { color: inherit; text-decoration: none; }
        img { max-width: 100%; height: auto; display: block; }
        button, input, select, textarea { font-family: inherit; }

        /* ── Utilities ─────────────────────────────────────── */
        .container { max-width: 1280px; margin: 0 auto; padding: 0 24px; }
        .sr-only { position: absolute; width: 1px; height: 1px; overflow: hidden; clip: rect(0,0,0,0); }

        /* ── Typography ────────────────────────────────────── */
        .serif { font-family: 'Cormorant Garamond', serif; }
        h1,h2,h3 { font-family: 'Cormorant Garamond', serif; font-weight: 400; letter-spacing: -.01em; }

        /* ── Flash Messages ────────────────────────────────── */
        .flash {
            padding: 12px 20px;
            font-size: 13px;
            letter-spacing: .03em;
            text-transform: uppercase;
            border-left: 3px solid;
            margin-bottom: 0;
        }
        .flash-success { background: #edf7f2; border-color: var(--success); color: var(--success); }
        .flash-error   { background: #fdf2f2; border-color: var(--danger);  color: var(--danger);  }

        /* ── Nav ───────────────────────────────────────────── */
        .site-header {
            background: var(--ink);
            position: sticky; top: 0; z-index: 100;
        }
        .nav-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 64px;
        }
        .brand {
            font-family: 'Cormorant Garamond', serif;
            font-size: 22px;
            font-weight: 300;
            letter-spacing: .25em;
            text-transform: uppercase;
            color: var(--cream);
        }
        .nav-links {
            display: flex; gap: 32px; list-style: none;
        }
        .nav-links a {
            color: var(--stone);
            font-size: 11px;
            letter-spacing: .18em;
            text-transform: uppercase;
            transition: color .2s;
        }
        .nav-links a:hover { color: var(--cream); }

        .nav-actions { display: flex; align-items: center; gap: 20px; }

        .search-form {
            display: flex;
            align-items: center;
            background: rgba(255,255,255,.06);
            border: 1px solid rgba(255,255,255,.12);
            border-radius: var(--r);
        }
        .search-form input {
            background: none;
            border: none;
            outline: none;
            color: var(--cream);
            padding: 6px 12px;
            width: 160px;
            font-size: 12px;
        }
        .search-form input::placeholder { color: var(--stone); }
        .search-form button {
            background: none;
            border: none;
            color: var(--stone);
            padding: 6px 10px;
            cursor: pointer;
        }

        .cart-btn {
            display: flex; align-items: center; gap: 6px;
            color: var(--cream);
            font-size: 11px;
            letter-spacing: .12em;
            text-transform: uppercase;
            padding: 8px 16px;
            border: 1px solid rgba(255,255,255,.25);
            border-radius: var(--r);
            transition: border-color .2s;
        }
        .cart-btn:hover { border-color: rgba(255,255,255,.6); }
        .cart-count {
            background: var(--accent);
            color: white;
            font-size: 10px;
            border-radius: 50%;
            width: 18px; height: 18px;
            display: flex; align-items: center; justify-content: center;
        }

        /* ── Category Bar ──────────────────────────────────── */
        .cat-bar {
            background: var(--warm);
            border-bottom: 1px solid var(--border);
        }
        .cat-bar ul {
            display: flex;
            gap: 0;
            list-style: none;
            overflow-x: auto;
        }
        .cat-bar a {
            display: block;
            padding: 12px 20px;
            font-size: 11px;
            letter-spacing: .14em;
            text-transform: uppercase;
            color: var(--muted);
            border-bottom: 2px solid transparent;
            transition: all .2s;
            white-space: nowrap;
        }
        .cat-bar a:hover, .cat-bar a.active {
            color: var(--ink);
            border-bottom-color: var(--accent);
        }

        /* ── Buttons ───────────────────────────────────────── */
        .btn {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 12px 28px;
            font-size: 11px;
            letter-spacing: .16em;
            text-transform: uppercase;
            border: none;
            cursor: pointer;
            border-radius: var(--r);
            transition: all .2s;
            font-weight: 400;
        }
        .btn-dark {
            background: var(--ink); color: var(--cream);
        }
        .btn-dark:hover { background: #2d2924; }
        .btn-outline {
            background: transparent;
            border: 1px solid var(--ink);
            color: var(--ink);
        }
        .btn-outline:hover { background: var(--ink); color: var(--cream); }
        .btn-accent { background: var(--accent); color: white; }
        .btn-accent:hover { background: #946d44; }
        .btn-sm { padding: 8px 16px; font-size: 10px; }
        .btn-danger { background: var(--danger); color: white; }

        /* ── Product Card ──────────────────────────────────── */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 2px;
        }
        .product-card {
            background: white;
            position: relative;
            overflow: hidden;
        }
        .product-card:hover .card-img { transform: scale(1.04); }
        .card-img-wrap {
            aspect-ratio: 3/4;
            overflow: hidden;
            background: var(--warm);
        }
        .card-img {
            width: 100%; height: 100%;
            object-fit: cover;
            transition: transform .5s ease;
        }
        .card-img-placeholder {
            width: 100%; height: 100%;
            display: flex; align-items: center; justify-content: center;
            background: var(--warm);
            color: var(--stone);
            font-size: 11px;
            letter-spacing: .1em;
            text-transform: uppercase;
        }
        .card-body { padding: 16px; }
        .card-category {
            font-size: 10px;
            letter-spacing: .2em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 4px;
        }
        .card-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 18px;
            font-weight: 400;
            margin-bottom: 8px;
            line-height: 1.2;
        }
        .card-pricing {
            display: flex; align-items: baseline; gap: 8px;
        }
        .price { font-size: 15px; font-weight: 500; }
        .price-compare { font-size: 13px; text-decoration: line-through; color: var(--stone); }
        .badge-sale {
            position: absolute; top: 12px; left: 12px;
            background: var(--accent); color: white;
            font-size: 10px; letter-spacing: .1em; text-transform: uppercase;
            padding: 3px 8px;
        }
        .badge-oos {
            position: absolute; top: 12px; right: 12px;
            background: var(--ink); color: var(--cream);
            font-size: 10px; letter-spacing: .1em; text-transform: uppercase;
            padding: 3px 8px;
        }

        /* ── Forms ─────────────────────────────────────────── */
        .form-group { margin-bottom: 20px; }
        .form-label {
            display: block;
            font-size: 10px;
            letter-spacing: .16em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 6px;
        }
        .form-control {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid var(--border);
            border-radius: var(--r);
            background: white;
            color: var(--ink);
            font-size: 14px;
            transition: border-color .2s;
            outline: none;
        }
        .form-control:focus { border-color: var(--accent); }
        .form-error { font-size: 12px; color: var(--danger); margin-top: 4px; }

        /* ── Table ─────────────────────────────────────────── */
        .table { width: 100%; border-collapse: collapse; }
        .table th {
            font-size: 10px;
            letter-spacing: .2em;
            text-transform: uppercase;
            color: var(--muted);
            text-align: left;
            padding: 12px 16px;
            border-bottom: 1px solid var(--border);
        }
        .table td { padding: 16px; border-bottom: 1px solid var(--border); vertical-align: middle; }

        /* ── Footer ────────────────────────────────────────── */
        footer {
            margin-top: auto;
            background: var(--ink);
            color: var(--stone);
            padding: 48px 0 24px;
        }
        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 48px;
            margin-bottom: 48px;
        }
        .footer-brand {
            font-family: 'Cormorant Garamond', serif;
            font-size: 24px;
            color: var(--cream);
            letter-spacing: .25em;
            text-transform: uppercase;
            margin-bottom: 12px;
        }
        .footer-tagline { font-size: 13px; line-height: 1.7; }
        .footer-heading {
            font-size: 10px;
            letter-spacing: .2em;
            text-transform: uppercase;
            color: var(--cream);
            margin-bottom: 16px;
        }
        .footer-links { list-style: none; }
        .footer-links li { margin-bottom: 8px; }
        .footer-links a { font-size: 13px; transition: color .2s; }
        .footer-links a:hover { color: var(--cream); }
        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,.08);
            padding-top: 24px;
            font-size: 12px;
            display: flex;
            justify-content: space-between;
        }

        @media (max-width: 768px) {
            .nav-links { display: none; }
            .footer-grid { grid-template-columns: 1fr; gap: 24px; }
            .search-form input { width: 110px; }
        }
    </style>

    @stack('styles')
</head>
<body>

{{-- Flash Messages --}}
@if(session('success'))
<div class="flash flash-success">{{ session('success') }}</div>
@endif
@if(session('error'))
<div class="flash flash-error">{{ session('error') }}</div>
@endif

{{-- Header --}}
<header class="site-header">
    <div class="container">
        <nav class="nav-inner">
            <a href="{{ route('home') }}" class="brand">Clothing Brand</a>

            <ul class="nav-links">
                <li><a href="{{ route('shop') }}">Shop</a></li>
                <li><a href="{{ route('products.category', 'women') }}">Women</a></li>
                <li><a href="{{ route('products.category', 'men') }}">Men</a></li>
                <li><a href="{{ route('products.category', 'bags') }}">Bags</a></li>
                <li><a href="{{ route('products.category', 'shoes') }}">Shoes</a></li>
            </ul>

            <div class="nav-actions">
                <form action="{{ route('shop') }}" method="GET" class="search-form">
                    <input type="text" name="search" placeholder="Search…" value="{{ request('search') }}">
                    <button type="submit">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                    </button>
                </form>

                @php $cartCount = app(\App\Services\CartService::class)->count(); @endphp
                <a href="{{ route('cart.index') }}" class="cart-btn">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                    Bag
                    @if($cartCount > 0)
                    <span class="cart-count">{{ $cartCount }}</span>
                    @endif
                </a>
            </div>
        </nav>
    </div>
</header>

{{-- Category Bar --}}
@hasSection('no-catbar')
@else
<div class="cat-bar">
    <div class="container">
        <ul>
            <li><a href="{{ route('shop') }}" class="{{ request()->routeIs('shop') && !request('category') ? 'active' : '' }}">All</a></li>
            <li><a href="{{ route('products.category', 'women') }}" class="{{ request()->is('category/women') ? 'active' : '' }}">Women</a></li>
            <li><a href="{{ route('products.category', 'men') }}" class="{{ request()->is('category/men') ? 'active' : '' }}">Men</a></li>
            <li><a href="{{ route('products.category', 'bags') }}" class="{{ request()->is('category/bags') ? 'active' : '' }}">Bags</a></li>
            <li><a href="{{ route('products.category', 'shoes') }}" class="{{ request()->is('category/shoes') ? 'active' : '' }}">Shoes</a></li>
        </ul>
    </div>
</div>
@endif

{{-- Main Content --}}
<main>
    @yield('content')
</main>

{{-- Footer --}}
<footer>
    <div class="container">
        <div class="footer-grid">
            <div>
                <div class="footer-brand">Clothing Brand</div>
                <p class="footer-tagline">Refined clothing for the modern wardrobe. Crafted with intention, designed to endure.</p>
            </div>
            <div>
                <div class="footer-heading">Shop</div>
                <ul class="footer-links">
                    <li><a href="{{ route('products.category', 'women') }}">Women</a></li>
                    <li><a href="{{ route('products.category', 'men') }}">Men</a></li>
                    <li><a href="{{ route('products.category', 'bags') }}">Bags</a></li>
                    <li><a href="{{ route('products.category', 'shoes') }}">Shoes</a></li>
                </ul>
            </div>
            <div>
                <div class="footer-heading">Info</div>
                <ul class="footer-links">
                    <li><a href="#">Shipping & Returns</a></li>
                    <li><a href="#">Size Guide</a></li>
                    <li><a href="#">Contact</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <span>&copy; {{ date('Y') }} Maison Mode. All rights reserved.</span>
            <span>Free shipping on orders over $100</span>
        </div>
    </div>
</footer>

@stack('scripts')
</body>
</html>
