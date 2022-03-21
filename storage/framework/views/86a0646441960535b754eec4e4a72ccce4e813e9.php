<div class="container" style="justify-content: center;padding: 10px;">
    Dear <?php echo e(strtoupper($installmentDetails['userName'])); ?>,<br><br>

    <p>This is to notify you that you have paid the sum of <b><del style="text-decoration-style: double">N</del><?php echo e(number_format($installmentDetails['currentInstalment'],2)); ?></b> as loan installment due for <?php echo e(date('M-Y',strtotime($installmentDetails['paymentDate']))); ?>.</p>

    <p>Please note that with this payment, your current loan balance is: <b><del style="text-decoration-style: double">N</del><?php echo e(number_format($installmentDetails['currentLoanBalance'],2)); ?></b></p>

    <p>Thank you.</p>

</div>


<?php /**PATH C:\xampp\htdocs\coopmanager\resources\views/dashboard/mail/InstallmentPaymentNotification.blade.php ENDPATH**/ ?>