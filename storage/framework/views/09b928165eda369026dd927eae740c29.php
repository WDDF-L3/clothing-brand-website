<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-label">Total Revenue</div>
        <div class="stat-value stat-accent">Tk<?php echo e(number_format($stats['total_revenue'], 0)); ?></div>
        <div class="stat-sub">From completed orders</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Total Orders</div>
        <div class="stat-value"><?php echo e($stats['total_orders']); ?></div>
        <div class="stat-sub"><span class="stat-yellow"><?php echo e($stats['pending_orders']); ?> pending</span></div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Products</div>
        <div class="stat-value"><?php echo e($stats['total_products']); ?></div>
        <div class="stat-sub"><?php echo e($stats['active_products']); ?> active</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Stock Alerts</div>
        <div class="stat-value stat-red"><?php echo e($stats['out_of_stock']); ?></div>
        <div class="stat-sub"><?php echo e($stats['low_stock']); ?> low stock</div>
    </div>
</div>

<div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">

    
    <div class="card">
        <div class="card-header">
            <span class="card-title">Recent Orders</span>
            <a href="<?php echo e(route('admin.orders.index')); ?>" class="btn btn-ghost btn-sm">View All</a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $recent_orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td>
                        <a href="<?php echo e(route('admin.orders.show', $order)); ?>" style="color:var(--accent); font-family:'DM Mono',monospace; font-size:12px;">
                            <?php echo e($order->order_number); ?>

                        </a>
                    </td>
                    <td><?php echo e($order->customer_name); ?></td>
                    <td>$<?php echo e(number_format($order->total, 2)); ?></td>
                    <td>
                        <?php
                            $colors = ['pending'=>'yellow','processing'=>'blue','shipped'=>'accent','delivered'=>'green','cancelled'=>'red'];
                            $c = $colors[$order->status] ?? 'muted';
                        ?>
                        <span class="badge badge-<?php echo e($c); ?>"><?php echo e($order->status); ?></span>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="4" style="color:var(--muted); text-align:center;">No orders yet</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    
    <div class="card">
        <div class="card-header">
            <span class="card-title">⚠ Low Stock Items</span>
            <a href="<?php echo e(route('admin.products.index')); ?>" class="btn btn-ghost btn-sm">Manage</a>
        </div>
        <table class="table">
            <thead>
                <tr><th>Product</th><th>Stock</th><th></th></tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $low_stock_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($p->name); ?></td>
                    <td>
                        <span class="badge <?php echo e($p->stock === 0 ? 'badge-red' : 'badge-yellow'); ?>">
                            <?php echo e($p->stock === 0 ? 'Out of stock' : $p->stock . ' left'); ?>

                        </span>
                    </td>
                    <td><a href="<?php echo e(route('admin.products.edit', $p)); ?>" class="btn btn-ghost btn-sm">Edit</a></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="3" style="color:var(--muted); text-align:center;">All items well stocked ✓</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>


<div style="display:flex; gap:12px; margin-top:20px;">
    <a href="<?php echo e(route('admin.products.create')); ?>" class="btn btn-accent">+ Add Product</a>
    <a href="<?php echo e(route('admin.categories.index')); ?>" class="btn btn-ghost">Manage Categories</a>
    <a href="<?php echo e(route('admin.orders.index')); ?>" class="btn btn-ghost">View All Orders</a>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\New folder (2)\fashion-store\fashion-store\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>