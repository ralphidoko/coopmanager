<?php $__env->startSection('header'); ?>
    <header class="main-header">
        <!-- Logo -->
    <?php echo $__env->make('dashboard.brand', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
                        <div class="box box-danger">
                            <div class="box-header">
                                <?php if($application->membership_renewal_status == 'Request Submitted'): ?>
                                    <button style="font-weight: bold;font-size: 15px;" type="submit" id="reject_loan" value="reject_loan" class="btn btn-primary">Approve Renewal Request</button>
                                <?php endif; ?>
                                <div class="container-fluid pull-right" style=" display: inline-flex;">
                                    <ol class="breadcrumb breadcrumb-arrow" style="font-weight: bold;font-size: 15px;">
                                        <?php if($application->membership_renewal_status == 'Request Submitted'): ?>
                                            <li><a>Request Awaiting Approval</a></li>
                                        <?php else: ?>
                                            <li><a style="color:green;margin-bottom: 10px;">Membership Renewed</a></li>
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
                                    $( "#reject_loan" ).on( "click", function(e) {
                                        e.preventDefault();
                                        let reject_loan = $("#reject_loan").val();
                                        let application_id = $("#application_id").val();

                                        if(reason_for_rejection == ''){
                                            $("#show_reason").show();
                                            return false;
                                        }
                                        $('.preloader').show();

                                        data = {
                                            _token: "<?php echo e(csrf_token()); ?>",
                                            reject_loan: reject_loan,
                                            application_id: application_id,
                                        };

                                        $.ajax({
                                            url: '<?php echo e(URL::to('/handleAdminMembershipRenewal')); ?>',
                                            type: 'POST',
                                            dataType: 'json',
                                            data: data,
                                            success: function (response) {
                                                if(response.success === true) {
                                                    $('.preloader').hide();
                                                    setTimeout(function () {// wait for 5 secs(2)
                                                        location.reload(); // then reload the page.(3)
                                                    }, 1500);
                                                    toastr.success(response.message);
                                                }else if(response.warning === true){
                                                    $('.preloader').hide();
                                                    setTimeout(function(){// wait for 5 secs(2)
                                                        location.reload(); // then reload the page.(3)
                                                    }, 1500);
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
                            <div class="box-body">
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
                                            <div class="box-body" style="padding-bottom: 400px">
                                                <style>
                                                    .loader{
                                                        position: absolute;
                                                        left: 70%;
                                                        top: 20%;
                                                        -webkit-transform: translate(-50%, -50%);
                                                        transform: translate(-50%, -50%);
                                                    }
                                                </style>
                                                <div class="row">
                                                    <!-- textarea -->
                                                    <div class="form-group" id="show_reason" style="width: 70%; margin: auto; display: none">
                                                        <textarea class="form-control" rows="3" id="reason_for_rejection" value="" placeholder="Kindly provide the reason(s) membership is being rejected"></textarea>
                                                    </div>
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
                                                            <input type="hidden" value="<?php echo e($application->id); ?>" id="application_id" />
                                                            <thead>
                                                            <tr style="font-size: 18px;">
                                                                <th>Photograph</th>
                                                                <th>Personal Information</th>
                                                                <th>Official Information</th>
                                                                <th>NoK Information</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr>
                                                                <td style="border: 1px solid black; width: 150px">
                                                                    <img src="<?php echo e(asset('/storage/'. $application->passport_url)); ?>" class="user-image" height="100" width="150">
                                                                </td>
                                                                <td>
                                                                    <strong>First Name:</strong>&#160;&#160;&#160;<?php echo e($application->members->first_name); ?><br/>
                                                                    <?php if($application->members->middle_name != ''): ?><strong>Middle Name:</strong>&#160;&#160;&#160;<?php echo e($application->members->middle_name); ?><br/><?php endif; ?>
                                                                    <strong>Last Name:</strong>&#160;&#160;&#160;<?php echo e($application->members->last_name); ?><br/>
                                                                    <strong>Gender:</strong>&#160;&#160;&#160;<?php echo e($application->members->gender); ?><br/>
                                                                    <strong>Email:</strong>&#160;&#160;&#160;<?php echo e($application->email); ?><br/>
                                                                    <strong>Telephone:</strong>&#160;&#160;&#160;<?php echo e($application->phone_no); ?><br/>
                                                                    <strong>Contact Address:</strong>&#160;&#160;&#160;<?php echo e($application->members->residential_address); ?><br/>
                                                                </td>
                                                                <td>
                                                                    <strong>Membership No:</strong>&#160;&#160;&#160;<?php echo e($application->member_id); ?><br/>
                                                                    <strong>Account No:</strong>&#160;&#160;&#160;<?php echo e($application->ippis_no); ?><br/>
                                                                    <strong>Designation:</strong>&#160;&#160;&#160;<?php echo e($application->members->designation); ?><br/>
                                                                    <strong>Department:</strong>&#160;&#160;&#160;<?php echo e($application->members->department); ?><br/>
                                                                    <strong>Office Location:</strong>&#160;&#160;&#160;<?php echo e($application->members->office_location); ?><br/>
                                                                </td>
                                                                <td>
                                                                    <strong>First Name:</strong>&#160;&#160;&#160;<?php echo e($application->members->nok_fname); ?><br/>
                                                                    <?php if($application->members->nok_mname != ''): ?><strong>Middle Name:</strong>&#160;&#160;&#160;<?php echo e($application->members->nok_mname); ?><br/><?php endif; ?>
                                                                    <strong>Last Name:</strong>&#160;&#160;&#160;<?php echo e($application->members->nok_lname); ?><br/>
                                                                    <strong>Relationship:</strong>&#160;&#160;&#160;<?php echo e($application->members->nok_relationship); ?><br/>
                                                                    <strong>Telephone:</strong>&#160;&#160;&#160;<?php echo e($application->members->nok_phone_number); ?><br/>
                                                                    <?php if($application->members->nok_email != ''): ?><strong>Email:</strong>&#160;&#160;&#160;<?php echo e($application->members->nok_email); ?><br/><?php endif; ?>
                                                                    <strong>Contact Address:</strong>&#160;&#160;&#160;<?php echo e($application->members->nok_address); ?><br/>
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
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
} elseif ($_instance->childHasBeenRendered('Etu6g1Z')) {
    $componentId = $_instance->getRenderedChildComponentId('Etu6g1Z');
    $componentTag = $_instance->getRenderedChildComponentTagName('Etu6g1Z');
    $dom = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('Etu6g1Z');
} else {
    $response = \Livewire\Livewire::mount('change-password', []);
    $dom = $response->dom;
    $_instance->logRenderedChild('Etu6g1Z', $response->id, \Livewire\Livewire::getRootElementTagName($dom));
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
            border-left-color: #3C8DBC;
        }

        .breadcrumb-arrow li a:active {
            background-color: #3C8DBC;
            border: 1px solid #3C8DBC;
        }

        .breadcrumb-arrow li a:active:after,
        .breadcrumb-arrow li a:active:before {
            border-left-color: #3C8DBC;
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



<?php echo $__env->make('dashboard.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\coopmanager\resources\views/dashboard/admin/membershipRenewalApproval.blade.php ENDPATH**/ ?>