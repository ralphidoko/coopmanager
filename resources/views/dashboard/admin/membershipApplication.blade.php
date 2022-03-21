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
        {{--@include('dashboard.coopLogo')--}}
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
                                <h3 class="box-title">Membership Applications</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        {{--<th>S/No</th>--}}
                                        <th>Member's Name</th>
                                        <th>Membership No</th>
                                        <th>Department</th>
                                        <th>Designation</th>
                                        <th>Guarantor One</th>
                                        <th>Guarantor Two</th>
                                        <th>Application State</th>
                                        <th>Submission Date</th>
                                        <th>Membership Status</th>
                                    </tr>
                                    </thead>
                                    @php $counter = 1;@endphp
                                    @foreach($userDetails as $userDetail)
                                        @if($userDetail->first_name != 'Administrator')
                                            <tr data-href="{{url('/dashboard/admin/membershipApproval/'.$userDetail->id) }}" style="cursor: pointer">
                                                {{--<td>{{$counter++}}</td>--}}
                                                <td>{{$userDetail->first_name.' '.$userDetail->middle_name.' '.$userDetail->last_name}}</td>
                                                <td>{{$userDetail->member_id}}</td>
                                                <td>{{strtoupper($userDetail->department)}}</td>
                                                <td>{{strtoupper($userDetail->designation)}}</td>
                                                <td>{{strtoupper($userDetail->referee_one)}}</td>
                                                <td>{{strtoupper($userDetail->referee_two)}}</td>
                                                <th>
                                                    @if($userDetail->approval_status === 'Processing')
                                                        <span class="label label-warning">{{$userDetail->approval_status}}</span>
                                                    @elseif($userDetail->approval_status === 'Approved')
                                                        <span class="label label-success">{{$userDetail->approval_status}}</span>
                                                    @else
                                                        <span class="label label-danger">{{$userDetail->approval_status}}</span>
                                                    @endif
                                                </th>
                                                <td>{{$userDetail->created_at}}</td>
                                                <td>
                                                    @if($userDetail->membership_status === 'Active')
                                                        <span class="label label-success">{{$userDetail->membership_status}}</span>
                                                    @elseif($userDetail->membership_status === 'Archived')
                                                        <span class="label label-danger">{{$userDetail->membership_status}}</span>
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


