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
       {{-- @include('dashboard.coopLogo')--}}
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-xs-12">

                        <div class="box box-danger" >
                            <div class="box-header">
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                </div>
                                <h3 class="box-title">List View of all Loan</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="table-responsive" style="margin: 10px">
                                     <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>Applicant</th>
                                        <th>Loan Type</th>
                                        <th>Loan Amount(<del style="text-decoration-style: double">N</del>)</th>
                                        <th>Total Payable(<del style="text-decoration-style: double">N</del>)</th>
                                        <th>Monthly Amount Payable(<del style="text-decoration-style: double">N</del>)</th>
                                        <th>Total Interest Payable(<del style="text-decoration-style: double">N</del>)</th>
{{--                                        <th>Total Recovered(<del style="text-decoration-style: double">N</del>)</th>--}}
{{--                                        <th>Loan Balance</th>--}}
                                        <th>Loan State</th>
                                    </tr>
                                    </thead>
                                    <a href="">
                                    @foreach($loans as $loan)
                                        @if($loan->users->name != 'Administrator')
                                            <tr data-href="{{url('/dashboard/admin/adminLoanApproval/'.$loan->id)}}" style="cursor: pointer">
                                           <td>{{$loan->users->name}}</td>
                                            <td>{{$loan->loan_type}}</td>
                                            <td>{{number_format($loan->loan_amount,2)}}</td>
                                            <td>{{number_format($loan->total_amount_payable,2)}}</td>
                                            <td>{{number_format($loan->monthly_interest_payable,2)}}</td>
                                            <td>{{number_format($loan->total_interest_payable,2)}}</td>
{{--                                           <td>{{number_format($loan->amount_recovered,2)}}</td>--}}
{{--                                            <td>{{number_format($loan->total_amount_payable - $loan->amount_recovered,2)}}</td>--}}
                                            @if($loan->status=='Processing')
                                                <td><span class="label label-warning">{{$loan->status}}</span></td>
                                            @endif
                                            @if($loan->status=='Approved')
                                                <td><span class="label label-success">{{$loan->status}}</span></td>
                                            @endif
                                           @if($loan->status=='Settled')
                                               <td><span class="label label-success">{{$loan->status}}</span></td>
                                           @endif
                                            @if($loan->status=='Rejected')
                                                <td><span class="label label-danger">{{$loan->status}}</span></td>
                                            @endif
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
        <strong>Copyright &copy; 2020 <a href="https://isosystemss.com" target="_blank">ISOSYSTEMS</a>.</strong> All rights
        reserved.
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-white">

        <!-- Tab panes -->
        <div class="tab-content">
            <!-- Home tab content -->
            <div class="tab-pane" id="control-sidebar-home-tab">


            </div>
        </div>
    </aside>
@endsection


