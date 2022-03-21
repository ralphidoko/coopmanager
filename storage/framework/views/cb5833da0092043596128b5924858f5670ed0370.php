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
} elseif ($_instance->childHasBeenRendered('zzBdcq6')) {
    $componentId = $_instance->getRenderedChildComponentId('zzBdcq6');
    $componentTag = $_instance->getRenderedChildComponentTagName('zzBdcq6');
    $dom = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('zzBdcq6');
} else {
    $response = \Livewire\Livewire::mount('allow-admin', []);
    $dom = $response->dom;
    $_instance->logRenderedChild('zzBdcq6', $response->id, \Livewire\Livewire::getRootElementTagName($dom));
}
echo $dom;
?>

<?php $__env->startSection('main-content'); ?>
    <div class="content-wrapper">
        <section class="content">
           
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-xs-12">

                        <div class="box box-danger" style="padding: 10px;">
                            <div class="box-header">
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                </div>
                                <h3 class="box-title">List View of all Loan</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>Loan Type</th>
                                        <th>Loan Amount(<del style="text-decoration-style: double">N</del>)</th>
                                        <th>Total Payable(<del style="text-decoration-style: double">N</del>)</th>
                                        <th>Monthly Interest Payable(<del style="text-decoration-style: double">N</del>)</th>
                                        <th>Total Interest Payable(<del style="text-decoration-style: double">N</del>)</th>

                                        <th>Loan State</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <?php $__currentLoopData = $loans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($loan->loan_type); ?></td>
                                            <td><?php echo e(number_format($loan->loan_amount,2)); ?></td>
                                            <td><?php echo e(number_format($loan->total_amount_payable,2)); ?></td>
                                            <td><?php echo e(number_format($loan->monthly_interest_payable,2)); ?></td>
                                            <td><?php echo e(number_format($loan->total_interest_payable,2)); ?></td>

                                            <?php if($loan->status=='Processing'): ?>
                                                <td><span class="label label-warning"><?php echo e($loan->status); ?></span></td>
                                            <?php endif; ?>
                                            <?php if($loan->status=='Approved'): ?>
                                                <td><span class="label label-success"><?php echo e($loan->status); ?></span></td>
                                            <?php endif; ?>
                                            <?php if($loan->status=='Settled'): ?>
                                                <td><span class="label label-success"><?php echo e($loan->status); ?></span></td>
                                            <?php endif; ?>
                                            <?php if($loan->status=='Rejected'): ?>
                                                <td><span class="label label-danger"><?php echo e($loan->status); ?></span></td>
                                            <?php endif; ?>
                                            <td>
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                                        <span class="fa fa-caret-down"></span></button>
                                                    <ul class="dropdown-menu">
                                                        <li data-href="<?php echo e(url('/application/loanDetails/'.$loan->id)); ?>" style="cursor:pointer">View Loan</li>
                                                        <?php if($loan->status == 'Processing'): ?>
                                                            <li data-href="<?php echo e(url('/application/'.$loan->id.'/updateLoan/')); ?>" style="cursor:pointer">Edit Loan</li>
                                                        <?php endif; ?>
                                                        <?php if($loan->status == 'Processing'): ?>
                                                            <li onclick="deleteLoan(this.id)" id="<?php echo e($loan->id); ?>" style="cursor: pointer;">Delete Application</li>
                                                        <?php endif; ?>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </table>
                                <script>
                                    function deleteLoan(id) {
                                        var sure = confirm('Are you sure? This action cannot be reversed');
                                        if(sure ==false){
                                            return false;
                                        }else {
                                            data = {
                                                loan_id: id, _token: "<?php echo e(csrf_token()); ?>"
                                            }
                                            $.ajax({
                                                dataType: 'json',
                                                type: "DELETE",
                                                url: '<?php echo e(URL::to('/deleteApplication')); ?>',
                                                data: data,
                                                success: function (response) {
                                                    //location.reload();
                                                    window.location=response.url;
                                                }
                                            });
                                        }
                                    }
                                </script>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </section>
            <!-- /.content -->

            <script>
                document.addEventListener("DOMContentLoaded", () =>{
                    const rows = document.querySelectorAll("li[data-href]");
                    rows.forEach(row => {
                        row.addEventListener("click", () => {
                            window.location.href = row.dataset.href;
                        });
                    });
                });
                $(function () {
                    $('#example1').DataTable()
                    $('#example2').DataTable({
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
} elseif ($_instance->childHasBeenRendered('SmYAAVl')) {
    $componentId = $_instance->getRenderedChildComponentId('SmYAAVl');
    $componentTag = $_instance->getRenderedChildComponentTagName('SmYAAVl');
    $dom = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('SmYAAVl');
} else {
    $response = \Livewire\Livewire::mount('change-password', []);
    $dom = $response->dom;
    $_instance->logRenderedChild('SmYAAVl', $response->id, \Livewire\Livewire::getRootElementTagName($dom));
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
        </div>
    </aside>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('dashboard.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\coopmanager\resources\views/dashboard/application/loanList.blade.php ENDPATH**/ ?>