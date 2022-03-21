<section class="content" xmlns:wire="http://www.w3.org/1999/xhtml" xmlns:nwire="http://www.w3.org/1999/xhtml">
    <div class="row col-md-10 col-lg-10 flex justify-content-center">
        <div class="box box-primary " style="padding: 10px;">
          <?php echo $__env->make('dashboard.coopLogo', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="loader">
                <img src="<?php echo e(asset('custom/img')); ?>/loader.gif" alt="" />
            </div>
            <br /><br />
            <div role="form">
                <div style="margin-left: 30px; display:inline-flex">
                </div>
                <hr><br />
                    <div style="display: inline-flex;background-color: #4e555b;width: 30%; margin-left: 30px;" class="col-md-10 col-lg-12">
                        <label style="color: #ffffff;padding-top:2px; ">LOAN APPLICANT</label>
                    </div><br />
                <form name="loanApplication" wire:submit.prevent="submitLoanApplication" novalidate="novalidate">
                    <div style="display: inline-flex;" class="col-md-10 col-lg-12">
                        <div class="form-group col-md-10 col-lg-12">
                            <label>Full Name:</label>
                            <select class="form-control col-md-10 col-lg-12" wire:model.debounce.500ms="applicant" readonly disabled>
                                <option selected value="<?php echo e(\Illuminate\Support\Facades\Auth::user()->name); ?>"><?php echo e(\Illuminate\Support\Facades\Auth::user()->name); ?></option>
                            </select>
                            <?php $__errorArgs = ['applicant'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-md"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div style="display: inline-flex;background-color: #4e555b;width: 30%; margin-left: 30px;" class="col-md-10 col-lg-12">
                        <label style="color: #ffffff;padding-top:2px; ">LOAN DETAILS</label>
                    </div>

                    <div style="display: inline-flex;" class="col-md-10 col-lg-12" wire:ignore>
                        <div class="form-group col-md-10 col-lg-12">
                            <label>Loan Type:</label>
                            <select class="form-control col-md-10 col-lg-12" wire:model="loan_type" id="loan_type">
                                <option value="" selected>Select loan type</option>
                                <option value="1">Cash Loan</option>
                                <option value="2">Household Equipment Loan</option>
                            </select>
                            <p id="ErrorMsg" style="color:red"></p>
                        </div>
                    </div>
                    <div style="" class="col-md-10 col-lg-12" id="cash_loan" wire:ignore>
                        <div style="display: inline-flex">
                            <div class="form-group col-md-10 col-lg-10">
                                <label for="cash_loan_amount">Loan Amount (<del style="text-decoration-style: double">N</del>)</label>
                                <input input type="text" oninput="setCustomValidity('')" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" style="font-size: 25px; font-weight: bolder;" wire:model.debounce.500ms="cash_loan_amount" id="cash_loan_amount" class="form-control" data-type="currency" placeholder="20,000.00">
                                <p id="LErrorMsg" style="color:red"></p>
                            </div>
                            <div class="form-group col-md-10 col-lg-10">
                                <label for="interest_rate">Interest Rate(%)</label>
                                <input style="font-size: 25px; font-weight: bolder;" type="text" class="form-control" wire:model="cash_loan_rate" placeholder="7%" readonly>
                                <?php $__errorArgs = ['cash_loan_rate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-md"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-group col-md-10 col-lg-10">
                                <label for="duration">Repayment Duration (Months)</label>
                                <input style="font-size: 25px; font-weight: bolder;" type="text" class="form-control" wire:model="cash_loan_tenor" placeholder="24 Months" readonly>
                                <?php $__errorArgs = ['cash_loan_tenor'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-md"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                    </div>
                    <div style="" class="col-md-10 col-lg-12" id="item" wire:ignore>
                        <div style="display: inline-flex">
                             <div class="form-group col-md-10 col-lg-10" wire:ignore>
                                    <label>Household Equipment:</label>
                                    <select class="form-control col-md-10 col-lg-10" wire:model.debounce.500ms="item_name" id="item_name">
                                        <option value="" selected>Select item</option>
                                            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                              <option value="<?php echo e($item->id); ?>"><?php echo e($item->item_name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                 <p id="IErrorMsg" style="color:red"></p>
                             </div>

                            <div class="form-group col-md-10 col-lg-10">
                                <label for="interest_rate">Interest Rate(%)</label>
                                <input style="font-size: 25px; font-weight: bolder;" type="text" class="form-control" wire:model="item_rate" placeholder="3%" readonly>
                                <?php $__errorArgs = ['item_rate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-md"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-group col-md-10 col-lg-10">
                                <label for="item_loan_tenor">Repayment Duration</label>
                                <input style="font-size: 25px; font-weight: bolder;" type="text" class="form-control" wire:model="item_loan_tenor" placeholder="6 Months" readonly>
                                <?php $__errorArgs = ['item_loan_tenor'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-md"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                    </div>
                    <div style="display: inline-flex;background-color: #4e555b;width: 30%; margin-left: 30px;" class="col-md-10 col-lg-12">
                        <label style="color: #ffffff;padding-top:2px; ">LOAN GUARANTOR NO. 1</label>
                    </div>
                    <div style="display: inline-flex;" class="col-md-10 col-lg-12">
                        <div class="form-group col-md-10 col-lg-12">
                            <label>Full Name:</label>
                            <select class="form-control col-md-10 col-lg-12" wire:model.debounce.500ms="guarantor_one" id="guarantor_one">
                               <option value="" selected>Select first guarantor</option>
                                <?php if(auth()->guard()->check()): ?>
                                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($user->phone_no); ?>"><?php echo e($user->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </select>
                            <p id="G1ErrorMsg" style="color:red"></p>
                        </div>
                    </div>
                    <div style="display: inline-flex;background-color: #4e555b;width: 30%; margin-left: 30px;" class="col-md-10 col-lg-12">
                        <label style="color: #ffffff;padding-top:2px; ">LOAN GUARANTOR NO. 2</label>
                    </div>
                    <div style="display: inline-flex;" class="col-md-10 col-lg-12">
                        <div class="form-group col-md-10 col-lg-12">
                            <label>Full Name:</label>
                            <select class="form-control col-md-10 col-lg-12" wire:model.debounce.500ms="guarantor_two" id="guarantor_two">
                                <option value="" selected>Select second guarantor</option>
                                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($user->phone_no); ?>"><?php echo e($user->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <p id="G2ErrorMsg" style="color:red"></p>
                        </div>
                    </div>
                    <div class="form-group col-md-10 col-lg-10">
                        <div>
                            <?php if(session()->has('message')): ?>
                                <div class="alert alert-success">
                                    <?php echo e(session('message')); ?>

                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="" align="center">
                        <button type="submit" class="btn btn-primary">Submit Application</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

<script>
    $(document).ready(function(){
        $("#cash_loan_amount").prop("disabled",true);
         $("#item_name").prop("disabled",true);

        $('#loan_type').on('change', function(){
            if (this.value === '1'){
               // $("#cash_loan").show();
                $("#cash_loan_amount").prop("disabled",false);
                $("#item_name").prop('disabled',true);
            }
            else if(this.value === '2'){
                $("#cash_loan_amount").prop("disabled",true);
                $("#item_name").prop('disabled',false);
               // $("#item").show();
            }else{
                $("#cash_loan_amount").val('');
                $("#cash_loan_amount").prop("disabled",true);
                $("#item_name").val('');
                $("#item_name").prop('disabled',true);
            }
        });
    });
</script>
    <script>
        $(document).ready(function(){
            $('.btn').on('click', function(){
                $('.loader').show();

                if($("#loan_type option:selected").val() === "") {
                    $('.loader').hide();
                    $('#loan_type').css('border-color', 'red').focus();
                    $('#ErrorMsg').text('Please select a loan type');
                    $('#ErrorMsg').fadeOut(2000);
                    return false;
                }
                if($("#loan_type option:selected").val() == 1 && $("#cash_loan_amount").val() === "") {
                    $('.loader').hide();
                    $('#cash_loan_amount').css('border-color', 'red').focus();
                    $('#LErrorMsg').text('Please enter loan amount');
                    $('#LErrorMsg').fadeOut(2000);
                    return false;
                }
                if($("#loan_type option:selected").val() == 2 && $("#item_name").val() === "") {
                    $('#item_name').css('border-color', 'red').focus();
                    $('#IErrorMsg').text('Please select item');
                    $('#IErrorMsg').fadeOut(2000);
                }
                if($("#guarantor_one option:selected").val() === "") {
                    $('.loader').hide();
                    $('#guarantor_one').css('border-color', 'red').focus();
                    $('#G1ErrorMsg').text('Please select first guarantor');
                    $('#G1ErrorMsg').fadeOut(2000);
                    return false;
                }
                if($("#guarantor_two option:selected").val() === "") {
                    $('.loader').hide();
                    $('#guarantor_two').css('border-color', 'red').focus();
                    $('#G2ErrorMsg').text('Please select second guarantor');
                    $('#G2ErrorMsg').fadeOut(2000);
                    return false;
                }
            });
        });
    </script>
    <style>
        .loader{
            display: none;
            position: absolute;
            left: 50%;
            top: 50%;
            -webkit-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
        }
    </style>

    <script>
        // Jquery Dependency
        $("input[data-type='currency']").on({
            keyup: function() {
                formatCurrency($(this));
            },
            blur: function() {
                formatCurrency($(this), "blur");
            }
        });

        function formatNumber(n) {
            // format number 1000000 to 1,234,567
            return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        }

        function formatCurrency(input, blur) {
            // appends $ to value, validates decimal side
            // and puts cursor back in right position.

            // get input value
            var input_val = input.val();

            // don't validate empty input
            if (input_val === "") { return; }

            // original length
            var original_len = input_val.length;

            // initial caret position
            var caret_pos = input.prop("selectionStart");

            // check for decimal
            if (input_val.indexOf(".") >= 0) {

                // get position of first decimal
                // this prevents multiple decimals from
                // being entered
                var decimal_pos = input_val.indexOf(".");

                // split number by decimal point
                var left_side = input_val.substring(0, decimal_pos);
                var right_side = input_val.substring(decimal_pos);

                // add commas to left side of number
                left_side = formatNumber(left_side);

                // validate right side
                right_side = formatNumber(right_side);

                // On blur make sure 2 numbers after decimal
                if (blur === "blur") {
                    right_side += "00";
                }

                // Limit decimal to only 2 digits
                right_side = right_side.substring(0, 2);

                // join number by .
                input_val = "" + left_side + "." + right_side;

            } else {
                // no decimal entered
                // add commas to number
                // remove all non-digits
                input_val = formatNumber(input_val);
                input_val = "" + input_val;

                // final formatting
                if (blur === "blur") {
                    input_val += ".00";
                }
            }

            // send updated string to input
            input.val(input_val);

            // put caret back in the right position
            var updated_len = input_val.length;
            caret_pos = updated_len - original_len + caret_pos;
            input[0].setSelectionRange(caret_pos, caret_pos);
        }
    </script>

</section>








<?php /**PATH C:\xampp\htdocs\coopmanager\resources\views/livewire/loan-application.blade.php ENDPATH**/ ?>