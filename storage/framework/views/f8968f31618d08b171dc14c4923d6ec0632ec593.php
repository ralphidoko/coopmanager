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
        </nav>
    </header>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('dashboard.navigation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php
if (! isset($_instance)) {
    $dom = \Livewire\Livewire::mount('allow-admin', [])->dom;
} elseif ($_instance->childHasBeenRendered('Ndpi2Go')) {
    $componentId = $_instance->getRenderedChildComponentId('Ndpi2Go');
    $componentTag = $_instance->getRenderedChildComponentTagName('Ndpi2Go');
    $dom = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('Ndpi2Go');
} else {
    $response = \Livewire\Livewire::mount('allow-admin', []);
    $dom = $response->dom;
    $_instance->logRenderedChild('Ndpi2Go', $response->id, \Livewire\Livewire::getRootElementTagName($dom));
}
echo $dom;
?>
<?php $__env->startSection('main-content'); ?>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content">
           
            <div class="row col-md-10 col-lg-10 flex justify-content-center">
                <div class="box box-primary " style="padding: 10px;">
                    <div role="form">
                        <div style="display: inline-flex; margin-left: 10px;">
                            <div style="background-color: #4e555b;width: auto;" class="col-md-12 col-lg-12">
                                <label style="color: #ffffff;padding-top:4px;">SAVING/WITHDRAWAL TRANSACTIONS</label>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="example2" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Transaction Type</th>
                                    <th>Transaction Date</th>
                                    <th>Credit (Deposit)(<del style="text-decoration-style: double">N</del>)</th>
                                    <th>Debit (Withdrawal)(<del style="text-decoration-style: double">N</del>)</th>
                                    <th>Balance (<del style="text-decoration-style: double">N</del>)</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $__currentLoopData = $savings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $saving): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
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
                    </div>
                </div>
            </div>
            <script>
                $(function () {
                    $('#example1').DataTable()
                    $('#example2').DataTable({
                        'paging'      : true,
                        'lengthChange': false,
                        'searching'   : true,
                        'ordering'    : false,
                        'info'        : true,
                        'autoWidth'   : false
                    })
                })
            </script>
        </section>
        <?php
if (! isset($_instance)) {
    $dom = \Livewire\Livewire::mount('change-password', [])->dom;
} elseif ($_instance->childHasBeenRendered('sPvI6Jr')) {
    $componentId = $_instance->getRenderedChildComponentId('sPvI6Jr');
    $componentTag = $_instance->getRenderedChildComponentTagName('sPvI6Jr');
    $dom = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('sPvI6Jr');
} else {
    $response = \Livewire\Livewire::mount('change-password', []);
    $dom = $response->dom;
    $_instance->logRenderedChild('sPvI6Jr', $response->id, \Livewire\Livewire::getRootElementTagName($dom));
}
echo $dom;
?>
    </div>
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 1.0.0
        </div>
        <strong>Copyright &copy; 2021 <a href="https://isosystemss.com" target="_blank">ISOSYSTEMS</a>.</strong> All rights
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

        </div>
    </aside>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('dashboard.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\coopmanager\resources\views/dashboard/withdrawals/withdrawalTransactions.blade.php ENDPATH**/ ?>