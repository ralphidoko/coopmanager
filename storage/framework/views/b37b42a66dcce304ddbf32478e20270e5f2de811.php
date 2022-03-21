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
<?php echo $__env->make('dashboard.navigation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->startSection('main-content'); ?>
    <div class="content-wrapper">
            
            <br />
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box box-danger">
                            <div class="box-header with-border">
                                <h3 class="box-title">Import Models</h3>
                            </div>
                            <!-- form start -->
                            <form id="uploadFile" role="form" style="margin-top: 20px;" method="POST" action="/easyImportModels" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <div class="box-body">
                                    <?php echo $__env->make('flashMessages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    <?php if(isset($errors) && $errors->any()): ?>
                                        <div class="alert alert-danger" style="font-size:15px ! important">
                                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php echo e($error); ?>

                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="form-group">
                                        <label for="exampleInputFile">Model Types</label>
                                        <select name="model_type" class="form-control select2" style="width:50%;" required>
                                            <option value="">--Select models--</option>
                                            <option value="users">Users</option>
                                            <option value="user_details">Users Details</option>
                                            <option value="loan">Loans</option>
                                            <option value="instalments">Instalment</option>
                                            <option value="account_statement">Account Statement</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputFile">Select File to Upload</label>
                                        <input type="file" name="model_file" id="exampleInputFile" required>
                                    </div>
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-primary">Proceed With Import</button>
                                </div>
                            </form>
                            <script>
                                $(document).ready(function() {
                                    $("#uploadFile").submit(function() {
                                        $('.btn').html('Importing data....please wait &#160;<i class="fa fa-circle-o-notch fa-spin"></i>'
                                        ).addClass('disabled');
                                    });
                                });
                            </script>
                        </div>
                        <!-- /.box -->
                    </div>
                    <!-- /.col -->
                </div>
        </section>
        <?php
if (! isset($_instance)) {
    $dom = \Livewire\Livewire::mount('change-password', [])->dom;
} elseif ($_instance->childHasBeenRendered('QUa378c')) {
    $componentId = $_instance->getRenderedChildComponentId('QUa378c');
    $componentTag = $_instance->getRenderedChildComponentTagName('QUa378c');
    $dom = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('QUa378c');
} else {
    $response = \Livewire\Livewire::mount('change-password', []);
    $dom = $response->dom;
    $_instance->logRenderedChild('QUa378c', $response->id, \Livewire\Livewire::getRootElementTagName($dom));
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



            </div>
        </div>
    </aside>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('dashboard.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\coopmanager\resources\views/dashboard/admin/settings/importModels.blade.php ENDPATH**/ ?>