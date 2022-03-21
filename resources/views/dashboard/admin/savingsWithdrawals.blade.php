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
       {{-- @include('dashboard.coopLogo')--}}
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
                                <h3 class="box-title">List View of Savings Withdrawal Requests</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>Account Name</th>
                                        <th>Account Number</th>
                                        <th>Description</th>
                                        <th>Withdrawal Amount(<del style="text-decoration-style: double">N</del>)</th>
                                        <th>Date Submitted</th>
                                        <th>Withdrawal Status</th>
                                    </tr>
                                    </thead>
                                        @foreach($savings as $saving)
                                            @if($saving->users->name != 'Administrator')
                                            <tr data-href="{{url('/dashboard/admin/savingsWithdrawalApproval/'.$saving->id)}}" style="cursor: pointer">
                                                <td>{{$saving->users->name}}</td>
                                                <td>{{$saving->users->ippis_no}}</td>
                                                <td>{{$saving->description}}</td>
                                                <td>{{number_format($saving->amount_withdrawn,2)}}</td>
                                                <td>{{date('d-M-Y h:m:s',strtotime($saving->created_at))}}</td>
                                                <td>
                                                    @if($saving->status== 'Processing')
                                                    <span class="label label-warning">{{$saving->status}}</span>
                                                    @elseif($saving->status === 'Rejected')
                                                    <span class="label label-danger">{{$saving->status}}
                                                    @elseif($saving->status === 'Approved')
                                                    <span class="label label-success">{{$saving->status}}
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

            </div>
            <!-- /.tab-pane -->
        </div>
    </aside>
@endsection


