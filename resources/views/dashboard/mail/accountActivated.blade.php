<div class="container" style="justify-content: center;padding: 10px;">
    Hello {{strtoupper($email_data['name'])}},<br>
    <p>We are pleased to inform you that having paid your registration fees of <b><del style="text-decoration-style: double;">N</del>{{number_format($email_data['transaction_amount'],2)}}</b> with <br>
        <b>Reference Code: {{strtoupper($email_data['transaction_reference'])}}</b>, your NEPZA cooperative account has been successfully activated and
        it's awaiting EXCOs approval.</p>
    <p>PS: Do not forget to update your profile once you are logged in.</p>
    <p>Thank you.</p>


</div>
