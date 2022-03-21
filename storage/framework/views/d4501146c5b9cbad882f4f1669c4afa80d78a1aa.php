<?php if($message = Session::get('success')): ?>
    <div class="alert alert-success alert-block" style="font-size: 20px; height: 35px; padding: 0px;">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong><?php echo e($message); ?></strong>
    </div>
<?php endif; ?>


<?php if($message = Session::get('error')): ?>
    <div class="alert alert-danger alert-block" style="font-size: 20px; height: 35px; padding: 0px;">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong><?php echo e($message); ?></strong>
    </div>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\coopmanager\resources\views/generalFlash.blade.php ENDPATH**/ ?>