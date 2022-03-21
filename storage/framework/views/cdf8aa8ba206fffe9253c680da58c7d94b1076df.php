<?php
$name = Route::currentRouteName();
$is_admin = Auth::user()->is_admin;
//echo $is_admin;
$checkUserVerificationStatus = \App\Member::where('user_id',Auth::id())->first();
?>
<div class="navbar-custom-menu isDisabled">
    <ul class="nav navbar-nav">
        <!-- User Account: style can be found in dropdown.less -->
        <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <?php if(Auth::user()->passport_url != ''): ?>
                <img src="<?php echo e(asset('/storage/'. Auth::user()->passport_url)); ?>" class="user-image" alt="User Image">
                <?php endif; ?>
                <span class="hidden-xs" style="font-size: large"><?php echo e(Auth::User()->name); ?></span>
                <ul class="dropdown-menu" role="menu" style="width: 150px;">
                    <?php if($name != 'profile' && $name != 'admin-home' && $name != 'update-user-profile'): ?>
                    <li><a href="<?php echo e(url('/dashboard/userProfile/updateUserprofile')); ?>" class="btn btn-default btn-primary" style="background-color: #3C8DBC; color: white ! important">Update Profile</a></li>
                        <li class="divider"></li>
                    <?php endif; ?>

                    <li><a href="" class="btn btn-default btn-flat" data-toggle="modal" style="background-color: #3C8DBC; color: white ! important" data-target="#change_pwd">Change Password</a></li>
                    <li class="divider"></li>
                        <?php if($is_admin == true && $name !='admin-home'): ?>
                    <li><a href="" class="btn btn-default btn-flat" data-toggle="modal" style="background-color: #3C8DBC; color: white ! important" data-target="#allow-admin">Switch Role</a></li>
                    <li class="divider"></li>
                        <?php endif; ?>
                        <?php if($is_admin == true && $name == 'admin-home'): ?>
                            <li><a href="<?php echo e(url('/dashboard/home')); ?>" style="background-color: #3C8DBC; color: white ! important" class="btn btn-default btn-flat">Logout Role</a></li>
                            <li class="divider"></li>
                        <?php endif; ?>
                    <li><a href="<?php echo e(url('/accountActivation/makePayment')); ?>" class="btn btn-default btn-flat" style="background-color: red; color: white ! important" data-target="#allow-admin">Close Account</a></li>
                        <li class="divider"></li>
                    <li><a class="dropdown-item btn btn-default btn-flat" style="background-color: #3C8DBC; color: white ! important" href="<?php echo e(route('logout')); ?>"--}}
                           onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                            <?php echo e(__('Logout')); ?>

                        </a>
                        <form id="logout-form" action="<?php echo e(route('logout')); ?>"  method="POST" style="display: none;">
                            <?php echo csrf_field(); ?>
                        </form></li>
                    <li class="divider"></li>
                </ul>
            </a>
        </li>
        <!-- Control Sidebar Toggle Button -->
    </ul>
</div>
    <?php if($checkUserVerificationStatus->approval_count != 2 || $checkUserVerificationStatus->membership_status == 'Archived'): ?>
        <?php
            echo '<style type="text/css">
                .isDisabled {
                    color: currentColor;
                    cursor: not-allowed;
                    display: inline-block;
                    opacity: 0.5;
                    text-decoration: none;
                    pointer-events: none;
                }
            </style>';
        ?>
    <?php endif; ?>

<?php /**PATH C:\xampp\htdocs\coopmanager\resources\views/dashboard/userProfileLink.blade.php ENDPATH**/ ?>