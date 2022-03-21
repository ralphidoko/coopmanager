<div class="container" style="justify-content: center;padding: 10px;">
    Dear Sir/Ma,<br>

<p>This is a notification that <?php echo e(strtoupper($withdrawal_details['user_name'])); ?> has just submitted
    a request to withdraw the sum of <b><del style="text-decoration-style: double">N</del><?php echo e(number_format($withdrawal_details['withdrawal_amount'],2)); ?></b>
   from his/her NEPZA cooperative savings account.</p>

<p>Your approval is required.</p>

You can <a href="http://localhost:8000/login" target="_blank">login here</a><br><br>

Thank you.

</div>
<?php /**PATH C:\xampp\htdocs\coopmanager\resources\views/dashboard/mail/savingWithdrawalNotifyExcos.blade.php ENDPATH**/ ?>