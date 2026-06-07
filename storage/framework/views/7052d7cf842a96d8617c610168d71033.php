<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — Maison Mode</title>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Syne', sans-serif; background: #0f0f0f; color: #e8e8e8; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .box { width: 100%; max-width: 380px; padding: 0 20px; }
        .brand { text-align: center; margin-bottom: 40px; }
        .brand-name { font-size: 20px; font-weight: 700; letter-spacing: .25em; text-transform: uppercase; color: #c8a97e; }
        .brand-sub { font-size: 11px; letter-spacing: .2em; text-transform: uppercase; color: #555; margin-top: 4px; }
        .card { background: #181818; border: 1px solid #2a2a2a; border-radius: 10px; padding: 32px; }
        .form-group { margin-bottom: 18px; }
        .form-label { display: block; font-size: 10px; letter-spacing: .18em; text-transform: uppercase; color: #666; margin-bottom: 6px; }
        .form-control { width: 100%; background: #0f0f0f; border: 1px solid #2a2a2a; border-radius: 6px; color: #e8e8e8; padding: 10px 14px; font-size: 14px; outline: none; font-family: inherit; transition: border-color .15s; }
        .form-control:focus { border-color: #c8a97e; }
        .form-error { font-size: 11px; color: #f87171; margin-top: 5px; }
        .btn { width: 100%; padding: 12px; background: #c8a97e; color: #0f0f0f; border: none; border-radius: 6px; font-size: 12px; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; cursor: pointer; font-family: inherit; margin-top: 8px; transition: background .15s; }
        .btn:hover { background: #d4b88e; }
        .hint { font-size: 11px; color: #444; text-align: center; margin-top: 20px; line-height: 1.6; }
        .flash { padding: 10px 14px; border-radius: 6px; font-size: 12px; margin-bottom: 16px; background: rgba(74,222,128,.08); border-left: 3px solid #4ade80; color: #4ade80; }
    </style>
</head>
<body>
<div class="box">
    <div class="brand">
        <div class="brand-name">Maison Mode</div>
        <div class="brand-sub">Admin Panel</div>
    </div>

    <?php if(session('success')): ?>
    <div class="flash"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <div class="card">
        <form action="<?php echo e(route('admin.login.post')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo e(old('email', 'admin@maisonmode.com')); ?>" required autofocus>
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="form-error"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn">Sign In</button>
        </form>
    </div>

    <p class="hint">Default: admin@maisonmode.com / admin123<br>Change in AuthController.php</p>
</div>
</body>
</html>
<?php /**PATH E:\New folder (2)\fashion-store\fashion-store\resources\views/admin/login.blade.php ENDPATH**/ ?>