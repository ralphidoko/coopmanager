<p class="container" style="justify-content: center;padding: 10px;">
    Dear {{strtoupper($deduction_details['user_name'])}},<br>

    <p>This is a notification that your authorization to increase your saving has been received with the following details:</p>

    <p><h2><b>Authorization Details:</b></h2>
    <b>Authorization Type:</b> {{$deduction_details['auth_text']}}<br>
    <b>From Amount:</b> {{number_format($deduction_details['current_amount'],2)}}<br>
    <b>To Amount:</b> <del style="text-decoration-style: double;">N</del>{{number_format($deduction_details['desired_amount'],2)}}<br>
    <b>Starting From:</b> {{date('d-M-Y',strtotime($deduction_details['start_date']))}}</p>

    <p>Kindly wait for EXCOs approval. You will be notified when the approval is granted.</p>

    Thank you.


</div>
