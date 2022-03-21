<div class="container" style="justify-content: center;padding: 10px;">
    Dear Sir/Ma,<br>

    <p>This is a notification that {{strtoupper($loan_details['user_name'])}} has submitted a loan application with the following details:</p>

   <p> <b>Loan Type:</b> {{$loan_details['loan_type']}}<br>
    <b>Loan Amount:</b> <del style="text-decoration-style: double;">N</del>{{number_format($loan_details['loan_amount'],2)}}<br>
    <b>Loan Tenor:</b> {{$loan_details['cash_loan_tenor']." ".'Months'}}<br>
       <b>Interest Rate:</b> {{$loan_details['cash_loan_rate']."".'%'}}</p>

    <p>At the moment, the application is awaiting your approval. You can <a href="http://localhost:8000/login" target="_blank">login here</a></p>

    <p>Thank you.</p>


</div>
