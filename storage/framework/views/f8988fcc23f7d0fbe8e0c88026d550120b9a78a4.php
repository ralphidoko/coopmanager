<?php $__env->startSection('sidebar'); ?>
    <aside class="main-sidebar" style="font-size: large; ! important; background-color: #fff; color: #0b2e13;">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
                <?php
                    $name = Route::currentRouteName(); //echo $name;
                ?>
            <ul class="sidebar-menu" data-widget="tree">
                <li class="active treeview menu-open">
                    <a href="#">
                        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                        <span class="pull-right-container">
                           <i class="fa fa-angle-left pull-right"></i>
                        </span>
                        <?php if($name !=='home'): ?>
                            <ul class="treeview-menu">
                                <li><a href="<?php echo e(url('/dashboard/admin/adminHome')); ?>"><i class="fa fa-home"></i>Admin Dashboard</a></li>
                            </ul>
                        <?php endif; ?>
                    </a>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-money"></i> <span>Finance & Accounts</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href=""><i class="fa fa-plus"></i>Asset Management</a></li>
                        <li><a href="<?php echo e(url('dashboard/admin/accounting/createAccountChart')); ?>"><i class="fa fa-plus"></i>Chart of Accounts</a></li>
                        <li><a href="<?php echo e(url('dashboard/admin/accounting/recordExpense')); ?>"><i class="fa fa-plus"></i>Manage Expenses</a></li>
                        <li><a href="<?php echo e(url('dashboard/admin/accounting/createJournals')); ?>"><i class="fa fa-plus"></i>Setup Journals</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-money"></i> <span>Dividends Management</span>
                        <span class="pull-right-container">
                           <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="<?php echo e(url('dashboard/admin/accounting/declareDividends')); ?>"><i class="fa fa-edit"></i>Declare Dividends</a></li>
                        <li><a href="<?php echo e(url('dashboard/admin/accounting/dividendsList')); ?>"><i class="fa fa-list"></i>View Declared Dividends</a></li>
                        
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-upload"></i> <span>File Uploads</span>
                        <span class="pull-right-container">
                           <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="<?php echo e(url('dashboard/admin/adminFile/monthlyDepositUpload')); ?>"><i class="fa fa-upload"></i> Upload Monthly Savings</a></li>
                        <li><a href="<?php echo e(url('dashboard/admin/adminFile/downloadTemplate')); ?>"><i class="fa fa-download"></i> Download Savings Template</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-money"></i>
                        <span>Loan Management</span>
                        <span class="pull-right-container"></span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="<?php echo e(url('/dashboard/admin/loanApplicationList/')); ?>"><i class="fa fa-list"></i>View all Loans</a></li>
                        <li><a href="<?php echo e(url('/dashboard/admin/loanInstallmentsPayment/')); ?>"><i class="fa fa-circle-o"></i> Loan Repayments</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-bank"></i>
                        <span>Savings & Drawings</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="<?php echo e(url('/dashboard/admin/savingsAuthorizations')); ?>"><i class="fa fa-check"></i>Savings Authorization</a></li>
                        <li><a href="<?php echo e(url('/dashboard/admin/savingsWithdrawals')); ?>"><i class="fa fa-check"></i>Withdrawals Approval</a></li>
                        <li><a href="<?php echo e(url('/dashboard/admin/savingsWithdrawalsTransactions')); ?>"><i class="fa fa-exchange"></i>Members' Account Transactions</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-user"></i> <span>Member Management</span>
                        <span class="pull-right-container">
                           <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="<?php echo e(url('/dashboard/admin/membershipApplication')); ?>"><i class="fa fa-eye"></i>Membership Applications</a></li>
                        <li><a href="<?php echo e(url('/dashboard/admin/membershipRenewal')); ?>"><i class="fa fa-pencil"></i>Approve Renewal Requests</a></li>
                        <li><a href="<?php echo e(url('/dashboard/admin/membershipApplication')); ?>"><i class="fa fa-list"></i>View Members</a></li>
                        <li><a href="<?php echo e(url('/dashboard/admin/membersTransactions')); ?>"><i class="fa fa-list"></i>View Member Transactions</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-user"></i> <span>Roles & Permissions</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="<?php echo e(url('/dashboard/admin/config/configRolePermission')); ?>"><i class="fa fa-plus"></i>Set Roles/Permissions</a></li>
                        <li><a href=""><i class="fa fa-eye"></i>View Admin Users</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-shopping-cart"></i> <span>Products Management</span>
                        <span class="pull-right-container">
                           <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="<?php echo e(url('/dashboard/admin/products/manageProduct')); ?>"><i class="fa fa-plus"></i>Add Product</a></li>
                        <li><a href="<?php echo e(url('/dashboard/admin/products/manageProduct')); ?>"><i class="fa fa-edit"></i>Update Product Details</a></li>
                    </ul>
                </li>
               <!-- <li class="treeview">
                    <a href="#">
                        <i class="fa fa-user-circle"></i> <span>Elections & Pollings</span>
                        <span class="pull-right-container">
                           <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href=""><i class="fa fa-plus"></i>Setup Categories</a></li>
                        <li><a href=""><i class="fa fa-eye"></i>Setup Contestants</a></li>
                    </ul>
                </li> -->
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-pencil"></i> <span>Analysis/Reporting</span>
                        <span class="pull-right-container">
                           <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="<?php echo e(url('dashboard/admin/accounting/reportTemplate')); ?>"><i class="fa fa-eye"></i>View Reports Dashboard</a></li>
                        <li><a href="<?php echo e(url('dashboard/admin/reports/adminReportFilter')); ?>"><i class="fa fa-print"></i>Print Reports With Filter</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-eye"></i> <span>Audit Trails</span>
                        <span class="pull-right-container">
                           <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="<?php echo e(url('dashboard/admin/settings/viewLogs')); ?>"><i class="fa fa-eye"></i>View Logs</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-cogs"></i> <span>Configurations</span>
                        <span class="pull-right-container">
                           <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="<?php echo e(url('dashboard/admin/settings/setUpDepartments')); ?>"><i class="fa fa-plus"></i>Setup Departments/Zones</a></li>
                        <li><a href="<?php echo e(url('dashboard/admin/settings/setUpCharges')); ?>"><i class="fa fa-plus"></i>Setup Charges</a></li>
                        <li><a href="<?php echo e(url('dashboard/admin/settings/setUpCharges')); ?>"><i class="fa fa-list"></i>View all Charges</a></li>
                        <li><a href="<?php echo e(url('dashboard/admin/settings/importModels')); ?>"><i class="fa fa-forward"></i>Import Models</a></li>
                    </ul>
                </li>
            </ul>
        </section>
    </aside>
<?php $__env->stopSection(); ?>
<?php /**PATH C:\xampp\htdocs\coopmanager\resources\views/dashboard/admin/adminLinks.blade.php ENDPATH**/ ?>