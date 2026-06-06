<article class="product-card">
    <?php if($product->discount_percent > 0): ?>
        <div class="badge-sale">-<?php echo e($product->discount_percent); ?>%</div>
    <?php endif; ?>
    <?php if($product->stock === 0): ?>
        <div class="badge-oos">Sold Out</div>
    <?php endif; ?>

    <a href="<?php echo e(route('products.show', $product)); ?>" style="display:block;">
        <div class="card-img-wrap">
            <?php if(!empty($product->images)): ?>
                <img src="<?php echo e($product->primary_image); ?>" alt="<?php echo e($product->name); ?>" class="card-img" loading="lazy">
            <?php else: ?>
                <div class="card-img-placeholder">
                    <span><?php echo e($product->name); ?></span>
                </div>
            <?php endif; ?>
        </div>
    </a>

    <div class="card-body">
        <div class="card-category"><?php echo e($product->category->name ?? ''); ?></div>
        <h3 class="card-title">
            <a href="<?php echo e(route('products.show', $product)); ?>"><?php echo e($product->name); ?></a>
        </h3>

        
        <?php if(!empty($product->sizes)): ?>
        <div style="display:flex; gap:4px; flex-wrap:wrap; margin-bottom:12px;">
            <?php $__currentLoopData = $product->sizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <span style="font-size:9px; padding:2px 6px; border:1px solid var(--border); letter-spacing:.08em;"><?php echo e($size); ?></span>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php endif; ?>

        <div class="card-pricing">
            <span class="price"><?php echo e($product->formatted_price); ?></span>
            <?php if($product->compare_price): ?>
            <span class="price-compare"><?php echo e($product->formatted_compare_price); ?></span>
            <?php endif; ?>
        </div>

        <?php if($product->stock > 0): ?>
        <form action="<?php echo e(route('cart.add', $product)); ?>" method="POST" style="margin-top:12px;">
            <?php echo csrf_field(); ?>
            <?php if(!empty($product->sizes)): ?>
            <select name="size" class="form-control" style="margin-bottom:8px; font-size:12px; padding:7px 10px;" required>
                <option value="">Select size</option>
                <?php $__currentLoopData = $product->sizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($size); ?>"><?php echo e($size); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <?php endif; ?>
            <button type="submit" class="btn btn-dark" style="width:100%; justify-content:center;">
                Add to Bag
            </button>
        </form>
        <?php else: ?>
        <button class="btn" style="width:100%; justify-content:center; margin-top:12px; background:var(--warm); color:var(--stone); cursor:not-allowed;" disabled>
            Sold Out
        </button>
        <?php endif; ?>
    </div>
</article>
<?php /**PATH E:\New folder (2)\fashion-store\fashion-store\resources\views/components/product-card.blade.php ENDPATH**/ ?>