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
            @include('dashboard.admin.adminLinks')
        </nav>
    </header>
@endsection

@section('main-content')
    <div class="content-wrapper">
        <section class="content">
        {{--@include('dashboard.coopLogo')--}}
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box box-danger" style="padding: 10px ! important;" >
                            <div class="box-header">
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                </div>
                                <h3 class="box-title">List of Increase/Decrease Savings</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="table-responsive" id="">
                                <form>
                                    <div class="" align="left">
                                        <button type="button" style="margin-top:5px; margin-bottom: 15px;" id="incr_decr_saving" data-token="{{ csrf_token() }}" class="btn btn-primary">Approve Increase/Decrease Savings</button>
                                    </div>
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th><input type="checkbox" value="" id="check_all_in_de" />&#160;Select Record(s)</th>
                                            <th>Member's Name</th>
                                            <th>Authorization Type</th>
                                            <th>Previous Amount(<del style="text-decoration-style: double">N</del>)</th>
                                            <th>Newly Authorized Amount(<del style="text-decoration-style: double">N</del>)</th>
                                            <th>Authorization State</th>
                                            <th>Submission Date</th>
                                            <th>Start Date</th>
                                        </tr>
                                        </thead>
                                        @foreach($authorizations as $authorization)
                                            <tr>
                                                @if($authorization->status == 'Approved')
                                                <td><input type="" disabled name='inc_dec' style="border: none;"></td>
                                                @else
                                                    <td><input type="checkbox" name='inc_dec' value="{{$authorization->id}}"></td>
                                                @endif
                                                <td>{{$authorization->users->name}}</td>
                                                <td>{{$authorization->auth_text}}</td>
                                                <td>{{number_format($authorization->current_amount,2)}}</td>
                                                <td>{{number_format($authorization->desired_amount,2)}}</td>
                                                @if($authorization->status=='Awaiting Approval')
                                                    <td><span class="label label-warning">{{$authorization->status}}</span></td>
                                                @endif
                                                @if($authorization->status=='Approved')
                                                    <td><span class="label label-success">{{$authorization->status}}</span></td>
                                                @endif
                                                @if($authorization->status=='Rejected')
                                                    <td><span class="label label-danger">{{$authorization->status}}</span></td>
                                                @endif
                                                <td>{{date('d-M-Y',strtotime($authorization->created_at))}}</td>
                                                <td>{{date('d-M-Y',strtotime($authorization->start_date))}}</td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </form>
                            </div>
                            <script>
                                $(document).ready(function() {
                                    let allIndec = [];
                                    $('#check_all_in_de').click(function() {
                                        $(this.form.elements).filter(':checkbox').prop('checked', this.checked);
                                    });
                                    //update allDeductPay accordingly
                                    $('input[type="checkbox"]').change(function() {
                                        allIndec = $.map($('input[name="inc_dec"]:checked'), function(a) { return a.value; })
                                    });

                                    $( "#incr_decr_saving" ).on( "click", function(e) {
                                        e.preventDefault();
                                        let inc_dec_id = allIndec;
                                        if(inc_dec_id.length === 0){
                                            alert('Select increase or decrease request to approve');
                                        }else{
                                            $('.preloader').show();
                                            data = {
                                                _token: "{{csrf_token()}}",
                                                inc_dec_id: inc_dec_id,
                                            };

                                            $.ajax({
                                                url: '{{URL::to('/increaseDecreaseSavingApproval')}}',
                                                type: 'POST',
                                                dataType: 'json',
                                                data: data,
                                                success: function (response) {
                                                    if(response.success === true){
                                                        $('.preloader').hide();
                                                        setTimeout(function(){// wait for 5 secs(2)
                                                            location.reload(); // then reload the page.(3)
                                                        }, 1500);
                                                        toastr.success(response.message);
                                                    }else{
                                                        $('.preloader').hide();
                                                        //window.location=response.url;
                                                    }

                                                },
                                            });
                                        }
                                    });
                                });
                            </script>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                        <div class="box box-primary" >
                            <div class="preloader">
                                <img src="{{ asset('custom/img') }}/loader.gif" alt="" />
                            </div>
                            <style>
                                .preloader{
                                    display:none;
                                    position: absolute;
                                    left: 50%;
                                    top: 20%;
                                    -webkit-transform: translate(-50%, -50%);
                                    transform: translate(-50%, -50%);
                                }
                            </style>
                            <div class="box-header">
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                </div>
                                <h3 class="box-title">Authority to Deduct Pay</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body table-responsive">
                                <div class="" align="left">
                                    <button type="submit" id="approve_auth" data-token="{{ csrf_token() }}" class="btn btn-primary">Approve Authority</button>
                                </div>
                                <table id="example2" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th><input type="checkbox" value="" id="checkAll" />&#160;Select Record(s)</th>
                                        <th>Member's Name</th>
                                        <th>Authorization Type</th>
                                        <th>Authorized Amount(<del style="text-decoration-style: double">N</del>)</th>
                                        <th>Authorization State</th>
                                        <th>Submission Date</th>
                                        <th>Start Date</th>
                                    </tr>
                                    </thead>
                                    @foreach($deductions as $deduction)
                                        <tr>
                                            @if($deduction->status == 'Approved')
                                                <td><input type="" disabled name='deductPay' style="border: none"></td>
                                            @else
                                                <td><input type="checkbox" name='deductPay' value="{{$deduction->id}}"></td>
                                            @endif
                                            <td>{{$deduction->users->name}}</td>
                                            <td>Deduct Pay</td>
                                            <td>{{number_format($deduction->authorized_amount,2)}}</td>
                                            @if($deduction->status=='Awaiting Approval')
                                                <td><span class="label label-warning">{{$deduction->status}}</span></td>
                                            @endif
                                            @if($deduction->status=='Approved')
                                                <td><span class="label label-success">{{$deduction->status}}</span></td>
                                            @endif
                                            <td>{{date('d-M-Y',strtotime($deduction->created_at))}}</td>
                                            <td>{{date('d-M-Y',strtotime($deduction->start_date))}}</td>
                                        </tr>
                                    @endforeach
                                </table>
                                <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
                                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

                                <script>
                                    toastr.options = {
                                        "closeButton": true,
                                        "newestOnTop": true,
                                        "positionClass": "toast-top-right",
                                        "showDuration": "500",
                                    };
                                    $(document).ready(function() {
                                        let allDeductPay = [];
                                        $("#checkAll").click(function(){
                                            // $('input:checkbox').not(this).prop('checked', this.checked);
                                            // $.each($("input[name='deductPay']:checked"), function(){
                                            //     allDeductPay.push($(this).val());
                                            // });
                                            let checkboxes = $(this).closest('table').find(':checkbox').not($(this));
                                            checkboxes.prop('checked', $(this).is(':checked'));
                                            allDeductPay.push($(this).val());
                                        });
                                        //update allDeductPay accordingly
                                        $('input[type="checkbox"]').change(function() {
                                            allDeductPay = $.map($('input[name="deductPay"]:checked'), function(a) { return a.value; })
                                        });

                                        $( "#approve_auth" ).on( "click", function(e) {
                                            e.preventDefault();
                                            let auth_id = allDeductPay.filter(number => parseInt(number) == number);
                                            if(auth_id.length === 0){
                                                alert('Select authorization to approve');
                                            }else{
                                                $('.preloader').show();
                                                data = {
                                                    _token: "{{csrf_token()}}",
                                                    auth_id: auth_id,
                                                };

                                                $.ajax({
                                                    url: '{{URL::to('/approveAuthorityToDeductPay')}}',
                                                    type: 'POST',
                                                    dataType: 'json',
                                                    data: data,
                                                    success: function (response) {
                                                        if(response.success === true){
                                                            $('.preloader').hide();
                                                            setTimeout(function(){// wait for 5 secs(2)
                                                                location.reload(); // then reload the page.(3)
                                                            }, 1500);
                                                            toastr.success(response.message);
                                                        }else{
                                                            $('.preloader').hide();
                                                            //window.location=response.url;
                                                        }

                                                    },
                                                });
                                            }
                                        });
                                    });
                                </script>
                            </div>
                            <!-- /.box-body -->
                        </div>
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
                        'searching'   : true,
                        'ordering'    : true,
                        'info'        : true,
                        'autoWidth'   : false
                    })
                })
            </script>

        </section>

        <livewire:change-password />
    </div>
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 1.0.0
        </div>
        <strong>Copyright &copy; 2020 <a href="https://isosystemss.com" target="_blank">ISOSYSTEMS</a>.</strong> All rights
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
@endsection


