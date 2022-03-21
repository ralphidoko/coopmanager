<?php $__env->startSection('content'); ?>
    <!-- Top content -->
        <div class="container" style="height: 1000% ! important;margin-top:40px">
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2 text">
                    <h1>Account Login</h1>
                </div>
            </div><br>
                <div class="row register-form" id="form-outer">
                    <div class="col-sm-4 col-sm-offset-1" id="form-inner">
                           <?php echo $__env->make('flashMessages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <form method="POST" action="<?php echo e(route('login')); ?>" >
                            <?php echo csrf_field(); ?>
                            <div class="form-group">
                                <input id="email" type="email" placeholder="Enter Your Email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="email" value="<?php echo e(old('email')); ?>" required autocomplete="email" autofocus>
                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="invalid-feedback" role="alert" style="color: rosybrown">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-group">
                                <input type="password" id="myInput" placeholder="Enter Your Password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="password"  required autofocus>
                                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="invalid-feedback" role="alert" style="color: rosybrown">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-group">
                                <span style="float: left"><input type="checkbox" onclick="myFunction()">&#160;Show Password</span>&#160;
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary pull-left" style="background-color:#3C8DBC;font-size: 20px">
                                    <?php echo e(__('Login')); ?>

                                </button><br><br>
                            </div>
                            <div class="form-group pull-left">
                                <?php if(Route::has('password.request')): ?>
                                    <a type="button" class="btn btn-outline-info" href="<?php echo e(route('password.request')); ?>" style="font-size: large;" >
                                        <?php echo e(__('Forgot your password?')); ?>

                                    </a>
                                <?php endif; ?>
                            </div>
                            <div class=" pull-left" style="font-size: large;color: black; width: 800px">Don't have an account?
                                <a href="<?php echo e(url('/register')); ?>">Register</a>&#160;&#160;||
                                Returning Member?&#160;&#160;<a href="<?php echo e(url('/returningMember')); ?>">Rejoin Here</a>
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-6 forms-right-icons" style="top:-20px ! important">
                        <div class="row">
                            <div class="col-sm-2 icon"><i class="fa fa-group"></i></div>
                            <div class="col-sm-10">
                                <h2>Together we are stronger</h2>
                                <p style="color: black;font-size: 20px">We believe in unity for the benefit of all.</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2 icon"><i class="fa fa-life-saver"></i></div>
                            <div class="col-sm-10">
                                <h2>Nepza cooperative</h2>
                                <p style="color: black;font-size: 20px">Aims to improve the living standard of its members through the culture of saving</p>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    <script>
        function myFunction() {
            var x = document.getElementById("myInput");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('auth.shield.layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\coopmanager\resources\views/auth/shield/login.blade.php ENDPATH**/ ?>