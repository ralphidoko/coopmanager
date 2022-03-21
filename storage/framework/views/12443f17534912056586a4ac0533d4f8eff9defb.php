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
                            <div class="preloader">
                                <img src="<?php echo e(asset('custom/img')); ?>/loader.gif" alt="" />
                            </div>
                            <style>
                                .preloader{
                                    display:none;
                                    position: absolute;
                                    left: 50%;
                                    top: 20%;
                                    -webkit-transform: translate(-50%, -50%);
                                    transform: translate(-50%, -50%);
                                }
                            </style>
                            <div class="box-header">
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                </div>
                                <h3 class="box-title">Members' Account Transactions</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body table-responsive">
                                <table id="example-2" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>View Transactions</th>
                                        <th>Account Name</th>
                                        <th>Account Number</th>
                                        <th>Total Credit (Deposit)(<del style="text-decoration-style: double">N</del>)</th>
                                        <th>Total Debit (Withdrawal)(<del style="text-decoration-style: double">N</del>)</th>
                                        <th>Available/Book Balance (<del style="text-decoration-style: double">N</del>)</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($user->name != 'Administrator'): ?>
                                            <tr data-toggle="collapse" data-target="#<?php echo e($user->id); ?>" class="accordion-toggle">
                                                <td><button class="btn btn-default btn-xs"><span class="glyphicon glyphicon-eye-open"></span></button></td>
                                                <td><?php echo e($user->name); ?></td>
                                                <td><?php echo e($user->ippis_no); ?></td>
                                                <td><?php echo e(number_format($user->savings->sum('amount_saved'),2)); ?></td>
                                                <td><?php echo e(number_format($user->savings->where('status','Approved')->sum('amount_withdrawn'),2)); ?></td>
                                                <td><?php echo e(number_format($user->savings->sum('amount_saved') - $user->savings->where('status','Approved')->sum('amount_withdrawn'),2)); ?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="12" class="hiddenRow">
                                                        <div class="accordian-body collapse install_table" id="<?php echo e($user->id); ?>">
                                                            <table class="table table-striped example-1">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Transaction Type</th>
                                                                        <th>Transaction Date</th>
                                                                        <th>Credit (Deposit)(<del style="text-decoration-style: double">N</del>)</th>
                                                                        <th>Debit (Withdrawal)(<del style="text-decoration-style: double">N</del>)</th>
                                                                        <th>Theoritical Balance (<del style="text-decoration-style: double">N</del>)</th>
                                                                    </tr>
                                                                    </thead>
                                                                <tbody>
                                                                    <?php $__currentLoopData = $user->savings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $saving): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <tr data-toggle="collapse"  class="accordion-toggle" data-target="#demo10">
                                                                            <td><?php echo e($saving->description); ?></td>
                                                                            <td><?php echo e(date('d-M-Y',strtotime($saving->month))); ?></td>
                                                                            <td>
                                                                                <?php if($saving->amount_saved > 0.00): ?>
                                                                                    <span class="label label-success"><?php echo e(number_format($saving->amount_saved,2)); ?></span>
                                                                                <?php else: ?>
                                                                                    <span class="label"></span>
                                                                                <?php endif; ?>
                                                                            </td>
                                                                            <td>
                                                                                <?php if($saving->amount_withdrawn > 0.00 && $saving->status !== 'Processing' && $saving->status !== 'Rejected'): ?>
                                                                                    <span class="label label-danger" data-toggle="tooltip" title="Withdrawal Request Approved"><?php echo e(number_format($saving->amount_withdrawn,2)); ?>

                                                                                <?php elseif($saving->amount_withdrawn > 0.00 && $saving->status === 'Processing'): ?>
                                                                                   <span class="label label-info" data-toggle="tooltip" title="Approval Pending"><?php echo e(number_format($saving->amount_withdrawn,2)); ?>

                                                                                <?php elseif($saving->amount_withdrawn > 0.00 && $saving->status === 'Rejected'): ?>
                                                                                   <span class="label label-info" data-toggle="tooltip" title="Withdrawal Request Rejected"><del style="text-decoration-style: double;text-decoration-color: red"><?php echo e(number_format($saving->amount_withdrawn,2)); ?></del>
                                                                                <?php else: ?>
                                                                                <span class="label"></span>
                                                                                <?php endif; ?>
                                                                            </td>
                                                                            <td><?php echo e(number_format($saving->balance,2)); ?></td>
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
                                <div class="pagination">
                                    <?php echo e($users->links()); ?>

                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>
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
} elseif ($_instance->childHasBeenRendered('oowSKeA')) {
    $componentId = $_instance->getRenderedChildComponentId('oowSKeA');
    $componentTag = $_instance->getRenderedChildComponentTagName('oowSKeA');
    $dom = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('oowSKeA');
} else {
    $response = \Livewire\Livewire::mount('change-password', []);
    $dom = $response->dom;
    $_instance->logRenderedChild('oowSKeA', $response->id, \Livewire\Livewire::getRootElementTagName($dom));
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

<?php echo $__env->make('dashboard.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\coopmanager\resources\views/dashboard/admin/savingsWithdrawalsTransactions.blade.php ENDPATH**/ ?>