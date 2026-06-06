<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Dashboard'); ?> — Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700&family=DM+Mono:wght@300;400&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --bg:      #0f0f0f;
            --surface: #181818;
            --card:    #1e1e1e;
            --border:  #2a2a2a;
            --accent:  #c8a97e;
            --green:   #4ade80;
            --red:     #f87171;
            --yellow:  #fbbf24;
            --blue:    #60a5fa;
            --text:    #e8e8e8;
            --muted:   #666;
            --sidebar: 220px;
        }
        html, body { height: 100%; }
        body { font-family: 'Syne', sans-serif; background: var(--bg); color: var(--text); display: flex; font-size: 14px; }
        a { color: inherit; text-decoration: none; }
        button, input, select, textarea { font-family: inherit; }

        /* ── Sidebar ───────────────────────── */
        .sidebar {
            width: var(--sidebar);
            background: var(--surface);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0; bottom: 0;
            z-index: 50;
        }
        .sidebar-brand {
            padding: 24px 20px;
            border-bottom: 1px solid var(--border);
        }
        .sidebar-brand-name {
            font-size: 13px;
            font-weight: 700;
            letter-spacing: .2em;
            text-transform: uppercase;
            color: var(--accent);
        }
        .sidebar-brand-sub {
            font-size: 10px;
            color: var(--muted);
            letter-spacing: .15em;
            text-transform: uppercase;
            margin-top: 2px;
        }
        .sidebar-nav { flex: 1; padding: 16px 0; overflow-y: auto; }
        .nav-section-label {
            font-size: 9px;
            letter-spacing: .25em;
            text-transform: uppercase;
            color: var(--muted);
            padding: 8px 20px 6px;
        }
        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 20px;
            font-size: 13px;
            font-weight: 500;
            color: var(--muted);
            transition: all .15s;
            border-left: 2px solid transparent;
        }
        .nav-item:hover { color: var(--text); background: rgba(255,255,255,.03); }
        .nav-item.active { color: var(--accent); border-left-color: var(--accent); background: rgba(200,169,126,.06); }
        .nav-item svg { flex-shrink: 0; }

        .sidebar-footer {
            padding: 16px 20px;
            border-top: 1px solid var(--border);
        }
        .sidebar-user { font-size: 11px; color: var(--muted); margin-bottom: 8px; }
        .logout-btn {
            display: flex; align-items: center; gap: 6px;
            font-size: 11px; color: var(--red); cursor: pointer;
            background: none; border: none; padding: 0;
            letter-spacing: .08em; text-transform: uppercase;
        }

        /* ── Main ──────────────────────────── */
        .main { margin-left: var(--sidebar); flex: 1; display: flex; flex-direction: column; min-height: 100vh; }
        .topbar {
            height: 56px;
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center;
            padding: 0 28px;
            gap: 12px;
            position: sticky; top: 0; z-index: 40;
        }
        .topbar-title { font-size: 15px; font-weight: 600; flex: 1; }
        .topbar-actions { display: flex; gap: 8px; }

        .content { padding: 28px; flex: 1; }

        /* ── Flash ─────────────────────────── */
        .flash { padding: 12px 16px; border-radius: 6px; font-size: 13px; margin-bottom: 20px; border-left: 3px solid; }
        .flash-success { background: rgba(74,222,128,.08); border-color: var(--green); color: var(--green); }
        .flash-error   { background: rgba(248,113,113,.08); border-color: var(--red);   color: var(--red);   }

        /* ── Stats Grid ────────────────────── */
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 28px; }
        .stat-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 20px;
        }
        .stat-label { font-size: 10px; letter-spacing: .2em; text-transform: uppercase; color: var(--muted); margin-bottom: 8px; }
        .stat-value { font-size: 28px; font-weight: 700; line-height: 1; }
        .stat-sub { font-size: 11px; color: var(--muted); margin-top: 4px; }
        .stat-accent { color: var(--accent); }
        .stat-green  { color: var(--green); }
        .stat-red    { color: var(--red); }
        .stat-yellow { color: var(--yellow); }

        /* ── Cards ─────────────────────────── */
        .card { background: var(--card); border: 1px solid var(--border); border-radius: 8px; }
        .card-header { padding: 16px 20px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
        .card-title { font-size: 13px; font-weight: 600; letter-spacing: .05em; }
        .card-body { padding: 20px; }

        /* ── Table ─────────────────────────── */
        .table { width: 100%; border-collapse: collapse; }
        .table th { font-size: 10px; letter-spacing: .2em; text-transform: uppercase; color: var(--muted); text-align: left; padding: 10px 16px; border-bottom: 1px solid var(--border); font-weight: 400; }
        .table td { padding: 12px 16px; border-bottom: 1px solid var(--border); font-size: 13px; vertical-align: middle; }
        .table tr:last-child td { border-bottom: none; }
        .table tr:hover td { background: rgba(255,255,255,.02); }

        /* ── Badges ────────────────────────── */
        .badge { display: inline-flex; align-items: center; padding: 2px 8px; border-radius: 4px; font-size: 10px; letter-spacing: .08em; text-transform: uppercase; font-weight: 600; }
        .badge-green  { background: rgba(74,222,128,.12);  color: var(--green); }
        .badge-red    { background: rgba(248,113,113,.12); color: var(--red); }
        .badge-yellow { background: rgba(251,191,36,.12);  color: var(--yellow); }
        .badge-blue   { background: rgba(96,165,250,.12);  color: var(--blue); }
        .badge-muted  { background: rgba(255,255,255,.06); color: var(--muted); }
        .badge-accent { background: rgba(200,169,126,.15); color: var(--accent); }

        /* ── Buttons ───────────────────────── */
        .btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: 6px; font-size: 12px; font-weight: 600; cursor: pointer; border: none; transition: all .15s; letter-spacing: .04em; font-family: inherit; }
        .btn-accent  { background: var(--accent); color: #0f0f0f; }
        .btn-accent:hover  { background: #d4b88e; }
        .btn-ghost   { background: rgba(255,255,255,.06); color: var(--text); border: 1px solid var(--border); }
        .btn-ghost:hover   { background: rgba(255,255,255,.1); }
        .btn-danger  { background: rgba(248,113,113,.15); color: var(--red); border: 1px solid rgba(248,113,113,.3); }
        .btn-danger:hover  { background: rgba(248,113,113,.25); }
        .btn-green   { background: rgba(74,222,128,.15); color: var(--green); border: 1px solid rgba(74,222,128,.3); }
        .btn-sm { padding: 5px 10px; font-size: 11px; }

        /* ── Forms ─────────────────────────── */
        .form-grid { display: grid; gap: 20px; }
        .form-grid-2 { grid-template-columns: 1fr 1fr; }
        .form-group { display: flex; flex-direction: column; gap: 6px; }
        .form-label { font-size: 11px; letter-spacing: .12em; text-transform: uppercase; color: var(--muted); }
        .form-control { background: var(--bg); border: 1px solid var(--border); border-radius: 6px; color: var(--text); padding: 9px 12px; font-size: 13px; outline: none; transition: border-color .15s; width: 100%; font-family: inherit; }
        .form-control:focus { border-color: var(--accent); }
        .form-control::placeholder { color: var(--muted); }
        .form-error { font-size: 11px; color: var(--red); }
        .form-hint  { font-size: 11px; color: var(--muted); }

        /* ── Toggle ────────────────────────── */
        .toggle-wrap { display: flex; align-items: center; gap: 8px; cursor: pointer; }
        .toggle { width: 36px; height: 20px; background: var(--border); border-radius: 10px; position: relative; transition: background .2s; flex-shrink: 0; }
        .toggle::after { content:''; position:absolute; top:2px; left:2px; width:16px; height:16px; border-radius:50%; background:white; transition: transform .2s; }
        input[type=checkbox]:checked + .toggle { background: var(--accent); }
        input[type=checkbox]:checked + .toggle::after { transform: translateX(16px); }
        input[type=checkbox].toggle-input { display: none; }

        /* ── Product thumb ─────────────────── */
        .product-thumb { width: 40px; height: 50px; background: var(--border); border-radius: 4px; object-fit: cover; display: flex; align-items: center; justify-content: center; overflow: hidden; }
        .product-thumb img { width: 100%; height: 100%; object-fit: cover; }
        .product-thumb-text { font-size: 8px; color: var(--muted); text-align: center; padding: 2px; }

        /* ── Pagination ────────────────────── */
        .pagination { display: flex; gap: 4px; justify-content: center; margin-top: 20px; }
        .pagination a, .pagination span { padding: 6px 12px; border: 1px solid var(--border); border-radius: 4px; font-size: 12px; color: var(--muted); }
        .pagination a:hover { border-color: var(--accent); color: var(--accent); }
        .pagination .active span { background: var(--accent); color: #0f0f0f; border-color: var(--accent); }

        /* ── Modal ─────────────────────────── */
        .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.7); z-index: 100; align-items: center; justify-content: center; }
        .modal-overlay.open { display: flex; }
        .modal { background: var(--card); border: 1px solid var(--border); border-radius: 10px; padding: 28px; width: 100%; max-width: 480px; max-height: 90vh; overflow-y: auto; }
        .modal-title { font-size: 16px; font-weight: 600; margin-bottom: 20px; }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>


<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="sidebar-brand-name">Maison Mode</div>
        <div class="sidebar-brand-sub">Admin Panel</div>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section-label">Overview</div>
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
            Dashboard
        </a>

        <div class="nav-section-label" style="margin-top:8px;">Catalogue</div>
        <a href="<?php echo e(route('admin.products.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.products.*') ? 'active' : ''); ?>">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
            Products
        </a>
        <a href="<?php echo e(route('admin.categories.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.categories.*') ? 'active' : ''); ?>">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
            Categories
        </a>

        <div class="nav-section-label" style="margin-top:8px;">Sales</div>
        <a href="<?php echo e(route('admin.orders.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.orders.*') ? 'active' : ''); ?>">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
            Orders
        </a>

        <div class="nav-section-label" style="margin-top:8px;">Store</div>
        <a href="<?php echo e(route('home')); ?>" target="_blank" class="nav-item">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
            View Store ↗
        </a>
    </nav>

    <div class="sidebar-footer">
        <div class="sidebar-user"><?php echo e(session('admin_email', 'admin@maisonmode.com')); ?></div>
        <form action="<?php echo e(route('admin.logout')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <button type="submit" class="logout-btn">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                Sign Out
            </button>
        </form>
    </div>
</aside>


<div class="main">
    <div class="topbar">
        <div class="topbar-title"><?php echo $__env->yieldContent('title', 'Dashboard'); ?></div>
        <div class="topbar-actions"><?php echo $__env->yieldContent('topbar-actions'); ?></div>
    </div>

    <div class="content">
        <?php if(session('success')): ?>
        <div class="flash flash-success">✓ <?php echo e(session('success')); ?></div>
        <?php endif; ?>
        <?php if(session('error')): ?>
        <div class="flash flash-error">✗ <?php echo e(session('error')); ?></div>
        <?php endif; ?>

        <?php echo $__env->yieldContent('content'); ?>
    </div>
</div>

<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH E:\New folder (2)\fashion-store\fashion-store\resources\views/admin/layout.blade.php ENDPATH**/ ?>