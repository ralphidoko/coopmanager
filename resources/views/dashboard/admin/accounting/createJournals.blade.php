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
        <section class="content" xmlns:wire="http://www.w3.org/1999/xhtml" xmlns:nwire="http://www.w3.org/1999/xhtml">
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
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                </div>
                                <h3 class="box-title">Journals</h3>
                                <div class="box-footer">
                                    <button class="btn btn-primary create"><i class="fa fa-fw fa-plus"></i>Create</button>
                                    <button class="btn btn-secondary discard"><i class="fa fa-fw fa-minus"></i>Discard</button>
                                    <button class="btn btn-secondary back"><i class="fa fa-fw fa-backward"></i>Back to Journals</button>
                                    <hr>
                                </div>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body AccountFormDiv" style="display: none">
                                <form id="accountForm" method="POST" action="" role="form">
                                    @csrf
                                    <div class="box-body" style="width: 70%">
                                        <div class="form-group">
                                            <label for="exampleInputCode">Journal Code</label>
                                            <input type="text" class="form-control" id="code" placeholder="">
                                            <input type="hidden" class="form-control" value="" id="chartID">
                                            <p id="coError" style="color:red"></p>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputName">Journal Name</label>
                                            <input type="text" class="form-control" id="name" placeholder="">
                                            <p id="naError" style="color:red"></p>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputType">Journal Type</label>
                                            <select class="form-control select2" id="type" style="width: 100%;">
                                                <option value="">Select</option>
                                                @foreach($types as $type)
                                                    <option value="{{$type->id}}">{{$type->name}}</option>
                                                @endforeach
                                            </select>
                                            <p id="tyError" style="color:red"></p>
                                        </div>
                                        <div class="form-group">
                                            <input type="checkbox" id="allow_cancellation">
                                            <label for="allow_cancellation">Allow Cancellation of Entries</label><br>
                                        </div>
                                    </div>
                                    <!-- /.box-body -->
                                    <div class="box-footer">
                                        <button type="submit" id="save" class="btn btn-primary">Save</button>
                                        <button type="submit" id="updateAccount" class="btn btn-primary" style="display: none">Update Journal</button>
                                    </div>
                                </form>
                            </div>
                                <div class="box-body DisplayAccountDiv">
                                    <div class="box-body table-responsive">
                                    <table id="example-2" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th hidden></th>
                                            <th>S/N</th>
                                            <th>Code</th>
                                            <th>Name</th>
                                            <th>Journal Type</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php $counter = 1; @endphp
                                        @foreach($journals as $journal)
                                            <tr>
                                                <td hidden>{{$journal->id}}</td>
                                                <td>{{$counter++}}</td>
                                                <td>{{$journal->code}}</td>
                                                <td>{{$journal->name}}</td>
                                                <td>{{$journal->types->name}}</td>
                                                <td><i class="fa fa-fw fa-edit" id="{{$journal->id}}" style="cursor: pointer"></i>&#160;<i class="fa fa-fw fa-trash-o" id="{{$journal->id}}" style="cursor: pointer"></i></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                <script>
                                    $(document).ajaxStart(function() { Pace.restart(); });
                                    $(".create").on("click",function(e){
                                        $('.AccountFormDiv').show();
                                        $('.DisplayAccountDiv').hide()
                                        $('#save').show();
                                        $('#updateAccount').hide();
                                    });
                                    $(".discard").on("click",function(e){
                                        $('#updateAccount').hide();
                                        $('.AccountFormDiv').hide();
                                        $('.DisplayAccountDiv').show();
                                        $("#accountForm").trigger('reset')});
                                    $(".back").on("click",function(e){
                                        location.reload()});
                                    $(".fa-edit").click(function(){
                                        $('#updateAccount').show();
                                        $('#save').hide();
                                        var $row=$(this).closest("tr");
                                        var $tds = $row.find("td");
                                        let accountData=[];
                                        $.each($tds,function(){
                                            accountData.push($(this).text())});
                                        document.getElementById('chartID').value=accountData[0];
                                        document.getElementById('code').value=accountData[2];
                                        document.getElementById('name').value=accountData[3];
                                        $('.AccountFormDiv').show();$('.DisplayAccountDiv').hide()})
                                    $(".fa-trash-o").click(function(){
                                        let sure=confirm('Do you really want to delete this account');
                                        let accountID=this.id;
                                        if(sure===!1){return!1}
                                        else{
                                            data={_token:"{{csrf_token()}}",accountID:accountID};
                                            $.ajax({url:'{{URL::to('/deleteAccountJournal')}}',
                                                type:'DELETE',dataType:'json',
                                                data:data,
                                                success:function(response){
                                                    if(response.success===!0){
                                                        $('.preloader').hide();
                                                        toastr.success(response.message);
                                                        location.reload()
                                                    }else{
                                                        $('.preloader').hide();
                                                        toastr.warning(response.message)}},})}})
                                </script>
                                <script>
                                    $(function () {
                                        //use class for multiple table instead of id
                                        $('#example-2').DataTable({'paging' : true, 'lengthChange': false, 'searching'   : false, 'ordering'    : true, 'info'        : true, 'autoWidth'   : false})
                                    })
                                </script>
                                <script>
                                    toastr.options={"closeButton":!0,"newestOnTop":!0,"positionClass":"toast-top-right","showDuration":"500",};
                                    $(document).ready(function(){
                                        $("#save").on("click",function(e) {
                                            e.preventDefault();
                                            let code=$("#code").val();
                                            let name=$('#name').val();
                                            let type=$('#type').val();
                                            let allow_cancel = $('#allow_cancellation').is(":checked");
                                            if(code===''){
                                                $('#code').focus();$('#coError').text('Please enter account code');
                                                $('#coError').fadeOut(2000);$('.loader').hide()
                                            }else if(name===''){
                                                $('#name').focus();
                                                $('#naError').text('Enter account name');
                                                $('#naError').fadeOut(2000);
                                                $('.loader').hide()
                                            }else if(type===''){
                                                $('#type').focus();
                                                $('#tyError').text('Please select account type');
                                                $('#tyError').fadeOut(2000);$('.loader').hide()
                                            }else{$('.preloader').show();
                                                data={_token:"{{csrf_token()}}",code:code, name:name, type:type,allow_cancel:allow_cancel};

                                                $.ajax({url:'{{URL::to('/createAccountJournal')}}',
                                                    type:'POST',
                                                    dataType:'json',
                                                    data:data,
                                                    success:function(response){
                                                        if(response.success===!0){
                                                            $('.preloader').hide();
                                                            toastr.success(response.message);
                                                            $("#accountForm").trigger('reset')
                                                        }else{$('.preloader').hide();
                                                            toastr.warning(response.message)}},})}})})
                                    //update account chart
                                    $(document).ready(function(){
                                        $("#updateAccount").on("click",function(e) {
                                            e.preventDefault();
                                            let chartID = $("#chartID").val();
                                            let name=$('#name').val();
                                            let type=$('#type').val();
                                            let code=$('#code').val();
                                            let allow_cancel = $('#allow_cancellation').is(":checked");
                                            if(code===''){
                                                $('#code').focus();$('#coError').text('Please enter account code');
                                                $('#coError').fadeOut(2000);$('.loader').hide()
                                            }else if(name===''){
                                                $('#name').focus();
                                                $('#naError').text('Enter account name');
                                                $('#naError').fadeOut(2000);
                                                $('.loader').hide()
                                            }else if(type===''){
                                                $('#type').focus();
                                                $('#tyError').text('Please select account type');
                                                $('#tyError').fadeOut(2000);$('.loader').hide()
                                            }else{$('.preloader').show();
                                                data={_token:"{{csrf_token()}}",chartID:chartID,code:code, name:name, type:type,allow_cancel:allow_cancel};
                                                $.ajax({url:'{{URL::to('/updateAccountJournal')}}',
                                                    type:'PUT',
                                                    dataType:'json',
                                                    data:data,
                                                    success:function(response){
                                                        if(response.success===!0){
                                                            $('.preloader').hide();
                                                            toastr.success(response.message);
                                                            $("#accountForm").trigger('reset')
                                            }else{$('.preloader').hide();
                                                  toastr.warning(response.message)}},})}})})
                                </script>
                            </div>
                            </div>

                            <!-- /.box-body -->
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

                <!-- /.control-sidebar-menu -->

                <!-- /.control-sidebar-menu -->

            </div>
            <!-- /.tab-pane -->

            <!-- /.tab-pane -->
        </div>
    </aside>
@endsection
