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
                    <div class="col-xs-10">
                        <div class="box box-danger"  style="margin-top: 10px;">
                            <div class="box-header">
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                </div>
                                <h3 class="box-title">Sundry Reports</h3>
                            </div>
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
                                        <form id="printReport" method="POST" action="{{url('/filterReports')}}">
                                            @csrf
                                            <div style="display: inline-flex;height: 70vh" class="row" id="parent">
                                                <div class="form-group col-lg-12 col-md-10" id="child">
                                                    <label>Select type of Report</label>
                                                    <select id="report_type" name="report_type" class="form-control" required>
                                                        <option value="">Select report type</option>
                                                        <option value="monthly_deposits">Monthly Deposits</option>
                                                        <option value="monthly_drawings">Monthly Drawings</option>
                                                        <option value="monthly_loan_fees">Monthly Loan Fees</option>
                                                        <option value="monthly_loan_approved">Monthly Loan Approved</option>
                                                        <option value="monthly_loan_recovered">Monthly Loan Recovered</option>
                                                        <option value="general_ledger">General Ledger</option>
                                                        <option value="expense_report">Expense Report</option>
                                                        <option value="declared_dividends">Declared Dividends</option>
                                                        <option value="members_transactions">Members' Transactions</option>
                                                        <option value="yearly_grouped_income">Monthly Income (Categorized)</option>
                                                        <option value="monthly_income_with_sources">Monthly Income With Sources</option>
                                                    </select>
                                                    <p id="tyError" style="color:red"></p>
                                                </div>
                                                <div class="form-group col-lg-12 col-md-10 col-xs-7 show2" id="child" style="display: none">
                                                    <label>Accounts/Journals</label>
                                                    <select class="form-control select2" id="journal[]" name="journals[]" multiple="multiple" data-placeholder="Select a State" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                                        <option value="">Select journals</option>
                                                        @foreach($journals as $journal)
                                                            <option selected value="{{$journal->id}}">{{$journal->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <input name="date_range" id="hidden_date" type="hidden" value="">
                                                </div>
                                                <div class="form-group col-md-10 col-lg-10 show1" id="child" style="display: none">
                                                    <label>Date Range:</label>
                                                    <div class="input-group dp">
                                                        <button type="button" class="btn btn-default pull-right" id="daterange-btn">
                                                            <span name="daterange" id="daterange">
                                                              <i class="fa fa-calendar"></i> Date Range Picker
                                                            </span>
                                                            <i class="fa fa-caret-down"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-8 col-lg-8" id="child">
                                                    <label>Report Action</label>
                                                    <div class="input-group">
                                                        <button type="submit" id="printPDF" name="pdf" value="pdf" class="btn btn-primary pull-right" style="margin-right: 5px;">
                                                            <i class="fa fa-file-pdf-o"></i> Generate PDF</button>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-10 col-lg-10" id="child">
                                                    <label>Report Action</label>
                                                    <div class="input-group">
                                                        <button type="submit" id="printExcel" name="excel" value="excel" class="btn btn-success pull-right"><i class="fa fa-file-excel-o"></i> Export to Excel</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <script>
                                            $(document).ready(function() {
                                                $('#report_type').on('change',function (){
                                                    if(this.value === 'general_ledger'){
                                                        $('.show1').show();$('.show2').show();
                                                    }else if(this.value === 'expense_report'){
                                                        $('.show1').show();$('.show2').hide();
                                                    }else if(this.value === 'members_transactions') {
                                                        $('.show1').show();$('.show2').hide();
                                                    }else if(this.value === 'declared_dividends') {
                                                        $('.show1').show();$('.show2').hide();
                                                    }else if(this.value === 'monthly_deposits'){
                                                            $('.show1').show();$('.show2').hide();
                                                    }else if(this.value === 'monthly_drawings'){
                                                        $('.show1').show();$('.show2').hide();
                                                    }else if(this.value === 'monthly_loan_fees'){
                                                        $('.show1').show();$('.show2').hide();
                                                    }else if(this.value === 'monthly_loan_approved'){
                                                        $('.show1').show();$('.show2').hide();
                                                    }else if(this.value === 'monthly_loan_recovered') {
                                                        $('.show1').show();$('.show2').hide();
                                                    }else if(this.value === 'yearly_grouped_income'){
                                                        $('.show1').show();$('.show2').hide();
                                                    }else if(this.value === 'monthly_income_with_sources'){
                                                        $('.show1').show();$('.show2').hide();
                                                    }else{
                                                        $('.show1').hide();$('.show2').hide();
                                                    }
                                                });

                                                $("#printPDF").click(function() {
                                                    if($('#report_type').val() == ''){
                                                        $('#report_type').focus();$('#tyError').text('Please select a report type').fadeOut(2000);return false;
                                                    }

                                                    $('#printPDF').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Downloading....please wait'
                                                      ).addClass('disabled');
                                                    setTimeout(function(){
                                                       // location.reload();
                                                        $('#printPDF').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Generate PDF'
                                                        ).removeClass('disabled');
                                                    }, 1000);
                                                });
                                                $("#printExcel").click(function() {
                                                    if($('#report_type').val() == ''){
                                                        $('#report_type').focus();$('#tyError').text('Please select a report type').fadeOut(2000);return false;
                                                    }
                                                    $('#printExcel').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Downloading....please wait'
                                                    ).addClass('disabled');
                                                    setTimeout(function(){
                                                        //location.reload();
                                                        $('#printExcel').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Export to Excel'
                                                        ).removeClass('disabled');
                                                    }, 1000);
                                                });
                                            });
                                        </script>
                                        <script type="text/javascript">
                                            $(document).ready(function (){
                                                //Initialize Select2 Elements
                                                $('.select2').select2()
                                                $(function() {
                                                    var start = moment().subtract(29, 'days');
                                                    var end = moment();
                                                    function cb(start, end) {
                                                        $('#daterange-btn span').html(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
                                                    }
                                                    $('#daterange-btn').daterangepicker({
                                                        autoUpdateInput: false,
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
                                                    $('#daterange-btn').on('apply.daterangepicker', function() {
                                                        $('#hidden_date').val($('#daterange').html());
                                                    });

                                                });
                                            })
                                        </script>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </section>
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
            </div>
        </div>
    </aside>
@endsection


