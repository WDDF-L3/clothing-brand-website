<?php $__env->startSection('title', 'Shop'); ?>

<?php $__env->startSection('content'); ?>


<?php if(request()->routeIs('home') && $featured->isNotEmpty()): ?>
<section style="background:var(--ink); color:var(--cream); padding: 80px 0; overflow:hidden; position:relative;">
    <div class="container" style="display:grid; grid-template-columns:1fr 1fr; gap:64px; align-items:center;">
        <div>
            <p style="font-size:11px; letter-spacing:.25em; text-transform:uppercase; color:var(--stone); margin-bottom:16px;">New Collection</p>
            <h1 class="serif" style="font-size:clamp(48px,6vw,80px); line-height:1; margin-bottom:24px; font-weight:300;">
                Dressed<br><em>to endure.</em>
            </h1>
            <p style="color:var(--stone); line-height:1.8; margin-bottom:36px; max-width:380px;">
                Timeless pieces crafted from the finest materials. Each garment designed to become a cornerstone of your wardrobe.
            </p>
            <a href="<?php echo e(route('shop')); ?>" class="btn btn-accent">Shop the Collection</a>
        </div>
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:4px;">
            <?php $__currentLoopData = $featured->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('products.show', $p)); ?>" style="aspect-ratio:3/4; overflow:hidden; background:var(--warm); display:block;">
                <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-family:'Cormorant Garamond',serif;font-size:13px;color:#7a736b;text-align:center;padding:12px;"><?php echo e($p->name); ?></div>
            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php endif; ?>

<section style="padding: 48px 0;">
    <div class="container">

        
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:32px; flex-wrap:wrap; gap:16px;">
            <div>
                <h2 class="serif" style="font-size:28px;">
                    <?php if(request('search')): ?>
                        Results for "<?php echo e(request('search')); ?>"
                    <?php else: ?>
                        All Products
                    <?php endif; ?>
                </h2>
                <p style="font-size:12px; color:var(--muted); margin-top:4px;"><?php echo e($products->total()); ?> pieces</p>
            </div>

            <form action="<?php echo e(route('shop')); ?>" method="GET" style="display:flex; align-items:center; gap:8px;">
                <?php if(request('search')): ?><input type="hidden" name="search" value="<?php echo e(request('search')); ?>"><?php endif; ?>
                <select name="sort" onchange="this.form.submit()" class="form-control" style="width:auto; font-size:12px; padding:8px 12px;">
                    <option value="newest"     <?php echo e(request('sort','newest') === 'newest'     ? 'selected':''); ?>>Newest</option>
                    <option value="price_asc"  <?php echo e(request('sort') === 'price_asc'           ? 'selected':''); ?>>Price: Low → High</option>
                    <option value="price_desc" <?php echo e(request('sort') === 'price_desc'          ? 'selected':''); ?>>Price: High → Low</option>
                    <option value="name"       <?php echo e(request('sort') === 'name'                ? 'selected':''); ?>>Name A–Z</option>
                </select>
            </form>
        </div>

        
        <?php if($products->isEmpty()): ?>
        <div style="text-align:center; padding:80px 0; color:var(--muted);">
            <p class="serif" style="font-size:32px; margin-bottom:12px;">No products found.</p>
            <a href="<?php echo e(route('shop')); ?>" class="btn btn-outline" style="margin-top:16px;">Browse All</a>
        </div>
        <?php else: ?>
        <div class="product-grid">
            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo $__env->make('components.product-card', ['product' => $product], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        
        <div style="margin-top:48px; display:flex; justify-content:center;">
            <?php echo e($products->links()); ?>

        </div>
        <?php endif; ?>

    </div>
</section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\New folder (2)\fashion-store\fashion-store\resources\views/products/index.blade.php ENDPATH**/ ?>