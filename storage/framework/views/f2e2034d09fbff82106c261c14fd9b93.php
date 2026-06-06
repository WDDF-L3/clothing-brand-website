<?php $__env->startSection('title', 'Products'); ?>

<?php $__env->startSection('topbar-actions'); ?>
<a href="<?php echo e(route('admin.products.create')); ?>" class="btn btn-accent">+ New Product</a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>


<div class="card" style="margin-bottom:20px;">
    <div class="card-body" style="padding:14px 20px;">
        <form action="<?php echo e(route('admin.products.index')); ?>" method="GET" style="display:flex; gap:12px; align-items:center; flex-wrap:wrap;">
            <input type="text" name="search" placeholder="Search products…" class="form-control" style="width:220px;" value="<?php echo e(request('search')); ?>">
            <select name="category" class="form-control" style="width:160px;">
                <option value="">All Categories</option>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($cat->id); ?>" <?php echo e(request('category') == $cat->id ? 'selected' : ''); ?>><?php echo e($cat->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <button type="submit" class="btn btn-ghost">Filter</button>
            <?php if(request('search') || request('category')): ?>
            <a href="<?php echo e(route('admin.products.index')); ?>" class="btn btn-ghost">Clear</a>
            <?php endif; ?>
            <span style="margin-left:auto; font-size:12px; color:var(--muted);"><?php echo e($products->total()); ?> products</span>
        </form>
    </div>
</div>

<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Category</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Status</th>
                <th>Featured</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td>
                    <div style="display:flex; align-items:center; gap:12px;">
                        <div class="product-thumb">
                            <?php if(!empty($product->images)): ?>
                                <img src="<?php echo e($product->primary_image); ?>" alt="<?php echo e($product->name); ?>">
                            <?php else: ?>
                                <div class="product-thumb-text">No img</div>
                            <?php endif; ?>
                        </div>
                        <div>
                            <div style="font-weight:600; font-size:13px;"><?php echo e($product->name); ?></div>
                            <div style="font-size:11px; color:var(--muted);"><?php echo e($product->slug); ?></div>
                        </div>
                    </div>
                </td>
                <td><span class="badge badge-muted"><?php echo e($product->category->name ?? '—'); ?></span></td>
                <td>
                    <div style="font-weight:600;">Tk<?php echo e(number_format($product->price, 2)); ?></div>
                    <?php if($product->compare_price): ?>
                    <div style="font-size:11px; color:var(--muted); text-decoration:line-through;">Tk<?php echo e(number_format($product->compare_price, 2)); ?></div>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if($product->stock === 0): ?>
                        <span class="badge badge-red">Out of stock</span>
                    <?php elseif($product->stock <= 5): ?>
                        <span class="badge badge-yellow"><?php echo e($product->stock); ?> left</span>
                    <?php else: ?>
                        <span style="font-size:13px;"><?php echo e($product->stock); ?></span>
                    <?php endif; ?>
                </td>
                <td>
                    <form action="<?php echo e(route('admin.products.toggle-active', $product)); ?>" method="POST">
                        <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                        <button type="submit" class="badge <?php echo e($product->is_active ? 'badge-green' : 'badge-red'); ?>" style="cursor:pointer; border:none; background:inherit;">
                            <?php echo e($product->is_active ? 'Active' : 'Hidden'); ?>

                        </button>
                    </form>
                </td>
                <td>
                    <?php if($product->is_featured): ?>
                    <span class="badge badge-accent">⭐ Featured</span>
                    <?php else: ?>
                    <span style="color:var(--muted); font-size:12px;">—</span>
                    <?php endif; ?>
                </td>
                <td>
                    <div style="display:flex; gap:6px;">
                        <a href="<?php echo e(route('admin.products.edit', $product)); ?>" class="btn btn-ghost btn-sm">Edit</a>
                        <form action="<?php echo e(route('admin.products.destroy', $product)); ?>" method="POST" onsubmit="return confirm('Delete \'<?php echo e(addslashes($product->name)); ?>\'?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-danger btn-sm">Del</button>
                        </form>
                    </div>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="7" style="text-align:center; padding:40px; color:var(--muted);">
                    No products found. <a href="<?php echo e(route('admin.products.create')); ?>" style="color:var(--accent);">Add one →</a>
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <?php if($products->hasPages()): ?>
    <div style="padding:16px 20px; border-top:1px solid var(--border);">
        <?php echo e($products->links()); ?>

    </div>
    <?php endif; ?>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\New folder (2)\fashion-store\fashion-store\resources\views/admin/products/index.blade.php ENDPATH**/ ?>