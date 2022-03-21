<div class="container" style="justify-content: center;padding: 10px;">
    Dear {{strtoupper($approval_details['applicant_name'])}},<br>

    <p>This is a notification that your loan application has been approved.<p/>

     <p>Details of your application are as follow:<p>

    <b>Loan Type:</b> {{$approval_details['loan_type']}}<br>
    <b>Loan Amount Applied:</b> <del style="text-decoration-style: double;">N</del>{{number_format($approval_details['loan_amount'],2)}}<br>
    <b>Loan Tenor:</b> {{$approval_details['cash_loan_tenor']." ".'Months'}}<br>
    <b>Interest Rate:</b> {{$approval_details['cash_loan_rate']."".'%'}}<br/>

    <p>Thank you.</p>


</div>
