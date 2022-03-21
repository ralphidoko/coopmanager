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
        <?php $__currentLoopData = $paymentCharges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paymentCharge): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($paymentCharge->name =='Membership Renewal Fees'): ?> )
            <option id="<?php echo e($paymentCharge->id); ?>" value="<?php echo e($paymentCharge->fees_amount); ?>"><?php echo e($paymentCharge->name); ?></option>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select><br/>
    <div class="col-lg-12">
        <input type="number" id="extra_savings" style="display: none" class="col-md-5 form-control" placeholder="Enter amount to deposit e.g 20000">
    </div>
    <br/>
    <form method="POST" action="<?php echo e(route('pay')); ?>" accept-charset="UTF-8" class="form-horizontal" role="form">
        <div class="row" style="margin-bottom:40px; display: block !important;">
            <div class="col-md-8 col-md-offset-2">
                <input type="hidden" name="email" value="<?php echo e(Session::get('userEmail')); ?>"> 
                <input type="hidden" name="renewalID" id="renewalID" value="membership_renewal">
                <input type="hidden" name="memberID" id="memberID" value="<?php echo e(Session::get('memberID')); ?>">
                <input type="hidden" name="userID" id="userID" value="<?php echo e(Session::get('userID')); ?>">
                <input type="hidden" name="amount" class="amount" id="amount"> 
                <input type="hidden" name="quantity" value="1">
                <input type="hidden" name="currency" value="NGN">
                <input type="hidden" id="metadata" name="metadata" value="" > 
                <input type="hidden" name="reference" value="<?php echo e(Paystack::genTranxRef()); ?>"> 
                <?php echo csrf_field(); ?>
            </div>
            <p>
                <button class="btn btn-lm btn-block col-md-5" type="submit" id="extral" value="Pay Now!" style="background-color: #3C8DBC; color: #FFFFFF">
                    <i class="fa fa-plus fa-lg"></i> Proceed to Pay
                </button>
            </p>
            <?php echo $__env->make('flashMessages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
<?php /**PATH C:\xampp\htdocs\coopmanager\resources\views/dashboard/accountActivation/membershipRenewal.blade.php ENDPATH**/ ?>