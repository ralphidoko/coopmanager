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
           {{--@include('dashboard.coopLogo')--}}
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-xs-12">

                        <div class="box box-danger" style="padding: 10px;">
                            <div class="box-header">
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                </div>
                                <h3 class="box-title">List View of all Loan</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>Loan Type</th>
                                        <th>Loan Amount(<del style="text-decoration-style: double">N</del>)</th>
                                        <th>Total Payable(<del style="text-decoration-style: double">N</del>)</th>
                                        <th>Monthly Interest Payable(<del style="text-decoration-style: double">N</del>)</th>
                                        <th>Total Interest Payable(<del style="text-decoration-style: double">N</del>)</th>
{{--                                        <th>Loan Balance</th>--}}
                                        <th>Loan State</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    @foreach($loans as $loan)
                                        <tr>
                                            <td>{{$loan->loan_type}}</td>
                                            <td>{{number_format($loan->loan_amount,2)}}</td>
                                            <td>{{number_format($loan->total_amount_payable,2)}}</td>
                                            <td>{{number_format($loan->monthly_interest_payable,2)}}</td>
                                            <td>{{number_format($loan->total_interest_payable,2)}}</td>
{{--                                            <td></td>--}}
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
                                            <td>
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                                        <span class="fa fa-caret-down"></span></button>
                                                    <ul class="dropdown-menu">
                                                        <li data-href="{{url('/application/loanDetails/'.$loan->id)}}" style="cursor:pointer">View Loan</li>
                                                        @if($loan->status == 'Processing')
                                                            <li data-href="{{url('/application/'.$loan->id.'/updateLoan/')}}" style="cursor:pointer">Edit Loan</li>
                                                        @endif
                                                        @if($loan->status == 'Processing')
                                                            <li onclick="deleteLoan(this.id)" id="{{$loan->id}}" style="cursor: pointer;">Delete Application</li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                                <script>
                                    function deleteLoan(id) {
                                        var sure = confirm('Are you sure? This action cannot be reversed');
                                        if(sure ==false){
                                            return false;
                                        }else {
                                            data = {
                                                loan_id: id, _token: "{{csrf_token()}}"
                                            }
                                            $.ajax({
                                                dataType: 'json',
                                                type: "DELETE",
                                                url: '{{URL::to('/deleteApplication')}}',
                                                data: data,
                                                success: function (response) {
                                                    //location.reload();
                                                    window.location=response.url;
                                                }
                                            });
                                        }
                                    }
                                </script>
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
                    const rows = document.querySelectorAll("li[data-href]");
                    rows.forEach(row => {
                        row.addEventListener("click", () => {
                            window.location.href = row.dataset.href;
                        });
                    });
                });
                $(function () {
                    $('#example1').DataTable()
                    $('#example2').DataTable({
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
        </div>
    </aside>
@endsection


