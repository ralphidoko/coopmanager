<div class="container" style="justify-content: center;padding: 10px;">
    Dear <?php echo e(strtoupper($withdrawal_details['user_name'])); ?>,<br>

    <p>Be notified that your request to withdraw the sum of <b><del style="text-decoration-style: double">N</del><?php echo e(number_format($withdrawal_details['withdrawal_amount'],2)); ?></b>
        from your NEPZA cooperative savings account has been submitted and awaiting EXCOs' approval.</p>

    <p>You will be notified upon approval</p>

    Thank you.

</div>
<?php /**PATH C:\xampp\htdocs\coopmanager\resources\views/dashboard/mail/savingWithdrawalRequest.blade.php ENDPATH**/ ?>