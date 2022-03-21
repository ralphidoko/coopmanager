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
        <?php
if (! isset($_instance)) {
    $dom = \Livewire\Livewire::mount('loan-application', [])->dom;
} elseif ($_instance->childHasBeenRendered('ZgRvfsd')) {
    $componentId = $_instance->getRenderedChildComponentId('ZgRvfsd');
    $componentTag = $_instance->getRenderedChildComponentTagName('ZgRvfsd');
    $dom = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('ZgRvfsd');
} else {
    $response = \Livewire\Livewire::mount('loan-application', []);
    $dom = $response->dom;
    $_instance->logRenderedChild('ZgRvfsd', $response->id, \Livewire\Livewire::getRootElementTagName($dom));
}
echo $dom;
?>
        <?php
if (! isset($_instance)) {
    $dom = \Livewire\Livewire::mount('change-password', [])->dom;
} elseif ($_instance->childHasBeenRendered('MIvXRwy')) {
    $componentId = $_instance->getRenderedChildComponentId('MIvXRwy');
    $componentTag = $_instance->getRenderedChildComponentTagName('MIvXRwy');
    $dom = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('MIvXRwy');
} else {
    $response = \Livewire\Livewire::mount('change-password', []);
    $dom = $response->dom;
    $_instance->logRenderedChild('MIvXRwy', $response->id, \Livewire\Livewire::getRootElementTagName($dom));
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



<?php echo $__env->make('dashboard.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\coopmanager\resources\views/dashboard/application/loanApplication.blade.php ENDPATH**/ ?>