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
        <section class="content" xmlns:wire="http://www.w3.org/1999/xhtml" xmlns:nwire="http://www.w3.org/1999/xhtml">
        
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
                                <h3 class="box-title">Expenses</h3>
                                <div class="box-footer">
                                    <button class="btn btn-primary create"><i class="fa fa-fw fa-plus"></i>Create</button>
                                    <button class="btn btn-secondary discard"><i class="fa fa-fw fa-minus"></i>Discard</button>
                                    <button class="btn btn-secondary back"><i class="fa fa-fw fa-backward"></i>Back to Bills</button>
                                    <button class="btn btn-secondary cancel_entry" style="display: none;"><i class="fa fa-fw fa-minus"></i>Cancel Entry</button>
                                    <button class="btn btn-secondary repostEntry" style="display: none;"><i class="fa fa-fw fa-plus"></i>Repost Entry</button>
                                    <hr>
                                    <span type="text" class="form-control" id="expenseNumber" value="" style="border: hidden; font-size:30px;font-weight: bolder"></span>
                                </div>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body AccountFormDiv" style="display: none">
                                <form id="accountForm" method="POST" action="" role="form">
                                    <?php echo csrf_field(); ?>
                                    <div class="box-body" style="width: 70%">
                                        <input type="hidden" class="form-control" id="expenseID" value="">
                                        <input type="hidden" class="form-control" id="status" value="">
                                        <div class="form-group payment">
                                            <div id="pj">
                                                <label for="exampleInputCode">Description/Reference</label>
                                                <input type="text" class="form-control col-lg-12 col-md-5 col-sm-3" id="description" placeholder="">
                                                <p id="dError" style="color:red"></p>
                                            </div>
                                            <div id="pj">
                                                <label for="exampleInputCode">Products/Services</label>
                                                <input type="text" class="form-control col-lg-12 col-md-5 col-sm-3" id="product">
                                                <p id="pError" style="color:red"></p>
                                            </div>
                                            <div id="pj">
                                                <label for="exampleInputCode">Bill Date</label>
                                                <input type="date" class="form-control col-lg-12 col-md-5 col-sm-3" id="date" value="">
                                                <p id="bdError" style="color:red"></p>
                                            </div>
                                        </div>
                                        <div class="form-group payment">
                                            <div id="pj">
                                                <label for="exampleInputCode">Quantity</label>
                                                <input type="text" class="form-control col-lg-5 col-md-5 col-sm-3" id="quantity">
                                                <p id="qError" style="color:red"></p>
                                            </div>
                                            <div id="pj">
                                                <label for="exampleInputCode">Unit Price (<del style="text-decoration-style: double">N</del>)</label>
                                                <input type="text" class="form-control col-lg-5 col-md-5 col-sm-3" id="unit_price" value="">
                                                <p id="uError" style="color:red"></p>
                                            </div>
                                            <div id="pj">
                                                <label for="exampleInputCode">Sub Total (<del style="text-decoration-style: double">N</del>)</label>
                                                <input type="number" style="font-size: 18px; font-weight: bold;"  class="form-control col-lg-10 col-md-5 col-sm-3" value="" id="sub_total" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group payment" >
                                            <div id="pj">
                                                <label for="exampleInputType">Account</label>
                                                <select class="form-control col-lg-12 col-md-5 col-sm-3" id="coa" style="width: 100%;">
                                                    <option value="">Select</option>
                                                    <?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($account->id); ?>"><?php echo e($account->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                                <p id="coaError" style="color:red"></p>
                                            </div>
                                            <div id="pj">
                                                <label for="exampleInputType">Payment Journal</label>
                                                <select class="form-control col-lg-12 col-md-5 col-sm-3" id="payment_journal" style="width: 100%;">
                                                    <option value="">Select</option>
                                                    <?php $__currentLoopData = $paymentJournals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paymentJournal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($paymentJournal->id); ?>"><?php echo e($paymentJournal->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                                <p id="pjError" style="color:red"></p>
                                            </div>
                                            <div id="pj">
                                                <label for="exampleInputCode">Beneficiary</label>
                                                <input type="text" class="form-control col-lg-5 col-md-5 col-sm-3" id="vendor">
                                                <p id="vError" style="color:red"></p>
                                            </div>
                                        </div>
                                        <style>
                                            .payment #pj {
                                                display: inline-block;
                                            }
                                        </style>
                                    </div>
                                    <!-- /.box-body -->
                                    <div class="box-footer">
                                        <button type="submit" id="save" class="btn btn-primary">Post Expense</button>
                                    </div>
                                </form>
                            </div>
                            <div class="box-body DisplayAccountDiv">
                                <div class="box-body table-responsive">
                                    <table id="example-2" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th hidden>
                                            <th>S/N</th>
                                            <th>Reference/Description</th>
                                            <th>Expense Number</th>
                                            <th>Product/Service</th>
                                            <th>Vendor/Beneficiary</th>
                                            <th>Quantity</th>
                                            <th>Unit Price</th>
                                            <th>Sub Total</th>
                                            <th>Date</th>
                                            <th>State</th>
                                            <th hidden></th>
                                            <th hidden></th>
                                            <th>View Expense</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $counter = 1; ?>
                                          <?php $__currentLoopData = $expenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td hidden><?php echo e($expense->id); ?></td>
                                                <td></td>
                                                <td><?php echo e($expense->description); ?></td>
                                                <td><?php echo e($expense->expense_number); ?></td>
                                                <td><?php echo e($expense->product_service); ?></td>
                                                <td><?php echo e($expense->vendor); ?></td>
                                                <td><?php echo e($expense->quantity); ?></td>
                                                <td><?php echo e(number_format($expense->unit_price,2)); ?></td>
                                                <td><?php echo e($expense->total_price); ?></td>
                                                <td><?php echo e(date('d-M-Y',strtotime($expense->created_at))); ?></td>
                                                <td><?php echo e($expense->status); ?></td>
                                                <td hidden><?php echo e($expense->account_id); ?></td>
                                                <td hidden><?php echo e($paymentJournal->id); ?></td>
                                                <td><i class="fa fa-fw fa-eye" id="<?php echo e($expense->id); ?>" style="cursor: pointer"></i></td>
                                            </tr>
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                    <script>
                                        $(function () {
                                            //use class for multiple table instead of id
                                            $('#example-2').DataTable({'paging' : true, 'lengthChange': true, 'searching'   : true, 'ordering'    : true, 'info'        : true, 'autoWidth'   : false})
                                        })

                                        $(document).ajaxStart(function() { Pace.restart(); });
                                        $(".create").on("click",function(e){
                                            $('.AccountFormDiv').show();
                                            $('.DisplayAccountDiv').hide()
                                            $('#save').show();
                                            $('#updateAccount').hide();
                                            $('#expenseNumber').hide();
                                            $('.cancel_entry').hide();
                                            $('.repostEntry').hide();
                                            $('#accountForm input,select').attr('disabled',false);
                                        });
                                        $(".discard").on("click",function(e){
                                            $('#updateAccount').hide();
                                            $('.AccountFormDiv').hide();
                                            $('.DisplayAccountDiv').show();
                                            $('#expenseNumber').hide();
                                            $('.create').show();
                                            $('.cancel_entry').hide();
                                            $('.repostEntry').hide();
                                            $("#accountForm").trigger('reset')});
                                        $(".back").on("click",function(e){
                                            location.reload()});
                                        $(".fa-eye").click(function(){
                                            $('#updateAccount').hide();
                                            $('.create').hide();
                                            $('#expenseNumber').show();
                                            $('#save').hide();
                                            var $row=$(this).closest("tr");
                                            var $tds = $row.find("td");
                                            let accountData=[];
                                            $.each($tds,function(){
                                                accountData.push($(this).text())
                                            });
                                            document.getElementById('expenseNumber').innerHTML=accountData[3];
                                            document.getElementById('expenseID').value=accountData[0];
                                            document.getElementById('description').value=accountData[2];
                                            document.getElementById('product').value=accountData[4];
                                            document.getElementById('vendor').value=accountData[5];
                                            document.getElementById('quantity').value=accountData[6];
                                            document.getElementById('unit_price').value=accountData[7];
                                            document.getElementById('sub_total').value=accountData[8];
                                            document.getElementById('date').value=accountData[9];
                                            document.getElementById('status').value=accountData[10];
                                            document.getElementById('coa').value=accountData[11];
                                            document.getElementById('payment_journal').value=accountData[12];
                                            $('.AccountFormDiv').show();$('.DisplayAccountDiv').hide();
                                            var status = $('#status').val();
                                            if(status === 'Posted'){
                                                $('#accountForm input,select').attr('disabled',true);
                                                $('.cancel_entry').show();
                                            }else{
                                                $('#accountForm input,select').attr('disabled',false);
                                                $('.repostEntry').show();
                                            }
                                        })

                                    </script>

                                    <script>
                                        toastr.options={"closeButton":!0,"newestOnTop":!0,"positionClass":"toast-top-right","showDuration":"500",};
                                        $(document).ready(function(){
                                            $('#quantity, #unit_price').on('input',function() {
                                                var qty = parseInt($('#quantity').val());
                                                var price = parseFloat($('#unit_price').val());
                                                $('#sub_total').val((qty * price ? qty * price : 0).toFixed(2));
                                            });
                                            $("#save").on("click",function(e) {e.preventDefault();
                                                let description =$("#description").val(); let product=$('#product').val(); let date=$('#date').val();let coa=$('#coa').val();
                                                let unit_price =$("#unit_price").val(); let quantity=$('#quantity').val(); let payment_journal=$('#payment_journal').val();
                                                let sub_total =$("#sub_total").val();let vendor =$("#vendor").val();
                                                if(description===''){
                                                    $('#description').focus();$('#dError').text('Please enter description');$('#dError').fadeOut(2000);$('.loader').hide()
                                                }else if(product===''){
                                                    $('#product').focus();$('#pError').text('Enter a product or service');$('#pError').fadeOut(2000);
                                                    $('.loader').hide()
                                                }else if(date===''){
                                                    $('#date').focus();
                                                    $('#bdError').text('Pick transaction date');$('#bdError').fadeOut(2000);
                                                    $('.loader').hide()
                                                }else if(unit_price===''){
                                                    $('#unit_price').focus();$('#uError').text('Enter unit price');$('#uError').fadeOut(2000);
                                                    $('.loader').hide()
                                                }else if(quantity===''){
                                                    $('#quantity').focus();$('#qError').text('Enter unit price');$('#qError').fadeOut(2000);
                                                    $('.loader').hide()
                                                }else if(coa===''){
                                                    $('#coa').focus();$('#coaError').text('Select a chart of account');$('#coaError').fadeOut(2000);
                                                    $('.loader').hide()
                                                }else if(payment_journal===''){
                                                    $('#payment_journal').focus();$('#pjError').text('Select payment journal');$('#pjError').fadeOut(2000);
                                                    $('.loader').hide()
                                                }else if(vendor===''){
                                                    $('#vendor').focus();$('#vError').text('Select payment journal');$('#vError').fadeOut(2000);
                                                    $('.loader').hide()
                                                }else{$('.preloader').show();
                                                    data={_token:"<?php echo e(csrf_token()); ?>",vendor:vendor, description:description, product:product, date:date,quantity:quantity,unit_price:unit_price,coa:coa,payment_journal:payment_journal,sub_total:sub_total};
                                                    $.ajax({url:'<?php echo e(URL::to('/registerCoopExpense')); ?>',
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
                                            $(".repostEntry").on("click",function(e) {e.preventDefault();
                                                let description =$("#description").val(); let product=$('#product').val(); let date=$('#date').val();let coa=$('#coa').val();
                                                let unit_price =$("#unit_price").val(); let quantity=$('#quantity').val(); let payment_journal=$('#payment_journal').val();
                                                let sub_total =$("#sub_total").val();let vendor =$("#vendor").val();let expenseNumber =$("#expenseNumber").text();
                                                if(description===''){
                                                    $('#description').focus();$('#dError').text('Please enter description');$('#dError').fadeOut(2000);$('.loader').hide()
                                                }else if(product===''){
                                                    $('#product').focus();$('#pError').text('Enter a product or service');$('#pError').fadeOut(2000);
                                                    $('.loader').hide()
                                                }else if(date===''){
                                                    $('#date').focus();
                                                    $('#bdError').text('Pick transaction date');$('#bdError').fadeOut(2000);
                                                    $('.loader').hide()
                                                }else if(unit_price===''){
                                                    $('#unit_price').focus();$('#uError').text('Enter unit price');$('#uError').fadeOut(2000);
                                                    $('.loader').hide()
                                                }else if(quantity===''){
                                                    $('#quantity').focus();$('#qError').text('Enter unit price');$('#qError').fadeOut(2000);
                                                    $('.loader').hide()
                                                }else if(coa===''){
                                                    $('#coa').focus();$('#coaError').text('Select a chart of account');$('#coaError').fadeOut(2000);
                                                    $('.loader').hide()
                                                }else if(payment_journal===''){
                                                    $('#payment_journal').focus();$('#pjError').text('Select payment journal');$('#pjError').fadeOut(2000);
                                                    $('.loader').hide()
                                                }else if(vendor===''){
                                                    $('#vendor').focus();$('#vError').text('Select payment journal');$('#vError').fadeOut(2000);
                                                    $('.loader').hide()
                                                }else{$('.preloader').show();
                                                    data={_token:"<?php echo e(csrf_token()); ?>",vendor:vendor, description:description, product:product, date:date,quantity:quantity,unit_price:unit_price,coa:coa,payment_journal:payment_journal,sub_total:sub_total,expenseNumber:expenseNumber};
                                                    $.ajax({url:'<?php echo e(URL::to('/reportExpenses')); ?>',
                                                        type:'POST',
                                                        dataType:'json',
                                                        data:data,
                                                        success:function(response){
                                                            if(response.success){
                                                                $('.preloader').hide();
                                                                toastr.success(response.message);
                                                                location.reload();
                                                            }else{$('.preloader').hide();
                                                                toastr.warning(response.message)
                                                            }
                                                        },
                                                    })
                                                }
                                            })

                                        })

                                        $(".cancel_entry").click(function(){
                                            let sure=confirm('Do you really want to cancel this entry');
                                            let expenseID = $('#expenseNumber').text();
                                            if(sure===!1){return!1}
                                            else{
                                                data={_token:"<?php echo e(csrf_token()); ?>",expenseID:expenseID};
                                                $.ajax({url:'<?php echo e(URL::to('/cancelExpense')); ?>',
                                                    type:'POST',dataType:'json',
                                                    data:data,
                                                    success:function(response){
                                                        if(response.warning){
                                                            $('.preloader').hide();
                                                            toastr.warning(response.message);
                                                            location.reload();
                                                        }else{
                                                            $('.preloader').hide();
                                                            toastr.warning(response.message)
                                                        }
                                                    },
                                                })
                                            }
                                        })
                                    </script>
                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <div class="row">
                            <span class="pull-right totalExpense" style="margin-right: 140px;font-size: 40px;font-weight: bolder">Total Expenses:<del style="text-decoration-style: double">N</del><?php echo e(number_format($totalExpense,2)); ?></span>
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
} elseif ($_instance->childHasBeenRendered('yXglvA9')) {
    $componentId = $_instance->getRenderedChildComponentId('yXglvA9');
    $componentTag = $_instance->getRenderedChildComponentTagName('yXglvA9');
    $dom = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('yXglvA9');
} else {
    $response = \Livewire\Livewire::mount('change-password', []);
    $dom = $response->dom;
    $_instance->logRenderedChild('yXglvA9', $response->id, \Livewire\Livewire::getRootElementTagName($dom));
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

<?php echo $__env->make('dashboard.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\coopmanager\resources\views/dashboard/admin/accounting/recordExpense.blade.php ENDPATH**/ ?>