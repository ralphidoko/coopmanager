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
                    <div class="box box-danger"  style="margin-top: 10px;">
                        <div class="box-header">
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            </div>
                            <h3 class="box-title">Reports Dashboard</h3>
                        </div>
                        <div class="box-body DisplayAccountDiv">
                            <!-- /.box -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="box box-info collapsed-box">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Monthly Members' Deposits</h3>
                                            <div class="box-tools pull-right">
                                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="box-body">
                                            <table id="example-2" class="table table-bordered table-striped">
                                                <thead>
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Description</th>
                                                    <th>Value Month</th>
                                                    <th>Total Deposits(<del style="text-decoration-style: double">N</del>)</th>
                                                </tr>
                                                <tr>
                                                    <th></th>
                                                    <th colspan="2">Bal BFWD</th>
                                                    <th><?php echo e(number_format($reportData['balanceBroughtForward'],2)); ?></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php $counter = 1; ?>
                                                <?php $__currentLoopData = $reportData['monthlySavings']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $monthlySaving): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td><?php echo e($counter++); ?></td>
                                                        <td><?php echo e($monthlySaving->description); ?></td>
                                                        <td><?php echo e(date('M-Y',strtotime($monthlySaving->month_year))); ?></td>
                                                        <td><?php echo e(number_format($monthlySaving->amount_saved,2)); ?></td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td></td>
                                                    <td colspan="2"><b>Current Year Total Deposits</b></td>
                                                    <td><b><?php echo e(number_format($reportData['totalDeposit'],2)); ?></b></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="box box-info collapsed-box">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Monthly Members' Drawings</h3>
                                            <div class="box-tools pull-right">
                                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="box-body">
                                            <table id="example-2" class="table table-bordered table-striped">
                                                <thead>
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Description</th>
                                                    <th>Value Month</th>
                                                    <th>Total Withdrawn(<del style="text-decoration-style: double">N</del>)</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php $counter = 1; ?>
                                                <?php $__currentLoopData = $reportData['monthlyDrawings']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $monthlyDrawing): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td><?php echo e($counter++); ?></td>
                                                        <td><?php echo e($monthlyDrawing->description); ?></td>
                                                        <td><?php echo e(date('M-Y',strtotime($monthlyDrawing->month_year))); ?></td>
                                                        <td><?php echo e(number_format($monthlyDrawing->amount_withdrawn,2)); ?></td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td></td>
                                                    <td colspan="2"><b>Current Year Total Drawings</b></td>
                                                    <td><b><?php echo e(number_format($reportData['totalDrawings'],2)); ?></b></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.row -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="box box-info collapsed-box">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Monthly Loan Approved</h3>
                                            <div class="box-tools pull-right">
                                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="box-body">
                                            <table id="example-2" class="table table-bordered table-striped">
                                                <thead>
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Description</th>
                                                    <th>Value Month</th>
                                                    <th>Total Loan Amount(<del style="text-decoration-style: double">N</del>)</th>
                                                </tr>
                                                <tr>
                                                    <th></th>
                                                    <th colspan="2">Bal BFWD (Debtors)</th>
                                                    <th><?php echo e(number_format($reportData['LoanBalBroughtForward'],2)); ?></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php $counter = 1; ?>
                                                <?php $__currentLoopData = $reportData['monthlyApprovedLoans']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $monthlyApprovedLoan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td><?php echo e($counter++); ?></td>
                                                        <td>Loan Granted</td>
                                                        <td><?php echo e(date('M-Y',strtotime($monthlyApprovedLoan->month_year))); ?></td>
                                                        <td><?php echo e(number_format($monthlyApprovedLoan->loan_amount,2)); ?></td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td></td>
                                                    <td colspan="2"><b>Current Year Total Disbursed Loan</b></td>
                                                    <td><b><?php echo e(number_format($reportData['totalApprovedLoan'],2)); ?></b></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="box box-info collapsed-box">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Monthly Loan Recovered</h3>
                                            <div class="box-tools pull-right">
                                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="box-body">
                                            <table id="example-2" class="table table-bordered table-striped">
                                                <thead>
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Description</th>
                                                    <th>Value Month</th>
                                                    <th>Total Amount Recovered(<del style="text-decoration-style: double">N</del>)</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php $counter = 1; ?>
                                                <?php $__currentLoopData = $reportData['monthlyRecoveredLoans']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $monthlyRecoveredLoan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td><?php echo e($counter++); ?></td>
                                                        <td>Loan Recovered</td>
                                                        <td><?php echo e(date('M-Y',strtotime($monthlyRecoveredLoan->month_year))); ?></td>
                                                        <td><?php echo e(number_format($monthlyRecoveredLoan->amount_recovered,2)); ?></td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td></td>
                                                    <td colspan="2"><b>Total Recovered Loan</b></td>
                                                    <td><b><?php echo e(number_format($reportData['totalRecoveredLoan'],2)); ?></b></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="box box-info collapsed-box">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Monthly Loan Form Fees</h3>
                                            <div class="box-tools pull-right">
                                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="box-body">
                                            <table id="example-2" class="table table-bordered table-striped">
                                                <thead>
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Description</th>
                                                    <th>Value Month</th>
                                                    <th>Total Loan Fees(<del style="text-decoration-style: double">N</del>)</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php $counter = 1; ?>
                                                <?php $__currentLoopData = $reportData['monthlyLoanFees']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $monthlyLoanFee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td><?php echo e($counter++); ?></td>
                                                        <td><?php echo e($monthlyLoanFee->income_type); ?></td>
                                                        <td><?php echo e(date('M-Y',strtotime($monthlyLoanFee->month_year))); ?></td>
                                                        <td><?php echo e(number_format($monthlyLoanFee->income_realized,2)); ?></td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td></td>
                                                    <td colspan="2"><b>Current Year Total Loan Form Fees</b></td>
                                                    <td><b><?php echo e(number_format($reportData['totalLoanFees'],2)); ?></b></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="box box-info collapsed-box">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Current Year Income(With Sources)</h3>
                                            <div class="box-tools pull-right">
                                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="box-body">
                                            <table id="example-2" class="table table-bordered table-striped">
                                                <thead>
                                                <tr>
                                                    <th>View Sources</th>
                                                    <th>Description</th>
                                                    <th>Value Month</th>
                                                    <th>Total Income Realized(<del style="text-decoration-style: double">N</del>)</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php $counter = 1; ?>
                                                <?php $__currentLoopData = $reportData['monthlyIncomes']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $monthlyIncome): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr data-toggle="collapse" data-target="#<?php echo e($monthlyIncome->month_year); ?>" class="accordion-toggle">
                                                        <td><button class="btn btn-default btn-xs"><span class="glyphicon glyphicon-eye-open"></span></button></td>
                                                        <td>Income Realized For</td>
                                                        <td><?php echo e(date('M-Y',strtotime($monthlyIncome->month_year))); ?></td>
                                                        <td><?php echo e(number_format($monthlyIncome->income_realized,2)); ?></td>
                                                    </tr>
                                                    <?php
                                                        $incomeSources = \Illuminate\Support\Facades\DB::table('incomes')
                                                             ->join('users', 'users.id', '=', 'incomes.user_id')
                                                             ->select('users.name',\Illuminate\Support\Facades\DB::raw("incomes.created_at"),\Illuminate\Support\Facades\DB::raw("incomes.user_id"),\Illuminate\Support\Facades\DB::raw("DATE_FORMAT(incomes.created_at,'%Y-%m') month_year"),\Illuminate\Support\Facades\DB::raw('incomes.income_realized'),\Illuminate\Support\Facades\DB::raw('incomes.income_type'))
                                                             ->where('incomes.created_at','LIKE','%'.$monthlyIncome->recorded_on.'%')->get();
                                                    ?>
                                                    <tr>
                                                        <td colspan="12" class="hiddenRow">
                                                            <?php $counter = 1; ?>
                                                            <?php $__currentLoopData = $incomeSources; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $incomeSource): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <div class="accordian-body collapse install_table" id="<?php echo e($monthlyIncome->month_year); ?>">
                                                                    <table class="table table-striped example-1" style="font-size: 12px;">
                                                                        <thead>
                                                                        <tr>
                                                                            <th>S/N</th>
                                                                            <th>Income Type</th>
                                                                            <th>Paid By</th>
                                                                            <th>Amount Realized(<del style="text-decoration-style: double">N</del>)</th>
                                                                            <th>Value Date</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php $__currentLoopData = $incomeSources; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $incomeSource): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                <tr data-toggle="collapse"  class="accordion-toggle" data-target="#demo10">
                                                                                    <td><?php echo e($counter++); ?></td>
                                                                                    <td><?php echo e($incomeSource->income_type); ?></td>
                                                                                    <td><?php echo e($incomeSource->name); ?></td>
                                                                                    <td><del style="text-decoration-style: double">N</del><?php echo e(number_format($incomeSource->income_realized,2)); ?></td>
                                                                                    <td><?php echo e(date("d-M-Y",strtotime($incomeSource->created_at))); ?></td>
                                                                                </tr>
                                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td></td>
                                                    <td colspan="2"><b>Current Total Income Realized</b></td>
                                                    <td><b><?php echo e(number_format($reportData['totalMonthlyIncome'],2)); ?></b></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="box box-info collapsed-box">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Current Year Groupped Income</h3>
                                            <div class="box-tools pull-right">
                                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="box-body">
                                            <table id="example-2" class="table table-bordered table-striped">
                                                <thead>
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Description</th>
                                                    <th>Total Amount Realized(<del style="text-decoration-style: double">N</del>)</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php $counter = 1; ?>
                                                <?php $__currentLoopData = $reportData['incomeGroupings']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $incomeGrouping): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td><?php echo e($counter++); ?></td>
                                                        <td><?php echo e($incomeGrouping->income_type); ?></td>
                                                        <td><?php echo e(number_format($incomeGrouping->income_realized,2)); ?></td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td></td>
                                                    <td colspan="1"><b>Current Year Groupped Income</b></td>
                                                    <td><b><?php echo e(number_format($reportData['totalGroupedIncome'],2)); ?></b></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="box box-info collapsed-box table-responsive">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Current Year Expenditure</h3>
                                            <div class="box-tools pull-right">
                                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="box-body">
                                            <table id="example-2" class="table table-bordered table-striped">
                                                <thead>
                                                <tr>
                                                    <th>View Sources</th>
                                                    <th>Description</th>
                                                    <th>Value Month</th>
                                                    <th>Total Expenses(<del style="text-decoration-style: double">N</del>)</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php $counter = 1; ?>
                                                <?php $__currentLoopData = $reportData['monthlyExpenses']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $monthlyExpense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr data-toggle="collapse" data-target="#<?php echo e($monthlyExpense->transactionMonth); ?>" class="accordion-toggle">
                                                        <td><button class="btn btn-default btn-xs"><span class="glyphicon glyphicon-eye-open"></span></button></td>
                                                        <td>Expenses For</td>
                                                        <td><?php echo e(date('M-Y',strtotime($monthlyExpense->monthYear))); ?></td>
                                                        <td><?php echo e(number_format($monthlyExpense->subTotal,2)); ?></td>
                                                    </tr>
                                                    <?php
                                                        $expenseSources = \Illuminate\Support\Facades\DB::table('expenses')
                                                               ->select('*')->whereMonth('created_at',$monthlyExpense->transactionMonth)->get();
                                                    ?>
                                                    <tr>
                                                        <td colspan="12" class="hiddenRow">
                                                            <?php $counter = 1; ?>
                                                            <?php $__currentLoopData = $expenseSources; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expenseSource): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <div class="accordian-body collapse install_table " id="<?php echo e($monthlyExpense->transactionMonth); ?>">
                                                                    <table class="table table-bordered table-striped example-1" style="font-size: 12px;">
                                                                        <thead>
                                                                        <tr>
                                                                            <th>S/N</th>
                                                                            <th>Transaction Reference</th>
                                                                            <th>Expense Number</th>
                                                                            <th>Product/Service</th>
                                                                            <th>Quantity</th>
                                                                            <th>Unit Price(<del style="text-decoration-style: double">N</del>)</th>
                                                                            <th>Sub Total(<del style="text-decoration-style: double">N</del>)</th>
                                                                            <th>Value Date</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php $__currentLoopData = $expenseSources; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expenseSource): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                <tr data-toggle="collapse" class="accordion-toggle" data-target="#demo10">
                                                                                    <td><?php echo e($counter++); ?></td>
                                                                                    <td><?php echo e($expenseSource->description); ?></td>
                                                                                    <td><?php echo e($expenseSource->expense_number); ?></td>
                                                                                    <td><?php echo e($expenseSource->product_service); ?></td>
                                                                                    <td><?php echo e($expenseSource->quantity); ?></td>
                                                                                    <td><del style="text-decoration-style: double">N</del><?php echo e(number_format($expenseSource->unit_price,2)); ?></td>
                                                                                    <td><del style="text-decoration-style: double">N</del><?php echo e(number_format($expenseSource->total_price,2)); ?></td>
                                                                                    <td><?php echo e(date("d-M-Y",strtotime($expenseSource->created_at))); ?></td>
                                                                                </tr>
                                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td></td>
                                                        <td colspan="2"><b>Current Total Expenses</b></td>
                                                        <td><b><?php echo e(number_format($reportData['totalMonthlyExpenses'],2)); ?></b></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="box box-info collapsed-box">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Yearly Appropriations</h3>
                                            <div class="box-tools pull-right">
                                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="box-body">
                                            <table class="table table-bordered table-striped example-1">
                                                <thead>
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Financial Year</th>
                                                    <th>Education Reserve(<del style="text-decoration-style: double">N</del>)</th>
                                                    <th>Statutory Reserve(<del style="text-decoration-style: double">N</del>)</th>
                                                    <th>Proposed Dividends(<del style="text-decoration-style: double">N</del>)</th>
                                                    <th>General Reserve(<del style="text-decoration-style: double">N</del>)</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php $counter = 1; ?>
                                                <?php $__currentLoopData = $reportData['yearlyAppropriations']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $yearlyAppropriation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td><?php echo e($counter++); ?></td>
                                                        <td><?php echo e($yearlyAppropriation->financial_year); ?></td>
                                                        <td><?php echo e(number_format($yearlyAppropriation->education_reserve,2)); ?></td>
                                                        <td><?php echo e(number_format($yearlyAppropriation->statutory_reserve,2)); ?></td>
                                                        <td><?php echo e(number_format($yearlyAppropriation->proposed_dividend,2)); ?></td>
                                                        <td><?php echo e(number_format($yearlyAppropriation->general_reserve,2)); ?></td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tbody>
                                                <tr>
                                                    <td></td>
                                                    <td colspan="2"><b>Total Appropriation</b></td>
                                                    <td colspan="3"><b><del style="text-decoration-style: double">N</del><?php echo e(number_format($reportData['totalAppropriation'],2)); ?></b></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="box box-info collapsed-box">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Yearly Cumulative Appropriations</h3>
                                            <div class="box-tools pull-right">
                                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="box-body">
                                            <table id="example-2" class="table table-bordered table-striped">
                                                <thead>
                                                <tr>
                                                    <th>Appropriations</th>
                                                    <th>Cumulative Balance(<del style="text-decoration-style: double">N</del>)</th>
                                                </tr>
                                                <tr>
                                                    <td>Education Reserve</td>
                                                    <td><?php echo e(number_format($reportData['educationReserve'],2)); ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Statutory Reserve</td>
                                                    <td><?php echo e(number_format($reportData['statutoryReserve'],2)); ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Proposed Dividends</td>
                                                    <td><?php echo e(number_format($reportData['proposedDividend'],2)); ?></td>
                                                </tr>
                                                <tr>
                                                    <td>General Reserve</td>
                                                    <td><?php echo e(number_format($reportData['generalReserve'],2)); ?></td>
                                                </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
    </section>
    <script>
        $(function () {
            //use class for multiple table instead of id
            $('.example-1').DataTable({
                'paging'      : true,
                'lengthChange': true,
                'searching'   : false,
                'ordering'    : true,
                'info'        : true,
                'autoWidth'   : false
            })
        })
    </script>
    <?php
if (! isset($_instance)) {
    $dom = \Livewire\Livewire::mount('change-password', [])->dom;
} elseif ($_instance->childHasBeenRendered('FTpxekb')) {
    $componentId = $_instance->getRenderedChildComponentId('FTpxekb');
    $componentTag = $_instance->getRenderedChildComponentTagName('FTpxekb');
    $dom = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('FTpxekb');
} else {
    $response = \Livewire\Livewire::mount('change-password', []);
    $dom = $response->dom;
    $_instance->logRenderedChild('FTpxekb', $response->id, \Livewire\Livewire::getRootElementTagName($dom));
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



<?php echo $__env->make('dashboard.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\coopmanager\resources\views/dashboard/admin/accounting/reportTemplate.blade.php ENDPATH**/ ?>