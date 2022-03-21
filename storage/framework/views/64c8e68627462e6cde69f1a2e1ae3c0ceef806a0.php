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

<?php $__env->startSection('main-content'); ?>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <?php
if (! isset($_instance)) {
    $dom = \Livewire\Livewire::mount('update-user-profile', [])->dom;
} elseif ($_instance->childHasBeenRendered('CQ4780b')) {
    $componentId = $_instance->getRenderedChildComponentId('CQ4780b');
    $componentTag = $_instance->getRenderedChildComponentTagName('CQ4780b');
    $dom = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('CQ4780b');
} else {
    $response = \Livewire\Livewire::mount('update-user-profile', []);
    $dom = $response->dom;
    $_instance->logRenderedChild('CQ4780b', $response->id, \Livewire\Livewire::getRootElementTagName($dom));
}
echo $dom;
?>
        <?php
if (! isset($_instance)) {
    $dom = \Livewire\Livewire::mount('change-password', [])->dom;
} elseif ($_instance->childHasBeenRendered('88Ty1eu')) {
    $componentId = $_instance->getRenderedChildComponentId('88Ty1eu');
    $componentTag = $_instance->getRenderedChildComponentTagName('88Ty1eu');
    $dom = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('88Ty1eu');
} else {
    $response = \Livewire\Livewire::mount('change-password', []);
    $dom = $response->dom;
    $_instance->logRenderedChild('88Ty1eu', $response->id, \Livewire\Livewire::getRootElementTagName($dom));
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


<?php echo $__env->make('dashboard.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\coopmanager\resources\views/dashboard/updateUserProfile.blade.php ENDPATH**/ ?>