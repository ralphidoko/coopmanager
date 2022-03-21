
<div>
   
    <section style="height: 190vh ! important;" class="content">
        <div class="row col-md-10 col-lg-10 flex justify-content-center">
            <div class="box box-danger " style="padding: 10px;">
                <br /><br />
                <div role="form">
                    <?php
if (! isset($_instance)) {
    $dom = \Livewire\Livewire::mount('upload-profile-image', [])->dom;
} elseif ($_instance->childHasBeenRendered('1n0SsU8')) {
    $componentId = $_instance->getRenderedChildComponentId('1n0SsU8');
    $componentTag = $_instance->getRenderedChildComponentTagName('1n0SsU8');
    $dom = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('1n0SsU8');
} else {
    $response = \Livewire\Livewire::mount('upload-profile-image', []);
    $dom = $response->dom;
    $_instance->logRenderedChild('1n0SsU8', $response->id, \Livewire\Livewire::getRootElementTagName($dom));
}
echo $dom;
?>
                    <hr>
                    <div style="display: inline-flex;background-color: #4e555b;width: 30%; margin-left: 30px;margin-bottom: 5px;" class="col-md-10 col-lg-12">
                        <label style="color: #ffffff;padding-top:2px; ">PERSONAL INFORMATION</label>
                    </div>
                    <form  method="" action="">
                        <?php echo csrf_field(); ?>
                        <div style="display: inline-flex;" class="col-md-10 col-lg-12">
                            <div class="form-group col-md-10 col-lg-10">
                                <label for="first_name">First Name</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo e($member->first_name); ?>">
                                <p id="fnErrorMsg" style="color:red"></p>
                            </div>
                            <div class="form-group col-md-10 col-lg-10">
                                <label for="first_name">Middle Name</label>
                                <input type="text" class="form-control" id="middle_name" name="middle_name" value="<?php echo e($member->middle_name); ?>">
                                <p id="mnErrorMsg" style="color:red"></p>
                            </div>
                            <div class="form-group col-md-10 col-lg-10">
                                <label for="last_name">Last Name</label>
                                <input type="text" class="form-control" name="last_name" id="last_name" value="<?php echo e($member->last_name); ?>">
                                <p id="lnErrorMsg" style="color:red"></p>
                            </div>
                        </div>
                        <div style="display: inline-flex;" class="col-md-10 col-lg-12">
                            <div class="form-group col-md-10 col-lg-12">
                                <label for="office_location">Office Location</label>
                                <input type="text" class="form-control" name="office_location" id="office_location" value="<?php echo e($member->office_location); ?>">
                                <p id="offErrorMsg" style="color:red"></p>
                            </div>
                            <div class="form-group col-md-10 col-lg-12">
                                <label for="staff_no">Staff Number</label>
                                <input type="text" class="form-control" name="staff_no" id="staff_no" value="<?php echo e($member->staff_no); ?>">
                                <p id="snErrorMsg" style="color:red"></p>
                            </div>
                            <div class="form-group col-md-10 col-lg-10">
                                <label>Department</label>
                                <select class="form-control col-md-10 col-lg-10" id="department" name="department">
                                    <option selected disabled>select department</option>
                                    <option selected ="<?php echo e($member->department); ?>"><?php echo e($member->department); ?></option>
                                    <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                       <option value="<?php echo e($department->name); ?>"><?php echo e($department->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <p id="dpErrorMsg" style="color:red"></p>
                            </div>
                        </div>
                        <div style="display: inline-flex;" class="col-md-10 col-lg-12">
                            <div class="form-group col-md-10 col-lg-10">
                                <label>Gender</label>
                                <select class="form-control col-md-10 col-lg-10" id="gender" name="gender">
                                    <option selected value="<?php echo e($member->gender); ?>"><?php echo e($member->gender); ?></option>
                                    <option disabled>select gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                                <p id="gdErrorMsg" style="color:red"></p>
                            </div>
                            <div class="form-group col-md-10 col-lg-12">
                                <label for="designation">Designation</label>
                                <input type="text" class="form-control" id="designation" name="designation" value="<?php echo e($member->designation); ?>">
                                <p id="deErrorMsg" style="color:red"></p>
                            </div>
                            <div class="form-group col-md-10 col-lg-12">
                                <label for="residential_address">Residential Address</label>
                                <input type="text" class="form-control" id="residential_address" name="residential_address" value="<?php echo e($member->residential_address); ?>">
                                <p id="rdErrorMsg" style="color:red"></p>
                            </div>
                        </div>
                        <div style="display: inline-flex;" class="col-md-10 col-lg-12">
                            <div class="form-group col-md-10 col-lg-10">
                                <label>State of Origin</label>
                                <select class="form-control col-md-10 col-lg-10" id="state_of_origin" name="state_of_origin">
                                    <option selected value="<?php echo e($member->state_of_origin); ?>"><?php echo e($member->state_of_origin); ?></option>
                                    <option disabled >--Select State--</option>
                                    <option value="Abia">Abia</option>
                                    <option value="Adamawa">Adamawa</option>
                                    <option value="Akwa Ibom">Akwa Ibom</option>
                                    <option value="Anambra">Anambra</option>
                                    <option value="Bauchi">Bauchi</option>
                                    <option value="Bayelsa">Bayelsa</option>
                                    <option value="Benue">Benue</option>
                                    <option value="Borno">Borno</option>
                                    <option value="Cross Rive">Cross River</option>
                                    <option value="Delta">Delta</option>
                                    <option value="Ebonyi">Ebonyi</option>
                                    <option value="Edo">Edo</option>
                                    <option value="Ekiti">Ekiti</option>
                                    <option value="Enugu">Enugu</option>
                                    <option value="FCT">Federal Capital Territory</option>
                                    <option value="Gombe">Gombe</option>
                                    <option value="Imo">Imo</option>
                                    <option value="Jigawa">Jigawa</option>
                                    <option value="Kaduna">Kaduna</option>
                                    <option value="Kano">Kano</option>
                                    <option value="Katsina">Katsina</option>
                                    <option value="Kebbi">Kebbi</option>
                                    <option value="Kogi">Kogi</option>
                                    <option value="Kwara">Kwara</option>
                                    <option value="Lagos">Lagos</option>
                                    <option value="Nasarawa">Nasarawa</option>
                                    <option value="Niger">Niger</option>
                                    <option value="Ogun">Ogun</option>
                                    <option value="Ondo">Ondo</option>
                                    <option value="Osun">Osun</option>
                                    <option value="Oyo">Oyo</option>
                                    <option value="Plateau">Plateau</option>
                                    <option value="Rivers">Rivers</option>
                                    <option value="Sokoto">Sokoto</option>
                                    <option value="Taraba">Taraba</option>
                                    <option value="Yobe">Yobe</option>
                                    <option value="Zamfara">Zamfara</option>
                                </select>
                                <p id="soErrorMsg" style="color:red"></p>
                            </div>
                            <div class="form-group col-md-10 col-lg-12">
                                <label for="lga">Local Government Area</label>
                                <select class='form-control col-md-10 col-lg-10 response' id='lga' name='lga'>


                                </select>
                                <p id="lgErrorMsg" style="color:red"></p>
                            </div>
                            <div class="form-group col-md-10 col-lg-12">
                                <label for="town">Town</label>
                                <input type="text" class="form-control" id="town" name="town" value="<?php echo e($member->town); ?>">
                                <p id="twErrorMsg" style="color:red"></p>
                            </div>
                        </div>
                        <div style="display: inline-flex;background-color: #4e555b;width: 30%; margin-left: 30px;" class="col-md-10 col-lg-12">
                            <label style="color: #ffffff;padding-top:2px; ">NEXT OF KIN</label>
                        </div>

                        <div style="display: inline-flex;" class="col-md-10 col-lg-12">
                            <div class="form-group col-md-10 col-lg-10">
                                <label for="first_name">First Name</label>
                                <input type="text" class="form-control" name="nok_fname" id="nok_fname" value="<?php echo e($member->nok_fname); ?>">
                                <p id="nkfnErrorMsg" style="color:red"></p>
                            </div>
                            <div class="form-group col-md-10 col-lg-10">
                                <label for="middle_name">Middle Name</label>
                                <input type="text" class="form-control" name="nok_mname" id="nok_mname" value="<?php echo e($member->nok_mname); ?>">
                                <p id="nkmnErrorMsg" style="color:red"></p>
                            </div>
                            <div class="form-group col-md-10 col-lg-10">
                                <label for="last_name">Last Name</label>
                                <input type="text" class="form-control" name="nok_lname" id="nok_lname" value="<?php echo e($member->nok_lname); ?>">
                                <p id="nklnErrorMsg" style="color:red"></p>
                            </div>
                        </div>
                        <div style="display: inline-flex;" class="col-md-10 col-lg-12">
                            <div class="form-group col-md-10 col-lg-10">
                                <label for="first_name">Phone Number</label>
                                <input type="text" class="form-control" min="11" maxlength="11" name="nok_tel" id="nok_tel" value="<?php echo e($member->nok_phone_number); ?>">
                                <p id="nkfnErrorMsg" style="color:red"></p>
                            </div>
                            <div class="form-group col-md-10 col-lg-10">
                                <label for="middle_name">Residential Address</label>
                                <input type="text" class="form-control" name="nok_address" id="nok_address" value="<?php echo e($member->nok_address); ?>">
                                <p id="nkrdErrorMsg" style="color:red"></p>
                            </div>
                            <div class="form-group col-md-10 col-lg-10">
                                <label for="last_name">Relationship</label>
                                <input type="text" class="form-control" name="nok_relationship" id="nok_relationship" value="<?php echo e($member->nok_relationship); ?>">
                                <p id="nkrlErrorMsg" style="color:red"></p>
                            </div>
                        </div>
                        <div style="display: inline-flex;background-color: #4e555b;width: 30%; margin-left: 30px;" class="col-md-10 col-lg-12">
                            <label style="color: #ffffff;padding-top:2px; ">REFEREES</label>
                        </div>
                        <div style="display: inline-flex;" class="col-md-10 col-lg-12">
                            <div class="form-group col-md-10 col-lg-10">
                                <label for="referee_one">Referee 1</label>
                                <select class="form-control col-md-10 col-lg-10" id="referee_one" name="referee_one">
                                    <option selected>select Referee</option>
                                    <option selected value="<?php echo e($member->referee_one); ?>"><?php echo e($member->referee_one); ?></option>
                                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($user); ?>"><?php echo e($user); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <p id="r1ErrorMsg" style="color:red"></p>
                            </div>
                            <div class="form-group col-md-10 col-lg-10">
                                <label for="referee_two">Referee Two</label>
                                <select class="form-control col-md-10 col-lg-10" id="referee_two" name="referee_two">
                                    <option selected>select referee</option>
                                    <option selected value="<?php echo e($member->referee_two); ?>"><?php echo e($member->referee_two); ?></option>
                                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($user); ?>"><?php echo e($user); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <p id="r2ErrorMsg" style="color:red"></p>
                            </div>
                        </div>
                        <div style="display: inline-flex;background-color: #4e555b;width: 30%; margin-left: 30px;" class="col-md-10 col-lg-12">
                            <label style="color: #ffffff;padding-top:2px; ">BANKING INFORMATION</label>
                        </div>
                        <div style="display: inline-flex;" class="col-md-10 col-lg-12">
                            <div class="form-group col-md-10 col-lg-10">
                                <label>Bank Name</label>
                                <select class="form-control col-md-10 col-lg-10" id="bank_name" name="bank_name">
                              
                                    <option selected disabled>select Bank</option>
                                        <?php $__currentLoopData = $banks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($bank); ?>"><?php echo e($bank); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <p id="bnErrorMsg" style="color:red"></p>
                            </div>
                            <div class="form-group col-md-10 col-lg-10">
                                <label for="account_name">Account Name</label>
                                <input type="text" class="form-control" name="account_name" id="account_name" value="">
                                <p id="acnErrorMsg" style="color:red"></p>
                            </div>
                            <div class="form-group col-md-10 col-lg-10">
                                <label for="account_no">Account Number</label>
                                <input type="text" class="form-control" maxlength="10" name="account_no" id="account_no">
                                <p id="actnErrorMsg" style="color:red"></p>
                            </div>
                        </div>

                        <div style="display: inline-flex;background-color: #4e555b;width: 30%; margin-left: 30px;" class="col-md-10 col-lg-12">
                            <label style="color: #ffffff;padding-top:2px; ">MEMBERSHIP CERTIFICATION</label>
                        </div>
                        <div style="display: inline-flex;" class="col-md-10 col-lg-12">
                            <div class="checkbox" id="certificate" style="border: 0.5px solid">
                                <label for="certification"><b>OATH:</b></label>
                                <label id="lab">
                                    <input type="checkbox" id="certification" name="certification" >I solemnly agree to be a responsible
                                    member of the Society, I promised to abide with the rule and regulation of the Society and bylaws of <b>THE NEPZA STAFF
                                        MULTIPURPOSE COOPERATIVE SOCIETY.</b>
                                </label>
                                <p id="cerErrorMsg" style="color:red"></p>
                            </div>
                        </div>
                        
                        <div class="" align="center">
                            <button type="button" class="btn btn-primary" id="updateProfile">Update Profile</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script>
                $("#state_of_origin").change(function(){
                    var selectedState = $("#state_of_origin option:selected").val();
                    $.ajax({
                        type: "POST",
                        url: '<?php echo e(URL::to('/handleUserProfileUpdate')); ?>',
                        data: { state : selectedState,_token: "<?php echo e(csrf_token()); ?>" }
                    }).done(function(data){
                        $(".response").html(data);
                    });
                });
        </script>

        <script>
            toastr.options = {
                "closeButton": true,
                "newestOnTop": true,
                "positionClass": "toast-top-right",
                "showDuration": "700",
            };

            $( "#updateProfile" ).on( "click", function(e) {
                e.preventDefault();
                var first_name = $('#first_name').val();
                var middle_name = $('#middle_name').val();
                var last_name =  $('#last_name').val();
                var residential_address = $('#residential_address').val();
                var office_location = $('#office_location').val();
                var staff_no = $('#staff_no').val();
                var department = $('#department').val();
                var gender = $('#gender').val();
                var designation = $('#designation').val();
                var state_of_origin = $('#state_of_origin').val();
                var lga = $('#lga').val();
                var town = $('#town').val();
                var nok_fname = $('#nok_fname').val();
                var nok_mname = $('#nok_mname').val();
                var nok_lname = $('#nok_lname').val();
                var nok_tel =$('#nok_tel').val()
                var nok_address = $('#nok_address').val();
                var nok_relationship = $('#nok_relationship').val()
                var referee_one = $('#referee_one').val();
                var referee_two = $('#referee_two').val();
                var bank_name = $('#bank_name').val();
                var account_no = $('#account_no').val();
                var account_name = $('#account_name').val();
                var certification = $('#certification').prop("checked") ? 1 : 0 ;

               if(certification === 0) {
                //$('#certificate').css('border', 'red');
                $('#cerErrorMsg').text('Please check certification box');
                $('#cerErrorMsg').fadeOut(5000);
                return false;
            }
                data = {
                    _token: "<?php echo e(csrf_token()); ?>",
                    first_name: first_name,
                    middle_name: middle_name,
                    last_name: last_name,
                    residential_address: residential_address,
                    office_location: office_location,
                    staff_no: staff_no,
                    department: department,
                    gender: gender,
                    designation: designation,
                    state_of_origin: state_of_origin,
                    lga: lga,
                    town: town,
                    nok_fname: nok_fname,
                    nok_mname: nok_mname,
                    nok_lname: nok_lname,
                    nok_tel: nok_tel,
                    nok_address: nok_address,
                    nok_relationship: nok_relationship,
                    referee_one: referee_one,
                    referee_two: referee_two,
                    bank_name: bank_name,
                    account_no: account_no,
                    account_name: account_name,
                    certification: certification,
                };

                $('.loader').show();
                $.ajax({
                    url: '<?php echo e(URL::to('/handleUserProfileUpdate')); ?>',
                    type: 'POST',
                    data: data,
                    success: function (response) {
                        if(response.message){
                            $('.loader').hide();
                            toastr.success(response.message);
                            setTimeout(function()
                            { window.location = '/home'; }, 2000);

                        }else{
                            $('.loader').hide();
                            toastr.warning(response.message);
                        }
                    },
                    error: function(response) {
                        $('#certificate').css('border-color','red');
                        $('#fnErrorMsg').text(response.responseJSON.errors.first_name);
                        $('#mnErrorMsg').text(response.responseJSON.errors.middle_name);
                        $('#lnErrorMsg').text(response.responseJSON.errors.last_name);
                        $('#snErrorMsg').text(response.responseJSON.errors.staff_no);
                        $('#rdErrorMsg').text(response.responseJSON.errors.residential_address);
                        $('#offErrorMsg').text(response.responseJSON.errors.office_location);
                        $('#dpErrorMsg').text(response.responseJSON.errors.department);
                        $('#gdErrorMsg').text(response.responseJSON.errors.gender);
                        $('#deErrorMsg').text(response.responseJSON.errors.designation);
                        $('#soErrorMsg').text(response.responseJSON.errors.state_of_origin);
                        $('#lgErrorMsg').text(response.responseJSON.errors.lga);
                        $('#twErrorMsg').text(response.responseJSON.errors.town);
                        $('#nkfnErrorMsg').text(response.responseJSON.errors.nok_fname);
                        $('#nkmnErrorMsg').text(response.responseJSON.errors.nok_mname);
                        $('#nklnErrorMsg').text(response.responseJSON.errors.nok_lname);
                        $('#nktelErrorMsg').text(response.responseJSON.errors.nok_phone_number);
                        $('#nkrdErrorMsg').text(response.responseJSON.errors.nok_address);
                        $('#nkrlErrorMsg').text(response.responseJSON.errors.nok_relationship);
                        $('#r1ErrorMsg').text(response.responseJSON.errors.referee_one);
                        $('#r2ErrorMsg').text(response.responseJSON.errors.referee_two);
                        $('#bnErrorMsg').text(response.responseJSON.errors.bank_name);
                        $('#acnErrorMsg').text(response.responseJSON.errors.account_name);
                        $('#actnErrorMsg').text(response.responseJSON.errors.account_no);
                        $('#cerErrorMsg').text(response.responseJSON.errors.certification);
                    }
                });
            });
        </script>

        <style>
            .loader{
                display: none;
                position: absolute;
                left: 50%;
                top: 45%;
                -webkit-transform: translate(-50%, -50%);
                transform: translate(-50%, -50%);
            }
        </style>

    </section>
</div>
<?php /**PATH C:\xampp\htdocs\coopmanager\resources\views/dashboard/userProfile/userProfileIncluded.blade.php ENDPATH**/ ?>