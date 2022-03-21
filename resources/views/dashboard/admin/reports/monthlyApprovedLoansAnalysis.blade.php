<!DOCTYPE html>
<html>
<body>
<div class="row col-md-10 col-lg-10 flex justify-content-center">
    <span style="font-size: 10px;">Printed: {{date('F j, Y, g:i a',strtotime(now().'+1 hours'))}}</span>
    <div class="pull-right" style="width: 100%; display: flex; justify-content: center; align-items: center;">
        <table>
            <tr>
                <th><img src="{{ public_path('/custom/img/nepza_logo.jpg') }}" style="width: 100px; height: 90px"></th>
                <th>
                    <p style="font-weight: bolder; font-size: 20px; color: #0c5460;"><b>NEPZA STAFF MULTIPURPOSE CO-OPERATIVE SOCIETY</b></p>
                    <p style="margin-top: -17px; font-weight:bolder; font-size: 15px; background-color: black;color: #FFFFFF; ">MONTHLY APPROVED LOAN FOR THE PERIOD {{date('d-m-Y',strtotime($startDate))}} - {{date('d-m-Y',strtotime($endDate))}}</p>
                </th>
            </tr>
        </table>
    </div>
</div>
<div class="row col-md-10 col-lg-10 flex justify-content-center">
    <div class="pull-right" style="width: 100%; display: flex; justify-content: center; align-items: center;">
        <table id="saving">
            <thead>
            <tr id="s">
                <th id="s">S/N</th>
                <th id="s">DESCRIPTION</th>
                <th id="s">VALUE MONTH</th>
                <th id="s">TOTAL APPROVED/DISBURSED(<del style="text-decoration-style: double">N</del>)</th>
            </tr>
            <tr id="s">
                <th id="s"></th>
                <th colspan="2" id="s">Bal BFWD</th>
                <th id="s">{{number_format($loanBalBroughtForward,2)}}</th>
            </tr>
            </thead>
            <tbody>
            @php $counter = 1; @endphp
            @foreach($monthlyApprovedLoans as $monthlyApprovedLoan)
                <tr id="s">
                    <td id="s">{{$counter++}}</td>
                    <td id="s">Loan Granted</td>
                    <td id="s">{{date('M-Y',strtotime($monthlyApprovedLoan->month_year))}}</td>
                    <td id="s" style="text-align: right"><del style="text-decoration-style: double">N</del>{{number_format($monthlyApprovedLoan->loan_amount,2)}}</td>
                </tr>
            @endforeach
            <tr id="figure" style="border: 1px solid #0a0a0a ! important;">
                <td colspan="2"><b>Total Disbursed Loans</b></td>
                <td colspan="2" style="text-align: right ! important;"><b><del style="text-decoration-style: double">N</del>{{number_format($totalApprovedLoan,2)}}</b></td>
            </tr>
            <tr id="figure">
                <td colspan="2"><b>Bal BFWD + Total Disbursed</b></td>
                <td colspan="2" style="text-align: right ! important;"><b><del style="text-decoration-style: double">N</del>{{number_format($loanBalBroughtForward,2)}} + <del style="text-decoration-style: double">N</del>{{number_format($totalApprovedLoan,2)}} = <del style="text-decoration-style: double">N</del>{{number_format($loanBalBroughtForward + $totalApprovedLoan,2)}}</b></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<style>
    #saving, #s{
        width: 100%;
        border: 0.4px solid black;
        border-collapse: collapse;
        font-size: 12px ! important;
    }
    tbody tr:nth-child(odd) {
        background: #eee;
    }
    table thead th{
        font-size: 12px ! important;
        border: 0.4px solid black;
    }
</style>
</body>
</html>

