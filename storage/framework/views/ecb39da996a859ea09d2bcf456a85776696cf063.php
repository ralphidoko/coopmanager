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
    $dom = \Livewire\Livewire::mount('change-password', [])->dom;
} elseif ($_instance->childHasBeenRendered('lYQqbvi')) {
    $componentId = $_instance->getRenderedChildComponentId('lYQqbvi');
    $componentTag = $_instance->getRenderedChildComponentTagName('lYQqbvi');
    $dom = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('lYQqbvi');
} else {
    $response = \Livewire\Livewire::mount('change-password', []);
    $dom = $response->dom;
    $_instance->logRenderedChild('lYQqbvi', $response->id, \Livewire\Livewire::getRootElementTagName($dom));
}
echo $dom;
?>
<?php
if (! isset($_instance)) {
    $dom = \Livewire\Livewire::mount('allow-admin', [])->dom;
} elseif ($_instance->childHasBeenRendered('5yJR2ED')) {
    $componentId = $_instance->getRenderedChildComponentId('5yJR2ED');
    $componentTag = $_instance->getRenderedChildComponentTagName('5yJR2ED');
    $dom = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('5yJR2ED');
} else {
    $response = \Livewire\Livewire::mount('allow-admin', []);
    $dom = $response->dom;
    $_instance->logRenderedChild('5yJR2ED', $response->id, \Livewire\Livewire::getRootElementTagName($dom));
}
echo $dom;
?>

<?php $__env->startSection('main-content'); ?>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <?php
                $checkUserVerificationStatus = \App\Member::where('user_id',Auth::id())->first();
            ?>
            <h1>
                <b>Welcome, <?php echo e(\Illuminate\Support\Facades\Auth::user()->name); ?></b>&#160;&#160;&#160;&#160;&#160;&#160;&#160;
                <b>Your Last Login Was: <?php echo e(date('h:i:s a m-d-Y',strtotime(Auth::user()->last_login_at))); ?></b><br>
                <?php if($checkUserVerificationStatus->approval_count != 2): ?>
                <span style="color: green;font-size: medium ! important">Your dashboard is inactive because your membership application is being processed.</span>
                <a href="<?php echo e(url('/logout')); ?>" style="font-size: medium;border-bottom: 2px solid;">Check back later</a>
                <?php endif; ?>
                <?php if($checkUserVerificationStatus->membership_status == 'Archived'): ?>
                    <span style="color: green;font-size: medium ! important">Your membership renewal request is awaiting EXCOs approval.</span>
                    <a href="<?php echo e(url('/logout')); ?>" style="font-size: medium;border-bottom: 2px solid;">Check back later</a>
                <?php endif; ?>
            </h1>
        </section><br />
        <!-- Main content -->
<section class="content">
    <!-- Info boxes -->
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><font style="font-weight: bold; font-size:90px;"><del style="text-decoration-style: double;">N</del></font></span>
                <div class="info-box-content">
                    <span class="info-box-text" style="font-size: large;font-weight: bold">Total Loan Value</span>
                    <span class="info-box-number" style="font-size: 28px;font-weight: bold"><?php echo e(number_format($dashboard_data['total_loan_value'],2)); ?></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><font style="font-weight: bold; font-size:90px;"><del style="text-decoration-style: double;">N</del></font></span>
                <div class="info-box-content">
                    <span class="info-box-text" style="font-size: large;font-weight: bold">Total Savings</span>
                    <span class="info-box-number" style="font-size: 28px;font-weight: bold"><?php echo e(number_format($dashboard_data['total_saving'],2)); ?></span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><font style="font-weight: bold; font-size:90px;"><del style="text-decoration-style: double;">N</del></font></span>
                <div class="info-box-content">
                    <span class="info-box-text" style="font-size: large;font-weight: bold">Total Debits</span>
                    <span class="info-box-number" style="font-size: 28px;font-weight: bold"><?php echo e(number_format($dashboard_data['total_withdrawals'],2)); ?></span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><font style="font-weight: bold; font-size:90px;"><del style="text-decoration-style: double;">N</del></font></span>
                <div class="info-box-content">
                    <span class="info-box-text" style="font-size: large;font-weight: bold">Account Balance</span>
                    <span class="info-box-number" style="font-size: 28px;font-weight: bold"><?php echo e(number_format($dashboard_data['total_saving'] - $dashboard_data['total_withdrawals'],2)); ?></span>
                </div>
            </div>
        </div>
        <!-- /.col -->
        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><font style="font-weight: bold; font-size:90px;"><del style="text-decoration-style: double;">N</del></font></span>
                <div class="info-box-content">
                    <span class="info-box-text" style="font-size: large;font-weight: bold">Dividends Earned</span>
                    <span class="info-box-number" style="font-size: 28px;font-weight: bold">00.00</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><font style="font-weight: bold; font-size:90px;"><del style="text-decoration-style: double;">N</del></font></span>
                <div class="info-box-content">
                    <span class="info-box-text" style="font-size: large;font-weight: bold">LPD Earned &#160;<small data-toggle="tooltip" data-placement="top" title="Loan Patronage Dividends">?</small></span>
                    <span class="info-box-number" style="font-size: 28px;font-weight: bold">00.00</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><font style="font-weight: bold; font-size:90px;"><del style="text-decoration-style: double;">N</del></font></span>
                <div class="info-box-content">
                    <span class="info-box-text" style="font-size: large;font-weight: bold">Total Dividends&#160;<small data-toggle="tooltip" data-placement="top" title="Dividends Earned + LPD Earned">?</small></span>
                    <span class="info-box-number" style="font-size: 28px;font-weight: bold">00.00</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><font style="font-weight: bold; font-size:90px;"><del style="text-decoration-style: double;">N</del></font></span>
                <div class="info-box-content">
                    <span class="info-box-text" style="font-size: large;font-weight: bold">Total Transactions&#160;<small data-toggle="tooltip" data-placement="top" title="Dividends Earned + LPD Earned">?</small></span>
                    <span class="info-box-number" style="font-size: 28px;font-weight: bold"><?php echo e(number_format($dashboard_data['total_transactions'],2)); ?></span>
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">My Transactions</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                  <div class="table-responsive">
                     <table class="table no-margin">
                        <thead>
                        <tr>
                            <th>Transaction Type</th>
                            <th>Transaction Amount</th>
                            <th>Channel</th>
                            <th>Status</th>
                            <th>Transaction Reference</th>
                            <th>Merchant</th>
                            <th>Transaction Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($transaction->transaction_type); ?></td>
                            <td><del style="text-decoration-style: double">N</del><?php echo e(number_format($transaction->transaction_amount,2)); ?></td>
                            <td><?php echo e($transaction->channel); ?></td>
                            <td><span class="label label-success">Successful</span></td>
                            <td><?php echo e($transaction->transaction_reference); ?></td>
                            <td>Paystack</td>
                            <td><?php echo e($transaction->created_at); ?></td>
                        </tr>
                        </tbody>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </table>
                  </div>
                </div>
                    <div class="box-footer clearfix">
                        <a href="<?php echo e(url('/transactions/myTransactions')); ?>" class="btn btn-sm btn-info btn-flat pull-right">View All Transaction</a>
                    </div>
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
    <!-- Main row -->
    <div class="row">
        <!-- Left col -->
        <div class="col-md-8">
            <!-- MAP & BOX PANE -->
            <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">My Loans</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.box-header -->
              <div class="box-body">
                <div class="table-responsive">
                   <table class="table no-margin" >
                    <thead>
                        <tr>
                            <th>Loan Type</th>
                            <th>Loan Amount(<del style="text-decoration-style: double">N</del>)</th>
                            <th>Total Payable(<del style="text-decoration-style: double">N</del>)</th>
                            <th>Monthly Interest Payable(<del style="text-decoration-style: double">N</del>)</th>
                            <th>Total Interest Payable(<del style="text-decoration-style: double">N</del>)</th>
                            <th>Loan State</th>
                        </tr>
                    </thead>
                  <tbody>
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
                                <td><span class="label label-info"><?php echo e($loan->status); ?></span></td>
                            <?php endif; ?>
                            <?php if($loan->status=='Rejected'): ?>
                                <td><span class="label label-danger"><?php echo e($loan->status); ?></span></td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                   </tbody>
                </table>
                </div>
              </div>
            <div class="box-footer clearfix">
                <a href="<?php echo e(url('/application/loanList')); ?>" class="btn btn-sm btn-info btn-flat pull-right">View All Loans</a>
             </div>
    </div>
            <!-- TABLE: LATEST ORDERS -->
            <div class="box box-info pull-right">
                <div class="box-header with-border">
                    <h3 class="box-title">My Monthly Savings</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table no-margin">
                            <thead>
                            <tr>
                                <th>Transaction Type</th>
                                <th>Transaction Date</th>
                                <th>Credit (Deposit)(<del style="text-decoration-style: double">N</del>)</th>
                                <th>Debit (Withdrawal)(<del style="text-decoration-style: double">N</del>)</th>
                                <th>Balance (<del style="text-decoration-style: double">N</del>)</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $savings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $saving): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($saving->description); ?></td>
                                    <td><?php echo e(date('d-M-Y',strtotime($saving->month))); ?></td>
                                    <td>
                                        <?php if($saving->amount_saved > 0.00): ?>
                                            <span class="label label-success"><?php echo e(number_format($saving->amount_saved,2)); ?></span>
                                        <?php else: ?>
                                            <span class="label"></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($saving->amount_withdrawn > 0.00 && $saving->status !== 'Processing' && $saving->status !== 'Rejected'): ?>
                                            <span class="label label-danger" data-toggle="tooltip" title="Withdrawal Request Approved"><?php echo e(number_format($saving->amount_withdrawn,2)); ?>

                                        <?php elseif($saving->amount_withdrawn > 0.00 && $saving->status === 'Processing'): ?>
                                             <span class="label label-info" data-toggle="tooltip" title="Approval Pending"><?php echo e(number_format($saving->amount_withdrawn,2)); ?>

                                        <?php elseif($saving->amount_withdrawn > 0.00 && $saving->status === 'Rejected'): ?>
                                            <span class="label label-info" data-toggle="tooltip" title="Withdrawal Request Rejected"><del style="text-decoration-style: double;text-decoration-color: red"><?php echo e(number_format($saving->amount_withdrawn,2)); ?></del>
                                            <?php else: ?>
                                            <span class="label"></span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e(number_format($saving->balance,2)); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">
                    <a href="<?php echo e(url('/withdrawals/withdrawalTransactions')); ?>" class="btn btn-sm btn-info btn-flat pull-right">View All Savings</a>
                </div>
                <!-- /.box-footer -->
            </div>
            <!-- /.box -->
            <!-- /.box -->
        </div>
        <!-- /.col -->

        <div class="col-md-4">
            <!-- PRODUCT LIST -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Available Loan Products</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <?php $__currentLoopData = $dashboard_data['products']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <ul class="products-list product-list-in-box">
                        <li class="item">
                            <div class="product-info">
                                <a class="product-title"><?php echo e($product['item_name']); ?>

                                    <span class="label label-info pull-right"><del style="text-decoration-style: double">N</del><?php echo e(number_format($product['item_price'],2)); ?></span></a>
                                <span class="product-description">
                                  <?php echo e($product['item_description']); ?>

                                </span>
                            </div>
                        </li>
                    </ul>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <!-- /.box-body -->
                <div class="box-footer text-center">
                    <a href="javascript:void(0)" class="uppercase">View All Products</a>
                </div>
                <!-- /.box-footer -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 2.4.0
        </div>
        <strong>Copyright &copy; 2020 <a href="https://isosystemss.com">ISOSYSTEMS</a>.</strong> All rights
        reserved.
    </footer>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('dashboard.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\coopmanager\resources\views/dashboard/resident.blade.php ENDPATH**/ ?>