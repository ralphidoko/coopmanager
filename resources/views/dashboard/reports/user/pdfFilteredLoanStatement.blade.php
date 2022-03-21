<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
<div class="row col-md-10 col-lg-10 flex justify-content-center">
    <div class="pull-right" style="width: 95%; display: flex; justify-content: center; align-items: center;margin-left: 22px">
        <table>
            <tr>
                <th>
                    <img src="{{ public_path('/custom/img/nepza_logo.jpg') }}" style="width: 100px; height: 90px">
                </th>
                <th>
                    <p style="font-weight: bolder; font-size: 20px; color: #0c5460;"><b>NEPZA STAFF MULTIPURPOSE CO-OPERATIVE SOCIETY</b></p>
                    <p style="margin-top:-17px; font-size: 20px; font-weight: bolder; background-color: black;color: #FFFFFF; ">{{strtoupper(Auth::user()->name)}} COOP ACCOUNT</p>
                    <p style="margin-top: -17px; font-weight:bolder; font-size: 15px; background-color: black;color: #FFFFFF; ">LOAN STATEMENT FOR THE PERIOD {{date('d-M-Y',strtotime($start_date))}} TO {{date('d-M-Y',strtotime($end_date))}}</p>
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
                <td id="s">SN</td>
                <th id="s">DATE</th>
                <th id="s">LOAN TYPE</th>
                <th id="s">LOAN AMOUNT<br>(<del style="text-decoration-style: double">N</del>)</th>
                <th id="s">INTEREST RATE(%)</th>
                <th id="s">LOAN TENOR (MONTH)</th>
                <th id="s">TOTAL INTEREST PAYABLE (<del style="text-decoration-style: double">N</del>)</th>
                <th id="s">TOTAL AMOUNT PAYABLE (<del style="text-decoration-style: double">N</del>)</th>
            </tr>
            </thead>
            @php $counter =1; @endphp
            @foreach($loans as $loan)
                <tr id="s">
                    <td id="s">{{$counter++}}</td>
                    <td id="s">{{date('d-M-Y ', strtotime($loan->created_at))}}</td>
                    <td id="s">{{$loan->loan_type}}</td>
                    <td id="s" style="text-align: right"><span style="color: red">-{{number_format($loan->loan_amount,2)}}</span></td>
                    <td id="s" style="text-align: center">@if($loan->loan_type=='Household Equipment Loan'){{($loan->item_loan_rate*100)/100}}@else{{$loan->cash_loan_rate}}@endif</td>
                    <td id="s" style="text-align: center">@if($loan->loan_type=='Household Equipment Loan'){{$loan->item_loan_tenor}}@else{{$loan->cash_loan_tenor}}@endif</td>
                    <td id="s" style="text-align: right">{{number_format($loan->total_interest_payable,2)}}</td>
                    <td id="s" style="text-align: right">{{number_format($loan->total_amount_payable,2)}}</td>
                </tr>
            @endforeach
{{--            <tr id="figure"> <th colspan="7">TOTAL PAYABLE FOR THE PERIOD</th> <td style="text-align: right;font-size: 15px"><b>{{number_format($total_payable,2)}}</b></td></tr>--}}
{{--            <tr id="figure"> <th colspan="6">TOTAL INTEREST PAYABLE FOR THE PERIOD</th> <td style="text-align: right;font-size: 15px"><b>{{number_format($total_interest_payable,2)}}</b></td> <td></td> </tr>--}}
            <tr id="figure"> <th colspan="3">SUBTOTALs FOR THE PERIOD</th> <td style="text-align: right;font-size: 15px;"><b>{{number_format($total_loan,2)}}</b></td> <td></td><td></td><td><b style="text-align: right;font-size: 15px;">{{number_format($total_interest_payable,2)}}</b></td><td style="text-align: right;font-size: 15px;"><b>{{number_format($total_payable,2)}}</b></td></tr>

        </table>
    </div>
</div>
<style>
    #saving, #s{
        width: 100%;
        border: 0.4px solid;
        border-collapse: collapse;
        font-size: 12px;
    }
    tbody tr:nth-child(odd) {
        background: #eee;
    }

    #s th{
        border-collapse: collapse;
        font-size: 10px;
    }
    #figure td{
        border-collapse: collapse;
        font-size: 10px;
        border: 0.4px solid black ;
    }
    #figure th{
        text-align: left;
    }

</style>
</body>
</html>

