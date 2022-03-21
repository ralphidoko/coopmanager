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
                                <h3 class="box-title">Yearly Declared Dividends</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body table-responsive">
                                <table id="example-2" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>View Beneficiaries</th>
                                        <th>Financial Year</th>
                                        <th>Proposed Dividends on Savings(<del style="text-decoration-style: double">N</del>)</th>
                                        <th>Proposed Loan Patronage Dividends(<del style="text-decoration-style: double">N</del>)</th>
                                        <th>Proposed Total Dividends(<del style="text-decoration-style: double">N</del>)</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $__currentLoopData = $declaredDividends; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $declaredDividend): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr data-toggle="collapse" data-target="#<?php echo e($declaredDividend->financialYear); ?>" class="accordion-toggle">
                                                <td><button class="btn btn-default btn-xs"><span class="glyphicon glyphicon-eye-open"></span></button></td>
                                                <td><?php echo e($declaredDividend->financialYear); ?></td>
                                                <td><?php echo e(number_format($declaredDividend->proposed_main_dividend,2)); ?></td>
                                                <td><?php echo e(number_format($declaredDividend->proposed_lpd,2)); ?></td>
                                                <td><?php echo e(number_format($declaredDividend->proposed_dividend,2)); ?></td>
                                            </tr>
                                            <tr>
                                                <?php
                                                    $dividendsEarned = \App\Dividend::where('financial_year','LIKE','%'.$declaredDividend->financialYear.'%')->get();
                                                ?>
                                                <td colspan="12" class="hiddenRow">
                                                    <div class="accordian-body collapse install_table" id="<?php echo e($declaredDividend->financialYear); ?>">
                                                           <table class="table table-striped example-1">
                                                            <thead>
                                                            <tr>
                                                                <th>Member's Name</th>
                                                                <th>Earned Dividends on Savings(<del style="text-decoration-style: double">N</del>)</th>
                                                                <th>Earned Loan Patronage Dividends(<del style="text-decoration-style: double">N</del>)</th>
                                                                <th>Total Dividends Earned (<del style="text-decoration-style: double">N</del>)</th>
                                                                <th>Financial Year</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php $__currentLoopData = $dividendsEarned; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dividendEarned): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <tr data-toggle="collapse"  class="accordion-toggle" data-target="#demo10">
                                                                    <td><?php echo e($dividendEarned->users->name); ?></td>
                                                                    <td><?php echo e(number_format($dividendEarned->dividend,2)); ?></td>
                                                                    <td><?php echo e(number_format($dividendEarned->loan_patronage_dividend,2)); ?></td>
                                                                    <td><?php echo e(number_format($dividendEarned->total_dividends,2)); ?></td>
                                                                    <td><?php echo e($dividendEarned->financial_year); ?></td>
                                                                </tr>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </td>
                                            </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                                <div class="pagination">
                                    
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
                        'lengthChange': false,
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
} elseif ($_instance->childHasBeenRendered('t4zDF2h')) {
    $componentId = $_instance->getRenderedChildComponentId('t4zDF2h');
    $componentTag = $_instance->getRenderedChildComponentTagName('t4zDF2h');
    $dom = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('t4zDF2h');
} else {
    $response = \Livewire\Livewire::mount('change-password', []);
    $dom = $response->dom;
    $_instance->logRenderedChild('t4zDF2h', $response->id, \Livewire\Livewire::getRootElementTagName($dom));
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

<?php echo $__env->make('dashboard.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\coopmanager\resources\views/dashboard/admin/accounting/dividendsList.blade.php ENDPATH**/ ?>