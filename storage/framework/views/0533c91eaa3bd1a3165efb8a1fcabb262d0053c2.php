<?php $__env->startSection('header'); ?>
    <header class="main-header">
        <!-- Logo -->
    <?php echo $__env->make('dashboard.brand', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
            <?php echo $__env->make('dashboard.userProfileLink', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        </nav>
    </header>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard.navigation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php
if (! isset($_instance)) {
    $dom = \Livewire\Livewire::mount('allow-admin', [])->dom;
} elseif ($_instance->childHasBeenRendered('XG15vYF')) {
    $componentId = $_instance->getRenderedChildComponentId('XG15vYF');
    $componentTag = $_instance->getRenderedChildComponentTagName('XG15vYF');
    $dom = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('XG15vYF');
} else {
    $response = \Livewire\Livewire::mount('allow-admin', []);
    $dom = $response->dom;
    $_instance->logRenderedChild('XG15vYF', $response->id, \Livewire\Livewire::getRootElementTagName($dom));
}
echo $dom;
?>
<?php $__env->startSection('main-content'); ?>
    <div class="content-wrapper">
        
        <section class="content">
            <div class="box box-danger " style="margin-top: 70px;">
                    <div class="loader">
                        <img src="<?php echo e(asset('custom/img')); ?>/loader.gif" alt="" />
                    </div><br />
                    <hr>
                    <div role="form">
                        <div id="loan_infos" style="display:none; width:45%; text-align:center; margin:auto; font-size:23px; color: white; background-color:#3CB371">
                            Your current loan type is:
                        </div><br />
                        <div style="display: inline-flex;background-color: #4e555b;width: 30%; margin-left: 30px;" class="col-sm-5 col-md-10 col-lg-12 col-xs-12 hidden hidden-xs visible-lg">
                            <label style="color: #ffffff;padding-top:2px;text-transform: uppercase ">STANDING ORDER ON SAVING</label>
                        </div><br /><br /><br />
                        <form id="enrollmentForm">
                            <input type="text" hidden id="ippis_no" value="<?php echo e(\Illuminate\Support\Facades\Auth::user()->ippis_no); ?>" />
                            <?php echo csrf_field(); ?>
                            <div style="display: inline-flex;" class="col-md-10 col-lg-12">
                                <div class="form-group col-md-10 col-lg-12">
                                    <label>Full Name:</label>
                                    <select class="form-control col-md-10 col-lg-12" name="applicant" id="applicant" readonly disabled>
                                        <option selected value="<?php echo e(\Illuminate\Support\Facades\Auth::user()->name); ?>"><?php echo e(\Illuminate\Support\Facades\Auth::user()->name); ?></option>
                                    </select>
                                </div>
                            </div>
                            <div style="display: inline-flex;background-color: #4e555b;width: 30%; margin-left: 30px;" class="col-md-10 col-xs-4 col-lg-12 col-xs-12 hidden hidden-xs visible-lg">
                                <label style="color: #ffffff;padding-top:2px; ">AUTHORIZATION DETAILS</label>
                            </div> <br /> <br /><br />

                            <div style="display: inline-flex;" class="col-md-10 col-lg-12">
                                <div class="form-group col-md-10 col-lg-12">
                                    <label>Authorization Type:</label>
                                    <select class="form-control col-md-10 col-lg-12" id="auth_type">
                                        <option value="">Select authorization type</option>
                                        <option value="3">Authority to Deduct Pay</option>
                                        <option value="1">Increase My Saving</option>
                                        <option value="2">Decrease My Saving</option>
                                    </select>
                                    <p id="ErrorMsg" style="color:red"></p>
                                </div>
                            </div>
                            <div style="" class="col-md-10 col-lg-12" id="cash_loan">
                                <div style="display: inline-flex">
                                    <div class="form-group col-md-10 col-lg-10">
                                        <label for="cash_loan_amount">From Current Amount (<del style="text-decoration-style: double">N</del>)</label>
                                        <?php if($current_saving != null): ?>
                                            <input type="text" style="font-size: 25px; font-weight: bolder;" class="form-control" id="current_amount" value="<?php echo e(number_format($current_saving->authorized_amount,2)); ?>">
                                        <?php else: ?>
                                            <input type="number" min="1" oninput="validity.valid||(value='');" style="font-size: 25px; font-weight: bolder;" class="form-control" id="current_amount" value="">
                                        <?php endif; ?>
                                        <p id="caError" style="color:red"></p>
                                    </div>
                                </div>
                                <div style="display: inline-flex">
                                    <div class="form-group col-md-10 col-lg-10">
                                        <label for="desired_amount">To Desired Amount (<del style="text-decoration-style: double">N</del>)</label>
                                       <input type="text" id="desired_amount" oninput="setCustomValidity('')" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" style="font-size: 25px; font-weight: bolder;" class="form-control" value=" " data-type="currency" placeholder="20,000.00">
                                        <p id="daError" style="color:red"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-10 col-lg-12" style="display: none" id="auth_a">
                                <div style="display: inline-flex">
                                    <div class="form-group col-md-10 col-lg-10">
                                        <label for="authorized_amount">Amount to Deduct (<del style="text-decoration-style: double">N</del>)</label>
                                        <input input type="text"  id="authorized_amount" oninput="setCustomValidity('')" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" style="font-size: 25px; font-weight: bolder;" class="form-control" value="" data-type="currency" placeholder="20,000.00">
                                        <p id="aaError" style="color:red"></p>
                                    </div>
                                </div>
                            </div>
                            <div style="" class="col-md-10 col-lg-12" id="cash_loan">
                                <div style="display: inline-flex">
                                    <div class="form-group col-md-10 col-lg-12">
                                        <label for="start_date">Effective From:</label>
                                        <input type="date" style="font-size: 25px; font-weight: bolder;" class="form-control" id="start_date" >
                                        <p id="sdateError" style="color:red"></p>
                                    </div>
                                </div>
                            </div>
                            <div style="margin-bottom: 10px; display: none" class="col-md-10 col-lg-12" id="certification">
                                <div style="display: inline-flex; border: 1px solid;" id="certificate">
                                    <div class="form-group col-md-10 col-lg-12">
                                        <div class="checkbox">
                                            <label for="certification"><b>Certification:</b></label>
                                            <label>
                                                <input type="checkbox" id="certify">Consequently, I hereby authorize the Finance Department
                                                <b>(Salary Unit)</b> to deduct same from my salary and pay to NEPZA Staff Multipurpose Cooperative
                                                Society account each month until further notice of any change.
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <p id="certError" style="color:red"></p>
                            </div>
                            <div class="" align="center">
                                <button type="submit" id="submit_auth" data-token="<?php echo e(csrf_token()); ?>" class="btn btn-primary">Submit Authorization</button>
                            </div>
                        </form>
                    </div>
                </div>

            <script>
                $(document).ready(function(){
                    $("#current_amount").prop("disabled",true);
                    $("#desired_amount").prop("disabled",true);

                    $('#auth_type').on('change', function(){
                        if (this.value === '1'){
                            $("#cash_loan").show();
                            $("#auth_a").hide();
                            $("#current_amount").prop("disabled",true);
                            $("#desired_amount").prop('disabled',false);
                            $('#certification').hide();
                            $("#certify").prop("checked", false);
                        }
                        else if(this.value === '2') {
                            $("#current_amount").prop("disabled", true);
                            $("#desired_amount").prop('disabled', false);
                            $("#cash_loan").show();
                            $("#auth_a").hide();
                            $('#certification').hide();
                            $("#certify").prop("checked", false);
                        }else if(this.value === '3'){
                            $("#auth_a").show();
                            $("#cash_loan").hide();
                            $('#certification').show();
                        }else{
                            $("#current_amount").prop("disabled",true);
                            $("#desired_amount").prop("disabled",true);
                            $("#auth_a").css("display",false);
                            $('#certification').hide();
                            $("#certify").prop("checked", false);
                        }
                    });
                });
            </script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
            <script>
                toastr.options = {
                    "closeButton": true,
                    "newestOnTop": true,
                    "positionClass": "toast-top-right",
                    "showDuration": "1000",
                };

                $('#loan_info').fadeIn(9000).fadeOut(5000).fadeIn(9000).fadeOut(5000);

                $( "#submit_auth" ).on( "click", function(e) {
                    e.preventDefault();
                    let auth_type = $("#auth_type").val();
                    var current_amount = $("#current_amount").val();
                    let desired_amount = $("#desired_amount").val();
                    let authorized_amount = $("#authorized_amount").val();
                    let start_date = $("#start_date").val();
                    let auth_text = $("#auth_type option:selected").text();
                    let certify = $('#certify').prop('checked');
                    let ippis_no = $('#ippis_no').val();

                    if($("#auth_type option:selected").val() === "") {
                        $('#auth_type').css('border-color', 'red').focus();
                        $('#ErrorMsg').text('Please select a loan type');
                        $('#ErrorMsg').fadeOut(2000);
                        $('.loader').hide();
                        return false;
                    }

                    if($("#auth_type").val() == 1 && $("#desired_amount").val() === "") {
                        $('#desired_amount').css('border-color', 'red').focus();
                        $('#daError').text('Please enter desired amount');
                        $('#daError').fadeOut(2000);
                        $('.loader').hide();
                    }else if($("#auth_type").val() == 1 && $("#start_date").val() === ""){
                        $('#start_date').css('border-color', 'red').focus();
                        $('#sdateError').text('Please pick a day');
                        $('#sdateError').fadeOut(2000);
                        $('.loader').hide();
                    }else if($("#auth_type").val() == 2 && $("#desired_amount").val() === "") {
                        $('#desired_amount').css('border-color', 'red').focus();
                        $('#daError').text('Please enter desired amount');
                        $('#daError').fadeOut(2000);
                        $('.loader').hide();
                    }else if($("#auth_type").val() == 2 && $("#start_date").val() === "") {
                        $('#start_date').css('border-color', 'red').focus();
                        $('#sdateError').text('Please pick a day');
                        $('#sdateError').fadeOut(2000);
                        $('.loader').hide();
                    }else if($("#auth_type").val() == 3 && $("#authorized_amount").val() === "") {
                        $('#authorized_amount').css('border-color', 'red').focus();
                        $('#aaError').text('Please enter desired amount');
                        $('#aaError').fadeOut(2000);
                        $('.loader').hide();
                    }else if($("#auth_type").val() == 3 && $("#start_date").val() === "") {
                        $('#start_date').css('border-color', 'red').focus();
                        $('#sdateError').text('Please pick a day');
                        $('#sdateError').fadeOut(2000);
                        $('.loader').hide();
                    }else if($("#auth_type").val() == 3 && certify == false){
                            $('#certificate').css('border-color', 'red').focus();
                            $('#certError').text('Please check certification box');
                            $('#certError').fadeOut(2000);
                        $('.loader').hide();
                    }else{
                        $('.loader').show();

                        data = {
                            _token: "<?php echo e(csrf_token()); ?>",
                            current_amount: current_amount,
                            auth_type: auth_type,
                            desired_amount: desired_amount,
                            start_date: start_date,
                            auth_text: auth_text,
                            authorized_amount: authorized_amount,
                            certify: certify,
                            ippis_no: ippis_no,
                        };

                        $.ajax({
                            url: '<?php echo e(URL::to('/handleSavingAuthorization')); ?>',
                            type: 'POST',
                            dataType: 'json',
                            data: data,
                            success: function (response) {
                                if(response.message){
                                    $('.loader').hide();
                                    toastr.warning(response.message);
                                }else{
                                    $('.loader').hide();
                                    window.location=response.url;
                                }
                            },
                            error: function(response) {
                                //$('#caError').text(response.responseJSON.errors.current_amount);
                                $('#daErrorError').text(response.responseJSON.errors.desired_amount);
                                $('#sdateErrorError').text(response.responseJSON.errors.start_date);
                                $('#aaError').text(response.responseJSON.errors.authorized_amount);
                            }
                        });
                    }

                });
            </script>

            <style>
                .loader{
                    display: none;
                    position: absolute;
                    left: 50%;
                    top: 45%;
                    -webkit-transform: translate(-50%, -50%);
                    transform: translate(-50%, -50%);
                }
            </style>
        </section>
        <?php
if (! isset($_instance)) {
    $dom = \Livewire\Livewire::mount('change-password', [])->dom;
} elseif ($_instance->childHasBeenRendered('23eylU4')) {
    $componentId = $_instance->getRenderedChildComponentId('23eylU4');
    $componentTag = $_instance->getRenderedChildComponentTagName('23eylU4');
    $dom = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('23eylU4');
} else {
    $response = \Livewire\Livewire::mount('change-password', []);
    $dom = $response->dom;
    $_instance->logRenderedChild('23eylU4', $response->id, \Livewire\Livewire::getRootElementTagName($dom));
}
echo $dom;
?>
    </div>
        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <b>Version</b> 1.0.0
            </div>
            <strong>Copyright &copy; 2021 <a href="https://isosystemss.com" target="_blank">ISOSYSTEMS</a>.</strong> All rights
            reserved.
        </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-white">
        <!-- Tab panes -->
        <div class="tab-content">
            <!-- Home tab content -->
            <div class="tab-pane" id="control-sidebar-home-tab">

                <!-- /.control-sidebar-menu -->

                <!-- /.control-sidebar-menu -->

            </div>
        </div>
    </aside>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('dashboard.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\coopmanager\resources\views/dashboard/savings/savingStandingOrder.blade.php ENDPATH**/ ?>