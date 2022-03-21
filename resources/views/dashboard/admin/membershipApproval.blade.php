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
        <section class="content">
            {{--@include('dashboard.coopLogo')--}}
            <br />
            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box box-danger">
                            <div class="box-header">
                                @if(Auth::user()->user_role == 'Admin1' && $application->approval_status == 'Processing')
                                    <button style="font-weight: bold;font-size: 15px;" type="submit" id="sec_approve" value="sec_approved" class="btn btn-primary">Sec Approve Membership</button>
                                    <button style="font-weight: bold;font-size: 15px;" type="submit" id="chair_approve" value="chair_approved" class="btn btn-primary">Pres. Approve Membership</button>
                                    <button style="font-weight: bold;font-size: 15px;" type="submit" id="reject_loan" value="reject_loan" class="btn btn-danger">Reject Membership</button>
                                @elseif(Auth::user()->user_role == 'Admin1' && $application->approval_status == 'Rejected')
                                    <button style="font-weight: bold;font-size: 15px;" type="submit" id="revoke_rejection" value="revoke_rejection" class="btn btn-bitbucket">Set to Draft</button>
                                @endif
                                @if(Auth::user()->user_role == 'Admin2' && $application->approval_status == 'Processing')
                                    <button style="font-weight: bold;font-size: 15px;" type="submit" id="sec_approve" value="sec_approved" class="btn btn-primary">Sec Approve Membership</button>
                                    <button style="font-weight: bold;font-size: 15px;" type="submit" id="reject_loan" value="reject_loan" class="btn btn-danger">Reject Membership</button>
                                @elseif(Auth::user()->user_role == 'Admin2' && $application->approval_status == "Rejected")
                                    <button style="font-weight: bold;font-size: 15px;" type="submit" id="revoke_rejection" value="revoke_rejection" class="btn btn-bitbucket">Set to Draft</button>
                               @endif

                               @if(Auth::user()->user_role == 'Admin1' && $application->membership_status == 'Active')
                                  {{--  <button style="font-weight: bold;font-size: 15px;" type="submit" id="reject_loan" value="reject_loan" class="btn btn-danger">Archive Member</button>--}}
                               @elseif(Auth::user()->user_role == 'Admin1' && $application->membership_status== "Archived")
                                    <button style="font-weight: bold;font-size: 15px;" type="submit"  class="btn btn-danger">Archived</button>
                               @elseif(Auth::user()->user_role == 'Admin2' && $application->membership_status == 'Active')
                                    {{--<button style="font-weight: bold;font-size: 15px;" type="submit" id="reject_loan" value="reject_loan" class="btn btn-danger">Archive Member</button>--}}
                               @elseif(Auth::user()->user_role == 'Admin2' && $application->membership_status== "Archived")
                                    <button style="font-weight: bold;font-size: 15px;" type="submit"  class="btn btn-danger">Archived</button>
                               @endif
                                <div class="container-fluid pull-right" style=" display: inline-flex;margin-bottom: 8px;">
                                    <ol class="breadcrumb breadcrumb-arrow" style="font-weight: bold;font-size: 15px;">
                                        @if($application->approval_count == 1)
                                            <li id="sa" style=""><a hreff="#" style="color: green">Secretary Approved</a></li>
                                        @endif
                                        @if($application->approval_count == 2)
                                            <li id="sa"><a hreff="#" style="color: green">Secretary Approved</a></li>
                                            <li id="ca" ><a hreff="#" style="color: green">President Approved</a></li>
                                        @endif
                                        @if($application->approval_status == 'Processing')
                                            <li class="sa" ><a hreff="#" style="">Await Sec Approval</a></li>
                                            <li class="ca"><a hreff="#" style="">Await Pres. Approval</a></li>
                                        @endif
                                        @if($application->approval_status == "Rejected")
                                            <li id="sa"><a hreff="#" style="color: darkred">Membership Rejected</a></li>
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
                                        let application_id = $("#application_id").val();
                                        let staff_email = $('#staff_email').val();
                                        let staff_name = $('#staff_name').val();
                                        $('.preloader').show();

                                        data = {
                                            _token: "{{csrf_token()}}",
                                            sec_approve: sec_approve,
                                            application_id: application_id,
                                            staff_email: staff_email,
                                            staff_name: staff_name,
                                        };

                                        $.ajax({
                                            url: '{{URL::to('/handleAdminMembershipApproval')}}',
                                            type: 'POST',
                                            dataType: 'json',
                                            data: data,
                                            success: function (response) {
                                                if(response.success === true) {
                                                    $('.preloader').hide();
                                                    setTimeout(function () {// wait for 5 secs(2)
                                                        location.reload(); // then reload the page.(3)
                                                    }, 2000);
                                                    toastr.success(response.message);
                                                }else if(response.warning === true){
                                                    $('.preloader').hide();
                                                    setTimeout(function(){// wait for 5 secs(2)
                                                        //location.reload(); // then reload the page.(3)
                                                    }, 2000);
                                                    toastr.warning(response.message);

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
                                        let application_id = $("#application_id").val();
                                        let staff_email = $('#staff_email').val();
                                        let staff_name = $('#staff_name').val();
                                        $('.preloader').show();

                                        data = {
                                            _token: "{{csrf_token()}}",
                                            chair_approve: chair_approve,
                                            application_id: application_id,
                                            staff_email: staff_email,
                                            staff_name: staff_name,
                                        };

                                        $.ajax({
                                            url: '{{URL::to('/handleAdminMembershipApproval')}}',
                                            type: 'POST',
                                            dataType: 'json',
                                            data: data,
                                            success: function (response) {
                                                if(response.success === true) {
                                                    $('.preloader').hide();
                                                    setTimeout(function () {// wait for 5 secs(2)
                                                        location.reload(); // then reload the page.(3)
                                                    }, 2000);
                                                    toastr.success(response.message);
                                                }else if(response.warning === true){
                                                    $('.preloader').hide();
                                                    setTimeout(function(){// wait for 5 secs(2)
                                                        //location.reload(); // then reload the page.(3)
                                                    }, 2000);
                                                    toastr.warning(response.message);

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
                                        let application_id = $("#application_id").val();
                                        let reason_for_rejection = $("#reason_for_rejection").val();
                                        let staff_email = $('#staff_email').val();
                                        let staff_name = $('#staff_name').val();

                                        if(reason_for_rejection == ''){
                                            $("#show_reason").show();
                                            return false;
                                        }
                                        $('.preloader').show();

                                        data = {
                                            _token: "{{csrf_token()}}",
                                            reject_loan: reject_loan,
                                            application_id: application_id,
                                            reason_for_rejection: reason_for_rejection,
                                            staff_email: staff_email,
                                            staff_name: staff_name,

                                        };

                                        $.ajax({
                                            url: '{{URL::to('/handleAdminMembershipApproval')}}',
                                            type: 'POST',
                                            dataType: 'json',
                                            data: data,
                                            success: function (response) {
                                                if(response.success === true) {
                                                    $('.preloader').hide();
                                                    setTimeout(function () {// wait for 5 secs(2)
                                                        location.reload(); // then reload the page.(3)
                                                    }, 2000);
                                                    toastr.success(response.message);
                                                }else if(response.warning === true){
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
                                        let application_id = $("#application_id").val();
                                        let staff_email = $('#staff_email').val();
                                        let staff_name = $('#staff_name').val();
                                        $('.preloader').show();

                                        data = {
                                            _token: "{{csrf_token()}}",
                                            revoke_rejection: revoke_rejection,
                                            application_id: application_id,
                                            staff_email: staff_email,
                                            staff_name: staff_name,
                                        };

                                        $.ajax({
                                            url: '{{URL::to('/handleAdminMembershipApproval')}}',
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
                                                <script>
                                                    $(document).ready(function(){
                                                        if($('#approval_count').val() == 1){
                                                            $('#sec_approve').prop("disabled",true);
                                                            $('.sa').hide();
                                                        }else{
                                                            $('#chair_approve').prop("disabled",true);
                                                        }
                                                        if($('#approval_count').val() == 2){
                                                            $('.ca').hide();
                                                        }
                                                    });
                                                    (jQuery);
                                                </script>
                                                <div class="row">
                                                    <!-- textarea -->
                                                    <div class="form-group" id="show_reason" style="width: 70%; margin: auto; display: none">
                                                        <textarea class="form-control" rows="3" id="reason_for_rejection" value="" placeholder="Kindly provide the reason(s) membership is being rejected"></textarea>
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
                                                        <table class="table table-bordered table-striped"  style="border: 2px;font-size: medium">
                                                        <input type="hidden" value="{{$application->id}}" id="application_id" />
                                                        <input type="hidden" value="{{$application->users->email}}" id="staff_email" />
                                                        <input type="hidden" value="{{$application->users->name}}" id="staff_name" />
                                                        <input type="hidden" value="{{$application->users->id}}" id="user_id" />
                                                        <input type="hidden" value="{{$application->approval_count}}" id="approval_count" />
                                                        <thead>
                                                            <tr style="font-size: 18px;">
                                                                <th>Photograph</th>
                                                                <th>Personal Information</th>
                                                                <th>Official Information</th>
                                                                <th>NoK Information</th>
                                                                <th>Referees' Information</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            @if($application->users->passport_url)
                                                            <td style="width: 150px">
                                                               <img src="{{asset('/storage/'. $application->users->passport_url)}}" class="user-image" height="150" width="150">
                                                            </td>
                                                            @else
                                                                <td style="width: 150px;border:0.5px solid"></td>
                                                            @endif
                                                            <td>
                                                                <strong>First Name:</strong>&#160;&#160;&#160;{{$application->first_name}}<br/>
                                                                @if($application->middle_name != '')<strong>Middle Name:</strong>&#160;&#160;&#160;{{$application->middle_name}}<br/>@endif
                                                                <strong>Last Name:</strong>&#160;&#160;&#160;{{$application->last_name}}<br/>
                                                                <strong>Gender:</strong>&#160;&#160;&#160;{{$application->gender}}<br/>
                                                                <strong>Email:</strong>&#160;&#160;&#160;{{$application->users->email}}<br/>
                                                                <strong>Telephone:</strong>&#160;&#160;&#160;{{$application->users->phone_no}}<br/>
                                                                <strong>Contact Address:</strong>&#160;&#160;&#160;{{$application->residential_address}}<br/>
                                                            </td>
                                                            <td>
                                                                <strong>Membership No:</strong>&#160;&#160;&#160;{{$application->member_id}}<br/>
                                                                <strong>Staff No:</strong>&#160;&#160;&#160;{{$application->users->ippis_no}}<br/>
                                                                <strong>Designation:</strong>&#160;&#160;&#160;{{$application->designation}}<br/>
                                                                <strong>Department:</strong>&#160;&#160;&#160;{{$application->department}}<br/>
                                                                <strong>Office Location:</strong>&#160;&#160;&#160;{{$application->office_location}}<br/>
                                                            </td>
                                                            <td>
                                                                <strong>First Name:</strong>&#160;&#160;&#160;{{$application->nok_fname}}<br/>
                                                                @if($application->nok_mname != '')<strong>Middle Name:</strong>&#160;&#160;&#160;{{$application->nok_mname}}<br/>@endif
                                                                <strong>Last Name:</strong>&#160;&#160;&#160;{{$application->nok_lname}}<br/>
                                                                <strong>Relationship:</strong>&#160;&#160;&#160;{{$application->nok_relationship}}<br/>
                                                                <strong>Telephone:</strong>&#160;&#160;&#160;{{$application->nok_phone_number}}<br/>
                                                                @if($application->nok_email != '')<strong>Email:</strong>&#160;&#160;&#160;{{$application->nok_email}}<br/>@endif
                                                                <strong>Contact Address:</strong>&#160;&#160;&#160;{{$application->nok_address}}<br/>
                                                            </td>
                                                            <td>
                                                                <strong>1st Referee's Name:</strong>&#160;&#160;&#160;{{$application->referee_one}}<br/>
                                                                <strong>Telephone:</strong>&#160;&#160;&#160;<br/>
                                                                <strong>2nd Referee's Name:</strong>&#160;&#160;&#160;{{$application->referee_two}}<br/>
                                                                <strong>Telephone:</strong>&#160;&#160;&#160;<br/>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table><br />
                                                        <hr>
                                                            <div class="box-header with-borderr">
                                                                <b>Multiple Loans Permission</b><br>
                                                                <input type="checkbox" id="customSwitch1" data-onstyle="info">
                                                            </div>
                                                        <hr>
                                                        <script>
                                                            $('#customSwitch1').change(function () {
                                                                if(!confirm('You are granting permission for multiple loans, are you sure')) {
                                                                    return this.checked = false;
                                                                }else{
                                                                    let user_id = $('#user_id').val();
                                                                    data = {granted: this.checked,user_id:user_id,_token: "{{csrf_token()}}"}
                                                                        $.ajax({
                                                                            dataType: 'json',
                                                                            type: "POST",
                                                                            url: '{{URL::to('/permitMultipleLoan')}}',
                                                                            data: data,
                                                                            success: function (response) {
                                                                                if(response.success === true) {
                                                                                    toastr.success(response.message);
                                                                                }else {
                                                                                    toastr.warning(response.message);
                                                                                    document.getElementById('customSwitch1').checked = false;
                                                                                }
                                                                            },
                                                                        });
                                                                    }
                                                            });
                                                        </script>
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
@endsection


