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
                        <div class="box box-danger"  style="margin-top: 10px">
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
                                <h3 class="box-title">Members' Account Transactions</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body table-responsive">
                                <table id="example-2" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>View Transactions</th>
                                        <th>Account Name</th>
                                        <th>Account Number</th>
                                        <th>Total Credit (Deposit)(<del style="text-decoration-style: double">N</del>)</th>
                                        <th>Total Debit (Withdrawal)(<del style="text-decoration-style: double">N</del>)</th>
                                        <th>Available/Book Balance (<del style="text-decoration-style: double">N</del>)</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($users as $user)
                                        @if($user->name != 'Administrator')
                                            <tr data-toggle="collapse" data-target="#{{$user->id}}" class="accordion-toggle">
                                                <td><button class="btn btn-default btn-xs"><span class="glyphicon glyphicon-eye-open"></span></button></td>
                                                <td>{{$user->name}}</td>
                                                <td>{{$user->ippis_no}}</td>
                                                <td>{{number_format($user->savings->sum('amount_saved'),2)}}</td>
                                                <td>{{number_format($user->savings->where('status','Approved')->sum('amount_withdrawn'),2)}}</td>
                                                <td>{{number_format($user->savings->sum('amount_saved') - $user->savings->where('status','Approved')->sum('amount_withdrawn'),2)}}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="12" class="hiddenRow">
                                                        <div class="accordian-body collapse install_table" id="{{$user->id}}">
                                                            <table class="table table-striped example-1">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Transaction Type</th>
                                                                        <th>Transaction Date</th>
                                                                        <th>Credit (Deposit)(<del style="text-decoration-style: double">N</del>)</th>
                                                                        <th>Debit (Withdrawal)(<del style="text-decoration-style: double">N</del>)</th>
                                                                        <th>Theoritical Balance (<del style="text-decoration-style: double">N</del>)</th>
                                                                    </tr>
                                                                    </thead>
                                                                <tbody>
                                                                    @foreach($user->savings as $saving)
                                                                        <tr data-toggle="collapse"  class="accordion-toggle" data-target="#demo10">
                                                                            <td>{{$saving->description}}</td>
                                                                            <td>{{date('d-M-Y',strtotime($saving->month))}}</td>
                                                                            <td>
                                                                                @if($saving->amount_saved > 0.00)
                                                                                    <span class="label label-success">{{number_format($saving->amount_saved,2)}}</span>
                                                                                @else
                                                                                    <span class="label"></span>
                                                                                @endif
                                                                            </td>
                                                                            <td>
                                                                                @if($saving->amount_withdrawn > 0.00 && $saving->status !== 'Processing' && $saving->status !== 'Rejected')
                                                                                    <span class="label label-danger" data-toggle="tooltip" title="Withdrawal Request Approved">{{number_format($saving->amount_withdrawn,2)}}
                                                                                @elseif($saving->amount_withdrawn > 0.00 && $saving->status === 'Processing')
                                                                                   <span class="label label-info" data-toggle="tooltip" title="Approval Pending">{{number_format($saving->amount_withdrawn,2)}}
                                                                                @elseif($saving->amount_withdrawn > 0.00 && $saving->status === 'Rejected')
                                                                                   <span class="label label-info" data-toggle="tooltip" title="Withdrawal Request Rejected"><del style="text-decoration-style: double;text-decoration-color: red">{{number_format($saving->amount_withdrawn,2)}}</del>
                                                                                @else
                                                                                <span class="label"></span>
                                                                                @endif
                                                                            </td>
                                                                            <td>{{number_format($saving->balance,2)}}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                                <div class="pagination">
                                    {{ $users->links() }}
                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </section>
            <!-- /.content -->
            <script>
                $(function () {
                    //use class for multiple table instead of id
                    $('.example-1').DataTable({
                        'paging'      : true,
                        'lengthChange': true,
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
