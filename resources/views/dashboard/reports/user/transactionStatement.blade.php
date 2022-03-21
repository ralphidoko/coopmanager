<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
{{--<h1>{{ $title }}</h1>--}}
<div class="row col-md-10 col-lg-10 flex justify-content-center">
    <div class="pull-right" style="width: 95%; display: flex; justify-content: center; align-items: center;margin-left: 25px">
        <table>
            <tr>
                <th>
                    <img src="{{ public_path('/custom/img/nepza_logo.jpg') }}" style="width: 100px; height: 90px">
                </th>
                <th>
                    <p style="font-weight: bolder; font-size: 20px; color: #0c5460;"><b>NEPZA STAFF MULTIPURPOSE CO-OPERATIVE SOCIETY</b></p>
                    <p style="margin-top:-17px; font-size: 20px; font-weight: bolder; background-color: black;color: #FFFFFF; ">{{strtoupper(Auth::user()->name)}} COOP ACCOUNT</p>
                    <p style="margin-top: -17px; font-weight:bolder; font-size: 15px; background-color: black;color: #FFFFFF; ">TRANSACTIONS STATEMENT AS AT {{date('d M Y')}}</p>
                </th>
            </tr>
        </table>
    </div>
</div>
<div class="row col-md-10 col-lg-10 flex justify-content-center">
    <div class="pull-left" style="width: 100%; display: flex; justify-content: center; align-items: center;">
        <table id="saving">
            <thead>
            <tr id="rtd">
                <th>S/N</th>
                <th>Transaction Type</th>
                <th>Channel</th>
                <th>Transaction Reference</th>
                <th>Merchant</th>
                <th>Transaction Date</th>
                <th>Transaction Amount</th>
            </tr>
            </thead>
            <tbody>
            @php $counter = 1; @endphp
            @foreach($transactions as $transaction)
                <tr>
                    <th style="width: 10px ! important;">{{$counter++}}</th>
                    <td id="s">{{$transaction->transaction_type}}</td>
                    <td id="s">{{$transaction->channel}}</td>
                    <td id="s">{{$transaction->transaction_reference}}</td>
                    <td id="s">Paystack</td>
                    <td id="s">{{date('d-m-Y h:m:s',strtotime($transaction->created_at))}}</td>
                    <td id="s"><del style="text-decoration-style: double">N</del>{{number_format($transaction->transaction_amount,2)}}</td>
                </tr>
            @endforeach
                <tr id="figure">
                    <th colspan="6">SUBTOTAL</th> <td style="text-align: right;font-size: 15px"><b><del style="text-decoration-style: double">N</del>{{number_format($total_transaction,2)}}</b></td>
                </tr>

            </tbody>

        </table>
    </div>
</div>
<style>
    #saving, #s{
        width: 90%;
        border: 0.4px solid black;
        border-collapse: collapse;
        font-size: 12px;
    }
    #saving{
     float: left;
        margin-right: 20px ! important;
    }
    tbody tr:nth-child(odd) {
        background: #eee;
    }
    #rtd th{
        border: 0.4px solid black;
        border-collapse: collapse;
    }

</style>
</body>
</html>

