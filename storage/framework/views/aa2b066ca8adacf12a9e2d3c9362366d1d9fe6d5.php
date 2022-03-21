<div class="container" style="justify-content: center;padding: 10px;">
    Hello <?php echo e(strtoupper($userDetails['name'])); ?>,<br>
    <p style="font-weight: bolder; font-size: 20px">Account Verification</p>
    <p>Please click on the link below to verify your email</p>

    <a href="http://localhost:8000/emailVerification/verify?code=<?php echo e($userDetails['verification_code']); ?>">
        <button type="button" class="btn btn-primary "> <?php echo e(__('Verify Email')); ?></button>
    </a>

    <p>Thank you.</p>

</div>
<?php /**PATH C:\xampp\htdocs\coopmanager\resources\views/dashboard/mail/SendEmailVerification.blade.php ENDPATH**/ ?>