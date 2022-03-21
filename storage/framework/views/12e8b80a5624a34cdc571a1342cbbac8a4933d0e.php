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

<?php echo $__env->make('dashboard.admin.adminLinks', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->startSection('main-content'); ?>
    <div class="content-wrapper">
        <section class="content">
            
            <br />
            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box box-primary" >
                            <div class="box-header">
                                <?php if(Auth::user()->user_role == 'Admin1' && $saving->status == 'Processing'): ?>
                                    <button style="font-weight: bold;font-size: 15px;" type="submit" id="sec_approve" value="sec_approved" class="btn btn-primary">Sec Approve Debit</button>
                                    <button style="font-weight: bold;font-size: 15px;" type="submit" id="chair_approve" value="chair_approved" class="btn btn-primary">Pres. Approve Debit</button>
                                    <button style="font-weight: bold;font-size: 15px;" type="submit" id="reject_loan" value="reject_loan" class="btn btn-danger">Reject Debit</button>
                                    <?php elseif(Auth::user()->user_role == 'Admin1' && $saving->status == 'Approved'): ?>
                                    <button style="font-weight: bold;font-size: 15px;" type="submit" id="reject_loan" value="reject_loan" class="btn btn-danger">Reject Debit</button>
                                    <?php elseif(Auth::user()->user_role == 'Admin1' && $saving->status == 'Rejected'): ?>
                                    <button style="font-weight: bold;font-size: 15px;" type="submit"  id="revoke_rejection" value="revoke_rejection" class="btn btn-bitbucket">Revoke Rejection</button>
                                <?php endif; ?>
                                <?php if(Auth::user()->user_role == 'Admin2' && $saving->status == 'Processing'): ?>
                                    <button style="font-weight: bold;font-size: 15px;" type="submit" id="sec_approve" value="sec_approved" class="btn btn-primary">Sec Approve Debit</button>
                                    <button style="font-weight: bold;font-size: 15px;" type="submit" id="reject_loan" value="reject_loan" class="btn btn-danger">Reject Debit</button>
                                        
                                        
                                <?php endif; ?>
                                <div class="container-fluid pull-right" style=" display: inline-flex;">
                                    <ol class="breadcrumb breadcrumb-arrow" style="font-weight: bold;font-size: 15px;">
                                        <?php if($saving->sec_approve == "sec_approved"): ?>
                                            <li id="sa"><a hreff="#" style="color: green">Secretary Approved</a></li>
                                        <?php endif; ?>
                                        <?php if($saving->chair_approve == "chair_approved"): ?>
                                            <li id="ca" ><a hreff="#"style="color: green">President Approved</a></li>
                                        <?php endif; ?>
                                        <?php if($saving->status == "Processing"): ?>
                                            <li class="sa" ><a hreff="#" style="">Await Sec Approval</a></li>
                                            <li class="ca"><a hreff="#" style="">Await Pres. Approval</a></li>
                                        <?php endif; ?>
                                        <?php if($saving->status == "Rejected"): ?>
                                            <li id="sa"><a hreff="#" style="color: darkred">Debit Rejected</a></li>
                                        <?php endif; ?>
                                    </ol>
                                </div>
                                <script>
                                    toastr.options = {
                                        "closeButton": true,
                                        "newestOnTop": true,
                                        "positionClass": "toast-top-right",
                                        "showDuration": "500",
                                    };

                                    $( "#sec_approve" ).on( "click", function(e) {
                                        e.preventDefault();
                                        let sec_approve = $("#sec_approve").val();
                                        let saving_id = $("#saving_id").val();
                                        let withdrawn_amount = $('#withdrawn_amount').val();

                                        $('.preloader').show();
                                        data = {
                                            _token: "<?php echo e(csrf_token()); ?>",
                                            sec_approve: sec_approve,
                                            saving_id: saving_id,
                                            withdrawn_amount:withdrawn_amount,
                                        };

                                        $.ajax({
                                            url: '<?php echo e(URL::to('/handleAdminWithdrawalApproval')); ?>',
                                            type: 'POST',
                                            dataType: 'json',
                                            data: data,
                                            success: function (response) {
                                                if(response.success === true){
                                                    $('.preloader').hide();
                                                    setTimeout(function(){// wait for 5 secs(2)
                                                        location.reload(); // then reload the page.(3)
                                                    }, 2000);
                                                    toastr.success(response.message);
                                                }else{
                                                    $('.preloader').hide();
                                                    //window.location=response.url;
                                                }
                                            },
                                        });
                                    });
                                    $( "#chair_approve" ).on( "click", function(e) {
                                        e.preventDefault();
                                        let chair_approve = $("#chair_approve").val();
                                        let saving_id = $("#saving_id").val();
                                        let withdrawn_amount = $('#withdrawn_amount').val();

                                        $('.preloader').show();

                                        data = {
                                            _token: "<?php echo e(csrf_token()); ?>",
                                            chair_approve: chair_approve,
                                            saving_id: saving_id,
                                            withdrawn_amount: withdrawn_amount,
                                        };

                                        $.ajax({
                                            url: '<?php echo e(URL::to('/handleAdminWithdrawalApproval')); ?>',
                                            type: 'POST',
                                            dataType: 'json',
                                            data: data,
                                            success: function (response) {
                                                if(response.success === true){
                                                    $('.preloader').hide();
                                                    setTimeout(function(){// wait for 5 secs(2)
                                                        location.reload(); // then reload the page.(3)
                                                    }, 2000);
                                                    toastr.success(response.message);
                                                }else{
                                                    $('.preloader').hide();
                                                    //window.location=response.url;
                                                }
                                            },
                                        });
                                    });
                                    $( "#reject_loan" ).on( "click", function(e) {
                                        e.preventDefault();
                                        let reject_loan = $("#reject_loan").val();
                                        let saving_id = $("#saving_id").val();
                                        let reason_for_rejection = $("#reason_for_rejection").val();
                                        let withdrawn_amount = $('#withdrawn_amount').val();

                                        if(reason_for_rejection == ''){
                                            $("#show_reason").show();
                                            return false;
                                        }
                                        $('.preloader').show();

                                        data = {
                                            _token: "<?php echo e(csrf_token()); ?>",
                                            reject_loan: reject_loan,
                                            saving_id: saving_id,
                                            reason_for_rejection: reason_for_rejection,
                                            withdrawn_amount: withdrawn_amount
                                        };
                                        $.ajax({
                                            url: '<?php echo e(URL::to('/handleAdminWithdrawalApproval')); ?>',
                                            type: 'POST',
                                            dataType: 'json',
                                            data: data,
                                            success: function (response) {
                                                if(response.success === true){
                                                    $('.preloader').hide();
                                                    setTimeout(function(){// wait for 5 secs(2)
                                                        location.reload(); // then reload the page.(3)
                                                    }, 2000);
                                                    toastr.warning(response.message);
                                                }else{
                                                    $('.preloader').hide();
                                                    //window.location=response.url;
                                                }
                                            },
                                        });
                                    });
                                    $( "#revoke_rejection" ).on( "click", function(e) {
                                        e.preventDefault();
                                        let revoke_rejection = $("#revoke_rejection").val();
                                        let saving_id = $("#saving_id").val();
                                        let withdrawn_amount = $('#withdrawn_amount').val();
                                        $('.preloader').show();

                                        data = {
                                            _token: "<?php echo e(csrf_token()); ?>",
                                            revoke_rejection: revoke_rejection,
                                            saving_id: saving_id,
                                            withdrawn_amount: withdrawn_amount,
                                        };

                                        $.ajax({
                                            url: '<?php echo e(URL::to('/handleAdminWithdrawalApproval')); ?>',
                                            type: 'POST',
                                            dataType: 'json',
                                            data: data,
                                            success: function (response) {
                                                if(response.success === true){
                                                    $('.preloader').hide();
                                                    setTimeout(function(){// wait for 5 secs(2)
                                                        location.reload(); // then reload the page.(3)
                                                    }, 2000);
                                                    toastr.warning(response.message);
                                                }else{
                                                    $('.preloader').hide();
                                                    //window.location=response.url;
                                                }

                                            },
                                        });
                                    });
                                </script>

                            </div>

                            <!-- /.box-header -->
                            <div class="box-body" style="margin-top:3px;">
                                <!-- /.row -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="box"  style="margin-top: -13px;">
                                            <div class="box-header with-borderr">
                                                <div class="box-tools pull-right">
                                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="box-body">
                                                <style>
                                                    .loader{
                                                        position: absolute;
                                                        left: 70%;
                                                        top: 20%;
                                                        -webkit-transform: translate(-50%, -50%);
                                                        transform: translate(-50%, -50%);
                                                    }
                                                </style>
                                                <script>
                                                    $(document).ready(function(){
                                                        if($('#loan_sec_app').val() === 'sec_approved'){
                                                            $('#sec_approve').prop("disabled",true);
                                                            $('.sa').hide();
                                                        }else{
                                                            $('#chair_approve').prop("disabled",true);
                                                        }
                                                        if($('#loan_chair_app').val() === 'chair_approved'){
                                                            $('.ca').hide();
                                                        }
                                                    })(jQuery);
                                                </script>
                                                <div class="row">
                                                    <div class="preloader">
                                                        <img src="<?php echo e(asset('custom/img')); ?>/loader.gif" alt="" />
                                                    </div>
                                                    <style>
                                                        .preloader{
                                                            display: none;
                                                            position: absolute;
                                                            left: 50%;
                                                            top: 20%;
                                                            -webkit-transform: translate(-50%, -50%);
                                                            transform: translate(-50%, -50%);
                                                        }
                                                    </style>
                                                    <div class="box-body table-responsive">
                                                        <table class="table table-bordered table-striped"  style="border: 2px;font-size: medium">
                                                            <input type="hidden" value="<?php echo e($saving->id); ?>" id="saving_id" />
                                                            <input type="hidden" value="<?php echo e($saving->sec_approve); ?>" id="loan_sec_app" />
                                                            <input type="hidden" value="<?php echo e($saving->chair_approve); ?>" id="loan_chair_app" />
                                                            <input type="hidden" value="<?php echo e(number_format($saving->amount_withdrawn,2)); ?>" id="withdrawn_amount" />
                                                            <thead>
                                                            <tr style="font-size: 18px;">
                                                                <th>Photograph</th>
                                                                <th>Personal Details</th>
                                                                <th>Withdrawal Request Details</th>
                                                                <th></th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr>
                                                                <td style="width: 150px">
                                                                    <img src="<?php echo e(asset('/storage/'. $saving->passport_url)); ?>" class="user-image" height="150" width="150">
                                                                </td>
                                                                <td style="padding-left: 10px; width:30% ! important;">
                                                                    <strong>Full Name:</strong>&#160;&#160;&#160;<?php echo e($saving->name); ?><br/>
                                                                    <strong>Membership No:</strong>&#160;&#160;&#160;<?php echo e($saving->member_id); ?><br/>
                                                                    <strong>Designation:</strong>&#160;&#160;&#160;<?php echo e($saving->designation); ?><br/>
                                                                    <strong>Department:</strong>&#160;&#160;&#160;<?php echo e($saving->department); ?><br/>
                                                                    <strong>Office Location:</strong>&#160;&#160;&#160;<?php echo e($saving->office_location); ?><br/>
                                                                    <strong>Telephone:</strong>&#160;&#160;&#160;<?php echo e($saving->phone_no); ?><br/>
                                                                </td>
                                                                <td>
                                                                    <strong>Account No:</strong>&#160;&#160;&#160;<?php echo e($saving->ippis_no); ?><br/>
                                                                    <strong style="font-size: large; border: 1px;">Withdrawal Status:</strong>&#160;&#160;&#160;&#160;&#160; <?php echo e($saving->status); ?>

                                                                    <?php if($saving->status=='Approved'): ?>&#160;&#160;<i class="fa fa-check"  style="color: green;" aria-hidden="true"></i><?php endif; ?>
                                                                    <?php if($saving->status=='Processing'): ?>&#160;&#160;<i class="fa fa-refresh fa-spin" style="color: orange;" aria-hidden="true"></i><?php endif; ?>
                                                                    <?php if($saving->status=='Rejected'): ?>&#160;&#160;<i class="fa fa-times" style="color: red;" aria-hidden="true"></i><?php endif; ?><br/>
                                                                    <strong>Description:</strong>&#160;&#160;&#160;&#160;&#160;  <?php echo e($saving->description); ?><br/>
                                                                    <?php if($saving->status =='Rejected'): ?><strong style="font-size: large;">Reason For Rejection:</strong>&#160;&#160;&#160;&#160;&#160;<?php echo e($saving->reason_for_rejection); ?><br/><?php endif; ?>
                                                                    <strong style="font-size: large;">Withdrawal Amount:</strong>&#160;&#160;&#160;&#160;&#160;<del style="text-decoration-style: double">N</del><?php echo e(number_format($saving->amount_withdrawn,2)); ?><br />
                                                                    <?php if($saving->status =='Approved'): ?><strong style="font-size: large;">Account Balance:</strong>&#160;&#160;&#160;&#160;&#160;<del style="text-decoration-style: double">N</del><?php echo e(number_format($saving->balance,2)); ?><?php endif; ?>
                                                                </td>
                                                                <td>
                                                                    <?php if($saving->status == 'Approved'): ?>
                                                                      <img src="<?php echo e(asset('custom/img')); ?>/approved.png" width="200" height="200" alt="" />
                                                                    <?php endif; ?>
                                                                    <?php if($saving->status == 'Rejected'): ?>
                                                                       <img src="<?php echo e(asset('custom/img')); ?>/rejected.jpg" width="120" height="120" alt="" />
                                                                    <?php endif; ?>
                                                                </td>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <!-- textarea -->
                                                    <div class="form-group" id="show_reason" style="width: 70%; margin: auto; display: none">
                                                        <textarea class="form-control" rows="3" cols="5" id="reason_for_rejection" value="" placeholder="Kindly provide the reason(s) the withdrawal request is being rejected"></textarea>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.box -->
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </section>
            <!-- /.content -->
            <!-- /.content-wrapper -->
        </section>
        <?php
if (! isset($_instance)) {
    $dom = \Livewire\Livewire::mount('change-password', [])->dom;
} elseif ($_instance->childHasBeenRendered('PMXlpkb')) {
    $componentId = $_instance->getRenderedChildComponentId('PMXlpkb');
    $componentTag = $_instance->getRenderedChildComponentTagName('PMXlpkb');
    $dom = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('PMXlpkb');
} else {
    $response = \Livewire\Livewire::mount('change-password', []);
    $dom = $response->dom;
    $_instance->logRenderedChild('PMXlpkb', $response->id, \Livewire\Livewire::getRootElementTagName($dom));
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
            <!-- /.tab-pane -->

            <!-- /.tab-pane -->
        </div>
    </aside>
    <style>
        .breadcrumb-arrow {
            min-height: 36px;
            line-height: 36px;
            list-style: none;
            overflow: auto;
            background-color: #ffffff ! important;
            margin-bottom: -20px;
            margin-top: -10px;
        }

        .breadcrumb-arrow li:first-child a {
            border-radius: 4px 0 0 4px;
            -webkit-border-radius: 4px 0 0 4px;
            -moz-border-radius: 4px 0 0 4px;
        }

        .breadcrumb-arrow li,
        .breadcrumb-arrow li a,
        .breadcrumb-arrow li span {
            display: inline-block;
        }

        .breadcrumb-arrow li:not(:first-child) {
            margin-left: -5px;
        }

        .breadcrumb-arrow li+li:before {
            padding: 0;
            content: "";
        }

        .breadcrumb-arrow li span {
            padding: 0 10px;
        }

        .breadcrumb-arrow li a,
        .breadcrumb-arrow li:not(:first-child) span {
            height: 36px;
            padding: 0 10px 0 25px;

        }

        .breadcrumb-arrow li:first-child a {
            padding: 0 10px;
        }

        .breadcrumb-arrow li a {
            position: relative;
            color: #fff;
            text-decoration: none;
            background-color:#3C8DBC;
            border: 1px solid #3C8DBC;
        }

        .breadcrumb-arrow li:first-child a {
            padding-left: 10px;
        }

        .breadcrumb-arrow li a:after,
        .breadcrumb-arrow li a:before {
            position: absolute;
            top: -1px;
            width: 0;
            height: 0;
            content: '';
            border-top: 18px solid transparent;
            border-bottom: 18px solid transparent;
        }

        .breadcrumb-arrow li a:before {
            right: -10px;
            z-index: 3;
            border-left-color: #3C8DBC;
            border-left-style: solid;
            border-left-width: 10px;
        }

        .breadcrumb-arrow li a:after {
            right: -11px;
            z-index: 2;
            border-left: 11px solid #fff;
        }

        .breadcrumb-arrow li a:focus:before,
        .breadcrumb-arrow li a:hover:before {
            border-left-color: #40474e;
        }

        .breadcrumb-arrow li a:active {
            background-color: #40474e;
            border: 1px solid #40474e;
        }

        .breadcrumb-arrow li a:active:after,
        .breadcrumb-arrow li a:active:before {
            border-left-color: #40474e;
        }

        .breadcrumb-arrow li.active:first-child span {
            padding-left: 10px;
        }

        .breadcrumb-arrow li.active span:after,
        .breadcrumb-arrow li.active span:before {
            position: absolute;
            top: -1px;
            width: 0;
            height: 0;
            content: '';
            border-top: 18px solid transparent;
            border-bottom: 18px solid transparent;
        }

        .breadcrumb-arrow li.active span:before {
            right: -10px;
            z-index: 3;
            border-left-color: #007bff;
            border-left-style: solid;
            border-left-width: 11px;
        }

        .breadcrumb-arrow li.active span:after {
            right: -11px;
            z-index: 2;
            border-left: 10px solid #007bff;
        }
    </style>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('dashboard.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\coopmanager\resources\views/dashboard/admin/savingsWithdrawalApproval.blade.php ENDPATH**/ ?>