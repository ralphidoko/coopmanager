<?php $__env->startSection('header'); ?>
    <header class="main-header">
        <!-- Logo -->
    <?php echo $__env->make('dashboard.brand', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
            <?php echo $__env->make('dashboard.userProfileLink', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('dashboard.admin.adminLinks', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </nav>
    </header>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('main-content'); ?>
    <div class="content-wrapper">
        <section class="content">
        
        <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box box-danger"  style="margin-top: 10px">
                            <div class="preloader">
                                <img src="<?php echo e(asset('custom/img')); ?>/loader.gif" alt="" />
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
                                <h3 class="box-title">Departments/Zones</h3>
                                <div class="box-footer">
                                    <button class="btn btn-primary create"><i class="fa fa-fw fa-plus"></i>Create</button>
                                    <button class="btn btn-secondary discard"><i class="fa fa-fw fa-minus"></i>Discard</button>
                                    <button class="btn btn-secondary back"><i class="fa fa-fw fa-backward"></i>Back to Departments/Zones</button>
                                    <hr>
                                </div>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body AccountFormDiv" style="display: none">
                                <form id="accountForm" method="POST" action="" role="form">
                                    <?php echo csrf_field(); ?>
                                    <div class="box-body" style="width: 70%">
                                        <div class="form-group">
                                            <label for="exampleInputCode">Department/Zone Name</label>
                                            <input type="text" class="form-control" id="departName" placeholder="">
                                            <input type="hidden" class="form-control" value="" id="chargeID">
                                            <p id="coError" style="color:red"></p>
                                        </div>
                                    </div>
                                    <!-- /.box-body -->
                                    <div class="box-footer">
                                        <button type="submit" id="save" class="btn btn-primary">Create Department</button>
                                        <button type="submit" id="updateAccount" class="btn btn-primary" style="display: none">Update Department</button>
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
                                            <th>Department Name</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $counter = 1; ?>
                                        <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td hidden><?php echo e($department->id); ?></td>
                                                <td><?php echo e($counter++); ?></td>
                                                <td><?php echo e($department->name); ?></td>
                                                <td><i class="fa fa-fw fa-edit" id="<?php echo e($department->id); ?>" style="cursor: pointer"></i>&#160;<i class="fa fa-fw fa-trash-o" id="<?php echo e($department->id); ?>" style="cursor: pointer"></i></td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                            $('.create').show();
                                            $("#accountForm").trigger('reset')});
                                        $(".back").on("click",function(e){
                                            location.reload()});
                                        $(".fa-edit").click(function(){
                                            $('#updateAccount').show();
                                            $('#save').hide();$('.create').hide();
                                            var $row=$(this).closest("tr");
                                            var $tds = $row.find("td");
                                            let accountData = [];
                                            $.each($tds,function(){
                                                accountData.push($(this).text())});
                                            document.getElementById('chargeID').value=accountData[0];
                                            document.getElementById('departName').value=accountData[2];
                                            $('.AccountFormDiv').show();$('.DisplayAccountDiv').hide()})
                                        $(".fa-trash-o").click(function(){
                                            let sure=confirm('Do you really want to delete this department');
                                            let departmentID = this.id;
                                            if(sure===!1){return!1}
                                            else{
                                                data={_token:"<?php echo e(csrf_token()); ?>",departmentID:departmentID};
                                                $.ajax({url:'<?php echo e(URL::to('/deleteDepartment')); ?>',
                                                    type:'DELETE',dataType:'json',
                                                    data:data,
                                                    success:function(response){
                                                        if(response.warning){
                                                            $('.preloader').hide();
                                                            toastr.warning(response.message);
                                                            location.reload()
                                                        }else{
                                                            $('.preloader').hide();
                                                            toastr.warning(response.message)
                                                        }
                                                    },
                                                })
                                            }
                                        })
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
                                                let departName = $("#departName").val();
                                                let departmentID = $('#chargeID').val();
                                                if(departName ===''){
                                                    $('#departName').focus();$('#coError').text('Please enter department or zone name');
                                                    $('#coError').fadeOut(2000);$('.loader').hide()
                                                }else{$('.preloader').show();
                                                    data={_token:"<?php echo e(csrf_token()); ?>",departName:departName,departmentID:departmentID};

                                                    $.ajax({url:'<?php echo e(URL::to('/createDepartment')); ?>',
                                                        type:'POST',
                                                        dataType:'json',
                                                        data:data,
                                                        success:function(response){
                                                            if(response.success===!0){
                                                                $('.preloader').hide();
                                                                toastr.success(response.message);
                                                                $("#accountForm").trigger('reset')
                                                            }else{$('.preloader').hide();
                                                                toastr.warning(response.message)
                                                            }
                                                        },
                                                    })
                                                }
                                            })
                                        })
                                        //update account chart
                                        $(document).ready(function(){
                                            $("#updateAccount").on("click",function(e) {
                                                e.preventDefault();
                                                let departName = $("#departName").val();
                                                let departmentID = $('#chargeID').val();
                                                if(departName ===''){
                                                    $('#departName').focus();$('#coError').text('Please enter department/zone name');
                                                    $('#coError').fadeOut(2000);$('.loader').hide()
                                                }else{$('.preloader').show();
                                                    data = {_token:"<?php echo e(csrf_token()); ?>",departName:departName,departmentID:departmentID};

                                                    $.ajax({url:'<?php echo e(URL::to('/createDepartment')); ?>',
                                                        type:'POST',
                                                        dataType:'json',
                                                        data:data,
                                                        success:function(response){
                                                            if(response.success===!0){
                                                                $('.preloader').hide();
                                                                toastr.success(response.message);
                                                                $("#accountForm").trigger('reset')
                                                            }else{$('.preloader').hide();
                                                                toastr.warning(response.message)
                                                            }
                                                        },
                                                    })
                                                }
                                            })
                                        })
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
        <?php
if (! isset($_instance)) {
    $dom = \Livewire\Livewire::mount('change-password', [])->dom;
} elseif ($_instance->childHasBeenRendered('gBUgBPb')) {
    $componentId = $_instance->getRenderedChildComponentId('gBUgBPb');
    $componentTag = $_instance->getRenderedChildComponentTagName('gBUgBPb');
    $dom = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('gBUgBPb');
} else {
    $response = \Livewire\Livewire::mount('change-password', []);
    $dom = $response->dom;
    $_instance->logRenderedChild('gBUgBPb', $response->id, \Livewire\Livewire::getRootElementTagName($dom));
}
echo $dom;
?>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('dashboard.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\coopmanager\resources\views/dashboard/admin/settings/setUpDepartments.blade.php ENDPATH**/ ?>