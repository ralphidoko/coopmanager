<div class="container" style="justify-content: center;padding: 10px;">
    Hello {{strtoupper($userDetails['name'])}},<br>
    <p style="font-weight: bolder; font-size: 20px">Account Verification</p>
    <p>Please click on the link below to verify your email</p>

    <a href="http://localhost:8000/emailVerification/verify?code={{$userDetails['verification_code']}}">
        <button type="button" class="btn btn-primary "> {{ __('Verify Email') }}</button>
    </a>

    <p>Thank you.</p>

</div>
