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
        <!-- Content Header (Page header) -->
        <section class="content">
           {{--@include('dashboard.coopLogo')--}}
            <div class="row col-md-10 col-lg-10 flex justify-content-center">
                <div class="box box-primary " style="padding: 10px;">
                    <div role="form">
                        <div style="display: inline-flex; margin-left: 10px;">
                            <div style="background-color: #4e555b;width: auto;" class="col-md-12 col-lg-12">
                                <label style="color: #ffffff;padding-top:4px;">SAVING/WITHDRAWAL TRANSACTIONS</label>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="example2" class="table table-bordered table-striped">
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
                    </div>
                </div>
            </div>
            <script>
                $(function () {
                    $('#example1').DataTable()
                    $('#example2').DataTable({
                        'paging'      : true,
                        'lengthChange': false,
                        'searching'   : true,
                        'ordering'    : false,
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

                <!-- /.control-sidebar-menu -->

            </div>

        </div>
    </aside>
@endsection

