<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
<div class="row col-md-10 col-lg-10 flex justify-content-center">
    <span style="font-size: 10px;">Printed: {{date('F j, Y, g:i a',strtotime(now().'+1 hours'))}}</span>
    <div class="pull-right" style="width: 100%; display: flex; justify-content: center; align-items: center;">
        <table>
            <tr>
                <th><img src="{{ public_path('/custom/img/nepza_logo.jpg') }}" style="width: 100px; height: 90px"></th>
                <th>
                    <p style="font-weight: bolder; font-size: 20px; color: #0c5460;"><b>NEPZA STAFF MULTIPURPOSE CO-OPERATIVE SOCIETY</b></p>
                    <p style="margin-top: -17px; font-weight:bolder; font-size: 15px; background-color: black;color: #FFFFFF; ">MEMBERS' TRANSACTION LEDGER</p>
                    <p style="margin-top: -17px; font-weight:bolder; font-size: 15px; background-color: black;color: #FFFFFF; ">FILTERED DATE {{date('d-m-Y',strtotime($startDate))}} - {{date('d-m-Y',strtotime($endDate))}}</p>
                </th>
            </tr>
        </table>
    </div>
</div>
<div class="row col-md-10 col-lg-10 flex justify-content-center">
    <div>
        <table id="saving" style="width: 100vw ! important">
            <thead>
            <tr id="s">
                <th id="s">S/N</th>
                <th id="s" colspan="3">MEMBER NAME</th>
                <th id="a" colspan="1">TOTAL TRANSACTION &#160;(<del style="text-decoration-style: double">N</del>)</th>
            </tr>
            </thead>
            <tbody>
            @php $counter=1;@endphp
            @foreach($memberTotalTransactions as $memberTotalTransaction)
                <tr id="a">
                    <td id="a">{{$counter++}}</td>
                    <td id="a" colspan="3" style="text-align: center">{{$memberTotalTransaction->users->name}}</td>
                    <td id="a" colspan="1" style="text-align: right;">{{number_format($memberTotalTransaction->total_transaction,2)}}</td>
                </tr>
            @php
                $userTransactions = \App\Transaction::where('user_id',$memberTotalTransaction->user_id)->get();
            @endphp
            <thead>
            <tr id="header">
                <th width="100">Transaction Date</th>
                <th width="120">Transaction Type</th>
                <th>Transaction Reference</th>
                <th>Channel</th>
                <th>Amount(<del style="text-decoration-style: double">N</del>)</th>
            </tr>
            </thead>
            @foreach($userTransactions as $userTransaction)
                <tr>
                    <td width="100">{{date("d-M-Y h:m:s",strtotime($userTransaction->created_at))}}</td>
                    <td width="120">{{$userTransaction->transaction_type}}</td>
                    <td>{{$userTransaction->transaction_reference}}</td>
                    <td>{{$userTransaction->channel}}</td>
                    <td style="text-align: right"><del style="text-decoration-style: double;">N</del>{{number_format($userTransaction->transaction_amount,2)}}</td>
                </tr>
            @endforeach
            @endforeach
            <tr id="figure" style="border: 1px solid #0a0a0a ! important;font-size: 20px; font-weight: bold">
                <td colspan="2"><b>Total Transaction</b></td>
                <td style="text-align: right ! important;" colspan="3"><b>{{number_format($totalTransaction,2)}}</b></td>
            </tr>
        </table>
    </div>
</div>
<style>
    #saving, #s{
        border: 0.4px solid;
        border-collapse: collapse;
        font-size: 11px;
    }
    tbody tr:nth-child(odd) {
        background: #eee;
    }

    table thead th{
        font-size: 11px ! important;
        border: 0.4px solid black;
    }
    #a{
        border: 0.4px solid;
        border-collapse: collapse;
        font-size: 15px;
    }
</style>
</body>
</html>


