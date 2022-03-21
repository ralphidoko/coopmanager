<!DOCTYPE html>
<html>
<head>
    <title>Hi</title>
</head>
<body>
<div class="row col-md-10 col-lg-10 flex justify-content-center">
    <div class="pull-right" style="width: 100%; display: flex; justify-content: center; align-items: center;">
        <table>
            <tr>
                <th>
                    <img src="<?php echo e(public_path('/custom/img/nepza_logo.jpg')); ?>" style="width: 100px; height: 90px">
                </th>
                <th>
                    <p style="font-weight: bolder; font-size: 20px; color: #0c5460;"><b>NEPZA STAFF MULTIPURPOSE CO-OPERATIVE SOCIETY</b></p>
                    <p style="margin-top:-17px; font-size: 20px; font-weight: bolder; background-color: black;color: #FFFFFF; "><?php echo e(strtoupper(Auth::user()->name)); ?> COOP ACCOUNT</p>
                    <p style="margin-top: -17px; font-weight:bolder; font-size: 15px; background-color: black;color: #FFFFFF; ">SAVINGS ACCOUNT AS AT <?php echo e(date('d M Y')); ?></p>
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
                    <th id="s">DATE</th>
                    <th id="s">DESCRIPTION</th>
                    <th id="s">CREDIT/DEPOSIT(<del style="text-decoration-style: double">N</del>)</th>
                    <th id="s">DEBIT/<br>WITHDRAWAL(<del style="text-decoration-style: double">N</del>)</th>
                    <th id="s">BALANCE(<del style="text-decoration-style: double">N</del>)</th>
                </tr>
            </thead>
            <tbody>
            <?php $__currentLoopData = $savings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $saving): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr id="s">
                    <td id="s"><?php if($saving->month): ?><?php echo e(date('d-M-Y', strtotime($saving->month))); ?><?php endif; ?></td>
                    <td id="s"><?php echo e($saving->description); ?></td>
                    <td id="s" style="text-align: right">
                        <?php if($saving->amount_saved > 0.00): ?>
                            <span style="color: green"><?php echo e(number_format($saving->amount_saved,2)); ?></span>
                        <?php else: ?>
                            <span class="label"></span>
                        <?php endif; ?>
                    </td>
                    <td id="s" style="text-align: right">
                        <?php if($saving->amount_withdrawn > 0.00): ?>
                            <span style="color: red"><?php echo e(number_format($saving->amount_withdrawn,2)); ?>

                        <?php endif; ?>
                    </td>
                    <td id="s" style="text-align: right"><?php echo e(number_format($saving->balance,2)); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <tr id="figure">
                <th colspan="2">ACCOUNT BALANCE</th><td style="text-align: right;font-size: 15px;background-color: #0a0a0a;color: #FFFFFF"><b><?php echo e(number_format($total_savings,2)); ?></b></td> <td style="text-align: right;font-size: 15px;background-color: #0a0a0a;color: #FFFFFF"><b><?php echo e(number_format($total_withdrawal,2)); ?></b></td><td style="text-align: right;font-size: 15px;background-color: #0a0a0a;color: #FFFFFF"><b><?php echo e(number_format($total_savings - $total_withdrawal,2)); ?></b></td>
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
<?php /**PATH C:\xampp\htdocs\coopmanager\resources\views/dashboard/reports/user/accountStatement.blade.php ENDPATH**/ ?>