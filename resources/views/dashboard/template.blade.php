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

@section('main-content')
    <div class="content-wrapper">
        <section class="content" xmlns:wire="http://www.w3.org/1999/xhtml" xmlns:nwire="http://www.w3.org/1999/xhtml">
            <div class="row col-md-10 col-lg-10 flex justify-content-center">

                <div class="pull-right" style="width: 100%; display: flex; justify-content: center; align-items: center;">
                    <img src="{{ asset('custom/img') }}/nepza_logo.jpg" width="100" height="90" alt="" />
                    <span style="font-size: 24px; font-weight: bolder; color: #0c5460; line-height: 17px;">
                            NEPZA STAFF MULTIPURPOSE CO-OPERATIVE SOCIETY LIMITED<br />
                            <small style="font-size: 13px; color: #0c5460; align-items: center; ! important;">
                                2, Zambezi Crescent Cadestral Zone A6, Behind Merit House, Off Aguiyi Ironsi Street, Maitama, Abuja<br />
                               &#160;&#160;&#160; &#160; &#160; &#160; &#160; &#160; &#160;&#160; &#160; &#160; &#160; &#160; &#160; Contact GSM: 08054222750; 08086664932; Email: nepzacoop@yahoo.com<br />
                                &#160;&#160;&#160; &#160; &#160; &#160; &#160; &#160; &#160;&#160;&#160;&#160; &#160; &#160; &#160; &#160; &#160; &#160;&#160;&#160;&#160; &#160; &#160; &#160; &#160; &#160; &#160;
                                &#160;&#160;&#160; &#160; &#160; &#160; &#160; &#160; &#160;Motto: Unity & Progress
                            </small>
                        </span>
                </div>
            </div>
            <br />
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-xs-12">

                        <div class="box box-primary" >
                            <div class="box-header">
                                <h3 class="box-title">List View of all Loan</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">

                                contents here
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

                <!-- /.control-sidebar-menu -->

                <!-- /.control-sidebar-menu -->

            </div>
            <!-- /.tab-pane -->

            <!-- /.tab-pane -->
        </div>
    </aside>
@endsection


