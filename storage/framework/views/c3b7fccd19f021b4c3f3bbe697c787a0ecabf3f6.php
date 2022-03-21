<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
    <div style="justify-content: center">
        <div class="row">
            <div style="padding-left: 45px;width: 100%;">
                <table>
                    <tr>
                        <th>
                            <img src="<?php echo e(public_path('/custom/img/nepza_logo.jpg')); ?>" style="width: 100px; height: 90px">
                        </th>
                        <th>
                            <p style="font-weight: bold; font-size: 15px; color: #0c5460;"><b>NEPZA STAFF MULTIPURPOSE CO-OPERATIVE SOCIETY</b></p>
                            <p style="margin-top:-17px; font-size: 15px; font-weight: bold; background-color: black;color: #FFFFFF; "><?php echo e(strtoupper(Auth::user()->name)); ?> EARNED DIVIDENDS</p>
                            <p style="margin-top: -17px; font-weight:bold; font-size: 15px; background-color: black;color: #FFFFFF; ">YEARLY EARNED DIVIDENDS AS AT <?php echo e(date('Y')); ?></p>
                        </th>
                    </tr>
                </table>
            </div>
            <div style="width: 100%; padding-left: 30px">
                <table id="saving">
                    <thead>
                        <tr id="rtd">
                            <th>S/N</th>
                            <th>Financial Year</th>
                            <th>Loan Patronage Dividends</th>
                            <th>Main Dividends</th>
                            <th>Total Dividends</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $counter = 1; ?>
                        <?php $__currentLoopData = $dividends; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dividend): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <th style="width: 10px ! important;"><?php echo e($counter++); ?></th>
                                <td id="s"><?php echo e($dividend->financial_year); ?></td>
                                <td id="s" style="text-align: right"><del style="text-decoration-style: double">N</del><?php echo e(number_format($dividend->loan_patronage_dividend,2)); ?></td>
                                <td id="s" style="text-align: right"><del style="text-decoration-style: double">N</del><?php echo e(number_format($dividend->dividend,2)); ?></td>
                                <td id="s" style="text-align: right"><del style="text-decoration-style: double">N</del><?php echo e(number_format($dividend->total_dividends,2)); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <tr id="figure">
                            <th colspan="4">TOTAL DIVIDENDS</th> <td style="text-align: right;font-size: 15px"><b><del style="text-decoration-style: double">N</del><?php echo e(number_format($total_dividends,2)); ?></b></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <style>
            #saving, #s{
                width: 90%;
                border: 0.4px solid black;
                border-collapse: collapse;
                font-size: 12px;
            }
            #saving{
                float: left;
                margin-right: 20px ! important;
            }
            tbody tr:nth-child(odd) {
                background: #eee;
            }
            #rtd th{
                border: 0.4px solid black;
                border-collapse: collapse;
            }
        </style>
    </div>
</body>
</html>

<?php /**PATH C:\xampp\htdocs\coopmanager\resources\views/dashboard/reports/user/dividends.blade.php ENDPATH**/ ?>