<?php $__env->startSection('header'); ?>
    <header class="main-header">
        <!-- Logo -->
    <?php echo $__env->make('dashboard.brand', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
            <?php echo $__env->make('dashboard.userProfileLink', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('dashboard.admin.adminLinks', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </nav>
    </header>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('main-content'); ?>
    <div class="content-wrapper">
        <section class="content">
        
        <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box box-danger"  style="margin-top: 10px">
                            <div class="box-header">
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                </div>
                                <h3 class="box-title">Members' Transactions</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body table-responsive">
                                <table id="example-2" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>View Transactions</th>
                                        <th>Name</th>
                                        <th>Membership Number</th>
                                        <th>Total Transaction(<del style="text-decoration-style: double">N</del>)</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($user->name != 'Administrator'): ?>
                                            <tr data-toggle="collapse" data-target="#<?php echo e($user->id); ?>" class="accordion-toggle">
                                                <td><button class="btn btn-default btn-xs"><span class="glyphicon glyphicon-eye-open"></span></button></td>
                                                <td><?php echo e($user->name); ?></td>
                                                <td><?php echo e($user->member_id); ?></td>
                                                <td><?php echo e(number_format($user->transactions->sum('transaction_amount'),2)); ?></td>
                                            </tr>
                                                <td colspan="12" class="hiddenRow">
                                                    <?php $counter = 1; ?>
                                                    <div class="accordian-body collapse install_table" id="<?php echo e($user->id); ?>">
                                                        <table class="table table-striped example-1">
                                                            <thead>
                                                            <tr>
                                                                <th>SN</th>
                                                                <th>Transaction Type</th>
                                                                <th>Transaction Amount(<del style="text-decoration-style: double">N</del>)</th>
                                                                <th>Channel</th>
                                                                <th>Status</th>
                                                                <th>Transaction Reference</th>
                                                                <th>Merchant</th>
                                                                <th>Transaction Date</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php $__currentLoopData = $user->transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <tr data-toggle="collapse"  class="accordion-toggle" data-target="#demo10">
                                                                        <td><?php echo e($counter++); ?></td>
                                                                        <td><?php echo e($transaction->transaction_type); ?></td>
                                                                        <td><del style="text-decoration-style: double">N</del><?php echo e(number_format($transaction->transaction_amount,2)); ?></td>
                                                                        <td><?php echo e($transaction->channel); ?></td>
                                                                        <td><span class="label label-success">Successful</span></td>
                                                                        <td><?php echo e($transaction->transaction_reference); ?></td>
                                                                        <td>Paystack</td>
                                                                        <td><?php echo e($transaction->created_at); ?></td>
                                                                    </tr>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <div class="row">
                            <span class="pull-right totalExpense" style="margin-right: 140px;font-size: 40px;font-weight: bolder">Total Members' Transaction:<del style="text-decoration-style: double">N</del><?php echo e(number_format($totalTransaction,2)); ?></span>
                        </div>
                    </div>
                    <div class="pagination">
                        <?php echo e($users->links()); ?>

                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </section>
            <!-- /.content -->
            <script>
                $(function () {
                    //use class for multiple table instead of id
                    $('.example-1').DataTable({
                        'paging'      : true,
                        'lengthChange': true,
                        'searching'   : false,
                        'ordering'    : true,
                        'info'        : true,
                        'autoWidth'   : false
                    })
                })
            </script>

        </section>

        <?php
if (! isset($_instance)) {
    $dom = \Livewire\Livewire::mount('change-password', [])->dom;
} elseif ($_instance->childHasBeenRendered('TASJh0J')) {
    $componentId = $_instance->getRenderedChildComponentId('TASJh0J');
    $componentTag = $_instance->getRenderedChildComponentTagName('TASJh0J');
    $dom = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('TASJh0J');
} else {
    $response = \Livewire\Livewire::mount('change-password', []);
    $dom = $response->dom;
    $_instance->logRenderedChild('TASJh0J', $response->id, \Livewire\Livewire::getRootElementTagName($dom));
}
echo $dom;
?>
    </div>
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 1.0.0
        </div>
        <strong>Copyright &copy; 2020 <a href="https://isosystemss.com" target="_blank">ISOSYSTEMS</a>.</strong> All rights
        reserved.
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-white">
        <!-- Tab panes -->
        <div class="tab-content">
            <!-- Home tab content -->
            <div class="tab-pane" id="control-sidebar-home-tab">

                <!-- /.control-sidebar-menu -->

                <!-- /.control-sidebar-menu -->

            </div>
            <!-- /.tab-pane -->

            <!-- /.tab-pane -->
        </div>
    </aside>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('dashboard.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\coopmanager\resources\views/dashboard/admin/membersTransactions.blade.php ENDPATH**/ ?>