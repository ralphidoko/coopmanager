<div class="modal fade modal-dialog-centered" id="allow-admin" xmlns:wire="http://www.w3.org/1999/xhtml" wire:ignore.self>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">Exit</span></button>
                <h4 class="modal-title"><b>Enter your password to continue</b></h4>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="grantAdminAccess()">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div style="display: inline-flex;" class="col-md-10 col-lg-12">
                            <div class="form-group col-md-10 col-lg-10">
                                <label for="password">Enter Password</label>
                                <input type="text" class="form-control" name="middle_name" wire:model.debounce.500ms="password">
                                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-md"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <br />
                                <button type="submit" style="width:40%;" class="form-control btn btn-primary">Grant Access</button>
                            </div>
                        </div>
                    </div>
                </form>
                <div><?php echo $__env->make('generalFlash', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></div>
            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->








<?php /**PATH C:\xampp\htdocs\coopmanager\resources\views/livewire/allow-admin.blade.php ENDPATH**/ ?>