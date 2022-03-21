<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
<div class="row col-md-10 col-lg-10 flex justify-content-center">
    <div class="pull-right" style="width: 100%; display: flex; justify-content: center; align-items: center;">
        <table>
            <tr>
                <th><img src="<?php echo e(public_path('/custom/img/nepza_logo.jpg')); ?>" style="width: 100px; height: 90px"></th>
                <th>
                    <p style="font-weight: bolder; font-size: 20px; color: #0c5460;"><b>NEPZA STAFF MULTIPURPOSE CO-OPERATIVE SOCIETY</b></p>
                    <p style="margin-top:-17px; font-size: 20px; font-weight: bolder; background-color: black;color: #FFFFFF; "><?php echo e(strtoupper(Auth::user()->name)); ?> COOP ACCOUNT</p>
                    <p style="margin-top: -17px; font-weight:bolder; font-size: 15px; background-color: black;color: #FFFFFF; ">LOAN ACCOUNT AS AT <?php echo e(date('d M Y')); ?></p>
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
                    <td id="s">SN</td>
                    <th id="s">DATE</th>
                    <th id="s">LOAN/DESCRIPTION</th>
                    <th id="s">INSTALLMENT</th>
                    <th id="s">ACCOUNT/INTEREST PAYABLE</th>
                    <th id="s">BALANCE</th>
                </tr>
            </thead>
         <tbody>
            <?php $__currentLoopData = $loans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr id="s">
                    <td id="s"><b>#</b></td>
                    <td id="s"><b><?php echo e(date('d-M-Y', strtotime($loan->created_at))); ?></b></td>
                    <td id="s"><b><?php echo e($loan->loan_type); ?></b></td>
                    <td id="s" style="text-align: right"></td>
                    <td id="s" style="text-align: right"><span style="color: red"><b>-<?php echo e(number_format($loan->loan_amount,2)); ?></b></span></td>
                    <td id="s" style="text-align: right"><b>-<?php echo e(number_format($loan->loan_amount,2)); ?></b></td>
                </tr>
                <tr id="s">
                    <td id="s"><b>#</b></td>
                    <td id="s"><b><?php echo e(date('d-M-Y', strtotime($loan->created_at))); ?></b></td>
                    <td id="s"><b>Loan Interest</b></td>
                    <td id="s" style="text-align: right"></td>
                    <td id="s" style="text-align: right"><span style="color: red"><b><?php echo e(number_format($loan->total_interest_payable,2)); ?></b></span></td>
                    <td id="s" style="text-align: right"><b>-<?php echo e(number_format($loan->total_amount_payable,2)); ?></b></td>
                </tr>
                    <?php $counter=1; ?>
                    <?php $__currentLoopData = $loan->installments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $installment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr id="s">
                            <td id="s"><?php echo e($counter++); ?></td>
                            <td id="s"><?php echo e(date('d-M-Y', strtotime($installment->payment_date))); ?></td>
                            <td id="s">Loan Repayment</td>
                            <td id="s" style="text-align: right"><?php echo e($installment->monthly_installment,2); ?></td>
                            <td id="s" style="text-align: right"><span style="color: red"></span></td>
                            <td id="s" style="text-align: right">-<?php echo e(number_format($installment->current_balance,2)); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         </tbody>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </table>
    </div>
</div>
<style>
    #saving, #s{
        width: 100%;
        border: 0.4px solid;
        border-collapse: collapse;
        font-size: 14px;
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

<?php /**PATH C:\xampp\htdocs\coopmanager\resources\views/dashboard/reports/user/loanStatementFromLink.blade.php ENDPATH**/ ?>