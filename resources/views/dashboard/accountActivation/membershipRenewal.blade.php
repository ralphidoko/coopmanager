<!DOCTYPE html>
<html lang="en">
<head>
    <title>CoopManager</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body style="background-color: #ECF0F5">
<br /><br /><br /><br />
<div class="container mt-3" align="center" style="margin-top: 20px;">
    <h4>To proceed, select applicable payment type and click on proceed to pay</h4>
    <br />
    <div style=" width: 40%; height: 80px; display:none" id="visible_amount">
        <p id="display_amount" style="font-size: 16px ! important;font-weight: bold; text-justify: auto; margin-top:10px"></p>
    </div>
    <select class="form-control col-md-5" id="sel_price">
        <option value="selected" selected>Select payment type</option>
        @foreach($paymentCharges as $paymentCharge)
            @if($paymentCharge->name =='Membership Renewal Fees') )
            <option id="{{$paymentCharge->id}}" value="{{$paymentCharge->fees_amount}}">{{$paymentCharge->name}}</option>
            @endif
        @endforeach
    </select><br/>
    <div class="col-lg-12">
        <input type="number" id="extra_savings" style="display: none" class="col-md-5 form-control" placeholder="Enter amount to deposit e.g 20000">
    </div>
    <br/>
    <form method="POST" action="{{route('pay')}}" accept-charset="UTF-8" class="form-horizontal" role="form">
        <div class="row" style="margin-bottom:40px; display: block !important;">
            <div class="col-md-8 col-md-offset-2">
                <input type="hidden" name="email" value="{{Session::get('userEmail')}}"> {{-- required --}}
                <input type="hidden" name="renewalID" id="renewalID" value="membership_renewal">
                <input type="hidden" name="memberID" id="memberID" value="{{Session::get('memberID')}}">
                <input type="hidden" name="userID" id="userID" value="{{Session::get('userID')}}">
                <input type="hidden" name="amount" class="amount" id="amount"> {{-- required in kobo --}}
                <input type="hidden" name="quantity" value="1">
                <input type="hidden" name="currency" value="NGN">
                <input type="hidden" id="metadata" name="metadata" value="" > {{-- For other necessary things you want to add to your payload. it is optional though --}}
                <input type="hidden" name="reference" value="{{ Paystack::genTranxRef() }}"> {{-- required --}}
                @csrf
            </div>
            <p>
                <button class="btn btn-lm btn-block col-md-5" type="submit" id="extral" value="Pay Now!" style="background-color: #3C8DBC; color: #FFFFFF">
                    <i class="fa fa-plus fa-lg"></i> Proceed to Pay
                </button>
            </p>
            @include('flashMessages')
        </div>
    </form>
    <script type="text/javascript">
        $(function(){
            $('#sel_price').change(function(){
                var selected = $(this).find('option:selected').val();
                var feeID = $(this).find('option:selected').attr('id');
                var renewalID = $('#renewalID').val();var userID = $('#userID').val();var memberID = $('#memberID').val();
                if(selected !== 'selected'){
                    let metadataArray = [];metadataArray.push(feeID);metadataArray.push(renewalID);metadataArray.push(userID);metadataArray.push(memberID);
                    $("#metadata").val(JSON.stringify(metadataArray));
                    $("#visible_amount").show();
                    var amountPayable = parseFloat(selected);
                    var finalAmountPayable,applicableFee = 0,cappedAmount = 2000;
                    if(amountPayable < 2500){
                        applicableFee = parseFloat((1.5/100) * amountPayable);
                        finalAmountPayable = parseFloat((amountPayable / (1- (1.5/100))) + 0.01);
                    }else if(amountPayable >= 2500){
                        applicableFee = parseFloat(((1.5/100) * amountPayable) + 100);
                        if(applicableFee > cappedAmount){
                            applicableFee = cappedAmount;
                            finalAmountPayable = parseFloat(amountPayable + cappedAmount);
                        }else{
                            finalAmountPayable =parseFloat(((amountPayable + 100) / (1 - (1.5/100))) + 0.01);
                        }
                    }
                    document.getElementById('amount').value=finalAmountPayable.toFixed(2)*100;
                    $("#display_amount").html('Amount Payable: '+formatter.format(amountPayable) +"<br/>"+
                        'Gateway Charge: '+formatter.format(applicableFee) +"<br/>"+
                        'Sub Total: ' +formatter.format(finalAmountPayable));
                }else{
                    document.getElementById('amount').value='';
                    $("#visible_amount").hide();
                }
            });
        })
        var formatter = new Intl.NumberFormat('en-NG', {
            style: 'currency',
            currency: 'NGN',
        });
    </script>
    <style>
        .container {
            box-shadow: rgba(0, 0, 0, 0.09) 0px 3px 12px;
        ;
            min-height: 200px;
            margin: 100px auto;
            background: white;
            border-radius: 5px;
            width: 70%;
            height: 400px;
            padding-top:20px;
        }
    </style>
</div>
</body>
</html>
