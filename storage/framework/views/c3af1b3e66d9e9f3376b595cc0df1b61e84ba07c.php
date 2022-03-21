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
} elseif ($_instance->childHasBeenRendered('ZlJ1JQ5')) {
    $componentId = $_instance->getRenderedChildComponentId('ZlJ1JQ5');
    $componentTag = $_instance->getRenderedChildComponentTagName('ZlJ1JQ5');
    $dom = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('ZlJ1JQ5');
} else {
    $response = \Livewire\Livewire::mount('allow-admin', []);
    $dom = $response->dom;
    $_instance->logRenderedChild('ZlJ1JQ5', $response->id, \Livewire\Livewire::getRootElementTagName($dom));
}
echo $dom;
?>
<?php $__env->startSection('main-content'); ?>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content" xmlns:wire="http://www.w3.org/1999/xhtml" xmlns:nwire="http://www.w3.org/1999/xhtml">
            <div class="row col-md-10 col-lg-10 flex justify-content-center">
                <div class="box box-primary " style="padding: 10px;">
                    
                    <div class="loader">
                        <img src="<?php echo e(asset('custom/img')); ?>/loader.gif" alt="" />
                    </div>
                    <br />
                    <hr><br />
                    <div role="form">
                        <div style="display: inline-flex; margin-left: 10px;">
                            <div style="background-color: #4e555b;width: auto;" class="col-md-12 col-lg-12">
                                <label style="color: #ffffff;padding-top:4px;">SAVINGS WITHDRAWAL REQUEST</label>
                            </div>
                            <button  id="make_request" class="btn btn-primary" style="margin-left: 15px;font-weight: bold">Start Request</button>
                            <button  id="cancel_request" class="btn btn-danger" style="margin-left: 15px;font-weight: bold">Cancel Request</button>
                        </div>
                        <br /><br /><br />
                        <form id="enrollmentForm">
                            <?php echo csrf_field(); ?>
                            <div class="col-md-10 col-lg-12" style="display: none" id="request_div">
                                <div style="display: inline-flex;">
                                    <div class="form-group col-md-10 col-lg-5">
                                        <label for="authorized_amount">Account Balance (<del style="text-decoration-style: double">N</del>)</label>
                                        <input type="text" readonly style="font-size: 25px; font-weight: bolder;" value="<?php echo e(number_format($acc_bal,2)); ?>" class="form-control">
                                        <p id="aaError" style="color:red"></p>
                                    </div>
                                    <div style="display: inline-flex">
                                        <div class="form-group col-md-10 col-lg-12">
                                            <label for="with_amount">Amount to Withdraw (<del style="text-decoration-style: double">N</del>)</label>
                                            <input input type="text"  id="with_amount" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" style="font-size: 25px; font-weight: bolder;" class="form-control" value="" data-type="currency" placeholder="20,000.00">
                                            <p id="daError" style="color:#ff0000"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="" align="center" style="display: none" id="sub_div">
                                <button type="submit" id="submit_req" data-token="<?php echo e(csrf_token()); ?>" class="btn btn-primary">Submit Request</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

            <script>
                $("#make_request").click(function(){
                    $("#request_div").show();
                    $("#sub_div").show();
                });
                $("#cancel_request").click(function(){
                    $('#with_amount').val('');
                    $('#bank_name').val('');
                    $('#account_name').val('');
                    $('#account_no').val('');
                    $("#request_div").hide();
                    $("#sub_div").hide();
                });
            </script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
            <script>
                toastr.options = {
                    "closeButton": true,
                    "newestOnTop": true,
                    "positionClass": "toast-top-right",
                    "showDuration": "700",
                };

                $( "#submit_req" ).on( "click", function(e) {
                    e.preventDefault();
                    let with_amount = $("#with_amount").val();
                    //let bank_name = $('#bank_name option:selected').val();
                    //let account_name = $("#account_name").val();
                    //let account_no = $("#account_no").val();

                    if(with_amount === '') {
                        $('#with_amount').css('border-color', 'red').focus();
                        $('#daError').text('Please enter amount to withdraw');
                        $('#daError').fadeOut(2000);

                    }else{
                        $('.loader').show();
                        data = {
                            _token: "<?php echo e(csrf_token()); ?>",
                            with_amount: with_amount,
                            //bank_name: bank_name,
                            //account_name: account_name,
                            //account_no: account_no
                        };

                        $.ajax({
                            url: '<?php echo e(URL::to('/handleWithdrawalRequest')); ?>',
                            type: 'POST',
                            dataType: 'json',
                            data: data,
                            success: function (response) {
                                if(response.success === true){
                                    $('.loader').hide();
                                    setTimeout(function(){// wait for 5 secs(2)
                                        location.reload(); // then reload the page.(3)
                                    }, 1500);
                                    toastr.success(response.message);
                                }else{
                                    toastr.warning(response.message);
                                    $('.loader').hide();
                                    //window.location=response.url;
                                }
                            },
                        });
                    }

                });
            </script>
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
        <section class="content" style="height: 120vh ! important;">
            <div class="row col-md-10 col-lg-10 flex justify-content-center">
                <div class="box box-primary " style="padding: 10px;">
                    <div role="form">
                        <div style="display: inline-flex; margin-left: 10px;">
                            <div style="background-color: #4e555b;width: auto;" class="col-md-12 col-lg-12">
                                <label style="color: #ffffff;padding-top:4px;">SAVINGS/WITHDRAWAL TRANSACTIONS</label>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="example2" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Transaction Type</th>
                                        <th>Transaction Date</th>
                                        <th>Credit (Deposit)(<del style="text-decoration-style: double">N</del>)</th>
                                        <th>Debit (Withdrawal)(<del style="text-decoration-style: double">N</del>)</th>
                                        <th>Balance</th>

                                    </tr>
                                </thead>
                            <tbody>
                                <?php $__currentLoopData = $savings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $saving): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($saving->description); ?></td>
                                        <td><?php echo e(date('d-M-Y',strtotime($saving->month))); ?></td>
                                        <td>
                                            <?php if($saving->amount_saved > 0.00): ?>
                                                <span class="label label-success"><?php echo e(number_format($saving->amount_saved,2)); ?></span>
                                            <?php else: ?>
                                                <span class="label"></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($saving->amount_withdrawn > 0.00 && $saving->status !== 'Processing' && $saving->status !== 'Rejected'): ?>
                                                <span class="label label-danger" data-toggle="tooltip" title="Withdrawal Request Approved"><?php echo e(number_format($saving->amount_withdrawn,2)); ?>

                                            <?php elseif($saving->amount_withdrawn > 0.00 && $saving->status === 'Processing'): ?>
                                                <span class="label label-info" data-toggle="tooltip" title="Approval Pending"><?php echo e(number_format($saving->amount_withdrawn,2)); ?>

                                            <?php elseif($saving->amount_withdrawn > 0.00 && $saving->status === 'Rejected'): ?>
                                                        <span class="label label-info" data-toggle="tooltip" title="Withdrawal Request Rejected"><del style="text-decoration-style: double;text-decoration-color: red"><?php echo e(number_format($saving->amount_withdrawn,2)); ?></del>
                                            <?php else: ?>
                                               <span class="label"></span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e(number_format($saving->balance,2)); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                $(function () {
                    $('#example1').DataTable()
                    $('#example2').DataTable({
                        'paging'      : true,
                        'lengthChange': false,
                        'searching'   : true,
                        'ordering'    : false,
                        'info'        : true,
                        'autoWidth'   : false
                    })
                })
            </script>
        </section>
        <?php
if (! isset($_instance)) {
    $dom = \Livewire\Livewire::mount('change-password', [])->dom;
} elseif ($_instance->childHasBeenRendered('RIpnoBf')) {
    $componentId = $_instance->getRenderedChildComponentId('RIpnoBf');
    $componentTag = $_instance->getRenderedChildComponentTagName('RIpnoBf');
    $dom = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('RIpnoBf');
} else {
    $response = \Livewire\Livewire::mount('change-password', []);
    $dom = $response->dom;
    $_instance->logRenderedChild('RIpnoBf', $response->id, \Livewire\Livewire::getRootElementTagName($dom));
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
<?php $__env->stopSection(); ?>


<?php echo $__env->make('dashboard.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\coopmanager\resources\views/dashboard/withdrawals/makeWithdrawal.blade.php ENDPATH**/ ?>