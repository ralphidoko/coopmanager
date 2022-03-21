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
        <section class="content" xmlns:wire="http://www.w3.org/1999/xhtml" xmlns:nwire="http://www.w3.org/1999/xhtml">
        
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
                                <h3 class="box-title">Current Loans With Installments</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body table-responsive">
                                <div class="" align="left">
                                    <button type="submit" id="approve_auth" data-token="<?php echo e(csrf_token()); ?>" class="btn btn-primary">Settle Installment(s)</button>
                                </div>
                                <table id="example-2" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Installment View</th>
                                            <th>Applicant</th>
                                            <th>Loan Type</th>
                                            <th>Loan Amount(<del style="text-decoration-style: double">N</del>)</th>
                                            <th>Total Payable(<del style="text-decoration-style: double">N</del>)</th>
                                            <th>Total Amount Recovered(<del style="text-decoration-style: double">N</del>)</th>
                                            <th>Monthly Amount Payable(<del style="text-decoration-style: double">N</del>)</th>
                                            <th>Total Interest Payable(<del style="text-decoration-style: double">N</del>)</th>
                                            <th>Interest/Income Realized(<del style="text-decoration-style: double">N</del>)</th>
                                            <th>Loan State</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $loans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr data-toggle="collapse" data-target="#<?php echo e($loan->id); ?>" class="accordion-toggle">
                                                <td><button class="btn btn-default btn-xs"><span class="glyphicon glyphicon-eye-open"></span></button></td>
                                                <td><?php echo e($loan->users->name); ?></td>
                                                <td><?php echo e($loan->loan_type); ?></td>
                                                <td><?php echo e(number_format($loan->loan_amount,2)); ?></td>
                                                <td><?php echo e(number_format($loan->total_amount_payable,2)); ?></td>
                                                <td><?php echo e(number_format($loan->amount_recovered,2)); ?></td>
                                                <td><?php echo e(number_format($loan->monthly_interest_payable,2)); ?></td>
                                                <td><?php echo e(number_format($loan->total_interest_payable,2)); ?></td>
                                                <?php if($loan->incomes): ?>
                                                   <td><?php echo e(number_format(round($loan->incomes->income_realized),2)); ?></td>
                                                <?php else: ?>
                                                    <td>0.00</td>
                                                <?php endif; ?>
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
                                                <tr>
                                                    <td colspan="12" class="hiddenRow">
                                                        <?php $__currentLoopData = $loan->installments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $installment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <div class="accordian-body collapse install_table" id="<?php echo e($installment->loan_id); ?>">
                                                                <table class="table table-striped example-1">
                                                                    <thead>
                                                                    <tr>
                                                                        <th><input disabled type="checkbox" value="" id="checkAll" /></th>
                                                                        <th>Monthly Interest Payable(<del style="text-decoration-style: double">N</del>)</th>
                                                                        <th>Monthly Reducing Balance(<del style="text-decoration-style: double">N</del>)</th>
                                                                        <th>Payment Due Date</th>
                                                                        <th>Payment Status</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php $__currentLoopData = $loan->installments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $installment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <?php if($installment->status == 'Unpaid'): ?>
                                                                            <tr data-toggle="collapse"  class="accordion-toggle" data-target="#demo10">
                                                                                <td><input type="checkbox" id="instal_ids" name='deductPay' value="<?php echo e($installment->unique_id); ?>"></td>
                                                                                <td><del style="text-decoration-style: double">N</del><?php echo e(number_format($installment->monthly_installment,2)); ?></td>
                                                                                <td><del style="text-decoration-style: double">N</del><?php echo e(number_format($installment->current_balance,2)); ?></td>
                                                                                <td><?php echo e(date("d-M-Y",strtotime($installment->payment_date))); ?></td>
                                                                                <td><?php echo e($installment->status); ?></td>
                                                                            </tr>
                                                                            <?php else: ?>
                                                                                <tr data-toggle="collapse"  class="accordion-toggle" data-target="#demo10">
                                                                                    <td><input disabled type="checkbox" id="instal_ids" name='deductPay' value="<?php echo e($installment->unique_id); ?>"></td>
                                                                                    <td><del style="text-decoration-style: double">N</del><?php echo e(number_format($installment->monthly_installment,2)); ?></td>
                                                                                    <td><del style="text-decoration-style: double">N</del><?php echo e(number_format($installment->current_balance,2)); ?></td>
                                                                                    <td><?php echo e(date("d-M-Y",strtotime($installment->payment_date))); ?></td>
                                                                                    <td><?php echo e($installment->status); ?></td>
                                                                                </tr>
                                                                                <?php endif; ?>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </td>
                                                </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                                <div class="pagination">
                                    <?php echo e($loans->links()); ?>

                                </div>
                                <script>
                                    toastr.options = {
                                        "closeButton": true,
                                        "newestOnTop": true,
                                        "positionClass": "toast-top-right",
                                        "showDuration": "500",
                                    };

                                    $(document).ready(function() {

                                        $( "#approve_auth" ).on( "click", function(e) {
                                            e.preventDefault();
                                                var installmentsIDs = [];
                                                $(".install_table input:checkbox:checked").map(function(){
                                                    installmentsIDs.push($(this).val());
                                                });

                                            if(installmentsIDs.length === 0){
                                                alert('Select installment(s) to settle');
                                            }else{
                                                $('.preloader').show();
                                                data = {
                                                    _token: "<?php echo e(csrf_token()); ?>",
                                                    installmentsIDs: installmentsIDs,
                                                };
                                                $.ajax({
                                                    url: '<?php echo e(URL::to('/settleLoanInstallments')); ?>',
                                                    type: 'POST',
                                                    dataType: 'json',
                                                    data: data,
                                                    success: function (response) {
                                                        if(response.success === true){
                                                            $('.preloader').hide();
                                                            setTimeout(function(){// wait for 5 secs(2)
                                                                location.reload(); // then reload the page.(3)
                                                            }, 1500);
                                                            toastr.success(response.message);
                                                        }else{
                                                            $('.preloader').hide();
                                                            //window.location=response.url;
                                                        }

                                                    },
                                                });
                                            }
                                        });
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
} elseif ($_instance->childHasBeenRendered('jTbL5CJ')) {
    $componentId = $_instance->getRenderedChildComponentId('jTbL5CJ');
    $componentTag = $_instance->getRenderedChildComponentTagName('jTbL5CJ');
    $dom = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('jTbL5CJ');
} else {
    $response = \Livewire\Livewire::mount('change-password', []);
    $dom = $response->dom;
    $_instance->logRenderedChild('jTbL5CJ', $response->id, \Livewire\Livewire::getRootElementTagName($dom));
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



<?php echo $__env->make('dashboard.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\coopmanager\resources\views/dashboard/admin/loanInstallmentsPayment.blade.php ENDPATH**/ ?>