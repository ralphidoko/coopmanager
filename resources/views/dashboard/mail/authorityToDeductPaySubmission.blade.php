<p class="container" style="justify-content: center;padding: 10px;">
    Dear {{strtoupper($deduction_details['user_name'])}},<br>

    <p>This is a notification that your authorization for pay deduction has been received:</p>

   <p> <h2><b>Authorization Details:</b></h2>
    <b>Amount To Deduct:</b> <del style="text-decoration-style: double;">N</del>{{number_format($deduction_details['authorized_amount'],2)}}<br>
    <b>Start Date:</b> {{date('d-M-Y',strtotime($deduction_details['start_date']))}}</p>

<p>You will be notified when approval is granted.</p>

    <p>Thank you.</p>


</div>
