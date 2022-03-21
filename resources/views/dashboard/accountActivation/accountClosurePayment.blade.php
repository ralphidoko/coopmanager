<!DOCTYPE html>
<html lang="en">
<head>
    <title>CoopManager</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body style="background-color: #ECF0F5">
<br /><br /><br /><br />
<div class="container mt-3" align="center" style="margin-top: 20px;">
    <h3>To proceed, select applicable payment type and click on proceed to pay</h3>
    <br />
    <div style=" width: 40%; height: 80px; display:none" id="visible_amount">
        <p id="display_amount" style="font-size: 20px ! important;font-weight: bold; text-justify: auto; margin-top:30px"></p>
    </div>
    <select class="form-control col-md-5" id="sel_price">
        <option value="" selected>Select payment type</option>
        <option value="250">Account Closure Fees</option>
    </select><br/>
    <div class="col-lg-12">
        <input type="number" id="extra_savings" style="display: none" class="col-md-5 form-control" placeholder="Enter amount to deposit e.g 20000">
    </div>
    <br/>
    <form method="POST" action="{{route('pay')}}" accept-charset="UTF-8" class="form-horizontal" role="form">
        <div class="row" style="margin-bottom:40px; display: block !important;">
            <div class="col-md-8 col-md-offset-2">
                <input type="hidden" name="email" value="{{Auth::user()->email}}"> {{-- required --}}
                <input type="hidden" name="memberID" value="">
                <input type="hidden" name="amount" class="amount" id="amount"> {{-- required in kobo --}}
                <input type="hidden" name="quantity" value="1">
                <input type="hidden" name="currency" value="NGN">
                <input type="hidden" name="metadata" value="{{ json_encode($array = ['type' => 'account_closure',]) }}" > {{-- For other necessary things you want to add to your payload. it is optional though --}}
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
        var extra_amt = $('#extra_savings').val();
        $(function(){
            $('#sel_price').change(function(){
                var selected = $(this).find('option:selected').val();
                if(selected !== ""){
                    $("#visible_amount").show();
                    document.getElementById('amount').value=selected+'00';
                    $("#display_amount").html('Amount payable for the payment type you have selected, is '+formatter.format(selected));  // set your input price with jquery
                    $("#extra_savings").hide();
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
