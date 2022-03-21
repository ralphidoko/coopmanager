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
                    <p style="margin-top: -17px; font-weight:bolder; font-size: 15px; background-color: black;color: #FFFFFF; ">DECLARED DIVIDENDS FOR THE <?php echo e(date('Y',strtotime($startDate))); ?> - <?php echo e(date('Y',strtotime($endDate))); ?>  FINANCIAL YEAR</p>
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
                <th id="s" >FINANCIAL YEAR</th>
                <th id="s" colspan="2">TOTAL DECLARED DIVIDENDS(<del style="text-decoration-style: double">N</del>)</th>
            </tr>
            </thead>
            <tbody>
                <?php $counter=1;?>
                <?php $__currentLoopData = $declaredDividends; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $declaredDividend): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr id="s">
                        <td id="s"><?php echo e($counter++); ?></td>
                        <td id="s" style=" text-align: center"><?php echo e($declaredDividend->financial_year); ?></td>
                        <td id="s" style="text-align: right" colspan="2"><del style="text-decoration-style: double">N</del><?php echo e(number_format($declaredDividend->proposed_dividend,2)); ?></td>
                    </tr>
                    <?php
                        $dividendBeneficiaries = \App\Dividend::where('financial_year','LIKE',$declaredDividend->financial_year)->get();
                    ?>
                        <tr>
                            <th>Member's Name</th>
                            <th>Loan Patronage Dividend(<del style="text-decoration-style: double">N</del>)</th>
                            <th>Main Dividend(<del style="text-decoration-style: double">N</del>)</th>
                            <th>Total Dividend(<del style="text-decoration-style: double">N</del>)</th>
                        </tr>
                    <?php $__currentLoopData = $dividendBeneficiaries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dividendBeneficiary): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($dividendBeneficiary->users->name); ?></td>
                            <td style="text-align: center;"><?php echo e(number_format($dividendBeneficiary->loan_patronage_dividend,2)); ?></td>
                            <td style="text-align: center;"><?php echo e(number_format($dividendBeneficiary->dividend,2)); ?></td>
                            <td style="text-align: right;"><del>N</del><?php echo e(number_format($dividendBeneficiary->total_dividends,2)); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
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


<?php /**PATH C:\xampp\htdocs\coopmanager\resources\views/dashboard/admin/reports/declaredDividends.blade.php ENDPATH**/ ?>