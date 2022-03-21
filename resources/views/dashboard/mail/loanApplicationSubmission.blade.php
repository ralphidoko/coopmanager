<div class="container" style="justify-content: center;padding: 10px;">
    Dear {{strtoupper($loan_details['user_name'])}},<br>

    <p>This is a notification that your loan application has been received with the following details:</p>

    <p><b>Loan Type:</b> {{$loan_details['loan_type']}}<br>
    <b>Loan Amount Applied:</b> <del style="text-decoration-style: double;">N</del>{{number_format($loan_details['loan_amount'],2)}}<br>
    <b>Loan Tenor:</b> {{$loan_details['cash_loan_tenor']." ".'Months'}}<br>
        <b>Interest Rate:</b> {{$loan_details['cash_loan_rate']."".'%'}}</p>

    <p>At the moment, your application is awaiting EXCOs approval. You will be notified when the approval is granted.</p>

    <p>Thank you.</p>


</div>
