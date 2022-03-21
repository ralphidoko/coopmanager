<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
<div class="row col-md-10 col-lg-10 flex justify-content-center">
    <span style="font-size: 10px;">Printed: <?php echo e(date('F j, Y, g:i a',strtotime(now().'+1 hours'))); ?></span>
    <div class="pull-right" style="width: 100%; display: flex; justify-content: center; align-items: center;">
        <table>
            <tr>
                <th><img src="<?php echo e(public_path('/custom/img/nepza_logo.jpg')); ?>" style="width: 100px; height: 90px"></th>
                <th>
                    <p style="font-weight: bolder; font-size: 20px; color: #0c5460;"><b>NEPZA STAFF MULTIPURPOSE CO-OPERATIVE SOCIETY</b></p>
                    <p style="margin-top: -17px; font-weight:bolder; font-size: 15px; background-color: black;color: #FFFFFF; ">INCOME ANALYSIS FOR THE PERIOD <?php echo e(date('d-m-Y',strtotime($startDate))); ?> - <?php echo e(date('d-m-Y',strtotime($endDate))); ?></p>
                </th>
            </tr>
        </table>
    </div>
</div>
<div class="row col-md-10 col-lg-10 flex justify-content-center">
    <div class="pull-right" style="width: 100%; display: flex; justify-content: center; align-items: center;">
        <table id="saving">
            <thead>
            <tr id="s">
                <th id="s">S/N</th>
                <th id="s">DESCRIPTION</th>
                <th id="s">VALUE MONTH</th>
                <th id="s">TOTAL INCOME REALIZED</th>
            </tr>
            </thead>
            <tbody>
                <?php $counter=1;?>
                <?php $__currentLoopData = $monthlyIncomes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $monthlyIncome): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr id="s">
                        <td id="s"><?php echo e($counter++); ?></td>
                        <td id="s">Income Realized</td>
                        <td id="s"><?php echo e($monthlyIncome->month_year); ?></td>
                        <td id="s" style="text-align: center"><del style="text-decoration-style: double">N</del><?php echo e(number_format($monthlyIncome->income_realized,2)); ?></td>
                    </tr>
                <?php
                    $incomeSources = \Illuminate\Support\Facades\DB::table('incomes')
                                ->join('users', 'users.id', '=', 'incomes.user_id')
                                ->select('users.name',\Illuminate\Support\Facades\DB::raw("incomes.created_at"),
                                                        \Illuminate\Support\Facades\DB::raw("incomes.user_id"),
                                                        \Illuminate\Support\Facades\DB::raw("DATE_FORMAT(incomes.created_at,'%Y-%m') month_year"),
                                                        \Illuminate\Support\Facades\DB::raw('incomes.income_realized'),
                                                        \Illuminate\Support\Facades\DB::raw('incomes.income_type'))
                               ->where('incomes.created_at','LIKE','%'.$monthlyIncome->recorded_on.'%')->get();
                ?>
                    <thead>
                        <tr>
                            <th>Income Type</th>
                            <th>Paid By</th>
                            <th>Value Date</th>
                            <th>Amount Realized(<del style="text-decoration-style: double">N</del>)</th>
                        </tr>
                    </thead>
                     <?php $__currentLoopData = $incomeSources; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $incomeSource): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($incomeSource->income_type); ?></td>
                            <td><?php echo e($incomeSource->name); ?></td>
                            <td style="text-align: center"><?php echo e(date("d-M-Y",strtotime($incomeSource->created_at))); ?></td>
                            <td style="text-align: right"><del style="text-decoration-style: double">N</del><?php echo e(number_format($incomeSource->income_realized,2)); ?></td>
                        </tr>
                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <tr id="figure" style="border: 1px solid #0a0a0a ! important;">
                <td colspan="2"><b>Total Income Realized</b></td>
                <td colspan="2" style="text-align: right ! important;"><b><del style="text-decoration-style: double">N</del><?php echo e(number_format($totalMonthlyIncome,2)); ?></b></td>
            </tr>
        </table>
    </div>
</div>
<style>
    #saving, #s{
        width: 100%;
        border: 0.4px solid;
        border-collapse: collapse;
        font-size: 12px;
    }
    tbody tr:nth-child(odd) {
        background: #eee;
    }

    table thead th{
        font-size: 12px ! important;
        border: 0.4px solid black;
    }
</style>
</body>
</html>


<?php /**PATH C:\xampp\htdocs\coopmanager\resources\views/dashboard/admin/reports/monthlyIncomeWithSourcesAnalysis.blade.php ENDPATH**/ ?>