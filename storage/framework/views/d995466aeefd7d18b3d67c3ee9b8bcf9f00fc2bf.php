<!DOCTYPE html>
<html>
<body>
<div class="row col-md-10 col-lg-10 flex justify-content-center">
    <span style="font-size: 10px;">Printed: <?php echo e(date('F j, Y, g:i a',strtotime(now().'+1 hours'))); ?></span>
    <div class="pull-right" style="width: 100%; display: flex; justify-content: center; align-items: center;">
        <table>
            <tr><th><img src="<?php echo e(public_path('/custom/img/nepza_logo.jpg')); ?>" style="width: 100px; height: 90px"></th><th>
                    <p style="font-weight: bolder; font-size: 20px; color: #0c5460;"><b>NEPZA STAFF MULTIPURPOSE CO-OPERATIVE SOCIETY</b></p>
                    <p style="margin-top: -17px; font-weight:bolder; font-size: 15px; background-color: black;color: #FFFFFF; ">YEARLY CATEGORIZED INCOME FOR THE PERIOD <?php echo e($startYear); ?> - <?php echo e($endYear); ?></p>
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
                    <th id="s">Financial Year</th>
                    <th id="s">Total Amount Realized(<del style="text-decoration-style: double">N</del>)</th>
                </tr>
            </thead>
            <tbody>
                <?php $counter = 1; ?>
                <?php $__currentLoopData = $incomeGroupings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $incomeGrouping): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr id="s">
                            <td id="s"><?php echo e($counter++); ?></td>
                            <td id="s" style="text-align: center"><?php echo e($incomeGrouping->year); ?></td>
                            <td id="s" style="text-align: right"><del style="text-decoration-style: double">N</del><?php echo e(number_format($incomeGrouping->income_realized,2)); ?></td>
                        </tr>
                    <?php
                        $groupedIncomes = \App\Income::WhereYear('created_at',$incomeGrouping->year)
                                        ->selectRaw("SUM(income_realized) as totalIncome")
                                        ->selectRaw("created_at as financialYear")
                                        ->selectRaw("income_type as incomeType")
                                        ->groupBy('income_type')
                                        ->get();
                    ?>
                    <tr id="header">
                        <th>Transaction Type</th>
                        <th>Transaction Year</th>
                        <th>Total Amount(<del style="text-decoration-style: double">N</del>)</th>
                    </tr>
                    <?php $__currentLoopData = $groupedIncomes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $groupedIncome): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($groupedIncome->incomeType); ?></td>
                            <td style="text-align: right"><?php echo e(date('Y',strtotime($groupedIncome->financialYear))); ?></td>
                            <td style="text-align: right"><del style="text-decoration-style: double;">N</del><?php echo e(number_format($groupedIncome->totalIncome,2)); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <tr id="s">
                    <td colspan="2"><b>Total Grouped Income</b></td>
                    <td style="text-align: right"><b><del style="text-decoration-style: double">N</del><?php echo e(number_format($totalGroupedIncome,2)); ?></b></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<style>
    #saving, #s{
        width: 100%;
        border: 0.4px solid black;
        border-collapse: collapse;
        font-size: 13px ! important;
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

<?php /**PATH C:\xampp\htdocs\coopmanager\resources\views/dashboard/admin/reports/monthlyGroupedIncomeAnalysis.blade.php ENDPATH**/ ?>