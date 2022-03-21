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
                            <div class="box-header">
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                </div>
                                <h3 class="box-title">Members' Transactions</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body table-responsive">
                                <table id="example-2" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>View Transactions</th>
                                        <th>Name</th>
                                        <th>Membership Number</th>
                                        <th>Total Transaction(<del style="text-decoration-style: double">N</del>)</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($users as $user)
                                        @if($user->name != 'Administrator')
                                            <tr data-toggle="collapse" data-target="#{{$user->id}}" class="accordion-toggle">
                                                <td><button class="btn btn-default btn-xs"><span class="glyphicon glyphicon-eye-open"></span></button></td>
                                                <td>{{$user->name}}</td>
                                                <td>{{$user->member_id}}</td>
                                                <td>{{number_format($user->transactions->sum('transaction_amount'),2)}}</td>
                                            </tr>
                                                <td colspan="12" class="hiddenRow">
                                                    @php $counter = 1; @endphp
                                                    <div class="accordian-body collapse install_table" id="{{$user->id}}">
                                                        <table class="table table-striped example-1">
                                                            <thead>
                                                            <tr>
                                                                <th>SN</th>
                                                                <th>Transaction Type</th>
                                                                <th>Transaction Amount(<del style="text-decoration-style: double">N</del>)</th>
                                                                <th>Channel</th>
                                                                <th>Status</th>
                                                                <th>Transaction Reference</th>
                                                                <th>Merchant</th>
                                                                <th>Transaction Date</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($user->transactions as $transaction)
                                                                    <tr data-toggle="collapse"  class="accordion-toggle" data-target="#demo10">
                                                                        <td>{{$counter++}}</td>
                                                                        <td>{{$transaction->transaction_type}}</td>
                                                                        <td><del style="text-decoration-style: double">N</del>{{number_format($transaction->transaction_amount,2)}}</td>
                                                                        <td>{{$transaction->channel}}</td>
                                                                        <td><span class="label label-success">Successful</span></td>
                                                                        <td>{{$transaction->transaction_reference}}</td>
                                                                        <td>Paystack</td>
                                                                        <td>{{$transaction->created_at}}</td>
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
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <div class="row">
                            <span class="pull-right totalExpense" style="margin-right: 140px;font-size: 40px;font-weight: bolder">Total Members' Transaction:<del style="text-decoration-style: double">N</del>{{number_format($totalTransaction,2)}}</span>
                        </div>
                    </div>
                    <div class="pagination">
                        {{ $users->links() }}
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
