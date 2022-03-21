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
} elseif ($_instance->childHasBeenRendered('7Kzx1By')) {
    $componentId = $_instance->getRenderedChildComponentId('7Kzx1By');
    $componentTag = $_instance->getRenderedChildComponentTagName('7Kzx1By');
    $dom = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('7Kzx1By');
} else {
    $response = \Livewire\Livewire::mount('allow-admin', []);
    $dom = $response->dom;
    $_instance->logRenderedChild('7Kzx1By', $response->id, \Livewire\Livewire::getRootElementTagName($dom));
}
echo $dom;
?>
<?php $__env->startSection('main-content'); ?>
    <div class="content-wrapper">
        <section class="content">
       
            <br />
            <!-- Main content -->
            <section class="content">
                <div class="col-md-10 col-lg-10" style="margin-top: 10px;">
                    <div class="box box-info col-md-10 col-lg-10">
                        <div class="box-header with-border">
                            <h3 class="box-title">Report Filter</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="modal-body">
                                <form method="POST" action="<?php echo e(url('/filterAccountStatement')); ?>" enctype="">
                                    <?php echo csrf_field(); ?>
                                    <div style="display: inline-flex;" class="col-lg-11 col-md-10">
                                        
                                        <div class="form-group col-md-12 col-lg-12">
                                            <label>Report Date Range:</label>
                                            <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                                <i class="fa fa-calendar"></i>&nbsp;
                                                <input name="date_range" value="" required style="border-style: none"><i class="fa fa-caret-down"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="display: inline-flex;" class="col-lg-12 col-md-10" id="parent">
                                        <div class="form-group col-lg-12 col-md-10 col-xs-7" id="child">
                                            <label>Select type of Report</label>
                                            <select id="report_type" name="report_type" class="form-control" required>
                                                <option value="">Select report type</option>
                                                <option value="account_statement">Account Statement</option>
                                                <option value="loan_statement">Loan Statement</option>
                                                <option value="consolidated_earning">Dividends Earned</option>
                                                <option value="trans_statement">Statement of Transaction</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-10 col-lg-10" id="child">
                                            <label>Report Action</label>
                                            <div class="input-group">
                                                <button type="submit" name="pdf" value="pdf" class="btn btn-primary pull-right" style="margin-right: 5px;">
                                                    <i class="fa fa-file-pdf-o"></i> Generate PDF</button>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-10 col-lg-10" id="child">
                                            <label>Report Action</label>
                                            <div class="input-group">
                                                <button type="submit" name="excel" value="excel" class="btn btn-success pull-right"><i class="fa fa-file-excel-o"></i> Export to Excel</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </section>
            <!-- /.content -->
            <!-- /.content-wrapper -->
        </section>
        <?php
if (! isset($_instance)) {
    $dom = \Livewire\Livewire::mount('change-password', [])->dom;
} elseif ($_instance->childHasBeenRendered('GF8sJFI')) {
    $componentId = $_instance->getRenderedChildComponentId('GF8sJFI');
    $componentTag = $_instance->getRenderedChildComponentTagName('GF8sJFI');
    $dom = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('GF8sJFI');
} else {
    $response = \Livewire\Livewire::mount('change-password', []);
    $dom = $response->dom;
    $_instance->logRenderedChild('GF8sJFI', $response->id, \Livewire\Livewire::getRootElementTagName($dom));
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
            <?php echo Toastr::message(); ?>

                <!-- /.control-sidebar-menu -->
                <!-- /.control-sidebar-menu -->
            </div>
        </div>
    </aside>

    <script type="text/javascript">
        $(function() {

            var start = moment().subtract(29, 'days');
            var end = moment();

            function cb(start, end) {
                $('#reportrange input').val(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
            }

            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, cb);

            cb(start, end);

        });
    </script>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('dashboard.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\coopmanager\resources\views/dashboard/reports/user/userReportTemplate.blade.php ENDPATH**/ ?>