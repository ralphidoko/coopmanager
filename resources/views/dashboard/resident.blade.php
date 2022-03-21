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
<livewire:change-password />
<livewire:allow-admin />
{{--@include('dashboard.reports.user.reportFilter')--}}
@section('main-content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            @php
                $checkUserVerificationStatus = \App\Member::where('user_id',Auth::id())->first();
            @endphp
            <h1>
                <b>Welcome, {{\Illuminate\Support\Facades\Auth::user()->name}}</b>&#160;&#160;&#160;&#160;&#160;&#160;&#160;
                <b>Your Last Login Was: {{date('h:i:s a m-d-Y',strtotime(Auth::user()->last_login_at))}}</b><br>
                @if($checkUserVerificationStatus->approval_count != 2)
                <span style="color: green;font-size: medium ! important">Your dashboard is inactive because your membership application is being processed.</span>
                <a href="{{url('/logout')}}" style="font-size: medium;border-bottom: 2px solid;">Check back later</a>
                @endif
                @if($checkUserVerificationStatus->membership_status == 'Archived')
                    <span style="color: green;font-size: medium ! important">Your membership renewal request is awaiting EXCOs approval.</span>
                    <a href="{{url('/logout')}}" style="font-size: medium;border-bottom: 2px solid;">Check back later</a>
                @endif
            </h1>
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
                    <span class="info-box-number" style="font-size: 28px;font-weight: bold">{{number_format($dashboard_data['total_loan_value'],2)}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><font style="font-weight: bold; font-size:90px;"><del style="text-decoration-style: double;">N</del></font></span>
                <div class="info-box-content">
                    <span class="info-box-text" style="font-size: large;font-weight: bold">Total Savings</span>
                    <span class="info-box-number" style="font-size: 28px;font-weight: bold">{{number_format($dashboard_data['total_saving'],2)}}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><font style="font-weight: bold; font-size:90px;"><del style="text-decoration-style: double;">N</del></font></span>
                <div class="info-box-content">
                    <span class="info-box-text" style="font-size: large;font-weight: bold">Total Debits</span>
                    <span class="info-box-number" style="font-size: 28px;font-weight: bold">{{number_format($dashboard_data['total_withdrawals'],2)}}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><font style="font-weight: bold; font-size:90px;"><del style="text-decoration-style: double;">N</del></font></span>
                <div class="info-box-content">
                    <span class="info-box-text" style="font-size: large;font-weight: bold">Account Balance</span>
                    <span class="info-box-number" style="font-size: 28px;font-weight: bold">{{number_format($dashboard_data['total_saving'] - $dashboard_data['total_withdrawals'],2)}}</span>
                </div>
            </div>
        </div>
        <!-- /.col -->
        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><font style="font-weight: bold; font-size:90px;"><del style="text-decoration-style: double;">N</del></font></span>
                <div class="info-box-content">
                    <span class="info-box-text" style="font-size: large;font-weight: bold">Dividends Earned</span>
                    <span class="info-box-number" style="font-size: 28px;font-weight: bold">00.00</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><font style="font-weight: bold; font-size:90px;"><del style="text-decoration-style: double;">N</del></font></span>
                <div class="info-box-content">
                    <span class="info-box-text" style="font-size: large;font-weight: bold">LPD Earned &#160;<small data-toggle="tooltip" data-placement="top" title="Loan Patronage Dividends">?</small></span>
                    <span class="info-box-number" style="font-size: 28px;font-weight: bold">00.00</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><font style="font-weight: bold; font-size:90px;"><del style="text-decoration-style: double;">N</del></font></span>
                <div class="info-box-content">
                    <span class="info-box-text" style="font-size: large;font-weight: bold">Total Dividends&#160;<small data-toggle="tooltip" data-placement="top" title="Dividends Earned + LPD Earned">?</small></span>
                    <span class="info-box-number" style="font-size: 28px;font-weight: bold">00.00</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><font style="font-weight: bold; font-size:90px;"><del style="text-decoration-style: double;">N</del></font></span>
                <div class="info-box-content">
                    <span class="info-box-text" style="font-size: large;font-weight: bold">Total Transactions&#160;<small data-toggle="tooltip" data-placement="top" title="Dividends Earned + LPD Earned">?</small></span>
                    <span class="info-box-number" style="font-size: 28px;font-weight: bold">{{number_format($dashboard_data['total_transactions'],2)}}</span>
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">My Transactions</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                  <div class="table-responsive">
                     <table class="table no-margin">
                        <thead>
                        <tr>
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
                    <div class="box-footer clearfix">
                        <a href="{{url('/transactions/myTransactions')}}" class="btn btn-sm btn-info btn-flat pull-right">View All Transaction</a>
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
                        <h3 class="box-title">My Loans</h3>
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
                <a href="{{url('/application/loanList')}}" class="btn btn-sm btn-info btn-flat pull-right">View All Loans</a>
             </div>
    </div>
            <!-- TABLE: LATEST ORDERS -->
            <div class="box box-info pull-right">
                <div class="box-header with-border">
                    <h3 class="box-title">My Monthly Savings</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table no-margin">
                            <thead>
                            <tr>
                                <th>Transaction Type</th>
                                <th>Transaction Date</th>
                                <th>Credit (Deposit)(<del style="text-decoration-style: double">N</del>)</th>
                                <th>Debit (Withdrawal)(<del style="text-decoration-style: double">N</del>)</th>
                                <th>Balance (<del style="text-decoration-style: double">N</del>)</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($savings as $saving)
                                <tr>
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
                    <!-- /.table-responsive -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">
                    <a href="{{url('/withdrawals/withdrawalTransactions')}}" class="btn btn-sm btn-info btn-flat pull-right">View All Savings</a>
                </div>
                <!-- /.box-footer -->
            </div>
            <!-- /.box -->
            <!-- /.box -->
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
                    <a href="javascript:void(0)" class="uppercase">View All Products</a>
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
        <strong>Copyright &copy; 2020 <a href="https://isosystemss.com">ISOSYSTEMS</a>.</strong> All rights
        reserved.
    </footer>
@endsection
