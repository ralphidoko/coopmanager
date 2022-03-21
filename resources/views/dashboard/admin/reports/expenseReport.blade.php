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
                <th>
                    <img src="{{ public_path('/custom/img/nepza_logo.jpg') }}" style="width: 100px; height: 90px">
                </th>
                <th>
                    <p style="font-weight: bolder; font-size: 20px; color: #0c5460;"><b>NEPZA STAFF MULTIPURPOSE CO-OPERATIVE SOCIETY</b></p>
                    <p style="margin-top: -17px; font-weight:bolder; font-size: 15px; background-color: black;color: #FFFFFF; ">EXPENSES BTW {{date('d-m-Y',strtotime($startDate))}} - {{date('d-m-Y',strtotime($endDate))}}</p>
                </th>
            </tr>
        </table>
    </div>
</div>
<div class="row col-md-10 col-lg-10 flex justify-content-center" style="width: 100%; display: flex; justify-content: center;">
    <div class="">
        <table id="saving">
            <thead>
            <tr id="s">
                <th id="s">Date</th>
                <th id="s">Vendor</th>
                <th id="s">Reference</th>
                <th id="s">Product/Service</th>
                <th id="s">Quantity</th>
                <th id="s">Unit Price(<del style="text-decoration-style: double">N</del>)</th>
                <th id="s">Sub Total(<del style="text-decoration-style: double">N</del>)</th>
                {{--<th id="s">Recorded By</th>--}}
            </tr>
            </thead>
            <tbody>
            @foreach($coopExpenses as $coopExpense)
                <tr id="s">
                    <td id="s">{{date('d-m-Y',strtotime($coopExpense->created_at))}}</td>
                    <td id="s">{{$coopExpense->vendor}}</td>
                    <td id="s" style="text-align: left">{{$coopExpense->description}}</td>
                    <td id="s" style="text-align: left">{{$coopExpense->product_service}}</td>
                    <td id="s" style="text-align: center">{{$coopExpense->quantity}}</td>
                    <td id="s" style="text-align: right"><del style="text-decoration-style: double">N</del>&#160;{{number_format($coopExpense->unit_price,2)}}</td>
                    <td id="s" style="text-align: right"><del style="text-decoration-style: double">N</del>&#160;{{number_format($coopExpense->total_price,2)}}</td>
                    {{--<td id="s">{{$coopExpense->salesperson->name}}</td>--}}
                </tr>
            @endforeach
            <tr id="figure">
                <th colspan="6" style="text-align: left; font-size: 13px;">Total Expenses</th> <td style="text-align: right;font-size: 13px"><b><del style="text-decoration-style: double">N</del>{{number_format($totalExpense,2)}}</b></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<style>
    #saving, #s{
        width: 100%;
        border-collapse: collapse;
        font-size: 10px;
    }
    #saving{
        float: left;
        margin-right: 20px ! important;
    }
    tbody tr:nth-child(odd) {
        background: #eee;
        border-bottom: 0.5px solid ! important;
    }
    th,td{
        border-bottom: 0.5px solid ! important;
        border-collapse: collapse;
    }

</style>
</body>
</html>




