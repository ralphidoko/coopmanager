@extends('dashboard.master')
@section('header')
    <header class="main-header">
        <!-- Logo -->
    @include('dashboard.brand')
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
            @include('dashboard.userProfileLink')

        </nav>
    </header>
@endsection
@include('dashboard.admin.adminLinks')
@section('main-content')
    <div class="content-wrapper">
        <section class="content" xmlns:wire="http://www.w3.org/1999/xhtml" xmlns:nwire="http://www.w3.org/1999/xhtml">
            {{--@include('dashboard.coopLogo')--}}
            <br />
            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box box-danger" >
                                <div class="box-header" style="margin-top: 10px">
                                    @if(Auth::user()->user_role == 'Admin1' && $loan[0]->status == 'Processing')
                                        <button style="font-weight: bold;font-size: 15px;" type="submit" id="sec_approve" value="sec_approved" class="btn btn-primary">Sec Approve Loan</button>
                                        <button style="font-weight: bold;font-size: 15px;" type="submit" id="chair_approve" value="chair_approved" class="btn btn-primary">Pres. Approve Loan</button>
                                        <button style="font-weight: bold;font-size: 15px;" type="submit" id="reject_loan" value="reject_loan" class="btn btn-danger">Reject Application</button>
                                    {{--@elseif(Auth::user()->user_role == 'Admin1' && $loan[0]->status == 'Approved')
                                        <button style="font-weight: bold;font-size: 15px;" type="submit" id="reject_loan" value="reject_loan" class="btn btn-danger">Reject Application</button>--}}
                                    @elseif(Auth::user()->user_role == 'Admin1' && $loan[0]->status == 'Rejected')
                                        <button style="font-weight: bold;font-size: 15px;" type="submit" id="revoke_rejection" value="revoke_rejection" class="btn btn-bitbucket">Set to Draft</button>
                                    @endif
                                    @if(Auth::user()->user_role == 'Admin2' && $loan[0]->status == 'Processing')
                                            <button style="font-weight: bold;font-size: 15px;" type="submit" id="sec_approve" value="sec_approved" class="btn btn-primary">Sec Approve Loan</button>
                                            <button style="font-weight: bold;font-size: 15px;" type="submit" id="reject_loan" value="reject_loan" class="btn btn-danger">Reject Application</button>
                                    @elseif(Auth::user()->user_role == 'Admin2' && $loan[0]->status == "Rejected")
                                            <button style="font-weight: bold;font-size: 15px;" type="submit" id="revoke_rejection" value="revoke_rejection" class="btn btn-bitbucket">Set to Draft</button>
                                    @endif

                                    <div class="container-fluid pull-right" style=" display: inline-flex;margin-bottom: 10px">
                                        <ol class="breadcrumb breadcrumb-arrow" style="font-weight: bold;font-size: 15px;">
                                            @if($loan[0]->sec_approve == "sec_approved")
                                               <li id="sa"><a hreff="#" style="color: green">Secretary Approved</a></li>
                                            @endif
                                            @if($loan[0]->chair_approve == "chair_approved")
                                               <li id="ca" ><a hreff="#" style="color: green">President Approved</a></li>
                                            @endif
                                            @if($loan[0]->status == "Processing")
                                                <li class="sa" ><a hreff="#" style="background: #3C8DBC ! important;">Await Sec Approval</a></li>
                                                <li class="ca"><a hreff="#" style="background: #3C8DBC ! important;">Await Pres. Approval</a></li>
                                            @endif
                                            @if($loan[0]->status == "Rejected")
                                                <li id="sa"><a hreff="#" style="color: darkred">Application Rejected</a></li>
                                            @endif
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
                                            let loan_id = $("#loan_id").val();
                                            $('.preloader').show();

                                                data = {_token: "{{csrf_token()}}", sec_approve: sec_approve, loan_id: loan_id,};

                                                $.ajax({
                                                    url: '{{URL::to('/handleLoanAdminApproval')}}',
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
                                            let loan_id = $("#loan_id").val();
                                            $('.preloader').show();

                                            data = {_token: "{{csrf_token()}}", chair_approve: chair_approve, loan_id: loan_id,};

                                            $.ajax({
                                                url: '{{URL::to('/handleLoanAdminApproval')}}',
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
                                            let loan_id = $("#loan_id").val();
                                            let reason_for_rejection = $("#reason_for_rejection").val();

                                            if(reason_for_rejection === ''){
                                                $("#show_reason").show();
                                                return false;
                                            }
                                            $('.preloader').show();

                                            data = {_token: "{{csrf_token()}}", reject_loan: reject_loan, loan_id: loan_id, reason_for_rejection: reason_for_rejection};

                                            $.ajax({
                                                url: '{{URL::to('/handleLoanAdminApproval')}}',
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
                                            let loan_id = $("#loan_id").val();
                                            $('.preloader').show();

                                            data = {_token: "{{csrf_token()}}", revoke_rejection: revoke_rejection, loan_id: loan_id,};

                                            $.ajax({
                                                url: '{{URL::to('/handleLoanAdminApproval')}}',
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
                                                    <!-- textarea -->
                                                    <div class="form-group" id="show_reason" style="width: 70%; margin: auto; display: none">
                                                        <textarea class="form-control" rows="3" id="reason_for_rejection" value="" placeholder="Kindly provide the reason(s) the loan is being rejected"></textarea>
                                                    </div>
                                                    <div class="preloader">
                                                        <img src="{{ asset('custom/img') }}/loader.gif" alt="" />
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
                                                      <table class="table table-bordered table-striped" style="border: 2px;">
                                                        <input type="hidden" value="{{$loan[0]->id}}" id="loan_id" />
                                                        <input type="hidden" value="{{$loan[0]->sec_approve}}" id="loan_sec_app" />
                                                        <input type="hidden" value="{{$loan[0]->chair_approve}}" id="loan_chair_app" />
                                                        <thead>
                                                        <tr style="font-size: 18px;">
                                                            <th>Photograph</th>
                                                            <th>Applicant Details</th>
                                                            <th>Basic Loan Information</th>
                                                            <th>Loan Computations</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td style="border: 1px solid black; width: 150px">
                                                                    <img src="{{asset('/storage/'. $loan[0]->passport_url)}}" class="user-image" height="150" width="150">
                                                                </td>
                                                                <td style="font-size: large;"><strong>Applicant:</strong>&#160;&#160;{{$loan[0]->name}}<br/>
                                                                    <strong>Membership No:</strong>&#160;&#160;&#160;{{$loan[0]->member_id}}<br/>
                                                                    <strong>Account No:</strong>&#160;&#160;&#160;{{$loan[0]->ippis_no}}<br/>
                                                                    <strong>Designation:</strong>&#160;&#160;&#160;{{$loan[0]->designation}}<br/>
                                                                    <strong>Department:</strong>&#160;&#160;{{$loan[0]->department}}<br/>
                                                                    <strong>Telephone:</strong>&#160;&#160;&#160;{{$loan[0]->phone_no}}<br/>
                                                                </td>
                                                                <td style="font-size: large;"><strong>Submission Date</strong>&#160;&#160;{{date("d-M-Y",strtotime($loan[0]->created_at))}}<br/>
                                                                    <strong>Loan Type:</strong>&#160;&#160;&#160;{{$loan[0]->loan_type}}<br/>
                                                                    <strong>Principal Amount:</strong>&#160;&#160;&#160;<del style="text-decoration-style: double">N</del>{{number_format($loan[0]->loan_amount,2)}}<br/>
                                                                    <strong>Loan Tenor:</strong>&#160;&#160;&#160;{{$loan[0]->cash_loan_tenor.' Months'}}<br/>
                                                                    <strong>Interest Rate:</strong>&#160;&#160;&#160;{{$loan[0]->cash_loan_rate.'%'}}<br/>
                                                                </td>
                                                                <td style="font-size: large;"><strong>Total Amount Payable</strong>&#160;&#160;<del style="text-decoration-style: double">N</del>{{number_format($loan[0]->total_amount_payable,2)}}<br/>
                                                                    <strong>Total Interest Payable:</strong>&#160;&#160;&#160;<del style="text-decoration-style: double">N</del>{{number_format($loan[0]->total_interest_payable,2)}}<br/>
                                                                    <strong>Monthly Installment:</strong>&#160;&#160;&#160;<del style="text-decoration-style: double">N</del>{{number_format($loan[0]->monthly_interest_payable,2)}}<br/>
                                                                    <strong>Total Installment Paid:</strong>&#160;&#160;&#160;<del style="text-decoration-style: double">N</del>{{number_format($total_installment_paid,2)}}<br/>
{{--                                                                    <strong>Amount Recovered:</strong>&#160;&#160;&#160;<del style="text-decoration-style: double">N</del>{{number_format($loan[0]->amount_recovered,2)}}<br/>--}}
                                                                    <strong>Loan Balance:</strong>&#160;&#160;&#160;<del style="text-decoration-style: double">N</del>{{number_format($loan[0]->total_amount_payable - $total_installment_paid,2)}}<br/>
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

                                <div class="row">
                                    <!-- /.col -->
                                    <div class="col-md-6 col-lg-12 col-sm-4">
                                        <!-- Custom Tabs (Pulled to the right) -->
                                        <div class="nav-tabs-custom">
                                            <ul class="nav nav-tabs pull-right">
                                                <li class="active"><a href="#tab_1-1" data-toggle="tab"><strong style="font-size: 15px">Loan Installments</strong></a></li>
                                                <li><a href="#tab_2-2" data-toggle="tab"><strong style="font-size: 15px">Loan Guarantors</strong></a></li>
                                                <li><a href="#tab_3-2" data-toggle="tab"><strong style="font-size: 15px">Reason(s) For Rejection</strong></a></li>

                                                <li class="pull-left header"><i class="fa fa-th"></i>Other Information</li>
                                            </ul>
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="tab_1-1">
                                                    <!-- Main content -->
                                                    <section class="content">
                                                        <div class="row">
                                                            <div class="col-xs-12">

                                                                <div class="box box-primary" >
                                                                    <div class="box-header">
                                                                        <h3 class="box-title">View of all Loan Installments</h3>
                                                                    </div>
                                                                    <!-- /.box-header -->
                                                                    <div class="box-body">
                                                                      <div class="box-body table-responsive">
                                                                        <table id="example2" class="table table-bordered table-striped">
                                                                            <thead>
                                                                            <tr>
                                                                                <th>Count</th>
                                                                                <th>Loan ID</th>
                                                                                <th>Monthly Amount Payable(<del style="text-decoration-style: double">N</del>)</th>
                                                                                <th>Payment Due Date</th>
                                                                                <th>Payment Status</th>
                                                                            </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                            @php
                                                                            $counter =1;
                                                                            @endphp
                                                                            @foreach($installments as $installment)
                                                                                <tr>
                                                                                    <th>{{$counter++}}</th>
                                                                                    <td>{{$installment->loan_id}}</td>
                                                                                    <td><del style="text-decoration-style: double">N</del>{{number_format($installment->monthly_installment,2)}}</td>
                                                                                    <td>{{date("d-M-Y",strtotime($installment->payment_date))}}</td>
                                                                                    <td>{{$installment->status}}</td>
                                                                                </tr>
                                                                            @endforeach
                                                                            </tbody>
                                                                        </table>
                                                                      </div>
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
                                                    <script>
                                                        $(function () {
                                                            $('#example1').DataTable()
                                                            $('#example2').DataTable({
                                                                'paging'      : true,
                                                                'lengthChange': false,
                                                                'searching'   : false,
                                                                'ordering'    : true,
                                                                'info'        : true,
                                                                'autoWidth'   : false
                                                            })
                                                        })
                                                    </script>
                                                </div>
                                                <!-- /.tab-pane -->
                                                <div class="tab-pane" id="tab_2-2">
                                                    <table id="example2" class="table table-bordered table-striped">
                                                        <thead>
                                                        <tr>
                                                            <th>Guarantor's Name</th>
                                                            <th>Guarantor's Phone Number</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <td>{{$loan[0]->guarantor_one}}</td>
                                                            <td>{{$loan[0]->g1_phone_no}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>{{$loan[0]->guarantor_two}}</td>
                                                            <td>{{$loan[0]->g2_phone_no}}</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <!-- /.tab-pane -->
                                                <div class="tab-pane" id="tab_3-2">
                                                    {{$loan[0]->reason_for_rejection}}
                                                </div>
                                                <!-- /.tab-pane -->
                                            </div>
                                            <!-- /.tab-content -->
                                        </div>
                                        <!-- nav-tabs-custom -->
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->
                                <!-- END CUSTOM TABS -->
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
        <livewire:change-password />
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


            </div>
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
@endsection


