<p class="container" style="justify-content: center;padding: 10px;">
    Dear Sir/Ma,<br>

    <p>An authorization to increase saving has just been submitted by {{strtoupper($deduction_details['user_name'])}}:</p>

   <p> <h2><b>Authorization Details:</b></h2>
    <b>Authorization Type:</b> {{$deduction_details['auth_text']}}<br>
    <b>From Amount:</b> {{number_format($deduction_details['current_amount'],2)}}<br>
    <b>To Amount:</b> <del style="text-decoration-style: double;">N</del>{{number_format($deduction_details['desired_amount'],2)}}<br>
    <b>Starting From:</b> {{date('d-M-Y',strtotime($deduction_details['start_date']))}}</p>

    <p>Your approval is required.</p>

    You can <a href="http://localhost:8000/login" target="_blank">login here</a><br><br>

    Thank you.

</div>
