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
} elseif ($_instance->childHasBeenRendered('oQFtKlc')) {
    $componentId = $_instance->getRenderedChildComponentId('oQFtKlc');
    $componentTag = $_instance->getRenderedChildComponentTagName('oQFtKlc');
    $dom = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('oQFtKlc');
} else {
    $response = \Livewire\Livewire::mount('allow-admin', []);
    $dom = $response->dom;
    $_instance->logRenderedChild('oQFtKlc', $response->id, \Livewire\Livewire::getRootElementTagName($dom));
}
echo $dom;
?>
<?php $__env->startSection('main-content'); ?>
    <div class="content-wrapper">
        <section class="content">
            
            <br />
            <section class="content">
                <div class="row">
                    <div class="col-xs-12">

                        <div class="box box-danger" >
                            <div class="box-header" style="padding-bottom: 2px ! important;">
                                <?php if($loan->status == "Approved"): ?>
                                    <input type="hidden" value="<?php echo e($loan->id); ?>" id="loan_id">
                                <button style="font-weight: bold;font-size: 15px;" type="submit" id="offset_loan_bal" value="sec_approved" class="btn btn-primary">Offset Loan Balance</button>
                                <?php endif; ?>
                                    <?php if($loan->status == "Settled"): ?>
                                        
                                        <a href="<?php echo e(url('/dashboard/offSetLoanBalance/'.$loan->id)); ?>"><button style="font-weight: bold;font-size: 15px;" type="submit" id="offset_loan_bal" value="sec_approved" class="btn btn-primary">Offset Loan Balance</button></a>
                                    <?php endif; ?>
                                <div class="container-fluid pull-right" style=" display: inline-flex;">
                                    <ol class="breadcrumb breadcrumb-arrow" style="font-weight: bold;font-size: 15px;">
                                        <?php if($loan->sec_approve == "sec_approved" && $loan->chair_approve == "chair_approved"): ?>
                                            <li id="sa"><a hreff="#" style="color: green">Secretary Approved</a></li>
                                            <li id="ca" ><a hreff="#" style="color: green">Chairman Approved</a></li>
                                        <?php elseif($loan->sec_approve == "sec_approved"): ?>
                                            <li id="sa"><a hreff="#" style="color: green">Secretary Approved</a></li>
                                        <?php elseif($loan->chair_approve == "chair_approved"): ?>
                                            <li id="ca" ><a hreff="#" style="color: green">Chairman Approved</a></li>
                                        <?php elseif($loan->status == "Rejected"): ?>
                                            <li id="sa"><a hreff="#" style="color: darkred ! important;">Application Rejected</a></li>
                                        <?php elseif($loan->status == "Processing"): ?>
                                            <li class="sa" ><a hreff="#" style="background: #3C8DBC ! important;">Await Sec Approval</a></li>
                                            <li class="ca"><a hreff="#" style="background: #3C8DBC ! important;">Await Chair Approval</a></li>
                                        <?php endif; ?>
                                    </ol>
                                </div>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <!-- /.row -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="box">
                                            <div class="box-header with-border">
                                                <div class="box-tools pull-right">
                                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                                </div>
                                            </div>
                                            <div class="box-body">
                                                <style>
                                                    .loader{
                                                        position: absolute;
                                                        left: 70%;
                                                        top: 20%;
                                                        -webkit-transform: translate(-50%, -50%);
                                                        transform: translate(-50%, -50%);
                                                    }
                                                </style>
                                                    <div class="box-body table-responsive">
                                                        <table class="table table-bordered table-striped" style="border: 2px;">
                                                            <thead>
                                                            <tr style="font-size:18px;">
                                                                <th>Basic Loan Information</th>
                                                                <th>Loan Computations</th>
                                                                <th>Remarks</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr>
                                                                <td style="font-size: large;"><strong>Submission Date</strong>&#160;&#160;<?php echo e(date("d-M-Y",strtotime($loan->created_at))); ?><br/>
                                                                    <strong>Loan Type:</strong>&#160;&#160;&#160;<?php echo e($loan->loan_type); ?><br/>
                                                                    <strong>Principal Amount:</strong>&#160;&#160;&#160;<del style="text-decoration-style: double">N</del><?php echo e(number_format($loan->loan_amount,2)); ?><br/>                                                                    <strong>LoanTenor:</strong>&#160;&#160;&#160;<?php echo e($loan->cash_loan_tenor.'Months'); ?><br/>
                                                                    <strong>Interest Rate:</strong>&#160;&#160;&#160;<?php echo e($loan->cash_loan_rate.'%'); ?><br/>
                                                                </td>
                                                                <td style="font-size: large;"><strong>Total Amount Payable</strong>&#160;&#160;<del style="text-decoration-style: double">N</del><?php echo e(number_format($loan->total_amount_payable,2)); ?><br/>
                                                                    <strong>Total Interest Payable:</strong>&#160;&#160;&#160;<del style="text-decoration-style: double">N</del><?php echo e(number_format($loan->total_interest_payable,2)); ?><br/>
                                                                    <strong>Monthly Installment:</strong>&#160;&#160;&#160;<del style="text-decoration-style: double">N</del><?php echo e(number_format($loan->monthly_interest_payable,2)); ?><br/>
                                                                    <strong>Total Installment Paid:</strong>&#160;&#160;&#160;<del style="text-decoration-style: double">N</del><?php echo e(number_format($total_installment_paid,2)); ?><br/>
                                                                    <strong>Loan Balance:</strong>&#160;&#160;&#160;<del style="text-decoration-style: double">N</del><?php echo e(number_format($loan->total_amount_payable - $total_installment_paid,2)); ?><br/>
                                                                </td>
                                                                <td>
                                                                    <?php if($loan->status == 'Approved'): ?>
                                                                      <img src="<?php echo e(asset('custom/img')); ?>/approved.png" width="200" height="200" alt="" />
                                                                    <?php endif; ?>
                                                                    <?php if($loan->status == 'Settled'): ?>
                                                                      <img src="<?php echo e(asset('custom/img')); ?>/settled.jpg" width="120" height="120" alt="" />
                                                                    <?php endif; ?>
                                                                    <?php if($loan->status == 'Rejected'): ?>
                                                                      <img src="<?php echo e(asset('custom/img')); ?>/rejected.jpg" width="120" height="120" alt="" />
                                                                    <?php endif; ?>
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                            </div>
                                        </div>
                                        <!-- /.box -->
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->
                                <!-- START CUSTOM TABS -->

                                <div class="row">
                                    <!-- /.col -->
                                    <div class="col-md-6 col-lg-12 col-sm-4">
                                        <!-- Custom Tabs (Pulled to the right) -->
                                        <div class="nav-tabs-custom">
                                            <ul class="nav nav-tabs pull-right">
                                                <li class="active"><a href="#tab_1-1" data-toggle="tab"><strong style="font-size: 15px">Loan Installments</strong></a></li>
                                                <li><a href="#tab_2-2" data-toggle="tab"><strong style="font-size: 15px">Loan Guarantors</strong></a></li>
                                                <li><a href="#tab_3-2" data-toggle="tab"><strong style="font-size: 15px">Reason(s) For Rejection</strong></a></li>

                                                <li class="pull-left header"><i class="fa fa-th"></i>Other Information</li>
                                            </ul>
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="tab_1-1">
                                                    <!-- Main content -->
                                        <section class="content">
                                            <div class="row">
                                                <div class="col-xs-12">

                                                    <div class="box box-primary" >
                                                        <div class="box-header">
                                                            <h3 class="box-title">View of all Loan Installments</h3>
                                                        </div>
                                                        <!-- /.box-header -->
                                                        <div class="box-body">
                                                            <table id="example2" class="table table-bordered table-striped">
                                                                <thead>
                                                                <tr>
                                                                    <th>Loan ID</th>
                                                                    <th>Monthly Interest Payable(<del style="text-decoration-style: double">N</del>)</th>
                                                                    <th>Monthly Reducing Balance(<del style="text-decoration-style: double">N</del>)</th>
                                                                    <th>Payment Due Date</th>
                                                                    <th>Payment Status</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <?php $__currentLoopData = $loan->installments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $installment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <tr>
                                                                        <td><?php echo e($installment->loan_id); ?></td>
                                                                        <td><del style="text-decoration-style: double">N</del><?php echo e(number_format($installment->monthly_installment,2)); ?></td>
                                                                        <td><del style="text-decoration-style: double">N</del><?php echo e(number_format($installment->current_balance,2)); ?></td>
                                                                        <td><?php echo e(date("d-M-Y",strtotime($installment->payment_date))); ?></td>
                                                                        <td><?php echo e($installment->status); ?></td>
                                                                    </tr>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </tbody>
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
                                        <!-- /.content-wrapper -->
                                        <script>
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
                                    </div>
                                        <div class="tab-pane" id="tab_2-2">
                                            <table id="example2" class="table table-bordered table-striped">
                                                <thead>
                                                <tr>
                                                    <th>Guarantor's Name</th>
                                                    <th>Guarantor's Phone Number</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><?php echo e($loan->guarantor_one); ?></td>
                                                        <td><?php echo e($loan->g1_phone_no); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><?php echo e($loan->guarantor_two); ?></td>
                                                        <td><?php echo e($loan->g2_phone_no); ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                            <div class="tab-pane" id="tab_3-2">
                                                <?php echo e($loan->reason_for_rejection); ?>

                                            </div>
                                            </div>
                                            <!-- /.tab-content -->
                                        </div>
                                        <!-- nav-tabs-custom -->
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->
                                <!-- END CUSTOM TABS -->
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
            <!-- /.content-wrapper -->
        </section>
        <?php
if (! isset($_instance)) {
    $dom = \Livewire\Livewire::mount('change-password', [])->dom;
} elseif ($_instance->childHasBeenRendered('voDFhhT')) {
    $componentId = $_instance->getRenderedChildComponentId('voDFhhT');
    $componentTag = $_instance->getRenderedChildComponentTagName('voDFhhT');
    $dom = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('voDFhhT');
} else {
    $response = \Livewire\Livewire::mount('change-password', []);
    $dom = $response->dom;
    $_instance->logRenderedChild('voDFhhT', $response->id, \Livewire\Livewire::getRootElementTagName($dom));
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

    <style>
        .breadcrumb-arrow {
            min-height: 36px;
            line-height: 36px;
            list-style: none;
            overflow: auto;
            background-color: #ffffff ! important;
            margin-bottom: -20px;
            margin-top: -10px;
        }
        .breadcrumb{
            top: 10px ! important;
        }

        .breadcrumb-arrow li:first-child a {
            border-radius: 4px 0 0 4px;
            -webkit-border-radius: 4px 0 0 4px;
            -moz-border-radius: 4px 0 0 4px;
        }

        .breadcrumb-arrow li,
        .breadcrumb-arrow li a,
        .breadcrumb-arrow li span {
            display: inline-block;
        }

        .breadcrumb-arrow li:not(:first-child) {
            margin-left: -5px;
        }

        .breadcrumb-arrow li+li:before {
            padding: 0;
            content: "";
        }

        .breadcrumb-arrow li span {
            padding: 0 10px;
        }

        .breadcrumb-arrow li a,
        .breadcrumb-arrow li:not(:first-child) span {
            height: 36px;
            padding: 0 10px 0 25px;

        }

        .breadcrumb-arrow li:first-child a {
            padding: 0 10px;
        }

        .breadcrumb-arrow li a {
            position: relative;
            color: #fff;
            text-decoration: none;
            background-color: #3C8DBC;
            border: 1px solid #3C8DBC;
        }

        .breadcrumb-arrow li:first-child a {
            padding-left: 10px;
        }

        .breadcrumb-arrow li a:after,
        .breadcrumb-arrow li a:before {
            position: absolute;
            top: -1px;
            width: 0;
            height: 0;
            content: '';
            border-top: 18px solid transparent;
            border-bottom: 18px solid transparent;
        }

        .breadcrumb-arrow li a:before {
            right: -10px;
            z-index: 3;
            border-left-color: #3C8DBC;
            border-left-style: solid;
            border-left-width: 10px;
        }

        .breadcrumb-arrow li a:after {
            right: -11px;
            z-index: 2;
            border-left: 11px solid #fff;
        }

        .breadcrumb-arrow li a:focus:before,
        .breadcrumb-arrow li a:hover:before {
            border-left-color: #3C8DBC;
        }

        .breadcrumb-arrow li a:active {
            background-color: #3C8DBC;
            border: 1px solid #3C8DBC;
        }

        .breadcrumb-arrow li a:active:after,
        .breadcrumb-arrow li a:active:before {
            border-left-color: #3C8DBC;
        }

        .breadcrumb-arrow li.active:first-child span {
            padding-left: 10px;
        }

        .breadcrumb-arrow li.active span:after,
        .breadcrumb-arrow li.active span:before {
            position: absolute;
            top: -1px;
            width: 0;
            height: 0;
            content: '';
            border-top: 18px solid transparent;
            border-bottom: 18px solid transparent;
        }

        .breadcrumb-arrow li.active span:before {
            right: -10px;
            z-index: 3;
            border-left-color: #007bff;
            border-left-style: solid;
            border-left-width: 11px;
        }

        .breadcrumb-arrow li.active span:after {
            right: -11px;
            z-index: 2;
            border-left: 10px solid #007bff;
        }
    </style>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('dashboard.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\coopmanager\resources\views/dashboard/application/loanDetails.blade.php ENDPATH**/ ?>