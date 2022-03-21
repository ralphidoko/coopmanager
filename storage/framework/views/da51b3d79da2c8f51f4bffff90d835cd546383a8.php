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
} elseif ($_instance->childHasBeenRendered('7mu4ax4')) {
    $componentId = $_instance->getRenderedChildComponentId('7mu4ax4');
    $componentTag = $_instance->getRenderedChildComponentTagName('7mu4ax4');
    $dom = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('7mu4ax4');
} else {
    $response = \Livewire\Livewire::mount('allow-admin', []);
    $dom = $response->dom;
    $_instance->logRenderedChild('7mu4ax4', $response->id, \Livewire\Livewire::getRootElementTagName($dom));
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
                        <div class="box box-danger">
                            <div class="box-header">
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                </div>
                                <h3 class="box-title">List View of all Authorization</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="table-responsive" style="padding: 10px;">
                                <table id="" class="table table-bordered table-striped example1">
                                    <thead>
                                    <tr>
                                        <th>Authorization Type</th>
                                        <th>Previous Amount(<del style="text-decoration-style: double">N</del>)</th>
                                        <th>Newly Authorized Amount(<del style="text-decoration-style: double">N</del>)</th>
                                        <th>Authorization State</th>
                                        <th>Submission Date</th>
                                        <th>Start Date</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <?php $__currentLoopData = $auth_lists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $auth_list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($auth_list->auth_text); ?></td>
                                            <td><?php echo e(number_format($auth_list->current_amount,2)); ?></td>
                                            <td><?php echo e(number_format($auth_list->desired_amount,2)); ?></td>
                                            <?php if($auth_list->status=='Awaiting Approval'): ?>
                                                <td><span class="label label-warning"><?php echo e($auth_list->status); ?></span></td>
                                            <?php endif; ?>
                                            <?php if($auth_list->status=='Approved'): ?>
                                                <td><span class="label label-success"><?php echo e($auth_list->status); ?></span></td>
                                            <?php endif; ?>
                                            <?php if($auth_list->status=='Rejected'): ?>
                                                <td><span class="label label-danger"><?php echo e($auth_list->status); ?></span></td>
                                            <?php endif; ?>
                                            <td><?php echo e(date('d-M-Y',strtotime($auth_list->created_at))); ?></td>
                                            <td><?php echo e(date('d-M-Y',strtotime($auth_list->start_date))); ?></td>
                                            <td>
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                                        <span class="fa fa-caret-down"></span></button>
                                                    <ul class="dropdown-menu">
                                                        <?php if($auth_list->status == 'Awaiting Approval'): ?>
                                                            <li><a href="/savings/<?php echo e($auth_list->id); ?>/updateAuthorization/">Edit Authorization</a></li>
                                                        <?php endif; ?>
                                                        <?php if($auth_list->status == 'Awaiting Approval'): ?>
                                                            <li>
                                                                <a  style="cursor: pointer;" onclick="deleteAuthorization('<?php echo e($auth_list->id); ?>','<?php echo e($auth_list->auth_type); ?>')" >Delete Authorization </a>
                                                            </li>
                                                        <?php endif; ?>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </table>
                                <script>
                                    function deleteAuthorization(id,auth_type) {
                                        var sure = confirm('Are you sure? This action cannot be reversed');
                                        if(sure ===false){
                                            return false;
                                        }else {
                                            data = {
                                                loan_id: id,auth_type: auth_type,_token: "<?php echo e(csrf_token()); ?>"
                                            }
                                            $.ajax({
                                                dataType: 'json',
                                                type: "DELETE",
                                                url: '<?php echo e(URL::to('/deleteAuthorization')); ?>',
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
                        <div class="box box-primary" >
                            <div class="box-header">
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                </div>
                                <h3 class="box-title">Authority to Deduct Pay</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body table-responsive">
                                <table id="" class="table table-bordered table-striped example1">
                                    <thead>
                                    <tr>
                                        <th>Authorization Type</th>
                                        <th>Authorized Amount(<del style="text-decoration-style: double">N</del>)</th>
                                        <th>Authorization State</th>
                                        <th>Submission Date</th>
                                        <th>Start Date</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <?php $__currentLoopData = $deductions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deduction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>Deduct Pay</td>
                                            <td><?php echo e(number_format($deduction->authorized_amount,2)); ?></td>
                                            <?php if($deduction->status=='Awaiting Approval'): ?>
                                                <td><span class="label label-warning"><?php echo e($deduction->status); ?></span></td>
                                            <?php endif; ?>
                                            <?php if($deduction->status=='Approved'): ?>
                                                <td><span class="label label-success"><?php echo e($deduction->status); ?></span></td>
                                            <?php endif; ?>
                                            <td><?php echo e(date('d-M-Y',strtotime($deduction->created_at))); ?></td>
                                            <td><?php echo e(date('d-M-Y',strtotime($deduction->start_date))); ?></td>
                                            <td>
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                                        <span class="fa fa-caret-down"></span></button>
                                                    <ul class="dropdown-menu">
                                                        <?php if($deduction->status == 'Awaiting Approval'): ?>
                                                            <li>
                                                                <a  style="cursor: pointer;" onclick="deleteAuthorityToPay('<?php echo e($deduction->id); ?>')" >Delete Authorization </a>
                                                            </li>
                                                        <?php endif; ?>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </table>
                                <script>
                                    function deleteAuthorityToPay(id) {
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
                                                url: '<?php echo e(URL::to('/deleteAuthorityDeductToPay')); ?>',
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
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </section>
            <!-- /.content -->

            <!-- /.content-wrapper -->
            <script>
                $(function () {
                    $('.example1').DataTable()
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
} elseif ($_instance->childHasBeenRendered('naofQ1M')) {
    $componentId = $_instance->getRenderedChildComponentId('naofQ1M');
    $componentTag = $_instance->getRenderedChildComponentTagName('naofQ1M');
    $dom = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('naofQ1M');
} else {
    $response = \Livewire\Livewire::mount('change-password', []);
    $dom = $response->dom;
    $_instance->logRenderedChild('naofQ1M', $response->id, \Livewire\Livewire::getRootElementTagName($dom));
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



<?php echo $__env->make('dashboard.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\coopmanager\resources\views/dashboard/savings/showSavingAuthorizationList.blade.php ENDPATH**/ ?>