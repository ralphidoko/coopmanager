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
       {{-- @include('dashboard.coopLogo')--}}
            <br />
            <!-- Main content -->
            <section class="content">
                <div class="col-md-10 col-lg-10" style="margin-top: 10px;">
                    <div class="box box-info col-md-10 col-lg-10">
                        <div class="box-header with-border">
                            <h3 class="box-title">Report Filter</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="modal-body">
                                <form method="POST" action="{{url('/filterAccountStatement')}}" enctype="">
                                    @csrf
                                    <div style="display: inline-flex;" class="col-lg-11 col-md-10">
                                        {{-- daterangepicker--}}
                                        <div class="form-group col-md-12 col-lg-12">
                                            <label>Report Date Range:</label>
                                            <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                                <i class="fa fa-calendar"></i>&nbsp;
                                                <input name="date_range" value="" required style="border-style: none"><i class="fa fa-caret-down"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="display: inline-flex;" class="col-lg-12 col-md-10" id="parent">
                                        <div class="form-group col-lg-12 col-md-10 col-xs-7" id="child">
                                            <label>Select type of Report</label>
                                            <select id="report_type" name="report_type" class="form-control" required>
                                                <option value="">Select report type</option>
                                                <option value="account_statement">Account Statement</option>
                                                <option value="loan_statement">Loan Statement</option>
                                                <option value="consolidated_earning">Dividends Earned</option>
                                                <option value="trans_statement">Statement of Transaction</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-10 col-lg-10" id="child">
                                            <label>Report Action</label>
                                            <div class="input-group">
                                                <button type="submit" name="pdf" value="pdf" class="btn btn-primary pull-right" style="margin-right: 5px;">
                                                    <i class="fa fa-file-pdf-o"></i> Generate PDF</button>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-10 col-lg-10" id="child">
                                            <label>Report Action</label>
                                            <div class="input-group">
                                                <button type="submit" name="excel" value="excel" class="btn btn-success pull-right"><i class="fa fa-file-excel-o"></i> Export to Excel</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </section>
            <!-- /.content -->
            <!-- /.content-wrapper -->
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
            {!! Toastr::message() !!}
                <!-- /.control-sidebar-menu -->
                <!-- /.control-sidebar-menu -->
            </div>
        </div>
    </aside>

    <script type="text/javascript">
        $(function() {

            var start = moment().subtract(29, 'days');
            var end = moment();

            function cb(start, end) {
                $('#reportrange input').val(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
            }

            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, cb);

            cb(start, end);

        });
    </script>
@endsection


