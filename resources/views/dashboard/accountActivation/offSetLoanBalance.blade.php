<!DOCTYPE html>
<html lang="en">
<head>
    <title>Nepza Cooperative</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body style="background-color: #ECF0F5">
     <br /><br />
    <div class="container mt-3" align="center">
        <div class="inner-container" style="margin-top: 10px ! important">
            <h3>Paying Outstanding Loan Balance</h3>
            <br />
            <div style=" width: 40%; height: 100px; display: none" id="visible_amount">
                <p style="font-size: 20px ! important;font-weight: bold; text-justify: auto; margin-top:30px">Your total outstanding loan balance is: <del style="text-decoration-style: double">N</del>{{number_format(round($unpaid_installments),2)}}</p>
            </div>
            <br/>
            <select class="form-control col-md-5" id="sel_price">
                <option value="selected" selected>Select payment type</option>
                <option value="{{$unpaid_installments}}">Loan Balance</option>
            </select>
            <br/>
            <form method="POST" action="{{route('pay')}}" accept-charset="UTF-8" class="form-horizontal" role="form">
                <div class="row" style="margin-bottom:40px; display: block !important;">
                    <div class="col-md-8 col-md-offset-2">
                        <input type="hidden" name="email" value="{{Auth::User()->email}}"> {{-- required --}}
                        <input type="hidden" name="orderID" value="345">
                        <input type="hidden" name="amount" id="amount"> {{-- required in kobo --}}
                        <input type="hidden" name="quantity" value="1">
                        <input type="hidden" name="currency" value="NGN">
                        <input type="hidden" name="metadata" value="{{ json_encode($array = ['type' => 'loan_balance','loan_id'=>$loan_id]) }}" > {{-- For other necessary things you want to add to your payload. it is optional though --}}
                        <input type="hidden" name="reference" value="{{ Paystack::genTranxRef() }}"> {{-- required --}}
                        @csrf
                    </div>
                    <p>
                        <button class="btn btn-lm btn-block col-md-5" type="submit" value="Pay Now!" style="background-color: #3C8DBC; color: #FFFFFF">
                            <i class="fa fa-plus fa-lg"></i> Proceed to Pay
                        </button>
                    </p>
                    @include('flashMessages')
                </div>
                <script type="text/javascript">
                    $(function(){
                        $('#sel_price').change(function(){
                            //var IdCanton = '00';
                            var selected = $(this).find('option:selected').val();
                            var hide = $(this).find('option:selected').val();
                            document.getElementById('amount').value=selected*100;
                            $("#visible_amount").show();
                            if(hide === 'selected'){$("#visible_amount").hide();}

                        });
                    })
                </script>
            </form>
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
    </div>
</body>

</html>




