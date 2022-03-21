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
                    <p style="margin-top: -17px; font-weight:bolder; font-size: 15px; background-color: black;color: #FFFFFF; ">MEMBERS' TRANSACTION LEDGER</p>
                    <p style="margin-top: -17px; font-weight:bolder; font-size: 15px; background-color: black;color: #FFFFFF; ">FILTERED DATE <?php echo e(date('d-m-Y',strtotime($startDate))); ?> - <?php echo e(date('d-m-Y',strtotime($endDate))); ?></p>
                </th>
            </tr>
        </table>
    </div>
</div>
<div class="row col-md-10 col-lg-10 flex justify-content-center">
    <div>
        <table id="saving" style="width: 100vw ! important">
            <thead>
            <tr id="s">
                <th id="s">S/N</th>
                <th id="s" colspan="3">MEMBER NAME</th>
                <th id="a" colspan="1">TOTAL TRANSACTION &#160;(<del style="text-decoration-style: double">N</del>)</th>
            </tr>
            </thead>
            <tbody>
            <?php $counter=1;?>
            <?php $__currentLoopData = $memberTotalTransactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $memberTotalTransaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr id="a">
                    <td id="a"><?php echo e($counter++); ?></td>
                    <td id="a" colspan="3" style="text-align: center"><?php echo e($memberTotalTransaction->users->name); ?></td>
                    <td id="a" colspan="1" style="text-align: right;"><?php echo e(number_format($memberTotalTransaction->total_transaction,2)); ?></td>
                </tr>
            <?php
                $userTransactions = \App\Transaction::where('user_id',$memberTotalTransaction->user_id)->get();
            ?>
            <thead>
            <tr id="header">
                <th width="100">Transaction Date</th>
                <th width="120">Transaction Type</th>
                <th>Transaction Reference</th>
                <th>Channel</th>
                <th>Amount(<del style="text-decoration-style: double">N</del>)</th>
            </tr>
            </thead>
            <?php $__currentLoopData = $userTransactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $userTransaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td width="100"><?php echo e(date("d-M-Y h:m:s",strtotime($userTransaction->created_at))); ?></td>
                    <td width="120"><?php echo e($userTransaction->transaction_type); ?></td>
                    <td><?php echo e($userTransaction->transaction_reference); ?></td>
                    <td><?php echo e($userTransaction->channel); ?></td>
                    <td style="text-align: right"><del style="text-decoration-style: double;">N</del><?php echo e(number_format($userTransaction->transaction_amount,2)); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <tr id="figure" style="border: 1px solid #0a0a0a ! important;font-size: 20px; font-weight: bold">
                <td colspan="2"><b>Total Transaction</b></td>
                <td style="text-align: right ! important;" colspan="3"><b><?php echo e(number_format($totalTransaction,2)); ?></b></td>
            </tr>
        </table>
    </div>
</div>
<style>
    #saving, #s{
        border: 0.4px solid;
        border-collapse: collapse;
        font-size: 10px;
    }
    tbody tr:nth-child(odd) {
        background: #eee;
    }

    table thead th{
        font-size: 10px ! important;
        border: 0.4px solid black;
    }
    #a{
        border: 0.4px solid;
        border-collapse: collapse;
        font-size: 15px;
    }
</style>
</body>
</html>


<?php /**PATH C:\xampp\htdocs\coopmanager\resources\views/dashboard/admin/reports/memberTransactionsReport.blade.php ENDPATH**/ ?>