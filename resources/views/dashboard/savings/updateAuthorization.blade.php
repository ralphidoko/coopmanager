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
        <section class="content" xmlns:wire="http://www.w3.org/1999/xhtml" xmlns:nwire="http://www.w3.org/1999/xhtml">
            <div class="row col-md-10 col-lg-10 flex justify-content-center">
                <div class="box box-primary " style="padding: 10px;">
                    {{--<div class="pull-right" style="width: 100%; display: flex; justify-content: center; align-items: center;">
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
                    </div>--}}
                    <br /><br /><br /><br /><br />
                    <hr><br />
                    <div role="form">
                        <div id="loan_infos" style="display:none; width:50%; text-align:center; margin:auto; font-size:23px; color: white; background-color:#3CB371">
                            Your current loan type is:
                        </div><br />
                        <div style="display: inline-flex;background-color: #4e555b;width: 30%; margin-left: 30px;" class="col-md-10 col-lg-12">
                            <label style="color: #ffffff;padding-top:2px;text-transform: uppercase ">STANDING ORDER ON SAVING</label>
                        </div><br /><br /><br />
                        <form id="enrollmentForm">
                            @csrf
                            <div style="display: inline-flex;" class="col-md-10 col-lg-12">
                                <div class="form-group col-md-10 col-lg-12">
                                    <label>Full Name:</label>
                                    <select class="form-control col-md-10 col-lg-12" name="applicant" id="applicant" readonly disabled>
                                        <option selected value="{{\Illuminate\Support\Facades\Auth::user()->name}}">{{\Illuminate\Support\Facades\Auth::user()->name}}</option>
                                    </select>
                                </div>
                            </div>
                            <div style="display: inline-flex;background-color: #4e555b;width: 30%; margin-left: 30px;" class="col-md-10 col-xs-4 col-lg-12">
                                <label style="color: #ffffff;padding-top:2px; ">AUTHORIZATION DETAILS</label>
                            </div> <br /> <br /><br />

                            <div style="display: inline-flex;" class="col-md-10 col-lg-12">
                                <div class="form-group col-md-10 col-lg-12">
                                    <label>Authorization Type:</label>
                                    <select class="form-control col-md-10 col-lg-12" id="auth_type">
                                        <option value="">Select authorization type</option>
                                        <option value="1">Increase my Saving</option>
                                        <option value="2">Decrease my Saving</option>
                                    </select>
                                    <p id="ErrorMsg" style="color:red"></p>
                                </div>
                            </div>
                            <div style="" class="col-md-10 col-lg-12" id="cash_loan">
                                <div style="display: inline-flex">
                                    <div class="form-group col-md-10 col-lg-10">
                                        <label for="cash_loan_amount">From Current Amount (<del style="text-decoration-style: double">N</del>)</label>
                                        <input type="text" style="font-size: 25px; font-weight: bolder;" class="form-control" id="current_amount" value="{{number_format($current_saving->amount_authorized,2)}}">
                                        <p id="caError" style="color:red"></p>
                                    </div>
                                </div>
                                <div style="display: inline-flex">
                                    <div class="form-group col-md-10 col-lg-10">
                                        <label for="desired_amount">To Desired Amount (<del style="text-decoration-style: double">N</del>)</label>
{{--                                      <input type="number" min="1" oninput="validity.valid||(value='');" style="font-size: 25px; font-weight: bolder;" class="form-control" id="desired_amount">--}}
                                        <input type="text" id="desired_amount" name="currency-field" oninput="setCustomValidity('')" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" style="font-size: 25px; font-weight: bolder;" class="form-control" value="" data-type="currency" placeholder="20,000.00">
                                        <input type="hidden" value="{{$auth_details->id}}" id="auth_id">
                                        <p id="daError" style="color:red"></p>
                                    </div>
                                </div>
                            </div>
                            <div style="" class="col-md-10 col-lg-12" id="cash_loan">
                                <div style="display: inline-flex">
                                    <div class="form-group col-md-10 col-lg-12">
                                        <label for="start_date">Effective From:</label>
                                        <input type="date" style="font-size: 25px; font-weight: bolder;" class="form-control" id="start_date" >
                                        <p id="sdateError" style="color:red"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="" align="center">
                                <button type="submit" id="submit_auth" data-token="{{ csrf_token() }}" class="btn btn-primary">Update Authorization</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <script>
                $(document).ready(function(){
                    $("#current_amount").prop("disabled",true);
                    $("#desired_amount").prop("disabled",true);

                    $('#auth_type').on('change', function(){
                        if (this.value === '1'){
                            $("#cash_loan").show();
                            $("#current_amount").prop("disabled",true);
                            $("#desired_amount").prop('disabled',false);
                        }
                        else if(this.value === '2') {
                            $("#current_amount").prop("disabled", true);
                            $("#desired_amount").prop('disabled', false);
                            $("#cash_loan").show();
                        }else{
                            $("#current_amount").prop("disabled",true);
                            $("#desired_amount").prop("disabled",true);

                        }
                    });
                });
            </script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
            <script>
                toastr.options = {
                    "closeButton": true,
                    "newestOnTop": true,
                    "positionClass": "toast-top-right",
                    "showDuration": "700",
                };

                $('#loan_info').fadeIn(9000).fadeOut(5000).fadeIn(9000).fadeOut(5000);

                $( "#submit_auth" ).on( "click", function(e) {
                    e.preventDefault();
                    let applicant = $("#applicant").val();
                    let auth_type = $("#auth_type").val();
                    var current_amount = $("#current_amount").val();
                    let desired_amount = $("#desired_amount").val();
                    let auth_id = $("#auth_id").val();
                    let start_date = $("#start_date").val();
                    let auth_text = $("#auth_type option:selected").text();
                    if($("#auth_type option:selected").val() === "") {
                        $('#auth_type').css('border-color', 'red').focus();
                        $('#ErrorMsg').text('Please select a loan type');
                        $('#ErrorMsg').fadeOut(2000);
                        return false;
                    }

                    if($("#auth_type").val() == 1 && $("#current_amount").val() === "") {
                        $('#current_amount').css('border-color', 'red').focus();
                        $('#caError').text('Please enter loan amount');
                        $('#caError').fadeOut(2000);
                    }else if($("#auth_type").val() == 1 && $("#desired_amount").val() === "") {
                        $('#desired_amount').css('border-color', 'red').focus();
                        $('#daError').text('Please enter desired amount');
                        $('#daError').fadeOut(2000);
                    }else if($("#auth_type").val() == 1 && $("#start_date").val() === ""){
                        $('#start_date').css('border-color', 'red').focus();
                        $('#sdateError').text('Please pick a day');
                        $('#sdateError').fadeOut(2000);

                    }else if($("#auth_type").val() == 2 && $("#current_amount").val() === "") {
                        $('#current_amount').css('border-color', 'red').focus();
                        $('#caError').text('Please enter loan amount');
                        $('#caError').fadeOut(2000);
                    }else if($("#auth_type").val() == 2 && $("#desired_amount").val() === "") {
                        $('#desired_amount').css('border-color', 'red').focus();
                        $('#daError').text('Please enter desired amount');
                        $('#daError').fadeOut(2000);
                    }else if($("#auth_type").val() == 2 && $("#start_date").val() === "") {
                        $('#start_date').css('border-color', 'red').focus();
                        $('#sdateError').text('Please pick a day');
                        $('#sdateError').fadeOut(2000);
                    }else{

                        data = {
                            _token: "{{csrf_token()}}",
                            applicant: applicant,
                            current_amount: current_amount,
                            auth_type: auth_type,
                            desired_amount: desired_amount,
                            start_date: start_date,
                            auth_text: auth_text,
                            auth_id: auth_id
                        };

                        $.ajax({
                            url: '{{URL::to('/handleAuthorizationUpdate')}}',
                            type: 'POST',
                            dataType: 'json',
                            data: data,
                            success: function (response) {
                                if(response.message){
                                    toastr.warning(response.message);
                                }else{
                                    window.location=response.url;
                                }

                            },
                            error: function(response) {
                                $('#caError').text(response.responseJSON.errors.current_amount);
                                $('#daErrorError').text(response.responseJSON.errors.desired_amount);
                                $('#sdateErrorError').text(response.responseJSON.errors.start_date);
                                $('#aaError').text(response.responseJSON.errors.authorized_amount);
                            }
                        });
                    }

                });
            </script>
            <script>
                // Jquery Dependency
                $("input[data-type='currency']").on({
                    keyup: function() {
                        formatCurrency($(this));
                    },
                    blur: function() {
                        formatCurrency($(this), "blur");
                    }
                });

                function formatNumber(n) {
                    // format number 1000000 to 1,234,567
                    return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                }

                function formatCurrency(input, blur) {
                    // appends $ to value, validates decimal side
                    // and puts cursor back in right position.

                    // get input value
                    var input_val = input.val();

                    // don't validate empty input
                    if (input_val === "") { return; }

                    // original length
                    var original_len = input_val.length;

                    // initial caret position
                    var caret_pos = input.prop("selectionStart");

                    // check for decimal
                    if (input_val.indexOf(".") >= 0) {

                        // get position of first decimal
                        // this prevents multiple decimals from
                        // being entered
                        var decimal_pos = input_val.indexOf(".");

                        // split number by decimal point
                        var left_side = input_val.substring(0, decimal_pos);
                        var right_side = input_val.substring(decimal_pos);

                        // add commas to left side of number
                        left_side = formatNumber(left_side);

                        // validate right side
                        right_side = formatNumber(right_side);

                        // On blur make sure 2 numbers after decimal
                        if (blur === "blur") {
                            right_side += "00";
                        }

                        // Limit decimal to only 2 digits
                        right_side = right_side.substring(0, 2);

                        // join number by .
                        input_val = "" + left_side + "." + right_side;

                    } else {
                        // no decimal entered
                        // add commas to number
                        // remove all non-digits
                        input_val = formatNumber(input_val);
                        input_val = "" + input_val;

                        // final formatting
                        if (blur === "blur") {
                            input_val += ".00";
                        }
                    }

                    // send updated string to input
                    input.val(input_val);

                    // put caret back in the right position
                    var updated_len = input_val.length;
                    caret_pos = updated_len - original_len + caret_pos;
                    input[0].setSelectionRange(caret_pos, caret_pos);
                }
            </script>
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
