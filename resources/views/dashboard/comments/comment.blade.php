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
        <section class="content" xmlns:wire="http://www.w3.org/1999/xhtml" xmlns:nwire="http://www.w3.org/1999/xhtml">
           @include('dashboard.coopLogo')
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="box box-info" style="margin-top:100px; width: 90%;">
                        <div class="box-header">
                            <h3 class="box-title">Send a Comment</h3>
                            <!-- tools box -->
                            <div class="pull-right box-tools">
                                <button type="button" class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip"
                                        title="Collapse">
                                    <i class="fa fa-minus"></i></button>
                            </div>
                            <!-- /. tools -->
                        </div>
                        <form>
                            @csrf
                            <!-- /.box-header -->
                            <div class="form-group" style="margin:5px; width: 60%;">
                                <label for="exampleInputEmail1">Subject</label>
                                <input type="text" class="form-control" id="subject" placeholder="">
                            </div>
                            <div class="box-body pad">
                                <textarea id="editor1" name="editor1" rows="10" cols="50" placeholder="Write your comment here">

                                </textarea>
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-primary">Submit Comment</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.box -->

                </div>
                <!-- /.row -->
            </section>
            <!-- /.content -->

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
                <script>
                    $(function () {
                        // Replace the <textarea id="editor1"> with a CKEditor
                        // instance, using default configuration.
                        CKEDITOR.replace('editor1')
                        //bootstrap WYSIHTML5 - text editor
                        $('.textarea').wysihtml5()
                    })
                </script>
            </div>
            <!-- /.tab-pane -->

            <!-- /.tab-pane -->
        </div>
    </aside>
@endsection


