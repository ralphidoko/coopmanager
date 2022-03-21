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
        @include('dashboard.coopLogo')
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box box-danger" style="padding: 10px ! important;">
                            <div class="box-header">
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                </div>
                                <h3 class="box-title">Membership Renewal Requests</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>Membership ID</th>
                                        <th>Member's Name</th>
                                        <th>Office Location</th>
                                        <th>Department</th>
                                        <th>Designation</th>
                                        <th>Request Status</th>
                                    </tr>
                                    </thead>
                                    @foreach($renewalRequests as $request)
                                        @if($request->name != 'Administrator')
                                            <tr data-href="{{url('/dashboard/admin/membershipRenewalApproval/'.$request->id) }}" style="cursor: pointer">
                                                <td>{{$request->member_id}}</td>
                                                <td>{{$request->name}}</td>
                                                <td>{{$request->members->office_location}}</td>
                                                <td>{{$request->members->department}}</td>
                                                <td>{{$request->members->designation}}</td>
                                                <td>
                                                    @if($request->membership_renewal_status == 'Request Submitted')
                                                        <span class="label label-warning">{{$request->membership_renewal_status}}</span>
                                                    @elseif($request->membership_renewal_status == 'Request Approved')
                                                        <span class="label label-success">{{$request->membership_renewal_status}}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </table>
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
            <script>
                document.addEventListener("DOMContentLoaded", () =>{
                    const rows = document.querySelectorAll("tr[data-href]");
                    rows.forEach(row => {
                        row.addEventListener("click", () => {
                            window.location.href = row.dataset.href;
                        });
                    });
                });
                $(function () {
                    // $('#example2').DataTable()
                    $('#example1').DataTable({
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
@endsection



