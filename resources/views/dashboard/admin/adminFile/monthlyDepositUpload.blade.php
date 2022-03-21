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

@include('dashboard.navigation')

@section('main-content')
    <div class="content-wrapper">
        <section class="content" xmlns:wire="http://www.w3.org/1999/xhtml" xmlns:nwire="http://www.w3.org/1999/xhtml">
         {{--@include('dashboard.coopLogo')--}}
            <br />
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box box-danger">
                            <div class="box-header with-border">
                                <h3 class="box-title">Monthly Savings Upload</h3>
                            </div>
                            <!-- form start -->
                            <form id="uploadFile" role="form" style="margin-top: 20px;" method="POST" action="/dashboard/admin/adminFile/importMonthlyDeposit" enctype="multipart/form-data">
                                @csrf
                                <div class="box-body">
{{--                                     @include('flashMessages')--}}
                                    @if(isset($errors) && $errors->any())
                                        <div class="alert alert-danger" style="font-size:15px ! important">
                                            @foreach($errors->all() as $error)
                                                {{$error}}
                                            @endforeach
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        <label for="exampleInputFile">Select File to Upload</label>
                                        <input type="file" name="deposit_file" id="exampleInputFile" required>
                                    </div>
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-primary">Upload File</button>
                                </div>
                            </form>
                            <script>
                                $(document).ready(function() {
                                    $("#uploadFile").submit(function() {
                                        $('.btn').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Uploading savings....please wait'
                                        ).addClass('disabled');
                                    });
                                    });
                            </script>
                        </div>
                        <!-- /.box -->
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


            </div>
        </div>
    </aside>
@endsection


