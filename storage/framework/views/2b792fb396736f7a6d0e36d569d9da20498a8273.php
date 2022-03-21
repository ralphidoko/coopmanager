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
        <section class="content" >
        
        <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="alert alert-info alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h4><i class="icon fa fa-warning"></i> Warning!</h4>
                            <h3>Actions performed on this page are irreversible. Ensure you are properly AUTHORIZED!</h3>
                        </div>
                        <div class="box box-danger"  style="margin-top: 10px">
                            <div class="box-header">
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                </div>
                                <h3 class="box-title">Dividends Declaration & Statutory Transfers</h3>
                                <hr>
                            </div>
                            <div class="box-body">
                                <h4><?php echo $__env->make('flashMessages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></h4>
                                <form id="declareDividend" action="<?php echo e(url('dashboard/admin/accounting/declareDividends')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                   <button type="submit" class="button-78">Declare Dividends & Post Appropriations</button>
                                    <br /><br /><br />
                                    <label for="backward">Is Late Declaration &#160;&#160;</label><input type="checkbox" name="previous_year" id="backward">
                                </form>
                                    <script>
                                        $(document).ready(function() {
                                            $("#declareDividend").submit(function() {
                                               if(confirm('This action cannot be reversed. Are you sure?')){
                                                    $('.button-78').html('Action in Progress....Please wait <i class="fa fa-circle-o-notch fa-spin"></i>'
                                                    ).prop("disabled", true);
                                                }else{
                                                   return false;
                                               }
                                            });
                                        });
                                        jQuery('#backward').change(function() {
                                            if ($(this).prop('checked')) {
                                                alert("You are about to declare dividends and post appropriations in retrospect. This action will irreversibly declare dividends and appropriations for the previous Financial Year. Continue?"); //checked
                                            }
                                            else {
                                                alert("Action will be discontinued."); //not checked
                                            }
                                        });
                                    </script>
                            </div>
                            <!-- /.box-body -->
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </section>
            <style>
                /* CSS */
                .button-78 {
                    align-items: center;
                    appearance: none;
                    background-color: initial;
                    background-image: none;
                    border-style: none ! important;
                    color: #fff;
                    display: inline-block;
                    flex-direction: row;
                    flex-shrink: 0;
                    font-family: Eina01,sans-serif;
                    font-size: 25px ! important;
                    font-weight: bold;
                    justify-content: center;
                    margin: 0;
                    min-height: 64px;
                    outline: none ! important;
                    padding: 19px 26px;
                    position: relative;
                    text-align: center;
                    text-decoration: none;
                    text-transform: none;
                    user-select: none;
                    -webkit-user-select: none;
                    vertical-align: middle;
                    width: auto;
                    z-index: 0;
                }

                @media (min-width: 768px) {
                    .button-78 {
                        padding: 19px 32px;
                    }
                }

                .button-78:before,
                .button-78:after {
                    border-radius: 80px;
                }

                .button-78:before {
                    background-image: linear-gradient(92.83deg, #ff7426 0, #f93a13 100%);
                    content: "";
                    height: 100%;
                    left: 0;
                    overflow: hidden;
                    position: absolute;
                    top: 0;
                    width: 100%;
                    z-index: -2;
                }

                .button-78:after {
                    background-color: initial;
                    background-image: linear-gradient(#541a0f 0, #0c0d0d 100%);
                    bottom: 4px;
                    content: "";
                    left: 4px;
                    overflow: hidden;
                    position: absolute;
                    right: 4px;
                    top: 4px;
                    transition: all 100ms ease-out;
                    z-index: -1;
                }

                .button-78:hover:not(:disabled):before {
                    background: linear-gradient(92.83deg, rgb(60,141,188) 0%, rgb(139,0,0) 100%);
                }

                .button-78:hover:not(:disabled):after {
                    bottom: 0;
                    left: 0;
                    right: 0;
                    top: 0;
                    transition-timing-function: ease-in;
                    opacity: 0;
                }

                .button-78:active:not(:disabled) {
                    color: #ccc;
                }
            </style>
        </section>

        <?php
if (! isset($_instance)) {
    $dom = \Livewire\Livewire::mount('change-password', [])->dom;
} elseif ($_instance->childHasBeenRendered('8zWa4kN')) {
    $componentId = $_instance->getRenderedChildComponentId('8zWa4kN');
    $componentTag = $_instance->getRenderedChildComponentTagName('8zWa4kN');
    $dom = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('8zWa4kN');
} else {
    $response = \Livewire\Livewire::mount('change-password', []);
    $dom = $response->dom;
    $_instance->logRenderedChild('8zWa4kN', $response->id, \Livewire\Livewire::getRootElementTagName($dom));
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

<?php echo $__env->make('dashboard.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\coopmanager\resources\views/dashboard/admin/accounting/declareDividends.blade.php ENDPATH**/ ?>