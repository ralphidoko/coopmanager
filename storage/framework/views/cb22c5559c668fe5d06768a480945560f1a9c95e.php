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

<?php echo $__env->make('dashboard.admin.adminLinks', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->startSection('main-content'); ?>
    <div class="content-wrapper">
        <section class="content" xmlns:wire="http://www.w3.org/1999/xhtml" xmlns:nwire="http://www.w3.org/1999/xhtml">
       
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-xs-12">

                        <div class="box box-danger" >
                            <div class="box-header">
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                </div>
                                <h3 class="box-title">List View of all Loan</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="table-responsive" style="margin: 10px">
                                     <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>Applicant</th>
                                        <th>Loan Type</th>
                                        <th>Loan Amount(<del style="text-decoration-style: double">N</del>)</th>
                                        <th>Total Payable(<del style="text-decoration-style: double">N</del>)</th>
                                        <th>Monthly Amount Payable(<del style="text-decoration-style: double">N</del>)</th>
                                        <th>Total Interest Payable(<del style="text-decoration-style: double">N</del>)</th>


                                        <th>Loan State</th>
                                    </tr>
                                    </thead>
                                    <a href="">
                                    <?php $__currentLoopData = $loans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($loan->users->name != 'Administrator'): ?>
                                            <tr data-href="<?php echo e(url('/dashboard/admin/adminLoanApproval/'.$loan->id)); ?>" style="cursor: pointer">
                                           <td><?php echo e($loan->users->name); ?></td>
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
                                        </tr>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </table>
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
                    const rows = document.querySelectorAll("tr[data-href]");
                    rows.forEach(row => {
                        row.addEventListener("click", () => {
                            window.location.href = row.dataset.href;
                        });
                    });
                });
                $(function () {
                    // $('#example2').DataTable()
                    $('#example1').DataTable({
                        'paging'      : true,
                        'lengthChange': false,
                        'searching'   : true,
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
} elseif ($_instance->childHasBeenRendered('JlXglj8')) {
    $componentId = $_instance->getRenderedChildComponentId('JlXglj8');
    $componentTag = $_instance->getRenderedChildComponentTagName('JlXglj8');
    $dom = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('JlXglj8');
} else {
    $response = \Livewire\Livewire::mount('change-password', []);
    $dom = $response->dom;
    $_instance->logRenderedChild('JlXglj8', $response->id, \Livewire\Livewire::getRootElementTagName($dom));
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


            </div>
        </div>
    </aside>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('dashboard.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\coopmanager\resources\views/dashboard/admin/loanApplicationList.blade.php ENDPATH**/ ?>