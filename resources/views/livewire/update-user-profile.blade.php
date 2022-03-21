  <div>
       {{--@include('dashboard.coopLogo')--}}
           <section style="height: 200vh ! important;" class="content" xmlns:wire="http://www.w3.org/1999/xhtml" xmlns:nwire="http://www.w3.org/1999/xhtml">
            <div class="row col-md-10 col-lg-10 flex justify-content-center">
                <div class="box box-primary " style="padding: 10px; margin-top: 10px">
                    <div class="pull-right" style="width: 100px; height: 100px; border: 2px solid;">
                        <img src="{{$image}}" width="100" height="100"/>
                    </div>
                    <br /><br />
                    <div role="form">
                        <div style="margin-left: 30px; display:inline-flex">
                            <div class="form-group" style="margin-left: 30px;">
                                <label for="exampleInputFile">Upload your passport</label>
                                <input type="file" id="image" wire:change="$emit('fileChosen')" onchange="validateFileType()" >
                            </div>
                        </div>
                        <hr><br />
                        <div style="display: inline-flex;background-color: #4e555b;width: 30%; margin-left: 30px;margin-bottom: 5px;" class="col-md-10 col-lg-12">
                            <label style="color: #ffffff;padding-top:2px; ">PERSONAL INFORMATION</label>
                        </div>
                        <form name="userProfile" wire:submit.prevent="updateProfile">
                            <div style="display: inline-flex;" class="col-md-10 col-lg-12">
                                <div class="form-group col-md-10 col-lg-10">
                                    <label for="first_name">First Name</label>
                                    <input type="text" class="form-control" wire:model.debounce.500ms="first_name" value="">
                                    @error('first_name') <span class="text-red-400 text-md">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group col-md-10 col-lg-10">
                                    <label for="middle_name">Middle Name</label>
                                    <input type="text" class="form-control" name="middle_name" wire:model.debounce.500ms="middle_name">
                                    @error('middle_name') <span class="text-red-500 text-md">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group col-md-10 col-lg-10">
                                    <label for="last_name">Last Name</label>
                                    <input type="text" class="form-control" name="last_name" wire:model.debounce.500ms="last_name">
                                    @error('last_name') <span class="text-red-500 text-md">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div style="display: inline-flex;" class="col-md-10 col-lg-12">
                                <div class="form-group col-md-10 col-lg-12">
                                    <label for="office_location">Office Location</label>
                                    <input type="text" class="form-control" name="office_location" wire:model.debounce.500ms="office_location">
                                    @error('office_location') <span class="text-red-500 text-md">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group col-md-10 col-lg-12">
                                    <label for="staff_no">Staff Number</label>
                                    <input type="text" class="form-control" name="staff_no" wire:model.debounce.500ms="staff_no">
                                    @error('staff_no') <span class="text-red-500 text-md">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group col-md-10 col-lg-10">
                                    <label>Department</label>
                                    <select class="form-control col-md-10 col-lg-10" wire:model.debounce.500ms="department">
                                        <option selected>select department</option>
                                        @foreach($departments as $department)
                                            <option value="{{$department->name}}">{{$department->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('department') <span class="text-red-500 text-md">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div style="display: inline-flex;" class="col-md-10 col-lg-12">
                                <div class="form-group col-md-10 col-lg-10">
                                    <label>Gender</label>
                                    <select class="form-control col-md-10 col-lg-10" wire:model.debounce.500ms="gender">
                                        <option selected>select gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                    @error('gender') <span class="text-red-500 text-md">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group col-md-10 col-lg-12">
                                    <label for="designation">Designation</label>
                                    <input type="text" class="form-control" wire:model.debounce.500ms="designation">
                                    @error('designation') <span class="text-red-500 text-md">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group col-md-10 col-lg-12">
                                    <label for="residential_address">Residential Address</label>
                                    <input type="text" class="form-control" wire:model.debounce.500ms="residential_address">
                                    @error('residential_address') <span class="text-red-500 text-md">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div style="display: inline-flex;" class="col-md-10 col-lg-12">
                                <div class="form-group col-md-10 col-lg-10">
                                    <label>State of Origin</label>
                                    <select class="form-control col-md-10 col-lg-10" wire:model.debounce.500ms="state_of_origin" id="state_of_origin">
                                        <option selected value="">--Select State--</option>
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
                                    @error('staff_of_origin') <span class="text-red-500 text-md">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group col-md-10 col-lg-12" wire:ignore>
                                    <label for="lga">Local Government Area</label>
                                    <select class='form-control col-md-10 col-lg-10 response' id='lga' wire:model='lga'>

                                    </select>
                                    @error('lga') <span class="text-red-500 text-md">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group col-md-10 col-lg-12">
                                    <label for="town">Town</label>
                                    <input type="text" class="form-control" wire:model.debounce.500ms="town">
                                    @error('town') <span class="text-red-500 text-md">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div style="display: inline-flex;background-color: #4e555b;width: 30%; margin-left: 30px;" class="col-md-10 col-lg-12">
                                <label style="color: #ffffff;padding-top:2px; ">NEXT OF KIN INFORMATION</label>
                            </div>

                            <div style="display: inline-flex;" class="col-md-10 col-lg-12">
                                <div class="form-group col-md-10 col-lg-10">
                                    <label for="first_name">First Name</label>
                                    <input type="text" class="form-control" name="nok_fname" wire:model.debounce.500ms="nok_fname">
                                    @error('nok_fname') <span class="text-red-500 text-md">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group col-md-10 col-lg-10">
                                    <label for="middle_name">Middle Name</label>
                                    <input type="text" class="form-control" name="nok_mname" wire:model.debounce.500ms="nok_mname">
                                    @error('nok_mname') <span class="text-red-500 text-md">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group col-md-10 col-lg-10">
                                    <label for="last_name">Last Name</label>
                                    <input type="text" class="form-control" name="nok_lname" wire:model.debounce.500ms="nok_lname">
                                    @error('nok_lname') <span class="text-red-500 text-md">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div style="display: inline-flex;" class="col-md-10 col-lg-12">
                                <div class="form-group col-md-10 col-lg-10">
                                    <label for="first_name">Phone Number</label>
                                    <input type="text" class="form-control" name="nok_tel" wire:model.debounce.500ms="nok_tel">
                                    @error('nok_tel') <span class="text-red-500 text-md">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group col-md-10 col-lg-10">
                                    <label for="middle_name">Residential Address</label>
                                    <input type="text" class="form-control" name="nok_address" wire:model.debounce.500ms="nok_address">
                                    @error('nok_address') <span class="text-red-500 text-md">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group col-md-10 col-lg-10">
                                    <label for="last_name">Relationship</label>
                                    <input type="text" class="form-control" name="nok_relationship" wire:model.debounce.500ms="nok_relationship">
                                    @error('nok_relationship') <span class="text-red-500 text-md">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div style="display: inline-flex;background-color: #4e555b;width: 30%; margin-left: 30px;" class="col-md-10 col-lg-12">
                                <label style="color: #ffffff;padding-top:2px; ">REFEREES</label>
                            </div>
                            <div style="display: inline-flex;" class="col-md-10 col-lg-12">
                                <div class="form-group col-md-10 col-lg-10">
                                    <label for="referee_one">Referee 1</label>
                                    <select class="form-control col-md-10 col-lg-10" wire:model.debounce.500ms="referee_one" wire:transition.fade key="id">
                                        <option selected>select referee</option>
                                        @foreach($this->user as $user)
                                            <option value="{{$user}}">{{$user}}</option>
                                        @endforeach
                                    </select>
                                    @error('referee_one') <span class="text-red-500 text-md">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group col-md-10 col-lg-10">
                                    <label for="referee_two">Referee Two</label>
                                    <select class="form-control col-md-10 col-lg-10" wire:model.debounce.500ms="referee_two" wire:transition.fade key="id">
                                        <option selected>select referee</option>
                                        @foreach($this->user as $user)
                                            <option value="{{$user}}">{{$user}}</option>
                                        @endforeach
                                    </select>
                                    @error('referee_two') <span class="text-red-500 text-md">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div style="display: inline-flex;background-color: #4e555b;width: 30%; margin-left: 30px;" class="col-md-10 col-lg-12">
                                <label style="color: #ffffff;padding-top:2px; ">BANKING INFORMATION</label>
                            </div>
                            <div style="display: inline-flex;" class="col-md-10 col-lg-12">
                                <div class="form-group col-md-10 col-lg-10">
                                    <label>Bank Name</label>
                                    <select class="form-control col-md-10 col-lg-10" wire:model.debounce.500ms="bank_name" wire:transition.fade key="id">
                                        <option selected>select bank</option>
                                        @foreach($this->banks as $bank)
                                            <option value="{{$bank}}">{{$bank}}</option>
                                        @endforeach
                                    </select>
                                    @error('bank_name') <span class="text-red-500 text-md">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group col-md-10 col-lg-10">
                                    <label for="account_name">Account Name</label>
                                    <input type="text" class="form-control" name="account_name" wire:model.debounce.500ms="account_name">
                                    @error('account_name') <span class="text-red-500 text-md">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group col-md-10 col-lg-10">
                                    <label for="account_no">Account Number</label>
                                    <input type="text" class="form-control" name="account_no" wire:model.debounce.500ms="account_no">
                                    @error('account_no') <span class="text-red-500 text-md">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div style="display: inline-flex;background-color: #4e555b;width: 30%; margin-left: 30px;" class="col-md-10 col-lg-12">
                                <label style="color: #ffffff;padding-top:2px; ">MEMBERSHIP CERTIFICATION</label>
                            </div>
                            <div style="display: inline-flex;" class="col-md-10 col-lg-12">
                                <div class="checkbox" id="_checkbox">
                                    <label for="certification"><b>OATH:</b></label>
                                    <label>
                                        <input type="checkbox" required id="certify" wire:model.debounce.500ms="certification">I solemnly agree to be a responsible
                                        member of the Society, I promised to abide with the rule and regulation of the Society and bylaws of <b>THE NEPZA STAFF
                                            MULTIPURPOSE COOPERATIVE SOCIETY.</b>
                                    </label>
                                    @error('certification') <span class="text-red-500 text-md">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="form-group col-md-10 col-lg-10">
                                @include('generalFlash')
                            </div>
                            <div class="" align="center">
                                <button type="submit" class="btn btn-primary" id="complete_registration">Complete Registration</button>
                                <span>&#160;&#160;<a href="{{url('/logout')}}">Complete Registration Later</a></span>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <script>
                window.livewire.on('fileChosen', () => {
                    let inputField = document.getElementById('image')
                    let file = inputField.files[0]
                    let reader = new FileReader();
                    reader.onloadend = () => {
                        //console.log(reader.result);
                        window.livewire.emit('fileUpload', reader.result)
                    }
                    reader.readAsDataURL(file);
                })
            </script>
            <script type="text/javascript">
                function validateFileType(){
                    var fileName = document.getElementById("image").value;
                    var idxDot = fileName.lastIndexOf(".") + 1;
                    var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
                    if (extFile=="jpg" || extFile=="jpeg" || extFile=="png"){
                        //TO DO
                    }else{
                        alert("Only jpg, jpeg, and png files are allowed!");
                        document.getElementById("image").value=null;
                    }
                }
            </script>
               <script>
                   $("#state_of_origin").change(function(){
                       var selectedState = $("#state_of_origin option:selected").val();
                       $.ajax({
                           type: "POST",
                           url: '{{URL::to('/handleUserProfileUpdate')}}',
                           data: { state : selectedState,_token: "{{csrf_token()}}" }
                       }).done(function(data){
                           $(".response").html(data);
                       });
                   });
               </script>
        </section>
  </div>



