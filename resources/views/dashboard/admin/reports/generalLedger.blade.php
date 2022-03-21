<!DOCTYPE html>
<html>
<body>
<div class="row col-md-10 col-lg-10 flex justify-content-center" style="margin-bottom: 40px">
    <span style="font-size: 10px;">Printed: {{date('F j, Y, g:i a',strtotime(now().'+1 hours'))}}</span>
        <div class="" style="width: 100%; justify-content: center;">
            <div><img src="{{ public_path('/custom/img/nepza_logo.jpg') }}" style="width: 80px; height: 70px"></div>
            <div style="margin-left: 100px; margin-top: -40px;width: 500px; font-weight: bold; font-size: 15px; background-color: white;text-align: center">NEPZA STAFF MULTIPURPOSE CO-OPERATIVE SOCIETY</div>
        </div>
        <div class="row col-md-10 col-lg-10 flex justify-content-center" style="margin-top: 30px; margin-left: 15px;font-size:10px;">
            <div style="float: left">
                Journals
            </div>
            <div style="float: left;padding-left: 70px">
                Display Accounts With Movements: &#160;&#160;
                Filtered Date:{{date('d-m-Y',strtotime($startDate))}} - {{date('d-m-Y',strtotime($endDate))}}
            </div>
            <div style="float: left; padding-left:90px">
                Target Moves: &#160;&#160; All Posted Entries
            </div>
        </div>
</div>
<div class="row col-md-10 col-lg-10 flex justify-content-center">
    <div class="pull-right" style="width: 100%; display: flex; justify-content: center; align-items: center;">
        <table id="saving">
            <thead style="border-bottom: 0.5px solid ! important">
            <tr id="s">
                <th id="s">Date</th>
                <th id="s">Vendor</th>
                <th id="s">Description</th>
                <th id="s">Move</th>
                <th id="s">Debit(<del style="text-decoration-style: double">N</del>)</th>
                <th id="s">Credit(<del style="text-decoration-style: double">N</del>)</th>
                <th id="s">Cumulative Balance(<del style="text-decoration-style: double">N</del>)</th>
            </tr>
            </thead>
            <tbody>
            @foreach($chartOfAccounts as $chartOfAccount)
                @php
                    $balance = 0;
                    $relatedEntries = \App\GeneralLedger::where('coa_id',$chartOfAccount->id)->whereBetween('created_at', [$startDate, $endDate])->get();
                    foreach($relatedEntries as $value){
                         $balance = ($value->debit != 0.00) ?
                         $balance + $value->debit : $balance + $value->credit;
                    }
                @endphp
                @if($balance != 0.00)
                    <tr id="s">
                        <td id="s" colspan="2"><b>{{$chartOfAccount->code.' '.$chartOfAccount->name}}</b></td>
                        <td id="" colspan="6" style="text-align: right;padding-right: 20px;"><b><del style="text-decoration-style: double">N</del>{{number_format($balance,2)}}</b></td>
                    </tr>
                    @foreach($relatedEntries as $relatedEntry)
                        <tr id="s">
                            <td id="s">{{date('d-m-Y',strtotime($relatedEntry->created_at))}}</td>
                            <td id="s">{{$relatedEntry->vendor}}</td>
                            <td id="s">{{$relatedEntry->reference}}</td>
                            <td id="s">{{$relatedEntry->move}}</td>
                            <td id="s" style="text-align: right"><del style="text-decoration-style: double">N</del>&#160;-{{number_format($relatedEntry->debit,2)}}</td>
                            <td id="s" style="text-align: right"><del style="text-decoration-style: double">N</del>{{number_format($relatedEntry->credit,2)}}</td>
                            <td id="s"></td>
                        </tr>
                    @endforeach
                @endif
            @endforeach
            </tbody>
        </table>
    </div>
</div>
<style>
    #saving, #s{
        width: 100%;
        border-collapse: collapse;
        font-size: 10px ! important;
    }
    tbody tr:nth-child(odd) {
        background: #eee;
    }
    thead th{
        font-size: 12px ! important;
    }
    #journal #j {
        width: 50% ! important;
        overflow: hidden;
        font-size: 10px;
        white-space: nowrap;
    }
</style>
</body>
</html>

