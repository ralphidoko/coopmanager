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
        
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box box-danger" style="padding: 10px ! important;">
                            <div class="box-header">
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                </div>
                                <h3 class="box-title">Membership Applications</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        
                                        <th>Member's Name</th>
                                        <th>Membership No</th>
                                        <th>Department</th>
                                        <th>Designation</th>
                                        <th>Guarantor One</th>
                                        <th>Guarantor Two</th>
                                        <th>Application State</th>
                                        <th>Submission Date</th>
                                        <th>Membership Status</th>
                                    </tr>
                                    </thead>
                                    <?php $counter = 1;?>
                                    <?php $__currentLoopData = $userDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $userDetail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($userDetail->first_name != 'Administrator'): ?>
                                            <tr data-href="<?php echo e(url('/dashboard/admin/membershipApproval/'.$userDetail->id)); ?>" style="cursor: pointer">
                                                
                                                <td><?php echo e($userDetail->first_name.' '.$userDetail->middle_name.' '.$userDetail->last_name); ?></td>
                                                <td><?php echo e($userDetail->member_id); ?></td>
                                                <td><?php echo e(strtoupper($userDetail->department)); ?></td>
                                                <td><?php echo e(strtoupper($userDetail->designation)); ?></td>
                                                <td><?php echo e(strtoupper($userDetail->referee_one)); ?></td>
                                                <td><?php echo e(strtoupper($userDetail->referee_two)); ?></td>
                                                <th>
                                                    <?php if($userDetail->approval_status === 'Processing'): ?>
                                                        <span class="label label-warning"><?php echo e($userDetail->approval_status); ?></span>
                                                    <?php elseif($userDetail->approval_status === 'Approved'): ?>
                                                        <span class="label label-success"><?php echo e($userDetail->approval_status); ?></span>
                                                    <?php else: ?>
                                                        <span class="label label-danger"><?php echo e($userDetail->approval_status); ?></span>
                                                    <?php endif; ?>
                                                </th>
                                                <td><?php echo e($userDetail->created_at); ?></td>
                                                <td>
                                                    <?php if($userDetail->membership_status === 'Active'): ?>
                                                        <span class="label label-success"><?php echo e($userDetail->membership_status); ?></span>
                                                    <?php elseif($userDetail->membership_status === 'Archived'): ?>
                                                        <span class="label label-danger"><?php echo e($userDetail->membership_status); ?></span>
                                                    <?php endif; ?>
                                                </td>
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
        <?php
if (! isset($_instance)) {
    $dom = \Livewire\Livewire::mount('change-password', [])->dom;
} elseif ($_instance->childHasBeenRendered('80Pc3Xt')) {
    $componentId = $_instance->getRenderedChildComponentId('80Pc3Xt');
    $componentTag = $_instance->getRenderedChildComponentTagName('80Pc3Xt');
    $dom = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('80Pc3Xt');
} else {
    $response = \Livewire\Livewire::mount('change-password', []);
    $dom = $response->dom;
    $_instance->logRenderedChild('80Pc3Xt', $response->id, \Livewire\Livewire::getRootElementTagName($dom));
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
            <!-- /.tab-pane -->

            <!-- /.tab-pane -->
        </div>
    </aside>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('dashboard.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\coopmanager\resources\views/dashboard/admin/membershipApplication.blade.php ENDPATH**/ ?>