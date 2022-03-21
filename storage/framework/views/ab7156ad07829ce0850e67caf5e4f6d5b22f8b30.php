<div class="container" style="justify-content: center;padding: 10px;">
    Dear <?php echo e(strtoupper($withdrawal_details['applicant_name'])); ?>,<br>

    <p>This is a notification that your request to withdraw the sum of <b><del style="text-decoration-style: double">N</del><?php echo e(number_format($withdrawal_details['amount_withdrawn'],2)); ?></b>
        from your NEPZA cooperative savings account has been approved</p>

    <p>Please note that your Account Balance is: <b><del style="text-decoration-style: double">N</del><?php echo e(number_format($withdrawal_details['balance'],2)); ?></b></p>

    <p>Your account will be credited accordingly.</p>

    Thank you.

</div>
<?php /**PATH C:\xampp\htdocs\coopmanager\resources\views/dashboard/mail/savingWithdrawalApprovalNotifyMember.blade.php ENDPATH**/ ?>