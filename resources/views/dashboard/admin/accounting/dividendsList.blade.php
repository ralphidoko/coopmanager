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
                                <h3 class="box-title">Yearly Declared Dividends</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body table-responsive">
                                <table id="example-2" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>View Beneficiaries</th>
                                        <th>Financial Year</th>
                                        <th>Proposed Dividends on Savings(<del style="text-decoration-style: double">N</del>)</th>
                                        <th>Proposed Loan Patronage Dividends(<del style="text-decoration-style: double">N</del>)</th>
                                        <th>Proposed Total Dividends(<del style="text-decoration-style: double">N</del>)</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($declaredDividends as $declaredDividend)
                                            <tr data-toggle="collapse" data-target="#{{$declaredDividend->financialYear}}" class="accordion-toggle">
                                                <td><button class="btn btn-default btn-xs"><span class="glyphicon glyphicon-eye-open"></span></button></td>
                                                <td>{{$declaredDividend->financialYear}}</td>
                                                <td>{{number_format($declaredDividend->proposed_main_dividend,2)}}</td>
                                                <td>{{number_format($declaredDividend->proposed_lpd,2)}}</td>
                                                <td>{{number_format($declaredDividend->proposed_dividend,2)}}</td>
                                            </tr>
                                            <tr>
                                                @php
                                                    $dividendsEarned = \App\Dividend::where('financial_year','LIKE','%'.$declaredDividend->financialYear.'%')->get();
                                                @endphp
                                                <td colspan="12" class="hiddenRow">
                                                    <div class="accordian-body collapse install_table" id="{{$declaredDividend->financialYear}}">
                                                           <table class="table table-striped example-1">
                                                            <thead>
                                                            <tr>
                                                                <th>Member's Name</th>
                                                                <th>Earned Dividends on Savings(<del style="text-decoration-style: double">N</del>)</th>
                                                                <th>Earned Loan Patronage Dividends(<del style="text-decoration-style: double">N</del>)</th>
                                                                <th>Total Dividends Earned (<del style="text-decoration-style: double">N</del>)</th>
                                                                <th>Financial Year</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($dividendsEarned as $dividendEarned)
                                                                <tr data-toggle="collapse"  class="accordion-toggle" data-target="#demo10">
                                                                    <td>{{$dividendEarned->users->name}}</td>
                                                                    <td>{{number_format($dividendEarned->dividend,2)}}</td>
                                                                    <td>{{number_format($dividendEarned->loan_patronage_dividend,2)}}</td>
                                                                    <td>{{number_format($dividendEarned->total_dividends,2)}}</td>
                                                                    <td>{{$dividendEarned->financial_year}}</td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </td>
                                            </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <div class="pagination">
                                    {{--{{ $users->links() }}--}}
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
