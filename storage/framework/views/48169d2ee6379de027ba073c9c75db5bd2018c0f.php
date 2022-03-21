<?php
    $checkUserVerificationStatus = \App\Member::where('user_id',Auth::id())->first();
?>
<?php $__env->startSection('sidebar'); ?>
    <aside class="main-sidebar isDisabled" style="font-size: large ! important; background-color: #fff; color: #0b2e13;">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
                <!-- Sidebar user panel -->
                <div class="user-panel">
                    <div class="pull-left image">
                        <?php if(Auth::user()->passport_url != null): ?>
                        <img src="<?php echo e(asset('/storage/'. Auth::user()->passport_url)); ?>" class="img-circle">
                        <?php endif; ?>
                        <?php if(Auth::check()): ?>
                            <a href="#"><i class="fa fa-circle text-success" style="font-size: 8px ! important;"></i> Online</a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php
                $name = Route::currentRouteName(); //echo $name;
            ?>
            <!-- sidebar menu: : style can be found in sidebar.less -->
              <ul class="sidebar-menu" data-widget="tree" >
                    <li class="active treeview menu-open">
                        <a href="#">
                            <i class="fa fa-dashboard"></i> <span>My Dashboard</span>
                            <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                            </span>
                            <?php if($name !=='home'): ?>
                                <ul class="treeview-menu">
                                    <li><a href="<?php echo e(url('/dashboard/home')); ?>"><i class="fa fa-home"></i>Dashboard</a></li>
                                </ul>
                            <?php endif; ?>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-money"></i>
                            <span>My Loan Activities</span>
                            <span class="pull-right-container">
                        </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="<?php echo e(url('/application/loanApplication/')); ?>"><i class="fa fa-pencil-square"></i>Apply for Loan</a></li>
                            <li><a href="<?php echo e(url('/application/loanList/')); ?>"><i class="fa fa-eye"></i>View all Loans</a></li>
                            <li><a href="<?php echo e(url('/application/loanList/')); ?>"><i class="fa fa-eye"></i>Offset Loan Balance</a></li>
                            <li><a href="<?php echo e(url('/archive/loanHistory/')); ?>"><i class="fa fa-eye"></i>My Loan Archive</a></li>
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-bank"></i>
                            <span>My Account Activities</span>
                            <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="<?php echo e(url('/savings/savingStandingOrder')); ?>"><i class="fa fa-circle-o"></i>Saving Authorization</a></li>
                            <li><a href="<?php echo e(url('/savings/savingAuthorizationList')); ?>"><i class="fa fa-circle-o"></i>View all Authorizations</a></li>
                            <li><a href="<?php echo e(url('/withdrawals/makeWithdrawal')); ?>"><i class="fa fa-circle-o"></i>Make Withdrawal</a></li>
                            <li><a href="<?php echo e(url('/withdrawals/withdrawalTransactions')); ?>"><i class="fa fa-circle-o"></i>View Saving Transactions</a></li>
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-exchange"></i>
                            <span>My Transactions</span>
                            <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="<?php echo e(url('/transactions/myTransactions')); ?>"><i class="fa fa-eye"></i>View all Transactions</a></li>
                        </ul>
                    </li>
                    
                  
                  <li class="treeview">
                      <a href="#">
                          <i class="fa fa-edit"></i> <span>My Reports</span>
                          <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                            </span>
                      </a>
                      <ul class="treeview-menu">
                          <li><a href="<?php echo e(url('reports/user/userReportTemplate')); ?>"><i class="fa fa-edit"></i>All Reports With Filter</a></li>
                          <li><a href="<?php echo e(url('reports/user/accountStatement')); ?>"><i class="fa fa-edit"></i>Print Account Statement</a></li>
                          <li><a href="<?php echo e(url('reports/user/loanStatement')); ?>"><i class="fa fa-edit"></i>Print Loan Statement</a></li>
                          <li><a href="<?php echo e(url('reports/user/transactionStatement')); ?>"><i class="fa fa-edit"></i>Print Transactions</a></li>
                          <li><a href="<?php echo e(url('reports/user/dividends')); ?>"><i class="fa fa-edit"></i>Print Dividends</a></li>
                      </ul>
                  </li>
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>
    <?php if($checkUserVerificationStatus->approval_count != 2): ?>
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
    <?php if($checkUserVerificationStatus->certification != 1): ?>
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

<?php $__env->stopSection(); ?>
<?php /**PATH C:\xampp\htdocs\coopmanager\resources\views/dashboard/navigation.blade.php ENDPATH**/ ?>