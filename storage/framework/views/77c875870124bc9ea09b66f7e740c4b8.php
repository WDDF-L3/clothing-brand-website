<?php $__env->startSection('title', 'Orders'); ?>

<?php $__env->startSection('content'); ?>


<div style="display:flex; gap:8px; margin-bottom:20px; flex-wrap:wrap;">
    <?php $statuses = [''=>'All', 'pending'=>'Pending', 'processing'=>'Processing', 'shipped'=>'Shipped', 'delivered'=>'Delivered', 'cancelled'=>'Cancelled']; ?>
    <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <a href="<?php echo e(route('admin.orders.index', $val ? ['status'=>$val] : [])); ?>"
       class="btn <?php echo e(request('status') == $val ? 'btn-accent' : 'btn-ghost'); ?> btn-sm">
        <?php echo e($label); ?>

    </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>Order #</th>
                <th>Customer</th>
                <th>Items</th>
                <th>Total</th>
                <th>Payment</th>
                <th>Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td>
                    <a href="<?php echo e(route('admin.orders.show', $order)); ?>" style="color:var(--accent); font-size:12px; font-weight:600;">
                        <?php echo e($order->order_number); ?>

                    </a>
                </td>
                <td>
                    <div style="font-weight:600; font-size:13px;"><?php echo e($order->customer_name); ?></div>
                    <div style="font-size:11px; color:var(--muted);"><?php echo e($order->customer_email); ?></div>
                </td>
                <td style="color:var(--muted);"><?php echo e($order->items()->count()); ?></td>
                <td style="font-weight:600;">$<?php echo e(number_format($order->total, 2)); ?></td>
                <td><span class="badge badge-muted"><?php echo e(strtoupper($order->payment_method)); ?></span></td>
                <td style="font-size:12px; color:var(--muted);"><?php echo e($order->created_at->format('M d, Y')); ?></td>
                <td>
                    <?php $colors = ['pending'=>'yellow','processing'=>'blue','shipped'=>'accent','delivered'=>'green','cancelled'=>'red']; ?>
                    <span class="badge badge-<?php echo e($colors[$order->status] ?? 'muted'); ?>"><?php echo e($order->status); ?></span>
                </td>
                <td>
                    <div style="display:flex; gap:6px;">
                        <a href="<?php echo e(route('admin.orders.show', $order)); ?>" class="btn btn-ghost btn-sm">View</a>
                        <form action="<?php echo e(route('admin.orders.destroy', $order)); ?>" method="POST" onsubmit="return confirm('Delete this order?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-danger btn-sm">Del</button>
                        </form>
                    </div>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="8" style="text-align:center; padding:40px; color:var(--muted);">No orders found.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <?php if($orders->hasPages()): ?>
    <div style="padding:16px 20px; border-top:1px solid var(--border);">
        <?php echo e($orders->links()); ?>

    </div>
    <?php endif; ?>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\New folder (2)\fashion-store\fashion-store\resources\views/admin/orders/index.blade.php ENDPATH**/ ?>