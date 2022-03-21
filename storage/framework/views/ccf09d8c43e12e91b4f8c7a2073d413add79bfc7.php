<!DOCTYPE html>
<html>
<body>
<div class="row col-md-10 col-lg-10 flex justify-content-center">
    <div class="pull-right" style="width: 100%; display: flex; justify-content: center; align-items: center;">
        <table>
            <tr>
                <th><img src="<?php echo e(public_path('/custom/img/nepza_logo.jpg')); ?>" style="width: 100px; height: 90px"></th>
                <th>
                    <p style="font-weight: bolder; font-size: 20px; color: #0c5460;"><b>NEPZA STAFF MULTIPURPOSE CO-OPERATIVE SOCIETY</b></p>
                    <p style="margin-top: -17px; font-weight:bolder; font-size: 15px; background-color: black;color: #FFFFFF; ">MONTHLY RECOVERED LOAN FOR THE PERIOD  <?php echo e(date('d-m-Y',strtotime($startDate))); ?> - <?php echo e(date('d-m-Y',strtotime($endDate))); ?></p>
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
                <th id="s">TOTAL RECOVERED(<del style="text-decoration-style: double">N</del>)</th>
            </tr>
            </thead>
            <tbody>
            <?php $counter = 1; ?>
            <?php $__currentLoopData = $monthlyRecoveredLoans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $monthlyRecoveredLoan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr id="s">
                    <td id="s"><?php echo e($counter++); ?></td>
                    <td id="s">Loan Recovered</td>
                    <td id="s"><?php echo e(date('M-Y',strtotime($monthlyRecoveredLoan->month_year))); ?></td>
                    <td id="s" style="text-align: right"><del style="text-decoration-style: double">N</del><?php echo e(number_format($monthlyRecoveredLoan->amount_recovered,2)); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <tr id="figure" style="border: 1px solid #0a0a0a ! important;">
                <td colspan="2"><b>Total Recovered Loans</b></td>
                <td colspan="2" style="text-align: right ! important;"><b><del style="text-decoration-style: double">N</del><?php echo e(number_format($totalRecoveredLoan,2)); ?></b></td>
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
        font-size: 12px ! important;
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

<?php /**PATH C:\xampp\htdocs\coopmanager\resources\views/dashboard/admin/reports/monthlyRecoveredLoansAnalysis.blade.php ENDPATH**/ ?>