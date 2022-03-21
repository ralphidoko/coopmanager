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

@include('dashboard.navigation')
<livewire:allow-admin />
@section('main-content')
    <div class="content-wrapper">
        <section class="content">
           {{--@include('dashboard.coopLogo')--}}
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box box-danger">
                            <div class="box-header">
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                </div>
                                <h3 class="box-title">List View of all Authorization</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="table-responsive" style="padding: 10px;">
                                <table id="" class="table table-bordered table-striped example1">
                                    <thead>
                                    <tr>
                                        <th>Authorization Type</th>
                                        <th>Previous Amount(<del style="text-decoration-style: double">N</del>)</th>
                                        <th>Newly Authorized Amount(<del style="text-decoration-style: double">N</del>)</th>
                                        <th>Authorization State</th>
                                        <th>Submission Date</th>
                                        <th>Start Date</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    @foreach($auth_lists as $auth_list)
                                        <tr>
                                            <td>{{$auth_list->auth_text}}</td>
                                            <td>{{number_format($auth_list->current_amount,2)}}</td>
                                            <td>{{number_format($auth_list->desired_amount,2)}}</td>
                                            @if($auth_list->status=='Awaiting Approval')
                                                <td><span class="label label-warning">{{$auth_list->status}}</span></td>
                                            @endif
                                            @if($auth_list->status=='Approved')
                                                <td><span class="label label-success">{{$auth_list->status}}</span></td>
                                            @endif
                                            @if($auth_list->status=='Rejected')
                                                <td><span class="label label-danger">{{$auth_list->status}}</span></td>
                                            @endif
                                            <td>{{date('d-M-Y',strtotime($auth_list->created_at))}}</td>
                                            <td>{{date('d-M-Y',strtotime($auth_list->start_date))}}</td>
                                            <td>
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                                        <span class="fa fa-caret-down"></span></button>
                                                    <ul class="dropdown-menu">
                                                        @if($auth_list->status == 'Awaiting Approval')
                                                            <li><a href="/savings/{{$auth_list->id}}/updateAuthorization/">Edit Authorization</a></li>
                                                        @endif
                                                        @if($auth_list->status == 'Awaiting Approval')
                                                            <li>
                                                                <a  style="cursor: pointer;" onclick="deleteAuthorization('{{$auth_list->id}}','{{$auth_list->auth_type}}')" >Delete Authorization </a>
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                                <script>
                                    function deleteAuthorization(id,auth_type) {
                                        var sure = confirm('Are you sure? This action cannot be reversed');
                                        if(sure ===false){
                                            return false;
                                        }else {
                                            data = {
                                                loan_id: id,auth_type: auth_type,_token: "{{csrf_token()}}"
                                            }
                                            $.ajax({
                                                dataType: 'json',
                                                type: "DELETE",
                                                url: '{{URL::to('/deleteAuthorization')}}',
                                                data: data,
                                                success: function (response) {
                                                    //location.reload();
                                                    window.location=response.url;
                                                }
                                            });
                                        }
                                    }

                                </script>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                        <div class="box box-primary" >
                            <div class="box-header">
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                </div>
                                <h3 class="box-title">Authority to Deduct Pay</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body table-responsive">
                                <table id="" class="table table-bordered table-striped example1">
                                    <thead>
                                    <tr>
                                        <th>Authorization Type</th>
                                        <th>Authorized Amount(<del style="text-decoration-style: double">N</del>)</th>
                                        <th>Authorization State</th>
                                        <th>Submission Date</th>
                                        <th>Start Date</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    @foreach($deductions as $deduction)
                                        <tr>
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
                                            <td>
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                                        <span class="fa fa-caret-down"></span></button>
                                                    <ul class="dropdown-menu">
                                                        @if($deduction->status == 'Awaiting Approval')
                                                            <li>
                                                                <a  style="cursor: pointer;" onclick="deleteAuthorityToPay('{{$deduction->id}}')" >Delete Authorization </a>
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                                <script>
                                    function deleteAuthorityToPay(id) {
                                        var sure = confirm('Are you sure? This action cannot be reversed');
                                        if(sure ==false){
                                            return false;
                                        }else {
                                            data = {
                                                loan_id: id, _token: "{{csrf_token()}}"
                                            }
                                            $.ajax({
                                                dataType: 'json',
                                                type: "DELETE",
                                                url: '{{URL::to('/deleteAuthorityDeductToPay')}}',
                                                data: data,
                                                success: function (response) {
                                                    //location.reload();
                                                    window.location=response.url;
                                                }
                                            });
                                        }
                                    }

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
                    $('.example1').DataTable()
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


