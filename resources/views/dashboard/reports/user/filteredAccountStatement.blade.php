<!DOCTYPE html>
<html>
<head>
    <title>Hi</title>
</head>
<body>
{{--<h1>{{ $title }}</h1>--}}
<div class="row col-md-10 col-lg-10 flex justify-content-center">
    <div class="pull-right" style="width: 100%; display: flex; justify-content: center; align-items: center;">
        <table style="">
            <tr>
                <th>
                    <img src="{{ public_path('/custom/img/nepza_logo.jpg') }}" style="width: 100px; height: 90px">
                </th>
                <th>
                    <p style="font-weight: bolder; font-size: 20px; color: #0c5460;"><b>NEPZA STAFF MULTIPURPOSE CO-OPERATIVE SOCIETY</b></p>
                    <p style="margin-top:-17px; font-size: 17px; font-weight: bolder; background-color: black;color: #FFFFFF; ">{{strtoupper(Auth::user()->name)}} COOP ACCOUNT</p>
                    <p style="margin-top: -17px; font-weight:bolder; font-size: 15px; background-color: black;color: #FFFFFF; ">STATEMENT FOR THE PERIOD {{date('d-M-Y',strtotime($start_date))}} TO {{date('d-M-Y',strtotime($end_date))}}</p>
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
                <th id="s">DATE</th>
                <th id="s">DESCRIPTION</th>
                <th id="s">CREDIT/DEPOSIT</th>
                <th id="s">DEBIT/WITHDRAWAL</th>
                <th id="s">BALANCE</th>
            </tr>
            </thead>
            <tbody>
            @foreach($savings as $saving)
                <tr id="s">
                    <td id="s">@if($saving->month){{date('d/m/Y', strtotime($saving->month))}}@endif</td>
                    <td id="s">{{$saving->description}}</td>
                    <td id="s" style="text-align: right">
                        @if($saving->amount_saved > 0.00)
                            <span style="color: green">{{number_format($saving->amount_saved,2)}}</span>
                        @else
                            <span class="label"></span>
                        @endif
                    </td>
                    <td id="s" style="text-align: right">
                        @if($saving->amount_withdrawn > 0.00)
                            <span style="color: red">{{number_format($saving->amount_withdrawn,2)}}
                        @endif
                    </td>
                    <td id="s" style="text-align: right">{{number_format($saving->balance,2)}}</td>
                </tr>
            @endforeach
            <tr id="figure">
                <th colspan="2">ACCOUNT BALANCE</th><td style="text-align: right;font-size: 15px;background-color: #0a0a0a;color: #FFFFFF"><b>{{number_format($total_savings,2)}}</b></td> <td style="text-align: right;font-size: 15px;background-color: #0a0a0a;color: #FFFFFF"><b>{{number_format($total_withdrawal,2)}}</b></td><td style="text-align: right;font-size: 15px;background-color: #0a0a0a;color: #FFFFFF"><b>{{number_format($total_savings - $total_withdrawal,2)}}</b></td>
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
