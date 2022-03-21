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
                                <h3 class="box-title">Loan Products</h3>
                                <div class="box-footer">
                                    <button class="btn btn-primary create"><i class="fa fa-fw fa-plus"></i>Create</button>
                                    <button class="btn btn-secondary discard"><i class="fa fa-fw fa-minus"></i>Discard</button>
                                    <button class="btn btn-secondary back"><i class="fa fa-fw fa-backward"></i>Back to Products</button>
                                    <hr>
                                </div>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body AccountFormDiv" style="display: none">
                                <form id="accountForm" method="POST" action="" role="form">
                                    <?php echo csrf_field(); ?>
                                    <div class="box-body" style="width: 70%">
                                        <div class="form-group">
                                            <label for="exampleInputCode">Product Name</label>
                                            <input type="text" class="form-control" id="name" placeholder="">
                                            <input type="hidden" class="form-control" value="" id="chartID">
                                            <p id="coError" style="color:red"></p>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputName">Product Description</label>
                                            <input type="text" class="form-control" id="description" value="" placeholder="">
                                            <p id="naError" style="color:red"></p>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputType">Product Price</label>
                                            <input type="text" class="form-control" id="price" value="" placeholder="">
                                            <p id="tyError" style="color:red"></p>
                                        </div>
                                    </div>
                                    <!-- /.box-body -->
                                    <div class="box-footer">
                                        <button type="submit" id="save" class="btn btn-primary">Create Product</button>
                                        <button type="submit" id="updateAccount" class="btn btn-primary" style="display: none">Update Product</button>
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
                                            <th>Product Name</th>
                                            <th>Product Description</th>
                                            <th>Price(<del style="text-decoration-style: double">N</del>)</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $counter = 1; ?>
                                        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td hidden><?php echo e($product->id); ?></td>
                                                <td><?php echo e($counter++); ?></td>
                                                <td><?php echo e($product->item_name); ?></td>
                                                <td><?php echo e($product->item_description); ?></td>
                                                <td><?php echo e($product->item_price); ?></td>
                                                <td><i class="fa fa-fw fa-edit" id="<?php echo e($product->id); ?>" style="cursor: pointer"></i>&#160;<i class="fa fa-fw fa-trash-o" id="<?php echo e($product->id); ?>" style="cursor: pointer"></i></td>
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
                                            document.getElementById('name').value=accountData[2];
                                            document.getElementById('description').value=accountData[3];
                                            document.getElementById('price').value=accountData[4];
                                            $('.AccountFormDiv').show();$('.DisplayAccountDiv').hide()})
                                        $(".fa-trash-o").click(function(){
                                            let sure=confirm('Do you really want to delete this product');
                                            let productID = this.id;
                                            if(sure===!1){return!1}
                                            else{
                                                data={_token:"<?php echo e(csrf_token()); ?>",productID:productID};
                                                $.ajax({url:'<?php echo e(URL::to('/deleteLoanProduct')); ?>',
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
                                                let productName = $("#name").val();
                                                let productDescription = $('#description').val();
                                                let productPrice = $('#price').val();
                                                let productID = $('#chartID').val();
                                                if(productName ===''){
                                                    $('#name').focus();$('#coError').text('Please enter product name');
                                                    $('#coError').fadeOut(2000);$('.loader').hide()
                                                }else if(productDescription ===''){
                                                    $('#description').focus();
                                                    $('#naError').text('Enter product description');
                                                    $('#naError').fadeOut(2000);
                                                    $('.loader').hide()
                                                }else if(productPrice ===''){
                                                    $('#price').focus();
                                                    $('#tyError').text('Enter product price');
                                                    $('#tyError').fadeOut(2000);$('.loader').hide()
                                                }else{$('.preloader').show();
                                                    data={_token:"<?php echo e(csrf_token()); ?>",productName:productName, productDescription:productDescription,productPrice:productPrice,productID:productID};

                                                    $.ajax({url:'<?php echo e(URL::to('/createLoanProduct')); ?>',
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
                                                let productID = $("#chartID").val();
                                                let productName = $('#name').val();
                                                let productDescription = $('#description').val();
                                                let productPrice = $('#price').val();
                                                if(productName===''){
                                                    $('#name').focus();$('#coError').text('Please enter product');
                                                    $('#coError').fadeOut(2000);$('.loader').hide()
                                                }else if(productDescription===''){
                                                    $('#description').focus();
                                                    $('#naError').text('Enter product description');
                                                    $('#naError').fadeOut(2000);
                                                    $('.loader').hide()
                                                }else if(productPrice===''){
                                                    $('#price').focus();
                                                    $('#tyError').text('Enter product price');
                                                    $('#tyError').fadeOut(2000);$('.loader').hide()
                                                }else{$('.preloader').show();
                                                    data={_token:"<?php echo e(csrf_token()); ?>",productID:productID,productName:productName, productDescription:productDescription, productPrice:productPrice};
                                                    $.ajax({url:'<?php echo e(URL::to('/createLoanProduct')); ?>',
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
} elseif ($_instance->childHasBeenRendered('Xgh0FCm')) {
    $componentId = $_instance->getRenderedChildComponentId('Xgh0FCm');
    $componentTag = $_instance->getRenderedChildComponentTagName('Xgh0FCm');
    $dom = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('Xgh0FCm');
} else {
    $response = \Livewire\Livewire::mount('change-password', []);
    $dom = $response->dom;
    $_instance->logRenderedChild('Xgh0FCm', $response->id, \Livewire\Livewire::getRootElementTagName($dom));
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

<?php echo $__env->make('dashboard.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\coopmanager\resources\views/dashboard/admin/products/manageProduct.blade.php ENDPATH**/ ?>