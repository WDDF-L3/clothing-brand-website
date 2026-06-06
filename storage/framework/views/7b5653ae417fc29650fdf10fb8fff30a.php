<?php if($paginator->hasPages()): ?>
<nav style="display:flex; justify-content:center; align-items:center; gap:8px; font-size:12px; letter-spacing:.1em; text-transform:uppercase;">
    
    <?php if($paginator->onFirstPage()): ?>
        <span style="padding:8px 16px; border:1px solid var(--border); color:var(--stone); cursor:default;">← Prev</span>
    <?php else: ?>
        <a href="<?php echo e($paginator->previousPageUrl()); ?>" style="padding:8px 16px; border:1px solid var(--border); color:var(--ink); transition:all .2s;">← Prev</a>
    <?php endif; ?>

    
    <span style="color:var(--muted);">Page <?php echo e($paginator->currentPage()); ?> of <?php echo e($paginator->lastPage()); ?></span>

    
    <?php if($paginator->hasMorePages()): ?>
        <a href="<?php echo e($paginator->nextPageUrl()); ?>" style="padding:8px 16px; border:1px solid var(--border); color:var(--ink); transition:all .2s;">Next →</a>
    <?php else: ?>
        <span style="padding:8px 16px; border:1px solid var(--border); color:var(--stone); cursor:default;">Next →</span>
    <?php endif; ?>
</nav>
<?php endif; ?>
<?php /**PATH E:\New folder (2)\fashion-store\fashion-store\resources\views/vendor/pagination/simple-tailwind.blade.php ENDPATH**/ ?>