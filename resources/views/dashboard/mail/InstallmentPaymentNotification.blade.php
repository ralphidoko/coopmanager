<div class="container" style="justify-content: center;padding: 10px;">
    Dear {{strtoupper($installmentDetails['userName'])}},<br><br>

    <p>This is to notify you that you have paid the sum of <b><del style="text-decoration-style: double">N</del>{{number_format($installmentDetails['currentInstalment'],2)}}</b> as loan installment due for {{date('M-Y',strtotime($installmentDetails['paymentDate']))}}.</p>

    <p>Please note that with this payment, your current loan balance is: <b><del style="text-decoration-style: double">N</del>{{number_format($installmentDetails['currentLoanBalance'],2)}}</b></p>

    <p>Thank you.</p>

</div>


