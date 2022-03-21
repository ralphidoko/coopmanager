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
<livewire:change-password />

@section('main-content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h3>
                <b>{{\Illuminate\Support\Facades\Auth::user()->name}}, <font style="color: green">You are now logged in as an Admin</font></b>
                {{--                @include('flashMessages')--}}
            </h3>
        </section><br />

        <!-- Main content -->
        <section class="content">
            <!-- Info boxes -->
            <div class="row">
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-aqua"><font style="font-weight: bold; font-size:90px;"><del style="text-decoration-style: double;">N</del></font></span>
                        <div class="info-box-content">
                            <span class="info-box-text" style="font-size: large;font-weight: bold">Total Loan Value</span>
                            <a href="{{url('/dashboard/admin/loanApplicationList')}}"><span class="info-box-number" style="font-size: 28px;font-weight: bold">{{number_format($dashboard_data['total_loan_value'],2)}}</span></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-aqua"><font style="font-weight: bold; font-size:90px;"><del style="text-decoration-style: double;">N</del></font></span>
                        <div class="info-box-content">
                            <span class="info-box-text" style="font-size: large;font-weight: bold">Loan Recovered</span>
                            <a href="#"><span class="info-box-number" style="font-size: 28px;font-weight: bold">{{number_format(round($dashboard_data['total_loan_recovered']),2)}}</span></a>
                        </div>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-aqua"><font style="font-weight: bold; font-size:90px;"><del style="text-decoration-style: double;">N</del></font></span>
                        <div class="info-box-content">
                            <span class="info-box-text" style="font-size: large;font-weight: bold">Total Savings</span>
                            <a href="#"><span class="info-box-number" style="font-size: 28px;font-weight: bold">{{number_format($dashboard_data['total_saving'],2)}}</span></a>
                        </div>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-aqua"><font style="font-weight: bold; font-size:90px;"><del style="text-decoration-style: double;">N</del></font></span>
                        <div class="info-box-content">
                            <span class="info-box-text" style="font-size: large;font-weight: bold">Total Debits</span>
                            <a href=""><span class="info-box-number" style="font-size: 28px;font-weight: bold">{{number_format($dashboard_data['total_debits'],2)}}</span></a>
                        </div>
                    </div>
                </div>
                <!-- fix for small devices only -->
                <div class="clearfix visible-sm-block"></div>

                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-aqua"><font style="font-weight: bold; font-size:90px;"><del style="text-decoration-style: double;">N</del></font></span>
                        <div class="info-box-content">
                            <span class="info-box-text" style="font-size: large;font-weight: bold">Main Dividends</span>
                            <a href="#"><span class="info-box-number" style="font-size: 28px;font-weight: bold">{{number_format(($dashboard_data['proposedDividend']*(90/100)),2)}}</span></a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-aqua"><font style="font-weight: bold; font-size:90px;"><del style="text-decoration-style: double;">N</del></font></span>
                        <div class="info-box-content">
                            <span class="info-box-text" style="font-size: large;font-weight: bold">LPD Declared &#160;<small data-toggle="tooltip" data-placement="top" title="Loan Patronage Dividends">?</small></span>
                            <a href="#"><span class="info-box-number" style="font-size: 28px;font-weight: bold">{{number_format(($dashboard_data['proposedDividend']*(10/100)),2)}}</span></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-aqua"><font style="font-weight: bold; font-size:90px;"><del style="text-decoration-style: double;">N</del></font></span>
                        <div class="info-box-content">
                            <span class="info-box-text" style="font-size: large;font-weight: bold">Total Dividends&#160;<small data-toggle="tooltip" data-placement="top" title="Dividends Earned + LPD Earned">?</small></span>
                            <a href="{{url('dashboard/admin/accounting/dividendsList')}}"><span class="info-box-number" style="font-size: 28px;font-weight: bold">{{number_format($dashboard_data['proposedDividend'],2)}}</span></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-aqua"><font style="font-weight: bold; font-size:90px;"><del style="text-decoration-style: double;">N</del></font></span>
                        <div class="info-box-content">
                            <span class="info-box-text" style="font-size: large;font-weight: bold">Total Transactions&#160;<small data-toggle="tooltip" data-placement="top" title="Dividends Earned + LPD Earned">?</small></span>
                            <a href="{{url('/dashboard/admin/membersTransactions')}}"><span class="info-box-number" style="font-size: 28px;font-weight: bold">{{number_format($dashboard_data['total_transaction'],2)}}</span></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-aqua"><font style="font-weight: bold; font-size:90px;"><del style="text-decoration-style: double;">N</del></font></span>
                        <div class="info-box-content">
                            <span class="info-box-text" style="font-size: large;font-weight: bold">Total Income&#160;<small data-toggle="tooltip" data-placement="top" title="2021 Earned Income">?</small></span>
                            <a href=""><span class="info-box-number" style="font-size: 28px;font-weight: bold">{{number_format(round($dashboard_data['total_income']),2)}}</span></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-aqua"><font style="font-weight: bold; font-size:90px;"><del style="text-decoration-style: double;">N</del></font></span>
                        <div class="info-box-content">
                            <span class="info-box-text" style="font-size: large;font-weight: bold">Total Expense&#160;<small data-toggle="tooltip" data-placement="top" title="2021 Incured Expenses">?</small></span>
                            <a href="{{url('dashboard/admin/accounting/recordExpense')}}"><span class="info-box-number" style="font-size: 28px;font-weight: bold">{{number_format(round($dashboard_data['total_expense']),2)}}</span></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-aqua"><font style="font-weight: bold; font-size:90px;"><del style="text-decoration-style: double;">N</del></font></span>
                        <div class="info-box-content">
                            <span class="info-box-text" style="font-size: large;font-weight: bold">Total Membership&#160;<small data-toggle="tooltip" data-placement="top" title="2021 Active Members">?</small></span>
                            <a href="{{url('/dashboard/admin/membershipApplication')}}"><span class="info-box-number" style="font-size: 28px;font-weight: bold">{{count($dashboard_data['members'])}}</span></a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-danger">
                        <div class="box-header with-border">
                            <h3 class="box-title">Members' Transactions</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table no-margin" id="example1">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Transaction Type</th>
                                        <th>Transaction Amount</th>
                                        <th>Channel</th>
                                        <th>Status</th>
                                        <th>Transaction Reference</th>
                                        <th>Merchant</th>
                                        <th>Transaction Date</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($transactions as $transaction)
                                        <tr>
                                            <td>{{$transaction->users->name}}</td>
                                            <td>{{$transaction->transaction_type}}</td>
                                            <td><del style="text-decoration-style: double">N</del>{{number_format($transaction->transaction_amount,2)}}</td>
                                            <td>{{$transaction->channel}}</td>
                                            <td><span class="label label-success">Successful</span></td>
                                            <td>{{$transaction->transaction_reference}}</td>
                                            <td>Paystack</td>
                                            <td>{{$transaction->created_at}}</td>
                                        </tr>
                                    </tbody>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                        <div class="box-footer clearfix pull-left">
                            <a href="{{url('/dashboard/admin/membersTransactions')}}" class="btn btn-sm btn-info btn-flat pull-right">View All Transaction</a>
                        </div>

                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- Main row -->
            <div class="row">
                <!-- Left col -->
                <div class="col-md-8">
                    <!-- MAP & BOX PANE -->
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Members' Loans</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table no-margin" >
                                    <thead>
                                    <tr>
                                        <th>Applicant</th>
                                        <th>Loan Type</th>
                                        <th>Loan Amount(<del style="text-decoration-style: double">N</del>)</th>
                                        <th>Total Payable(<del style="text-decoration-style: double">N</del>)</th>
                                        <th>Monthly Interest Payable(<del style="text-decoration-style: double">N</del>)</th>
                                        <th>Total Interest Payable(<del style="text-decoration-style: double">N</del>)</th>
                                        <th>Loan State</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($loans as $loan)
                                        <tr>
                                            <td>{{$loan->users->name}}</td>
                                            <td>{{$loan->loan_type}}</td>
                                            <td>{{number_format($loan->loan_amount,2)}}</td>
                                            <td>{{number_format($loan->total_amount_payable,2)}}</td>
                                            <td>{{number_format($loan->monthly_interest_payable,2)}}</td>
                                            <td>{{number_format($loan->total_interest_payable,2)}}</td>
                                            @if($loan->status=='Processing')
                                                <td><span class="label label-warning">{{$loan->status}}</span></td>
                                            @endif
                                            @if($loan->status=='Approved')
                                                <td><span class="label label-success">{{$loan->status}}</span></td>
                                            @endif
                                            @if($loan->status=='Settled')
                                                <td><span class="label label-info">{{$loan->status}}</span></td>
                                            @endif
                                            @if($loan->status=='Rejected')
                                                <td><span class="label label-danger">{{$loan->status}}</span></td>
                                            @endif
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="box-footer clearfix">
                            <a href="{{url('/dashboard/admin/loanApplicationList')}}" class="btn btn-sm btn-info btn-flat pull-right">View All Loans</a>
                        </div>
                    </div>
                </div>
                <!-- /.col -->

                <div class="col-md-4">
                    <!-- PRODUCT LIST -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Available Loan Products</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            @foreach($dashboard_data['products'] as $product)
                                <ul class="products-list product-list-in-box">
                                    <li class="item">
                                        <div class="product-info">
                                            <a class="product-title">{{$product['item_name']}}
                                                <span class="label label-info pull-right"><del style="text-decoration-style: double">N</del>{{number_format($product['item_price'],2)}}</span></a>
                                            <span class="product-description">
                                          {{$product['item_description']}}
                                        </span>
                                        </div>
                                    </li>
                                </ul>
                            @endforeach
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer text-center">
                            <a href="{{url('/dashboard/admin/products/manageProduct')}}" class="uppercase">View All Products</a>
                        </div>
                        <!-- /.box-footer -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 2.4.0
        </div>
        <strong>Copyright &copy; 2021 Nepza Cooperative <a href="https://isosystemss.com" target="_blank">ISOSYSTEMS</a>.</strong> All rights
        reserved.
    </footer>
@endsection
