<?php $__env->startSection('title', $product->name); ?>

<?php $__env->startSection('content'); ?>

<div style="padding: 48px 0;" class="container">

    
    <nav style="font-size:11px; letter-spacing:.12em; text-transform:uppercase; color:var(--muted); margin-bottom:40px;">
        <a href="<?php echo e(route('home')); ?>">Home</a>
        <span style="margin:0 8px;">›</span>
        <a href="<?php echo e(route('shop')); ?>">Shop</a>
        <span style="margin:0 8px;">›</span>
        <a href="<?php echo e(route('products.category', $product->category)); ?>"><?php echo e($product->category->name); ?></a>
        <span style="margin:0 8px;">›</span>
        <span style="color:var(--ink);"><?php echo e($product->name); ?></span>
    </nav>

    <div style="display:grid; grid-template-columns:1fr 480px; gap:64px; align-items:start;">

        
        <div style="background:var(--warm); aspect-ratio:3/4; display:flex; align-items:center; justify-content:center;">
            <?php if(!empty($product->images)): ?>
                <img src="<?php echo e($product->primary_image); ?>" alt="<?php echo e($product->name); ?>" style="width:100%;height:100%;object-fit:cover;">
            <?php else: ?>
                <div style="text-align:center; color:var(--stone);">
                    <p class="serif" style="font-size:32px; margin-bottom:8px;"><?php echo e($product->name); ?></p>
                    <p style="font-size:11px; letter-spacing:.15em; text-transform:uppercase;">No image available</p>
                </div>
            <?php endif; ?>
        </div>

        
        <div style="position:sticky; top:88px;">

            <p style="font-size:10px; letter-spacing:.22em; text-transform:uppercase; color:var(--muted); margin-bottom:8px;">
                <?php echo e($product->category->name); ?>

            </p>

            <h1 class="serif" style="font-size:42px; font-weight:300; margin-bottom:20px; line-height:1.1;">
                <?php echo e($product->name); ?>

            </h1>

            
            <div style="display:flex; align-items:baseline; gap:12px; margin-bottom:28px;">
                <span style="font-size:22px; font-weight:500;"><?php echo e($product->formatted_price); ?></span>
                <?php if($product->compare_price): ?>
                <span style="font-size:16px; text-decoration:line-through; color:var(--stone);"><?php echo e($product->formatted_compare_price); ?></span>
                <span style="background:var(--accent); color:white; font-size:10px; padding:2px 8px; letter-spacing:.08em; text-transform:uppercase;">
                    Save <?php echo e($product->discount_percent); ?>%
                </span>
                <?php endif; ?>
            </div>

            <p style="color:var(--muted); line-height:1.8; margin-bottom:32px; font-size:14px;">
                <?php echo e($product->description); ?>

            </p>

            <?php if($product->stock > 0): ?>
            <form action="<?php echo e(route('cart.add', $product)); ?>" method="POST">
                <?php echo csrf_field(); ?>

                <?php if(!empty($product->sizes)): ?>
                <div class="form-group">
                    <label class="form-label">Size</label>
                    <div style="display:flex; gap:8px; flex-wrap:wrap;">
                        <?php $__currentLoopData = $product->sizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <label style="cursor:pointer;">
                            <input type="radio" name="size" value="<?php echo e($size); ?>" style="display:none;" class="size-radio" required>
                            <span class="size-chip" style="display:inline-flex; align-items:center; justify-content:center; width:48px; height:48px; border:1px solid var(--border); font-size:12px; letter-spacing:.05em; transition:all .2s; cursor:pointer;">
                                <?php echo e($size); ?>

                            </span>
                        </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <?php endif; ?>

                <?php if(!empty($product->colors)): ?>
                <div class="form-group">
                    <label class="form-label">Color</label>
                    <select name="color" class="form-control">
                        <?php $__currentLoopData = $product->colors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($color); ?>"><?php echo e($color); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <?php endif; ?>

                <div class="form-group">
                    <label class="form-label">Quantity</label>
                    <input type="number" name="quantity" value="1" min="1" max="<?php echo e(min(10, $product->stock)); ?>" class="form-control" style="width:100px;">
                </div>

                <button type="submit" class="btn btn-dark" style="width:100%; justify-content:center; padding:16px;">
                    Add to Bag — <?php echo e($product->formatted_price); ?>

                </button>
            </form>
            <?php else: ?>
            <div style="padding:16px; background:var(--warm); text-align:center; border:1px solid var(--border); font-size:12px; letter-spacing:.1em; text-transform:uppercase; color:var(--muted);">
                Currently Out of Stock
            </div>
            <?php endif; ?>

            
            <p style="font-size:12px; color:var(--muted); margin-top:16px; text-align:center;">
                <?php if($product->stock <= 3 && $product->stock > 0): ?>
                    ⚠ Only <?php echo e($product->stock); ?> left in stock
                <?php elseif($product->stock > 3): ?>
                    ✓ In stock (<?php echo e($product->stock); ?> available)
                <?php endif; ?>
            </p>

            
            <div style="border-top:1px solid var(--border); margin-top:32px; padding-top:24px; font-size:12px; color:var(--muted); display:grid; gap:8px;">
                <div style="display:flex; justify-content:space-between;">
                    <span style="letter-spacing:.1em; text-transform:uppercase;">Free Shipping</span>
                    <span>on orders over $100</span>
                </div>
                <div style="display:flex; justify-content:space-between;">
                    <span style="letter-spacing:.1em; text-transform:uppercase;">Returns</span>
                    <span>30-day free returns</span>
                </div>
            </div>
        </div>
    </div>

    
    <?php if($related->isNotEmpty()): ?>
    <div style="margin-top:80px;">
        <h2 class="serif" style="font-size:32px; margin-bottom:32px; text-align:center;">You may also like</h2>
        <div class="product-grid">
            <?php $__currentLoopData = $related; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $relProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo $__env->make('components.product-card', ['product' => $relProduct], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php $__env->startPush('styles'); ?>
<style>
.size-radio:checked + .size-chip {
    background: var(--ink);
    color: var(--cream);
    border-color: var(--ink);
}
.size-chip:hover {
    border-color: var(--ink);
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\New folder (2)\fashion-store\fashion-store\resources\views/products/show.blade.php ENDPATH**/ ?>