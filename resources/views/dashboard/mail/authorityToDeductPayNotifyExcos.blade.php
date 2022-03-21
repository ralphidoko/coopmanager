<div class="container" style="justify-content: center;padding: 10px;">
    Dear Sir/Ma,<br>

    <p>Your approval is required for the authorization to deduct pay submitted by {{strtoupper($deduction_details['user_name'])}}:</p>

    <h2><b>Authorization Details:</b></h2>
    <b>Amount To Deduct:</b> <del style="text-decoration-style: double;">N</del>{{number_format($deduction_details['authorized_amount'],2)}}<br>
    <b>Start Date:</b> {{date('d-M-Y',strtotime($deduction_details['start_date']))}}<br />

    <p>You can <a href="http://localhost:8000/login" target="_blank">login here</a></p><br>

    Thank you.

</div>
